<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=cri', 'phoenix', 'phx');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
?>
