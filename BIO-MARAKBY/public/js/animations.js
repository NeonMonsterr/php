// Animation on Scroll
document.addEventListener('DOMContentLoaded', function () {
    // Initialize animations
    const animateOnScroll = function () {
        const elements = document.querySelectorAll('[data-aos]');

        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;

            if (elementPosition < windowHeight - 100) {
                element.classList.add('aos-animate');
            }
        });
    };

    // Run on load
    animateOnScroll();

    // Run on scroll
    window.addEventListener('scroll', animateOnScroll);

    // Add animation classes
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize animation styles for all elements
        const aosElements = document.querySelectorAll('[data-aos]');

        aosElements.forEach(element => {
            const animationType = element.getAttribute('data-aos');
            const delay = element.getAttribute('data-aos-delay') || 0;

            // Set initial styles based on animation type
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            element.style.transitionDelay = `${delay}ms`;
            element.classList.add('aos-init');

            switch (animationType) {
                case 'fade-up':
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(20px)';
                    break;
                case 'fade-down':
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(-20px)';
                    break;
                case 'fade-right':
                    element.style.opacity = '0';
                    element.style.transform = 'translateX(-20px)';
                    break;
                case 'fade-left':
                    element.style.opacity = '0';
                    element.style.transform = 'translateX(20px)';
                    break;
                case 'zoom-in':
                    element.style.opacity = '0';
                    element.style.transform = 'scale(0.9)';
                    break;
                case 'flip-up':
                    element.style.opacity = '0';
                    element.style.transform = 'rotateX(20deg)';
                    element.style.transformOrigin = 'bottom';
                    break;
                default:
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(20px)';
            }
        });

        // Function to check if elements are in viewport
        const animateOnScroll = function () {
            aosElements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;

                if (elementPosition < windowHeight - 100) {
                    element.classList.add('aos-animate');
                } else {
                    element.classList.remove('aos-animate');
                }
            });
        };

        // Run on initial load
        animateOnScroll();

        // Run on scroll events
        window.addEventListener('scroll', animateOnScroll);
    });
});
