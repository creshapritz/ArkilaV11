document.addEventListener("DOMContentLoaded", () => {




    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle the icon
        this.classList.toggle('bx-show');
    });


    // Typing Effect
    const dynamicText = document.querySelector("h2 span");
    const words = ["Admin", "Partners", "Staff", "Driver"];
    let wordIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    const typeEffect = () => {
        const currentWord = words[wordIndex];
        const currentText = isDeleting
            ? currentWord.substring(0, charIndex--)
            : currentWord.substring(0, charIndex++);

        dynamicText.textContent = currentText;
        dynamicText.classList.toggle("stop-blinking", isDeleting);

        if (!isDeleting && charIndex === currentWord.length) {
            setTimeout(() => (isDeleting = true), 1200);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            wordIndex = (wordIndex + 1) % words.length;
        }

        setTimeout(typeEffect, isDeleting ? 100 : 200);
    };

    typeEffect();


    


});
