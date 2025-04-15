document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registroForm');
    if (!form) {
        console.error('No se encontró el formulario de registro');
        return;
    }

    const password = document.getElementById('password');
    const confirm_password = document.getElementById('confirm_password');

    function mostrarAlerta(mensaje) {
        alert(mensaje);
    }

    form.addEventListener('submit', function(e) {
        // Validaciones del formulario
        const nombre = document.getElementById('nombre').value.trim();
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const telefono = document.getElementById('telefono').value.trim();
        const terminos = document.getElementById('terminos').checked;

        if (!nombre || !username || !email || !telefono || !password.value || !confirm_password.value) {
            e.preventDefault();
            mostrarAlerta('Por favor, completa todos los campos');
            return;
        }

        if (!terminos) {
            e.preventDefault();
            mostrarAlerta('Debes aceptar los términos y condiciones');
            return;
        }

        // Validar contraseñas
        if (password.value !== confirm_password.value) {
            e.preventDefault();
            mostrarAlerta('Las contraseñas no coinciden');
            return;
        }

        // Validar longitud y complejidad de la contraseña
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        if (!passwordRegex.test(password.value)) {
            e.preventDefault();
            mostrarAlerta('La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número');
            return;
        }

        // Validar formato de teléfono (formato Costa Rica)
        const telefonoRegex = /^\+506\s\d{4}-\d{4}$/;
        if (!telefonoRegex.test(telefono)) {
            e.preventDefault();
            mostrarAlerta('El formato del teléfono debe ser: +506 XXXX-XXXX');
            return;
        }
    });
}); 