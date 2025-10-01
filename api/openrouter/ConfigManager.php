<?php
/**
 * ConfigManager - Centralized configuration management for OpenRouter API
 *
 * Handles loading, validation, and caching of configuration.
 * Uses singleton pattern to prevent multiple loads.
 */
class ConfigManager {
    private static ?ConfigManager $instance = null;
    private array $config;
    private bool $loaded = false;

    private function __construct() {
        $this->loadConfig();
    }

    /**
     * Get singleton instance
     */
    public static function getInstance(): ConfigManager {
        if (self::$instance === null) {
            self::$instance = new ConfigManager();
        }
        return self::$instance;
    }

    /**
     * Load configuration from environment and config file
     */
    private function loadConfig(): void {
        if ($this->loaded) {
            return;
        }

        // Load includes/env.php for API key and database config
        $includesEnvPath = __DIR__ . '/../../includes/env.php';
        if (file_exists($includesEnvPath)) {
            require_once $includesEnvPath;
        }

        // Load .env file if it exists (for backwards compatibility)
        $envPath = __DIR__ . '/../../.env';
        if (file_exists($envPath)) {
            $this->loadEnvFile($envPath);
        }

        // Load base config
        $configPath = __DIR__ . '/config.php';
        if (file_exists($configPath)) {
            $fileConfig = require $configPath;
        } else {
            $fileConfig = [];
        }

        // Merge with environment variables (priority: constant > env var > config file)
        $this->config = array_merge($fileConfig, array_filter([
            'api_key' => (defined('OPENROUTER_API_KEY') ? OPENROUTER_API_KEY : null) ?: getenv('OPENROUTER_API_KEY') ?: ($fileConfig['api_key'] ?? null),
            'model' => getenv('OPENROUTER_MODEL') ?: ($fileConfig['model'] ?? 'openai/gpt-4o-mini'),
            'max_tokens' => (int)(getenv('OPENROUTER_MAX_TOKENS') ?: ($fileConfig['max_tokens'] ?? 1000)),
            'temperature' => (float)(getenv('OPENROUTER_TEMPERATURE') ?: ($fileConfig['temperature'] ?? 0.7))
        ]));

        $this->loaded = true;
        $this->validate();
    }

    /**
     * Load .env file into environment
     */
    private function loadEnvFile(string $path): void {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Remove quotes if present
                $value = trim($value, '"\'');

                // Set environment variable if not already set
                if (!getenv($key)) {
                    putenv("$key=$value");
                }
            }
        }
    }

    /**
     * Validate required configuration
     */
    private function validate(): void {
        if (empty($this->config['api_key'])) {
            throw new Exception('OPENROUTER_API_KEY is required. Please set it in .env file or environment.');
        }

        if (empty($this->config['model'])) {
            throw new Exception('OpenRouter model is required in configuration.');
        }
    }

    /**
     * Get configuration value
     */
    public function get(string $key, $default = null) {
        return $this->config[$key] ?? $default;
    }

    /**
     * Get all configuration
     */
    public function getAll(): array {
        return $this->config;
    }

    /**
     * Get API key
     */
    public function getApiKey(): string {
        return $this->config['api_key'];
    }

    /**
     * Get model
     */
    public function getModel(): string {
        return $this->config['model'];
    }

    /**
     * Get max tokens
     */
    public function getMaxTokens(): int {
        return $this->config['max_tokens'];
    }

    /**
     * Get temperature
     */
    public function getTemperature(): float {
        return $this->config['temperature'];
    }

    /**
     * Get configuration merged with custom options
     */
    public function merge(array $options): array {
        return array_merge($this->config, $options);
    }
}