<?php
require_once 'api/openrouter/OpenRouterClient.php';
$config = require 'api/openrouter/config.php';

/*
================================================================================
CONFIGURATION - COMPONENT SETTINGS
================================================================================
*/

const DiaryProcessorConfig = [
    'defaults' => [
        'moodDescriptions' => [1 => 'very sad', 2 => 'sad', 3 => 'okay', 4 => 'happy', 5 => 'very happy'],
        'energyDescriptions' => ['', 'very low', 'low', 'medium', 'high', 'very high'],
        'maxNarrativeSentences' => 6,
        'maxBehaviorPatterns' => 4,
        'maxSignificantDays' => 2
    ]
];

/*
================================================================================
CONNECTOR - SYSTEM INTERFACE
================================================================================
*/

class DiaryProcessorConnector {
    // Connection to OpenRouter API
    public static function connectToAPI($apiKey, $model) {
        return new OpenRouterClient($apiKey, $model);
    }

    // Connection to data loading
    public static function connectToDataLoader($filePath) {
        return json_decode(file_get_contents($filePath), true);
    }

    // Connection to response parser
    public static function connectToResponseParser($markdownText) {
        $json = [
            'todaySummary' => '',
            'pastWeek' => '',
            'recurringBehaviors' => [],
            'progressMarkers' => ['positive' => [], 'negative' => []]
        ];

        $lines = explode("\n", $markdownText);
        $currentSection = '';
        $content = '';

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Detect sections
            if (preg_match('/^(Today\'?s?\s*Summary|Past\s*Week|Recurring\s*Behaviors?|Progress\s*Markers?)/', $line, $matches)) {
                // Save previous section
                if ($currentSection && $content) {
                    switch ($currentSection) {
                        case 'todaySummary':
                            $json['todaySummary'] = trim($content);
                            break;
                        case 'pastWeek':
                            $json['pastWeek'] = trim($content);
                            break;
                        case 'recurringBehaviors':
                            $behaviors = array_filter(array_map('trim', explode("\n", $content)));
                            $json['recurringBehaviors'] = array_values($behaviors);
                            break;
                    }
                }

                // Set new section
                $section = strtolower(str_replace([' ', "'", 's'], '', $matches[1]));
                $currentSection = ($section === 'todaysummary') ? 'todaySummary' :
                                (($section === 'pastweek') ? 'pastWeek' :
                                (($section === 'recurringbehavior') ? 'recurringBehaviors' : 'progressMarkers'));
                $content = '';
            }
            // Handle progress markers specially
            elseif ($currentSection === 'progressMarkers') {
                if (preg_match('/^✓\s*(.+)/', $line, $matches)) {
                    $json['progressMarkers']['positive'][] = trim($matches[1]);
                } elseif (preg_match('/^✗\s*(.+)/', $line, $matches)) {
                    $json['progressMarkers']['negative'][] = trim($matches[1]);
                } elseif (strpos($line, 'Positive') === false && strpos($line, 'Areas') === false && strpos($line, 'Improvement') === false) {
                    // Handle lines that might be markers without symbols
                    if (strpos($content, 'positive') !== false || strpos($content, 'achievement') !== false) {
                        $json['progressMarkers']['positive'][] = trim($line);
                    } else {
                        $json['progressMarkers']['negative'][] = trim($line);
                    }
                }
            }
            // Regular content
            elseif ($currentSection && !preg_match('/^(Positive|Areas|Improvement)/', $line)) {
                $content .= $line . ' ';
            }
        }

        // Save final section
        if ($currentSection && $content) {
            switch ($currentSection) {
                case 'todaySummary':
                    $json['todaySummary'] = trim($content);
                    break;
                case 'pastWeek':
                    $json['pastWeek'] = trim($content);
                    break;
                case 'recurringBehaviors':
                    $behaviors = array_filter(array_map('trim', explode("\n", $content)));
                    $json['recurringBehaviors'] = array_values($behaviors);
                    break;
            }
        }

        // Return null if no content was parsed
        if (empty($json['todaySummary']) && empty($json['pastWeek'])) {
            return null;
        }

