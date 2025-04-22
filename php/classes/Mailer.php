<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class Mailer {
    private $mail;
    private $from_email = 'chesterab20@gmail.com';
    private $from_name = 'Cielo Tico';

    public function __construct() {
        $this->mail = new PHPMailer(true);
        
        // Configuración del servidor
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'chesterab20@gmail.com';
        $this->mail->Password = 'tzxc gqph iewa rfsr';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
        $this->mail->CharSet = 'UTF-8';

        // Configuración del remitente
        $this->mail->setFrom($this->from_email, $this->from_name);
    }

    // Enviar respuesta a un mensaje de contacto
    public function enviarRespuestaContacto($to_email, $to_name, $subject, $mensaje_original, $respuesta) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to_email, $to_name);
            $this->mail->Subject = $subject;

            // Crear el cuerpo del mensaje
            $body = "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>Respuesta a tu mensaje</h2>
                <p>Hola {$to_name},</p>
                <p>{$respuesta}</p>
                <hr>
                <p><strong>Tu mensaje original:</strong></p>
                <p><em>{$mensaje_original}</em></p>
                <br>
                <p>Saludos cordiales,<br>Equipo de Cielo Tico</p>
            </body>
            </html>";

            $this->mail->isHTML(true);
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], "\n", $body));

            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $e->getMessage());
            return false;
        }
    }

    // Enviar notificación de nuevo mensaje de contacto
    public function notificarNuevoMensaje($mensaje) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($this->from_email, 'Administrador');
            $this->mail->Subject = 'Nuevo mensaje de contacto recibido';

            $body = "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>Nuevo mensaje de contacto</h2>
                <p><strong>De:</strong> {$mensaje['nombre']} ({$mensaje['email']})</p>
                <p><strong>Teléfono:</strong> {$mensaje['telefono']}</p>
                <p><strong>Mensaje:</strong></p>
                <p>{$mensaje['mensaje']}</p>
                <br>
                <p><a href='http://localhost/cielotico/html/admin/mensajes.php'>Ver en el panel de administración</a></p>
            </body>
            </html>";

            $this->mail->isHTML(true);
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], "\n", $body));

            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar notificación: " . $e->getMessage());
            return false;
        }
    }

    // Enviar notificación de nueva reserva
    public function notificarNuevaReserva($reserva, $tour, $usuario) {
        try {
            // Notificar al administrador
            $this->mail->clearAddresses();
            $this->mail->addAddress($this->from_email, 'Administrador');
            $this->mail->Subject = 'Nueva reserva de tour recibida';

            $body = "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>Nueva reserva de tour</h2>
                <p><strong>Tour:</strong> {$tour['nombre']}</p>
                <p><strong>Cliente:</strong> {$usuario['nombre']} ({$usuario['email']})</p>
                <p><strong>Fecha:</strong> {$reserva['fecha_reserva']}</p>
                <p><strong>Personas:</strong> {$reserva['numero_personas']}</p>
                <p><strong>Total:</strong> ${$reserva['precio_total']}</p>
                <br>
                <p><a href='http://localhost/cielotico/html/admin/reservas.php'>Ver en el panel de administración</a></p>
            </body>
            </html>";

            $this->mail->isHTML(true);
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], "\n", $body));

            $admin_sent = $this->mail->send();

            // Notificar al cliente
            $this->mail->clearAddresses();
            $this->mail->addAddress($usuario['email'], $usuario['nombre']);
            $this->mail->Subject = 'Confirmación de tu reserva - Cielo Tico';

            $body = "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>¡Gracias por tu reserva!</h2>
                <p>Hola {$usuario['nombre']},</p>
                <p>Hemos recibido tu reserva para el tour {$tour['nombre']}.</p>
                <p><strong>Detalles de la reserva:</strong></p>
                <ul>
                    <li>Fecha: {$reserva['fecha_reserva']}</li>
                    <li>Número de personas: {$reserva['numero_personas']}</li>
                    <li>Total: ${$reserva['precio_total']}</li>
                </ul>
                <p>Nos pondremos en contacto contigo pronto para confirmar los detalles.</p>
                <br>
                <p>Saludos cordiales,<br>Equipo de Cielo Tico</p>
            </body>
            </html>";

            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], "\n", $body));

            $client_sent = $this->mail->send();

            return $admin_sent && $client_sent;
        } catch (Exception $e) {
            error_log("Error al enviar notificación de reserva: " . $e->getMessage());
            return false;
        }
    }
} 