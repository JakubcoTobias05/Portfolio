function showAlert(message, type = 'error') {
    const alertContainer = document.getElementById('alertContainer');
    const alertDiv = document.createElement('div');
    alertDiv.classList.add('alert', type === 'success' ? 'alert-success' : 'alert-error');
    alertDiv.textContent = message;
    alertContainer.appendChild(alertDiv);

    setTimeout(function() {
        alertDiv.style.display = 'none';
    }, 5000);
}

document.getElementById('contactForm').addEventListener('submit', function(event) {
    let isValid = true;
    let errorMessages = [];

    const requiredFields = ['firstName', 'lastName', 'email', 'phone', 'address', 'city', 'message'];

    requiredFields.forEach(function(field) {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            isValid = false;
            errorMessages.push('Políčko ' + field + ' je povinné vyplnit.');
        }
    });

    if (!isValid) 
    {
        event.preventDefault(); 
        errorMessages.forEach(function(message) {
            showAlert(message);
        });
    }
});

