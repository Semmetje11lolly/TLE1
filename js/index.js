window.addEventListener('load', init);

let form;
let radios;

function init() {
    form = document.querySelector('form');
    radios = form.querySelectorAll("input[type=radio]");

    radios.forEach(radio => {
        radio.addEventListener("change", checkAndSubmit);
    });
}

function checkAndSubmit() {
    const groups = [...new Set([...radios].map(r => r.name))];
    
    const allFilled = groups.every(name =>
        form.querySelector(`input[name="${name}"]:checked`)
    );

    if (allFilled) {
        form.submit();
    }
}