        return $json;
    }

    // Connection to config system
    public static function connectToConfig() {
        return require 'api/openrouter/config.php';
    }
}

/*
================================================================================
BUILDING BLOCK - COMPONENT IMPLEMENTATION
================================================================================
*/

class DiaryProcessor {
    private $testData;
    private $config;

    public function __construct($testData, $props = []) {
        $this->testData = $testData;
        $this->config = array_merge(DiaryProcessorConfig['defaults'], $props);
    }
    
    // Veilige data extractie
    private function safeGet($array, $key, $default = []) {
        return $array[$key] ?? $default;
    }
    
    // Normalize activity names for consistency
    private function normalizeActivities($activities) {
        $normalized = [];
        foreach ($activities as $activity) {
            // Normalize common variations
            $activity = str_replace(['movies/series', 'movies and series'], 'movies and series', $activity);
            $activity = str_replace(['video games', 'gaming'], 'video games', $activity);
            $normalized[] = $activity;
        }
        return $normalized;
    }
    
    // ============================================================================
    // PUBLIC INTERFACE - Component methods
    // ============================================================================

    public function analyzeWeekPatterns() {
        $patterns = [
            'badHabits' => [],
            'moodTrend' => [],
            'stepsAvg' => 0,
            'weekNarrative' => '',
            'behaviorPatterns' => []
        ];

        $totalSteps = 0;
        $validStepDays = 0;
        $moodDescriptions = $this->config['moodDescriptions'];
        
        foreach ($this->testData as $index => $day) {
            // Track bad habits frequency
            foreach ($this->safeGet($day['activityTrackers'], 'badHabits', []) as $habit) {
                $patterns['badHabits'][$habit] = ($patterns['badHabits'][$habit] ?? 0) + 1;
            }
            
            // Track mood progression with descriptions
            $mood = $day['levelGraders']['mood'] ?? 3;
            $patterns['moodTrend'][] = [
                'value' => $mood,
                'description' => $moodDescriptions[$mood] ?? 'okay',
                'weekday' => $day['weekday'] ?? '',
                'date' => $day['date'] ?? '',
                'activities' => $this->normalizeActivities($this->safeGet($day['activityTrackers'], 'activities', [])),
                'notes' => $day['notes'] ?? ''
            ];
            
            // Step tracking
            $dailySteps = $this->safeGet($day['activityTrackers'], 'dailySteps', []);
            if (isset($dailySteps['current'])) {
                $totalSteps += $dailySteps['current'];
                $validStepDays++;
            }
        }
        
        $patterns['stepsAvg'] = $validStepDays > 0 ? round($totalSteps / $validStepDays) : 0;
        
        // Generate week narrative
        $patterns['weekNarrative'] = $this->generateWeekNarrative($patterns['moodTrend']);
        
        // Detect recurring behavior patterns
        $patterns['behaviorPatterns'] = $this->detectBehaviorPatterns();
        
        return $patterns;
    }
    
