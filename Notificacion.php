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
		// cambiar el correo y contraseña
		$mail = new PHPMailer(true);
		// $mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'gamma385438@gmail.com';
		$mail->Password   = 'password123A';
		$mail->SMTPSecure = 'tls';
		foreach ($addresses as $index => $destiny) {			
			if($index === 1){
				try {
					$mail->setFrom('gamma385438@gmail.com', 'Unidad de Investigacion UCB');
					$mail->addAddress($destiny);
					$mail->isHTML(true);
					$mail->Subject = 'Se creo un nuevo Usuario';
					$mail->Body    = '<div align="center"><h1>Se creo un nuevo Usuario</h1></div>
									 <b>Usuario: </b> ' . $user . '<br>
									 <b>Contrase&ntilde;a: </b> ' . $user . '<br> Se recomienda cambiar su contrase&ntilde;a
									 lo mas antes posible.';
					$mail->send();
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}	
			}
			else{
				try {
					$mail->setFrom('gamma385438@gmail.com', 'Unidad de Investigacion UCB');
					$mail->addAddress($destiny);
					$mail->isHTML(true);
					$mail->Subject = 'Se creo un nuevo Usuario';
					$mail->Body    = '<div align="center"><h1>Se creo un nuevo Usuario</h1></div>' . '\n' .
										'<b>Usuario: </b>' . $user . '<br>\n' .
										'<b>Contrase&ntilde;a: </b>' . $user . '<br>\n';
					$mail->send();
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
			}
		}		
	}

	public function cierreInv($addresses, $nombre_investigacion, $investigador){
		// cambiar el correo y contraseña
		$mail = new PHPMailer(true);
		// $mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'gamma385438@gmail.com';
		$mail->Password   = 'password123A';
		$mail->SMTPSecure = 'tls';
		foreach ($addresses as $index => $destiny) {			
			try {
				
				$mail->setFrom('gamma385438@gmail.com', 'Unidad de Investigacion UCB');
				$mail->addAddress($destiny);
				$mail->isHTML(true);
				$mail->Subject = 'Se cerro una Investigaci&oacute;n';
				$mail->Body    = 'Se acaba de confirmar el cierre de la Investigaci&oacute;n: <b>' . $nombre_investigacion . 
								 '</b> por el usuario <b>' . $investigador . 
								 '</b><br>Si desea deshacer esta accion Dirigirse a los detalles de la Investigaci&oacute;n.';
				$mail->send();
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}	
		}
	}

	public function cierrePub($addresses, $nombre_publicacion, $investigador){
		// cambiar el correo y contraseña
		$mail = new PHPMailer(true);
		// $mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'gamma385438@gmail.com';
		$mail->Password   = 'password123A';
		$mail->SMTPSecure = 'tls';
		foreach ($addresses as $index => $destiny) {			
			try {
				
				$mail->setFrom('gamma385438@gmail.com', 'Unidad de Investigacion UCB');
				$mail->addAddress($destiny);
				$mail->isHTML(true);
				$mail->Subject = 'Se cerro una Publicaci&oacute;n';
				$mail->Body    = 'Se acaba de confirmar el cierre de la Publicaci&oacute;n: <b>:' . $nombre_publicacion . 
								 '</b> por el usuario: <b>' . $investigador . 
								 '</b><br>Si desea deshacer esta accion Dirigirse a los detalles de la Publicaci&oacute;n.';
				$mail->send();
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}	
		}
	}

	public function documentoFinalPub($addresses, $nombre_publicacion, $investigador){
		// cambiar el correo y contraseña
		$mail = new PHPMailer(true);
		// $mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'gamma385438@gmail.com';
		$mail->Password   = 'password123A';
		$mail->SMTPSecure = 'tls';
		foreach ($addresses as $index => $destiny) {			
			try {
				
				$mail->setFrom('gamma385438@gmail.com', 'Unidad de Investigacion UCB');
				$mail->addAddress($destiny);
				$mail->isHTML(true);
				$mail->Subject = 'Se subio el documento final';
				$mail->Body    = 'Se acaba de subir el documento final de la Publicaci&oacute;n: <b>' . $nombre_publicacion . 
								 '</b> por el Usuario: <b>' . $investigador . 
								 '</b><br>Si desea revisar el documento dirijase a los detalles de la Publicaci&oacute;n.';
				$mail->send();
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}	
		}
	}

	public function revisionCompleta($address, $titulo_pub){
		$mail = new PHPMailer(true);
		// $mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'gamma385438@gmail.com';
		$mail->Password   = 'password123A';
		$mail->SMTPSecure = 'tls';	
		try {
			
			$mail->setFrom('gamma385438@gmail.com', 'Unidad de Investigacion UCB');
			$mail->addAddress($address);
			$mail->isHTML(true);
			$mail->Subject = 'Se reviso el documento final';
			$mail->Body    = 'Se acaba de revisar el documento final de la Publicaci&oacute;n: <b>' . $titulo_pub . '</b>
							<br>Si desea ver la revision del documento dirijase a los detalles de la Publicaci&oacute;n.';
			$mail->send();
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}	
	}

	public function reaperturaPub($address, $titulo_pub){
		$mail = new PHPMailer(true);
		// $mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'gamma385438@gmail.com';
		$mail->Password   = 'password123A';
		$mail->SMTPSecure = 'tls';	
		try {
			
			$mail->setFrom('gamma385438@gmail.com', 'Unidad de Investigacion UCB');
			$mail->addAddress($address);
			$mail->isHTML(true);
			$mail->Subject = 'Se reabrio su publicacion';
			$mail->Body    = 'Se acaba de reabrir la Publicaci&oacute;n: <b>' . $titulo_pub . '</b>';
			$mail->send();
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}	
	}

	public function reaperturaInv($address, $titulo_inv){
		$mail = new PHPMailer(true);
		// $mail->SMTPDebug = 1;
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'gamma385438@gmail.com';
		$mail->Password   = 'password123A';
		$mail->SMTPSecure = 'tls';	
		try {
			
			$mail->setFrom('gamma385438@gmail.com', 'Unidad de Investigacion UCB');
			$mail->addAddress($address);
			$mail->isHTML(true);
			$mail->Subject = 'Se reabrio su investigacion';
			$mail->Body    = 'Se acaba de reabrir la Investigaci&oacute;n: <b>' . $titulo_inv . '</b>';
			$mail->send();
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}	
	}
}
?>

