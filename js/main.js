// Funcionalidad del menú móvil
document.addEventListener('DOMContentLoaded', function() {
    // Menú móvil
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    menuToggle.addEventListener('click', function() {
        navMenu.classList.toggle('active');
    });

    // Cerrar menú al hacer clic en un enlace
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
        });
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
        if (!navMenu.contains(e.target) && !menuToggle.contains(e.target)) {
            navMenu.classList.remove('active');
        }
    });

    // Funcionalidad del formulario de contacto
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtener los valores del formulario
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Aquí puedes agregar la lógica para enviar el formulario
            console.log('Datos del formulario:', data);
            
            // Mostrar mensaje de éxito
            alert('¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.');
            this.reset();
        });
    }

    // Funcionalidad del slider infinito
    const slider = document.querySelector('.slide-container');
    const slides = document.querySelectorAll('.slide');
    
    if (slider && slides.length > 0) {
        // Clonar el primer slide y añadirlo al final
        const firstSlideClone = slides[0].cloneNode(true);
        slider.appendChild(firstSlideClone);
        
        let currentSlide = 0;
        const totalSlides = slides.length;
        let isTransitioning = false;
        
        function moveToSlide(index) {
            if (isTransitioning) return;
            isTransitioning = true;
            
            slider.style.transition = 'transform 0.8s ease-in-out';
            slider.style.transform = `translateX(-${index * 100}%)`;
            currentSlide = index;
        }
        
        function nextSlide() {
            if (currentSlide === totalSlides) {
                // Si estamos en el clon, volver al inicio sin transición
                slider.style.transition = 'none';
                slider.style.transform = 'translateX(0)';
                currentSlide = 0;
                
                // Forzar un reflow
                slider.offsetHeight;
                
                // Mover al siguiente slide con transición
                setTimeout(() => {
                    slider.style.transition = 'transform 0.8s ease-in-out';
                    moveToSlide(1);
                }, 50);
            } else {
                moveToSlide(currentSlide + 1);
            }
        }
        
        slider.addEventListener('transitionend', () => {
            isTransitioning = false;
        });
        
        // Iniciar el slider automático
        setInterval(nextSlide, 5000);
    }
}); 