    // Generate flowing narrative for the week
    private function generateWeekNarrative($moodTrend) {
        if (empty($moodTrend)) return "Past week data unavailable.";
        
        $narrative = [];
        $firstDay = $moodTrend[0];
        $lastDay = end($moodTrend);
        $yesterday = count($moodTrend) > 1 ? $moodTrend[count($moodTrend) - 2] : $firstDay;
        
        // Week start
        $weekStart = "This past week started " . ($firstDay['value'] >= 4 ? "strong feeling {$firstDay['description']}" : "feeling {$firstDay['description']}");
        if (!empty($firstDay['activities'])) {
            $weekStart .= " with " . implode(' and ', array_slice($firstDay['activities'], 0, 2));
        }
        $narrative[] = $weekStart . ".";
        
        // Find and mention significant days (not just extremes)
        $significantDays = [];
        
        // Always include highest and lowest if different from first/last
        $highestMood = max(array_column($moodTrend, 'value'));
        $lowestMood = min(array_column($moodTrend, 'value'));
        
        foreach ($moodTrend as $index => $day) {
            // Skip first and last day (covered elsewhere)
            if ($index === 0 || $index === count($moodTrend) - 1) continue;
            
            $isSignificant = false;
            $description = "";
            
            // Extreme moods
            if ($day['value'] == $highestMood && $highestMood != $lowestMood) {
                $description = "{$day['weekday']} was the peak feeling {$day['description']}";
                if (!empty($day['activities'])) {
                    $description .= " doing " . implode(' and ', array_slice($day['activities'], 0, 2));
                }
                $isSignificant = true;
            } elseif ($day['value'] == $lowestMood && $highestMood != $lowestMood) {
                $description = "{$day['weekday']} hit hard feeling {$day['description']}";
                if (!empty($day['notes'])) {
                    $description .= " - {$day['notes']}";
                }
                $isSignificant = true;
            }
            
            // Important events based on notes
            elseif (!empty($day['notes']) && 
                   (strpos(strtolower($day['notes']), 'user testing') !== false ||
                    strpos(strtolower($day['notes']), 'insights') !== false ||
                    strpos(strtolower($day['notes']), 'useful') !== false)) {
                $description = "{$day['weekday']} brought useful progress despite feeling {$day['description']}";
                if (strpos(strtolower($day['notes']), 'user testing') !== false) {
                    $description .= " with productive user testing";
                }
                $isSignificant = true;
            }
            
            if ($isSignificant) {
                $significantDays[] = $description . ".";
            }
        }
        
        // Add up to 2 most significant days
        $narrative = array_merge($narrative, array_slice($significantDays, 0, 2));
        
        // Yesterday to today connection
        $connection = "On {$yesterday['weekday']} you were {$yesterday['description']}";
        if (!empty($yesterday['activities'])) {
            $connection .= " " . implode(' and ', array_slice($yesterday['activities'], 0, 2));
        }
        $connection .= ". Today you're {$lastDay['description']}";
        $narrative[] = $connection . ".";
        
        return implode(' ', array_slice($narrative, 0, $this->config['maxNarrativeSentences']));
    }

