document.getElementById('btn').addEventListener('click', function () {
    var cislo1 = parseFloat(document.getElementById('num1').value);
    var cislo2 = parseFloat(document.getElementById('num2').value);
    var operace = document.getElementById('op').value;
    var vysledek;

    switch (operace) {
        case '+':
            vysledek = cislo1 + cislo2;
            break;
        case '-':
            vysledek = cislo1 - cislo2;
            break;
        case '*':
            vysledek = cislo1 * cislo2;
            break;
        case '/':
            if (cislo2 === 0) {
                vysledek = 'Nelze dělit nulou';
            } else {
                vysledek = cislo1 / cislo2;
            }
            break;
        default:
            vysledek = 'Nepodporovaná operace';
    }

    document.getElementById('result').innerHTML = vysledek;
});
