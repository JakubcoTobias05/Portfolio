document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;
    const message = document.getElementById('message').value;
    
    if (!validateEmail(email)) {
        showAlert('E-mail má nesprávný formát.');
        return;
    }
    
    if (phone.length < 9) {
        showAlert('Telefon musí mít minimálně 9 znaků.');
        return;
    }
    
    if (!validateAddress(address)) {
        showAlert('Adresa musí obsahovat číslo popisné.');
        return;
    }
    
    if (message.length > 255) {
        showAlert('Zpráva může mít maximálně 255 znaků.');
        return;
    }
    
    showAlert('Formulář byl úspěšně odeslán!', 'success');
});

function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(String(email).toLowerCase());
}

function validateAddress(address) {
    const adressPattern = /\d{1,}/;
    return adressPattern.test(address);
}

function showAlert(message, type = 'error') {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    
    alertContainer.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 5000);
}