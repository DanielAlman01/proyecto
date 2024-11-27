// Manejo del menú desplegable
document.querySelectorAll('nav ul li').forEach(function (item) {
    item.addEventListener('mouseenter', function () {
        const dropdown = this.querySelector('.dropdown');
        if (dropdown) {
            dropdown.classList.add('show'); // Muestra el submenú al pasar el mouse
        }
    });

    item.addEventListener('mouseleave', function () {
        const dropdown = this.querySelector('.dropdown');
        if (dropdown) {
            dropdown.classList.remove('show'); // Oculta el submenú al salir del mouse
        }
    });

    // Si el elemento tiene un submenú, habilita el clic para abrirlo
    const link = item.querySelector('a');
    if (link) {
        link.addEventListener('click', function (e) {
            const dropdown = this.nextElementSibling;
            if (dropdown) {
                e.preventDefault(); // Previene el comportamiento por defecto
                dropdown.classList.toggle('show'); // Alterna la visibilidad del submenú
            }
        });
    }
});

// Movimiento suave al hacer clic en enlaces ancla
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth' // Desplazamiento suave
            });
        }
    });
});


