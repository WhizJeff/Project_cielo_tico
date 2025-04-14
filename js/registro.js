document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registroForm');
    if (!form) {
        console.error('No se encontró el formulario de registro');
        return;
    }
    console.log('Formulario de registro encontrado');

    const password = document.getElementById('password');
    const confirm_password = document.getElementById('confirm_password');

    function mostrarMensaje(mensaje, tipo) {
        console.log(`Mostrando mensaje: ${mensaje} (${tipo})`);
        // Remover mensajes anteriores
        const mensajesAnteriores = document.querySelectorAll('.alert');
        mensajesAnteriores.forEach(msg => msg.remove());

        const mensajeDiv = document.createElement('div');
        mensajeDiv.className = `alert alert-${tipo}`;
        mensajeDiv.textContent = mensaje;
        form.insertBefore(mensajeDiv, form.firstChild);
        
        setTimeout(() => {
            mensajeDiv.remove();
        }, 5000);
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log('Formulario enviado');

        try {
            // Validaciones del formulario
            const nombre = document.getElementById('nombre').value.trim();
            const email = document.getElementById('email').value.trim();
            const telefono = document.getElementById('telefono').value.trim();
            const terminos = document.getElementById('terminos').checked;

            console.log('Datos del formulario:', { nombre, email, telefono });

            if (!nombre || !email || !telefono || !password.value || !confirm_password.value) {
                mostrarMensaje('Por favor, completa todos los campos', 'error');
                return;
            }

            if (!terminos) {
                mostrarMensaje('Debes aceptar los términos y condiciones', 'error');
                return;
            }

            // Validar contraseñas
            if (password.value !== confirm_password.value) {
                mostrarMensaje('Las contraseñas no coinciden', 'error');
                return;
            }

            // Validar longitud y complejidad de la contraseña
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
            if (!passwordRegex.test(password.value)) {
                mostrarMensaje('La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número', 'error');
                return;
            }

            // Validar formato de teléfono (formato Costa Rica)
            const telefonoRegex = /^\+506\s\d{4}-\d{4}$/;
            if (!telefonoRegex.test(telefono)) {
                mostrarMensaje('El formato del teléfono debe ser: +506 XXXX-XXXX', 'error');
                return;
            }

            const formData = {
                nombre: nombre,
                email: email,
                telefono: telefono,
                password: password.value
            };

            console.log('Enviando datos al servidor...');
            
            // Construir la URL completa
            const baseUrl = window.location.origin;
            const phpUrl = `${baseUrl}/cielotico/php/procesar_registro.php`;
            console.log('URL del servidor:', phpUrl);

            const response = await fetch(phpUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            console.log('Respuesta del servidor:', response);
            console.log('Estado de la respuesta:', response.status);
            
            const responseText = await response.text();
            console.log('Texto de la respuesta:', responseText);

            try {
                const data = JSON.parse(responseText);
                console.log('Datos parseados:', data);

                if (data.success) {
                    mostrarMensaje(data.message, 'success');
                    form.reset();
                    // Redirigir al login después de 2 segundos
                    setTimeout(() => {
                        window.location.href = 'login.html';
                    }, 2000);
                } else {
                    mostrarMensaje(data.message, 'error');
                }
            } catch (jsonError) {
                console.error('Error al parsear JSON:', jsonError);
                mostrarMensaje('Error al procesar la respuesta del servidor', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarMensaje('Error al procesar el registro. Por favor, intenta nuevamente.', 'error');
        }
    });
}); 