    // Detect recurring behavior patterns
    private function detectBehaviorPatterns() {
        $patterns = [];
        
        // Check post-alcohol smoking pattern
        $alcoholDays = [];
        $smokingDays = [];
        
        foreach ($this->testData as $index => $day) {
            $badHabits = $this->safeGet($day['activityTrackers'], 'badHabits', []);
            if (in_array('alcohol', $badHabits)) {
                $alcoholDays[] = $index;
            }
            if (in_array('smoking', $badHabits)) {
                $smokingDays[] = $index;
            }
        }
        
        // Check if smoking happens day after alcohol
        $postAlcoholSmoking = 0;
        foreach ($alcoholDays as $alcoholDay) {
            if (in_array($alcoholDay + 1, $smokingDays)) {
                $postAlcoholSmoking++;
            }
        }
        
        if ($postAlcoholSmoking > 0) {
            $patterns[] = "You smoke the day after drinking alcohol. This happened {$postAlcoholSmoking} time(s) this week.";
        }
        
        // Recovery patterns (creative activities after bad days)
        $recoveryPattern = 0;
        for ($i = 1; $i < count($this->testData); $i++) {
            $yesterday = $this->testData[$i-1];
            $today = $this->testData[$i];
            
            if (($yesterday['levelGraders']['mood'] ?? 3) <= 2 && 
                array_intersect(['drawing', 'music', 'creative'], $this->safeGet($today['activityTrackers'], 'activities', []))) {
                $recoveryPattern++;
            }
        }
        
        if ($recoveryPattern > 0) {
            $patterns[] = "You engage in creative activities like drawing and music after low mood days. This happened {$recoveryPattern} time(s).";
        }
        
        // Social isolation after parties/social activities
        $isolationPattern = 0;
        for ($i = 1; $i < count($this->testData); $i++) {
            $yesterday = $this->testData[$i-1];
            $today = $this->testData[$i];
            
            // Check if yesterday had social/party activities (in socialActivity or badHabits for alcohol)
            $yesterdayBadHabits = $this->safeGet($yesterday['activityTrackers'], 'badHabits', []);
            $yesterdaySocial = $this->safeGet($yesterday['activityTrackers'], 'socialActivity', []);
            
            $hadSocialEvent = in_array('alcohol', $yesterdayBadHabits) || 
                            array_intersect(['friends', 'party'], $yesterdaySocial);
            
            $todayAlone = in_array('alone', $this->safeGet($today['activityTrackers'], 'socialActivity', []));
            
            if ($hadSocialEvent && $todayAlone) {
                $isolationPattern++;
            }
        }
        
        if ($isolationPattern > 0) {
            $patterns[] = "You spend time alone after social activities or drinking. This pattern occurred {$isolationPattern} time(s).";
        }
        
        // Procrastination before important events
        $procrastinationPattern = 0;
        for ($i = 0; $i < count($this->testData); $i++) {
            $day = $this->testData[$i];
            $badHabits = $this->safeGet($day['activityTrackers'], 'badHabits', []);
            $notes = strtolower($day['notes'] ?? '');
            
            if (in_array('procrastination', $badHabits) && 
                (strpos($notes, 'sprint') !== false || strpos($notes, 'deadline') !== false || 
                 strpos($notes, 'presentation') !== false || strpos($notes, 'preparation') !== false)) {
                $procrastinationPattern++;
            }
        }
        
        if ($procrastinationPattern > 0) {
            $patterns[] = "You procrastinate before important deadlines or events. This occurred {$procrastinationPattern} time(s).";
        }
        
        // Poor sleep after gaming
        $gamingSleepPattern = 0;
        foreach ($this->testData as $day) {
            $activities = $this->safeGet($day['activityTrackers'], 'activities', []);
            $sleep = $this->safeGet($day['activityTrackers'], 'sleep', '');
            
            if (array_intersect(['video games', 'gaming'], $activities) && 
                strpos(strtolower($sleep), '6 or less') !== false) {
                $gamingSleepPattern++;
            }
        }
        
        if ($gamingSleepPattern > 0) {
            $patterns[] = "You get poor sleep (6 hours or less) on days when you game. This happened {$gamingSleepPattern} time(s).";
        }
        
        return array_slice($patterns, 0, $this->config['maxBehaviorPatterns']);
    }

