<?php

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));
header('Content-type: application/json');
date_default_timezone_set('America/Argentina/Buenos_Aires');

require_once('php-mailer/PHPMailerAutoload.php');
$mail = new PHPMailer();

// Enter your email address. If you need multiple email recipes simply add a comma: email@domain.com, email2@domain.com
$to = "sprados@chimpancedigital.com.ar";


// Form Fields
$name = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
$email = $_POST["email"];
$phone = isset($_POST["tel"]) ? $_POST["tel"] : null;
$company = isset($_POST["empresa"]) ? $_POST["empresa"] : null;
// $service = isset($_POST["widget-contact-form-service"]) ? $_POST["widget-contact-form-service"] : null;
// // $subject = isset($_POST["widget-contact-form-subject"]) ? $_POST["widget-contact-form-subject"] : 'Formulario chori corta';
// $message = isset($_POST["widget-contact-form-message"]) ? $_POST["widget-contact-form-message"] : null;

// $recaptcha = $_POST['g-recaptcha-response'];
//inicio script grabar datos en csv
$fichero = 'turismo.csv';//nombre archivo ya creado
//crear linea de datos separado por coma
$fecha=date("Y-m-d H:i:s");
$linea = $fecha.";".$name.";".$company.";".$phone.";".$email."\n";
// Escribir la linea en el fichero
file_put_contents($fichero, $linea, FILE_APPEND | LOCK_EX);
//fin grabar datos

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	
    
 if($email != '') {
            
                //If you don't receive the email, enable and configure these parameters below: 
     
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->Debugoutput = "html";
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587;
                $mail->CharSet="UTF-8";
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->Username = "sprados@chimpancedigital.com.ar";
                $mail->Password = "Chimpance951#$";                                  // TCP port to connect to 
     
     	        $mail->IsHTML(true);                                    // Set email format to HTML
                $mail->CharSet = 'UTF-8';
     
                $mail->From = $email;
                $mail->FromName = $name;
                $mail->AddCC ('contacto@chimpancedigital.com.ar');
     
                $email_addresses = explode(',', $to);
                foreach ($email_addresses as $email_address) {
                     $mail->AddAddress(trim($email_address));
                }	
							  
                $mail->AddReplyTo($email, $name);
                $mail->Subject = 'Consulta landing turimo chimpa&idées';
          
                $name = isset($name) ? "Nombre y Apellido: $name<br><br>" : '';
                $email = isset($email) ? "Email: $email<br><br>" : '';
                $company = isset($company) ? "Empresa: $company<br><br>" : '';
                $phone = isset($phone) ? "Teléfono $phone<br><br>" : '';
                // $service = isset($service) ? "Service: $service<br><br>" : '';
                // $message = isset($message) ? "Message: $message<br><br>" : '';

                $mail->Body = $name . $email . $phone . $company . '<br><br><br>Mensaje enviado de: ' . $_SERVER['HTTP_REFERER'];
     
                if(!$mail->Send()) {
                    echo "<h4>error</h4>";  

                }else {
                    echo "<script>location.href='/gracias.html';</script>" ; //<script>location.href='enfermeria/gracias.html';</script>
                }
            }
        }        
?>