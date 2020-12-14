<?php
session_start();
require_once "c_pdo.php";
/*
Session:
['rol']

Post:
['user']
['pass']
*/
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
if( !isset($_SESSION['idUsuario']) || !isset($_SESSION['permisos'])){
    die('Sesion no iniciada');
}

if( !isset($_POST['rbfiliacion']) || !isset($_POST['rbpermisos'])){
	$_SESSION["error"] = "Debe llenar todos los campos obligatorios";
    header('Location: c_newuser.php');
    return;
}
if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['celular']) && isset($_POST['telefono']) && isset($_POST['rbfiliacion']) && isset($_POST['tUnidadI']) && isset($_POST['rbpermisos'])){

	echo "<pre>";
print_r($_POST);
echo "</pre>";

	if(strlen($_POST['nombre']) < 1 || strlen($_POST['rbfiliacion']) < 1 || strlen($_POST['rbpermisos']) < 1 ){
        $_SESSION["error"] = "Debe llenar todos los campos obligatorios";
        header('Location: c_newuser.php');
        return;
    }
    /*
    else if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $failure = "Email address must contain @";
        $_SESSION["error"] = $failure;
        header('Location: add.php');
        return;
    }
    else{
        // aqui vamos a validar las posiciones.
        function validatePos(){
            for ($i=1; $i <= 9 ; $i++) {
                if( !isset($_POST['year'.$i]) ) continue;
                if( !isset($_POST['desc'.$i]) ) continue;
                $year = $_POST['year'.$i];
                $desc = $_POST['desc'.$i];
                if(strlen($year) == 0 || strlen($desc) == 0){
                    return "All fields are required";
                }
                if( !is_numeric($year)){
                    return "Position year must be numeric";
                }
            }
            return true;
        }
        $failure = validatePos();
        if ( is_string($failure)) {
            $_SESSION['error'] = $failure;
            header("Location: add.php");
            return;
        }

        // Aqui vamos a validar las educations
        function validateEdu(){
            for ($i=1; $i <= 9 ; $i++) {
                if( !isset($_POST['edu_year'.$i]) ) continue;
                if( !isset($_POST['sch'.$i]) ) continue;
                $year = $_POST['edu_year'.$i];
                $sch = $_POST['sch'.$i];
                if(strlen($year) == 0 || strlen($sch) == 0){
                    return "All fields are required";
                }
                if( !is_numeric($year)){
                    return "Education year must be numeric";
                }
            }
            return true;
        }
        $failure = validateEdu();
        if ( is_string($failure)) {
            $_SESSION['error'] = $failure;
            header("Location: add.php");
            return;
        }

        // Si pasa la prueba de arriba, ahora si los datos son 100% validos
        $sql = "INSERT INTO profile (user_id, first_name, last_name, email, headline, summary)
                VALUES (:uid, :fn, :lsn, :em, :he, :su)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => $_POST['first_name'],
            ':lsn' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary'])
        );

        // Ahora, con la llave del perfil recien añadido, creamos los "positions"
        $profile_id = $pdo->lastInsertId(); // la pk del profile insertado recien

        $rank = 1; // usamos rank para tener info del orden en el que se guardan y el orden en el que debemos imprimirlos posteriormente
        for ($i=1; $i <= 9 ; $i++) {
            if( !isset($_POST['year'.$i]) ) continue;
            if( !isset($_POST['desc'.$i]) ) continue;
            $year = $_POST['year'.$i]; // año
            $desc = $_POST['desc'.$i]; // descripcion

            $sql = 'INSERT INTO position (profile_id, rank, year, description)
                    VALUES (:pid, :rank, :year, :descr)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':pid' => $profile_id,
                ':rank' => $rank,
                ':year' => $year,
                ':descr' => $desc
            ));
            $rank++;
        }

        // Finalmente, los "educations"
        $rank = 1; // usamos rank para tener info del orden en el que se guardan y el orden en el que debemos imprimirlos posteriormente
        for ($i=1; $i <= 9 ; $i++) {
            if( !isset($_POST['edu_year'.$i]) ) continue;
            if( !isset($_POST['sch'.$i]) ) continue;
            $year = $_POST['edu_year'.$i]; // año
            $sch = $_POST['sch'.$i]; // descripcion

            // primero comprobamos si la escuela ingresada ya existe o no en nuestra bdd
            $inst_id = false;
            $sql = 'SELECT institution_id
                    FROM institution
                    WHERE name = :name';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':name' => $sch
            ));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row !== false){ // significa que ya existe
                $inst_id = $row['institution_id'];
            }

            if( $inst_id === false){ // si no existe, la creamos
                $sql = 'INSERT INTO institution (name)
                        VALUES (:name)';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':name' => $sch
                ));
                $inst_id = $pdo->lastInsertId();
            }

            // ya con el institution_id en nuestras manos, procedemos a insertar todo
            $sql = 'INSERT INTO education (profile_id, rank, year, institution_id)
                    VALUES (:pid, :rank, :year, :inst_id)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':pid' => $profile_id,
                ':rank' => $rank,
                ':year' => $year,
                ':inst_id' => $inst_id
            ));
            $rank++;
        }

        $insert = "Record added";
        $_SESSION["success"] = $insert;
        header('Location: index.php');
        return;
    }*/
}

?>
