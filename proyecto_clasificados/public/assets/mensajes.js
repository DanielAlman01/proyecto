// mensajes.js
$(document).ready(function() {
    $('#mensajeForm').submit(function(e) {
        e.preventDefault(); // Evita que se recargue la página

        // Obtener los datos del formulario
        var formData = $(this).serialize();

        // Realizar la solicitud AJAX
        $.ajax({
            url: BASE_URL + 'mensaje/enviar', // Utiliza BASE_URL para la ruta completa
            type: 'POST',
            data: formData,
            success: function(response) {
                // La respuesta será en formato JSON
                var data = JSON.parse(response);
                if (data.success) {
                    alert('Mensaje enviado con éxito');
                } else {
                    alert('Error al enviar el mensaje: ' + data.message);
                }
            },
            error: function() {
                alert('Error al enviar el mensaje');
            }
        });
    });
});


