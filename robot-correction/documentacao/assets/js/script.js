document.addEventListener('DOMContentLoaded', function() {
    const galaxyContainer = document.querySelector('.galaxy');

    // Adiciona estrelas piscando
    for (let i = 0; i < 100; i++) {
        const star = document.createElement('div');
        star.classList.add('star');
        star.style.left = `${Math.random() * 100}vw`;
        star.style.top = `${Math.random() * 100}vh`;
        star.style.animationDuration = `${Math.random() * 2 + 1}s`;
        galaxyContainer.appendChild(star);
    }

    // Adiciona ícones de galáxia
    const cryptoIconsContainer = document.querySelector('.crypto-icons');
    const cryptoIcons = ['⭐', '🌟', '🌙', '☀️', '☁️', '🛰️'];

    for (let i = 0; i < 50; i++) {
        const span = document.createElement('span');
        span.textContent = cryptoIcons[Math.floor(Math.random() * cryptoIcons.length)];
        span.style.left = `${Math.random() * 100}vw`;
        span.style.animationDuration = `${Math.random() * 10 + 5}s`;
        span.style.fontSize = `${Math.random() * 20 + 10}px`;
        cryptoIconsContainer.appendChild(span);
    }
});