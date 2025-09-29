# Diary Test Page Plan

## Concept
Een test pagina om hardcoded dagelijkse data om te zetten naar diary formaat via AI, voor het ontwikkelen van de perfecte prompt en output structuur.

## Input Data Structuur
```json
{
  "date": "2024-01-15",
  "mood": 4,
  "activities": [
    "gekookt",
    "goed_geslapen", 
    "gerookt",
    "gesport",
    "gewerkt",
    "vrienden_gezien"
  ],
  "notes": "Hele dag productief geweest, eindelijk die presentatie af. Wel wat stress over deadline volgende week.",
  "ai_questions": [
    {
      "question": "Wat gaf je vandaag het meeste energie?",
      "answer": "Het afmaken van die presentatie, voelde echt als een overwinning"
    },
    {
      "question": "Hoe voel je je over de stress van volgende week?", 
      "answer": "Een beetje zenuwachtig maar ook uitgedaagd. Ik denk dat ik het wel aankan."
    }
  ],
  "context": {
    "previous_days_mood": [2, 2, 3, 4],
    "mood_trend": "improving",
    "recurring_activities": ["gekookt", "goed_geslapen"],
    "notes_from_context": "User was feeling down last few days but seems to be recovering"
  }
}
```

## Gewenste Diary Output Structuur
```markdown
# Dinsdag 15 Januari 2024

## Hoe ik me voelde 😊
Vandaag was een goede dag! Met een mood van 4/5 voel ik me een stuk beter dan de afgelopen dagen. Het is fijn om te merken dat de dip van vorige week langzaam achter me ligt.

## Wat ik deed vandaag
- 🍳 **Gekookt** - Zelf koken blijft een goede routine
- 😴 **Goed geslapen** - Blijkbaar krijg ik mijn slaapritme weer op orde  
- 🚬 **Gerookt** - [mogelijk gentle reminder of positieve note]
- 💪 **Gesport** - Goed bezig met de actieve lifestyle!
- 💼 **Gewerkt** - Productieve dag gehad
- 👥 **Vrienden gezien** - Sociale contacten zijn belangrijk

## Wat er door mijn hoofd speelde
"Hele dag productief geweest, eindelijk die presentatie af. Wel wat stress over deadline volgende week."

Die presentatie afmaken voelde als een echte overwinning! Het is herkenbaar dat je stress voelt over komende deadlines, maar je lijkt er wel vertrouwen in te hebben.

## Diepere gedachten
*Gebaseerd op AI-gesprek van vandaag*

Je vertelde dat het afmaken van de presentatie je het meeste energie gaf - dat gevoel van accomplishment is zo waardevol. Ook mooi om te horen dat je de stress van volgende week als uitdaging ziet in plaats van alleen maar last. Je groeit echt in je zelfvertrouwen.

## Patroon die ik zie 
Na een paar mindere dagen (mood 2-3) zie ik je weer opkrabbelen naar een 4. Je houdt goede routines vast zoals koken en slapen, en je blijft sociale en werkgerelateerde activiteiten doen. Dat wijst op veerkracht! 💪

---
*Dit is dag 4 van je mood-verbetering. Keep it up!* ✨
```

## Test Page Functionaliteit

### Interface
- **Input field**: Voor hardcoded JSON test data
- **Submit button**: Stuurt data naar AI
- **Output area**: Toont gegenereerde diary entry
- **Reset button**: Leegt velden voor nieuwe test

### Backend Flow
1. Test page ontvangt hardcoded JSON input
2. Data wordt geformateerd naar AI prompt
3. Call naar OpenRouter API met diary generation prompt
4. Response wordt geformatteerd en getoond

### Bestanden die nodig zijn
- `diary-test.php` - Test pagina interface  
- `diary-processor.php` - Logic voor AI prompt generation
- `diary-styles.css` - Basic styling
- `test-data-examples.json` - Hardcoded test scenarios

## Test Scenarios
1. **Happy day na slechte periode** - Mood improvement trend
2. **Consistent good mood** - Appreciation for stability  
3. **Bad day** - Gentle encouragement, pattern recognition
4. **Mixed day** - Balanced reflection
5. **Eerste dag data** - No context available

## Volgende Stappen
1. Test page implementeren met hardcoded data
2. Diary prompt verfijnen gebaseerd op outputs
3. Output formatting perfectioneren
4. Template sections uitwerken
5. Context/trend analysis verbeteren

## Vragen voor verfijning
- Welke test scenario wil je als eerste uitwerken?
- Hoe persoonlijk/empathisch moet de AI tone zijn?
- Moeten er specifieke triggers zijn voor bepaalde advice/encouragement?
- Welke activiteiten categorieën wil je ondersteunen?