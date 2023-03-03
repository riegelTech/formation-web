function assertFieldValue(field) {
    switch (field.name) {
        case 'animal_name':
            if (field.value.length === 0) {
                throw new Error('Le nom ne peut pas être vide');
            }
            break;
        case 'animal_species':
            if (!['chien', 'chat'].includes(field.value)) {
                throw new Error('Veuillez choisir entre chien et chat');
            }
            break;
        case 'animal_age':
            const age = parseInt(field.value, 10);
            if (age < 0 || age > 100) {
                throw new Error('Veuillez choisir un âge compris entre 0 et 100');
            }
            break;
    }
}

function checkField(input) {
    input.removeAttribute('class');
    input.parentElement.querySelectorAll('p.error').forEach(errorElem => {
        errorElem.remove();
    });
    try {
        assertFieldValue(input);
    } catch (e) {
        input.setAttribute('class', 'error');
        const errorMsg = document.createElement('p');
        errorMsg.setAttribute('class', 'error');
        errorMsg.textContent = e.message;
        input.parentElement.prepend(errorMsg);
    }
}

function init() {
    document.querySelectorAll('input, select').forEach(input => {
        checkField(input);
        input.addEventListener('change', () => checkField(input));
        input.addEventListener('keyup', () => checkField(input));
    });
}
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

