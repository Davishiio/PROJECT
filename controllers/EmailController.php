<?php
require_once 'core/Controller.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

class EmailController extends Controller
{
    public function send()
    {
        // Leer datos JSON del cuerpo de la petición POST
        $input = json_decode(file_get_contents('php://input'), true);

        $toEmail = $input['to'] ?? null;
        $toName = $input['name'] ?? '';
        $subject = $input['subject'] ?? 'Sin asunto';
        $body = $input['body'] ?? '';

        if (!$toEmail || !$body) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos obligatorios: to, body']);
            return;
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = '';  // tu correo
            $mail->Password = ''; // tu password de app o real (mejor variable de entorno)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dtdavidg@gmail.com', 'BIBLIOTECA LAPUERKA');
            $mail->addAddress($toEmail, $toName);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();

            echo json_encode(['success' => 'Correo enviado correctamente']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => "No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}"]);
        }
    }
}
