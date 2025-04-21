document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('nav');

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            menuToggle.setAttribute('aria-expanded', nav.classList.contains('active'));
        });
    }

    // Cerrar el menú al hacer clic en un enlace
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            nav.classList.remove('active');
            menuToggle.setAttribute('aria-expanded', 'false');
        });
    });

    // Configuración del modal de imágenes
    const modal = document.getElementById('imageModal');
    const closeBtn = document.querySelector('.close');

    if (closeBtn) {
        closeBtn.addEventListener('click', closeImagePopup);
    }

    // Cerrar el modal al hacer clic fuera de la imagen
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeImagePopup();
        }
    });

    // Cerrar el modal con la tecla ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.style.display === 'block') {
            closeImagePopup();
        }
    });

    // Menú de usuario
    const userToggle = document.querySelector('.user-toggle');
    const userDropdown = document.querySelector('.user-dropdown');

    if (userToggle && userDropdown) {
        userToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        // Cerrar el menú al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!userToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });

        // Cerrar el menú con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && userDropdown.classList.contains('show')) {
                userDropdown.classList.remove('show');
            }
        });
    }

    // Código del slider
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;
    let isTransitioning = false;

    // Mostrar el primer slide
    slides[0].classList.add('active');

    function showNextSlide() {
        if (isTransitioning) return;
        isTransitioning = true;

        // Ocultar el slide actual
        slides[currentSlide].classList.remove('active');
        
        // Calcular el siguiente slide
        currentSlide = (currentSlide + 1) % slides.length;
        
        // Mostrar el siguiente slide
        setTimeout(() => {
            slides[currentSlide].classList.add('active');
            setTimeout(() => {
                isTransitioning = false;
            }, 1500); // Coincidir con la duración de la transición CSS
        }, 50);
    }

    // Cambiar slides cada 6 segundos
    setInterval(showNextSlide, 6000);
});

