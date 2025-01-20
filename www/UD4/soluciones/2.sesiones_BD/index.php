<?php
    session_start();
    if(!isset($_SESSION['usuario'])) {
        header("Location: sesiones2_login.php?redirigido=true");
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Página principal</title>
		<!--<link rel = "stylesheet" href = "./css/alta_usuarios.css">-->
		<meta charset = "UTF-8">
	</head>
	<body>		
		<?php echo "Bienvenido " . $_SESSION['usuario']['usuario'];?>
		<br><a href = "sesiones2_logout.php"> Salir <a>
	</body>
</html>