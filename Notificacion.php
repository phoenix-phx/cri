<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once "c_pdo.php";
require_once "Usuario.php";
class Notificacion{
	// fields go here
	protected $rol;
	protected $id;
	
	// getters and setters go here
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getNombre(){
		return $this->nombre;
	}

	// methods go here
	public function nuevoUsuario($addresses, $user){
		$mail = new PHPMailer(true);
		$mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'gamma385438@gmail.com';
		$mail->Password   = 'password123A';
		$mail->SMTPSecure = 'tls';
		foreach ($addresses as $index => $destiny) {			
			if($index === 1){
				try {
					$mail->setFrom('gamma385438@gmail.com', 'Gamma Epsilon');
					$mail->addAddress($destiny);
					$mail->isHTML(true);
					$mail->Subject = 'Se creo un nuevo Usuario';
					$mail->Body    = '<div align="center"><h1>Se creo un nuevo Usuario</h1></div>
									 <b>Usuario: </b> ' . $user . '<br>
									 <b>Contrase&ntilde;a: </b> ' . $user . '<br> Se recomienda cambiar su contrase&ntilde;a
									 lo mas antes posible';
					$mail->send();
					echo 'Message has been sent';
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}	
			}
			else{
				try {
					$mail->setFrom('gamma385438@gmail.com', 'Gamma Epsilon');
					$mail->addAddress($destiny);
					$mail->isHTML(true);
					$mail->Subject = 'Se creo un nuevo Usuario';
					$mail->Body    = '<div align="center"><h1>Se creo un nuevo Usuario</h1></div>' . '\n' .
										'<b>Usuario: </b>' . $user . '<br>\n' .
										'<b>Contrase&ntilde;a: </b>' . $user . '<br>\n';
					$mail->send();
					echo 'Message has been sent';
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
			}
			// funcionamiento comprobado
			// $index es el indice del array
			// $destiny es el destinatario del correo
			// write code here...
		}		
	}
}
?>