// Función para abrir el popup de imágenes
function openImagePopup(imageSrc, title, description) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const modalDuration = document.getElementById('modalDuration');
    const modalGroupSize = document.getElementById('modalGroupSize');
    const modalMeals = document.getElementById('modalMeals');

    // Configurar la información del tour
    modalImg.src = imageSrc;
    modalTitle.textContent = title;

    // Descripciones detalladas para cada destino
    let detailedDescription = description;
    switch(title) {
        case 'San José':
            detailedDescription = `Explora la vibrante capital de Costa Rica. Visita el majestuoso Teatro Nacional, los fascinantes Museo Nacional y Museo del Oro, y el histórico Barrio Amón. Descubre la auténtica cultura tica en el Mercado Central y disfruta de la arquitectura colonial mezclada con el ambiente moderno de la ciudad.`;
            break;
        case 'Volcán Arenal':
            detailedDescription = `Maravíllate con el imponente volcán activo y su perfecta forma cónica. Relájate en las aguas termales naturales, explora senderos rodeados de vida silvestre y disfruta de vistas espectaculares. Podrás observar tucanes, perezosos y monos en su hábitat natural.`;
            break;
        case 'Manuel Antonio':
            detailedDescription = `Descubre uno de los parques nacionales más hermosos del mundo. Camina por senderos entre la selva tropical hasta llegar a playas paradisíacas de arena blanca. Observa monos capuchinos, perezosos e iguanas, y disfruta de actividades como snorkel en sus aguas cristalinas.`;
            break;
        case 'Monteverde':
            detailedDescription = `Adéntrate en el místico bosque nuboso donde las nubes abrazan los árboles. Atraviesa puentes colgantes sobre el dosel del bosque, observa el majestuoso Quetzal y más de 400 especies de aves. Visita jardines de colibríes y aprende sobre la producción de café orgánico local.`;
            break;
        case 'Guanacaste':
            detailedDescription = `Explora las mejores playas del Pacífico costarricense. Disfruta de arenas doradas, atardeceres espectaculares y la auténtica cultura guanacasteca. El tour incluye visitas a parques nacionales, actividades acuáticas opcionales y experiencias culturales con las tradiciones locales.`;
            break;
        case 'Cerro Chirripó':
            detailedDescription = `Asciende al punto más alto de Costa Rica (3,820 m). Durante el recorrido atravesarás diversos ecosistemas, desde bosques tropicales hasta páramos de altura. En días despejados, podrás ver tanto el Océano Pacífico como el Mar Caribe desde la cima.`;
            break;
        case 'Puerto Viejo':
            detailedDescription = `Sumérgete en la vibrante cultura afrocaribeña de Costa Rica. Relájate en playas de arena negra y dorada, prueba la deliciosa gastronomía caribeña y explora el Refugio de Vida Silvestre Gandoca-Manzanillo. Ideal para los amantes del surf y la cultura rastafari.`;
            break;
        case 'Río Celeste':
            detailedDescription = `Descubre el río de aguas turquesas más hermoso de Costa Rica. Camina por senderos del Parque Nacional Volcán Tenorio hasta la espectacular catarata del Río Celeste. Aprende sobre el fenómeno natural que da al río su característico color azul celeste.`;
            break;
        case 'Cahuita':
            detailedDescription = `Explora el único arrecife de coral del Caribe costarricense. El Parque Nacional Cahuita combina playas paradisíacas con selva tropical. Realiza snorkel entre peces tropicales, observa monos aulladores y perezosos, y disfruta de la cultura afrocaribeña local.`;
            break;
    }
    modalDescription.textContent = detailedDescription;

    // Configurar los detalles específicos del tour
    switch(title) {
        case 'Volcán Arenal':
            modalDuration.textContent = 'Duración: 1 día';
            modalGroupSize.textContent = 'Máximo: 20 personas';
            modalMeals.textContent = 'Incluye almuerzo';
            break;
        case 'Guanacaste':
            modalDuration.textContent = 'Duración: 2 días';
            modalGroupSize.textContent = 'Máximo: 15 personas';
            modalMeals.textContent = 'Incluye todas las comidas';
            break;
        case 'Cerro Chirripó':
            modalDuration.textContent = 'Duración: 2 días';
            modalGroupSize.textContent = 'Máximo: 12 personas';
            modalMeals.textContent = 'Incluye todas las comidas';
            break;
        case 'Manuel Antonio':
            modalDuration.textContent = 'Duración: 1 día';
            modalGroupSize.textContent = 'Máximo: 15 personas';
            modalMeals.textContent = 'Incluye almuerzo';
            break;
        case 'Monteverde':
            modalDuration.textContent = 'Duración: 2 días';
            modalGroupSize.textContent = 'Máximo: 15 personas';
            modalMeals.textContent = 'Incluye todas las comidas';
            break;
        case 'Puerto Viejo':
            modalDuration.textContent = 'Duración: 3 días';
            modalGroupSize.textContent = 'Máximo: 12 personas';
            modalMeals.textContent = 'Incluye todas las comidas';
            break;
        case 'Río Celeste':
            modalDuration.textContent = 'Duración: 1 día';
            modalGroupSize.textContent = 'Máximo: 15 personas';
            modalMeals.textContent = 'Incluye almuerzo';
            break;
        case 'Cahuita':
            modalDuration.textContent = 'Duración: 2 días';
            modalGroupSize.textContent = 'Máximo: 10 personas';
            modalMeals.textContent = 'Incluye todas las comidas';
            break;
        case 'San José':
            modalDuration.textContent = 'Duración: 1 día';
            modalGroupSize.textContent = 'Máximo: 20 personas';
            modalMeals.textContent = 'Incluye almuerzo';
            break;
        default:
            modalDuration.textContent = 'Duración: 1 día';
            modalGroupSize.textContent = 'Máximo: 15 personas';
            modalMeals.textContent = 'Incluye almuerzo';
    }

    modal.style.display = 'block';
    document.body.style.overflow = 'hidden'; // Prevenir el scroll
}

// Función para cerrar el popup de imágenes
function closeImagePopup() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
    document.body.style.overflow = ''; // Restaurar el scroll
} 