    public function generatePrompt($lastDay) {
        $weekPatterns = $this->analyzeWeekPatterns();
        
        // Ensure we have the correct last day data (array pointer might be affected)
        $actualLastDay = end($this->testData);
        
        // Today's data formatting
        $todayMood = $actualLastDay['levelGraders']['mood'] ?? 3;
        $todayEnergy = $actualLastDay['levelGraders']['energyLevel'] ?? 3;
        $moodDesc = $this->config['moodDescriptions'][$todayMood] ?? 'okay';
        $energyDesc = $this->config['energyDescriptions'][$todayEnergy] ?? 'medium';
        
        $activities = implode(', ', $this->normalizeActivities($this->safeGet($actualLastDay['activityTrackers'], 'activities', [])));
        $locations = implode(', ', $this->safeGet($actualLastDay['activityTrackers'], 'locations', []));
        $social = implode(', ', $this->safeGet($actualLastDay['activityTrackers'], 'socialActivity', []));
        $badHabits = implode(', ', $this->safeGet($actualLastDay['activityTrackers'], 'badHabits', []));
        $notes = $actualLastDay['notes'] ?? '';
        $sleep = $this->safeGet($actualLastDay['activityTrackers'], 'sleep', '');
        $emotes = implode(', ', $this->safeGet($actualLastDay['activityTrackers'], 'emotes', []));
        $food = implode(', ', $this->safeGet($actualLastDay['activityTrackers'], 'food', []));
        
        // Behavioral patterns text
        $behaviorText = !empty($weekPatterns['behaviorPatterns']) 
            ? implode(' ', $weekPatterns['behaviorPatterns']) 
            : 'No clear recurring patterns detected this week.';
        
        $prompt = "Write a complete diary entry in English using second person (you did X, you felt Y). 

TODAY ({$actualLastDay['date']}, {$actualLastDay['weekday']}):
- Mood/Energy: {$moodDesc}, {$energyDesc}
- Activities: {$activities}
- Locations: {$locations}  
- Social: {$social}
- Bad habits: {$badHabits}
- Notes: \"{$notes}\"
- Sleep: {$sleep}
- Emotions: {$emotes}
- Food: {$food}

PAST WEEK STORY: {$weekPatterns['weekNarrative']}

PATTERNS FOUND: {$behaviorText}

IMPORTANT: Use EXACT mood descriptions provided. Yesterday's mood was described as a specific term - use that EXACT term, do not interpret or change it.

RETURN ONLY THIS JSON STRUCTURE:

{\"todaySummary\":\"...\",\"pastWeek\":\"...\",\"recurringBehaviors\":[\"...\",\"...\"],\"progressMarkers\":{\"positive\":[\"...\",\"...\"],\"negative\":[\"...\",\"...\",\"...\"]}}

CRITICAL: Replace ... with actual content. progressMarkers MUST have 2-3 positive and 2-3 negative items (total 4-5). NO other text, NO markdown headers.";

        return $prompt;
    }
}

/*
================================================================================
INITIALIZATION - Component Setup
================================================================================
*/

// Load test data using connector
$testData = DiaryProcessorConnector::connectToDataLoader('api/openrouter/test-data.json');
$lastDay = end($testData);
$weekData = $testData; // For display in HTML

// Create processor and generate prompt
$processor = new DiaryProcessor($testData);
$prompt = $processor->generatePrompt($lastDay);

// Debug: Show week patterns and narrative
$debugPatterns = $processor->analyzeWeekPatterns();
$debugMode = isset($_GET['debug']) && $_GET['debug'] === '1';

$response = '';
$error = '';

/*
================================================================================
HTTP REQUEST HANDLING - Process diary generation requests
================================================================================
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Use connector to create API client
        $client = DiaryProcessorConnector::connectToAPI($config['api_key'], $config['model']);

        $result = $client->chat([
            ['role' => 'system', 'content' => 'CRITICAL: Return raw JSON object starting with { and ending with }. NO other text, NO markdown headers, NO formatting. If you return anything except valid JSON, the system will fail. Include exactly 4-5 progressMarkers (2-3 positive, 2-3 negative).'],
            ['role' => 'user', 'content' => $prompt]
        ], [
            'max_tokens' => 1500,
            'temperature' => 0.3,
            'cache_control' => ['type' => 'ephemeral']
        ]);

        $aiResponse = $result['choices'][0]['message']['content'];

        // Clean and process JSON response
        $cleanedResponse = trim($aiResponse);
        // Remove any leading/trailing whitespace or code block markers
        $cleanedResponse = preg_replace('/^```json\s*/', '', $cleanedResponse);
        $cleanedResponse = preg_replace('/\s*```$/', '', $cleanedResponse);

        $diaryJson = json_decode($cleanedResponse, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Try to fix common issues
            $fixedResponse = str_replace(["\n", "\r", "\t"], [" ", " ", " "], $cleanedResponse);
            $fixedResponse = preg_replace('/\s+/', ' ', $fixedResponse);

            $diaryJson = json_decode($fixedResponse, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Use connector's response parser as fallback
                $convertedJson = DiaryProcessorConnector::connectToResponseParser($aiResponse);
                if ($convertedJson) {
                    $response = $convertedJson;
                } else {
                    $error = 'JSON Parse Error: ' . json_last_error_msg() . ' - Raw response: ' . substr($aiResponse, 0, 200) . '...';
                    $response = $aiResponse; // Final fallback to raw response
                }
            } else {
                $response = $diaryJson;
            }
        } else {
            $response = $diaryJson;
        }
    } catch (Exception $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}

