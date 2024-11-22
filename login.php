<?php
require_once __DIR__ . "/log.php";

// Iniciamos Sesion ( si la cookie se comparte)
session_start();

// Destruimos la sesion
session_destroy();

// La volvemos a iniciar en limpio
session_start();

if(isset($_POST['iniciar'])) {
    $usuario = $_POST['nomUsuario'];
    $contraseña = $_POST['contrasena'];


    $login = new Login();

    if ($login->verificarLogin($usuario, $contraseña)) {
        // Redirigir al usuario según su rol
        switch ($_SESSION['rol']) {
            case 'Administrador':
                header('Location: index.php');
                break;
            case 'Estudiante':
                header('Location: index.php');
                break;
            case 'Profesor':
                header('Location: index.php');
                break;
            default:
                header('Location: index.php');
                break;
        }
    } else {
        echo "Usuario o contraseña incorrectos.";
    }


}


?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="icon" href="vendor/images/icon-home.png" type="image/png">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Iniciar Sesión</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="vendor/bootstrap/bootstrap-3.3.2/bootstrap3.3.2.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<!-- Animate CSS -->
	<link rel="stylesheet" href="vendor/animate/animate.css">

	<!-- Local CSS -->
	<link rel="stylesheet" href="vendor/css/root/login/css/util.css">
	<link rel="stylesheet" href="vendor/css/root/login/css/main.css?v=2">
	<link rel="stylesheet" href="vendor/css/preloader.css?n=1">


</head>

<body>
	<div class="loader_container">
		<div class="loader">
			<div class="one"></div>
			<div class="two"></div>
			<div class="three"></div>
			<div class="four"></div>
			<div class="five"></div>
			<div class="six"></div>
			<div class="seven"></div>
			<div class="eight"></div>
		</div>
	</div>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('vendor/images/background-login.jpg');">
			<div class="wrap-login100 p-b-30">
				<form id="login-form" method="post" class="login100-form validate-form">
					<div class="login100-form-avatar">
					</div>
				
					<div class="wrap-input100 validate-input m-b-10" data-validate="Ingrese su Usuario">
						<input class="input100" type="text" name="nomUsuario" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate="Ingrese su Clave">
						<input class="input100" type="password" name="contrasena" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button type="submit" name="iniciar" class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="vendor/jquery/jquery3.3.1.min.js"></script>
	<script src="vendor/js/general.js"></script>
	<script src="vendor/js/root/login/js/main.js?v=1"></script>


</body>


</html>