window.addEventListener('load', init);

const micButton = document.querySelector('.fa-microphone');
const inputField = document.querySelector('form textarea');

function init() {
    voiceInput();
}

function voiceInput() {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
        alert("It seems like your browser does not support speech recognition.");
    } else {
        const recognition = new SpeechRecognition();
        recognition.lang = 'en-US';
        recognition.interimResults = false; //
        recognition.maxAlternatives = 1;

        micButton.addEventListener('click', () => {
            recognition.start();
            console.log("Listening started...");
        });

        recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            inputField.value = transcript;
            inputField.dispatchEvent(new Event('input'), {
                'bubbles': true,
                'cancelable': true
            });
            console.log("User said:", transcript);
        };

        recognition.onerror = (event) => {
            console.error("Error with speech recognition:", event.error);
        }
    }
}