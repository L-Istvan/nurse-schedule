document.addEventListener('DOMContentLoaded', function() {
    const roleSelector = document.getElementById('roleSelector');

    roleSelector.addEventListener('change', function() {
        const selectedOption = roleSelector.options[roleSelector.selectedIndex];

        inputEmail = document.getElementById('email');
        inputPassword = document.getElementById('password');
        buttonLogin = document.getElementById('login');

        if (selectedOption.id === 'headNurse') {
            inputEmail.value = "FonoverBemutato@gmail.com";
        } else if (selectedOption.id === 'nurse') {
            inputEmail.value = "NoverBemutator@gmail.com";
        }
        inputPassword.value = 'Fonover123456';
        buttonLogin.click();
    });
});