/*
================================================================================
HTML TEMPLATE - User Interface
================================================================================
*/
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diary Generator Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        .test-data {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #4CAF50;
        }
        .test-data h3 {
            margin-top: 0;
            color: #555;
        }
        .test-data pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            font-size: 12px;
        }
        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px 0;
        }
        button:hover {
            background: #45a049;
        }
        .output {
            background: #fafafa;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            border: 1px solid #ddd;
            white-space: pre-wrap;
            line-height: 1.6;
        }
        .diary-section {
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }
        .diary-section h3 {
            margin-top: 0;
            color: #333;
        }
        .progress-marker {
            margin: 5px 0;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .progress-positive {
            background: #e8f5e8;
            color: #2e7d32;
        }
        .progress-negative {
            background: #ffebee;
            color: #c62828;
        }
        .behavior-item {
            margin: 8px 0;
            padding: 8px;
            background: #f5f5f5;
            border-radius: 4px;
        }
        .error {
            background: #fee;
            color: #c00;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗓️ Diary Generator Test</h1>
        
        <div class="test-data">
            <h3>Test Data - Laatste Dag (<?php echo $lastDay['weekday'] . ', ' . $lastDay['date']; ?>)</h3>
            <pre><?php echo json_encode($lastDay, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
        </div>
        
        <div class="test-data">
            <h3>Afgelopen Week Data (<?php echo count($weekData); ?> dagen)</h3>
            <pre><?php echo json_encode($weekData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
        </div>
        
        <?php if ($debugMode): ?>
            <div class="test-data">
                <h3>Debug: Week Narrative</h3>
                <pre><?php echo htmlspecialchars($debugPatterns['weekNarrative']); ?></pre>
                
                <h3>Debug: Mood Trend</h3>
                <pre><?php echo json_encode($debugPatterns['moodTrend'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
                
                <h3>Debug: Behavior Patterns</h3>
                <pre><?php echo json_encode($debugPatterns['behaviorPatterns'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <button type="submit">Generate Diary Entry</button>
            <a href="?debug=1" style="margin-left: 10px; color: #666;">Debug Mode</a>
        </form>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($response): ?>
            <h2>Generated Diary Entry:</h2>
            <?php if (is_array($response)): ?>
                <!-- JSON formatted output -->
                <div class="diary-section">
                    <h3>Today's Summary</h3>
                    <p><?php echo htmlspecialchars($response['todaySummary'] ?? 'Not available'); ?></p>
                </div>
                
                <div class="diary-section">
                    <h3>Past Week</h3>
                    <p><?php echo htmlspecialchars($response['pastWeek'] ?? 'Not available'); ?></p>
                </div>
                
                <div class="diary-section">
                    <h3>Recurring Behaviors</h3>
                    <?php if (!empty($response['recurringBehaviors'])): ?>
                        <?php foreach ($response['recurringBehaviors'] as $behavior): ?>
                            <div class="behavior-item"><?php echo htmlspecialchars($behavior); ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No recurring patterns detected.</p>
                    <?php endif; ?>
                </div>
                
                <div class="diary-section">
                    <h3>Progress Markers</h3>
                    <?php if (!empty($response['progressMarkers']['positive'])): ?>
                        <h4>Positive Actions:</h4>
                        <?php foreach ($response['progressMarkers']['positive'] as $positive): ?>
                            <div class="progress-marker progress-positive">✓ <?php echo htmlspecialchars($positive); ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($response['progressMarkers']['negative'])): ?>
                        <h4>Areas for Improvement:</h4>
                        <?php foreach ($response['progressMarkers']['negative'] as $negative): ?>
                            <div class="progress-marker progress-negative">✗ <?php echo htmlspecialchars($negative); ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Raw JSON for developers -->
                <details style="margin-top: 20px;">
                    <summary>Raw JSON Data (for developers)</summary>
                    <pre style="background: #f0f0f0; padding: 10px; border-radius: 4px; overflow-x: auto;"><?php echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
                </details>
            <?php else: ?>
                <!-- Fallback for non-JSON response -->
                <div class="output"><?php echo nl2br(htmlspecialchars($response)); ?></div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>