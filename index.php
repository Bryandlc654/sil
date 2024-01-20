<?php
require_once(__DIR__ . '/database/database.php');
session_start();

$dni = '';
$contrasena = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
  $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

  if ($conexion) {
    $consulta = $conexion->query("SELECT * FROM Usuarios WHERE Usuario_dni = '$dni' AND Usuario_contrasena = '$contrasena' AND Usuario_status = 1");

    if ($consulta->num_rows > 0) {
      $usuario = $consulta->fetch_assoc();
      $_SESSION['usuario'] = $usuario;
      header("Location: ./pages/dashboard/dashboard.php");
      exit();
    } else {
      $consultaDni = $conexion->query("SELECT * FROM Usuarios WHERE Usuario_dni = '$dni'");
      if ($consultaDni->num_rows == 0) {
        $mensaje = 'Usuario no existe';
      } else {
        $consultaus = $conexion->query("SELECT * FROM Usuarios WHERE Usuario_dni = '$dni' AND Usuario_contrasena = '$contrasena' AND Usuario_status = 0");
        if ($consultaus->num_rows > 0) {
          $mensaje = 'Usuario Deshabilitado';
        } else {
          $mensaje = 'Contraseña incorrecta';
        }
      }
    }
    $conexion->close();
  }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIL</title>
  <link rel="stylesheet" href="./css/login.css">
  <link rel="shortcut icon" href="./images/logosidebard.png" type="image/x-icon">
</head>

<body>
  <div class="container">
    <div class="left">
      <div class="header">
        <img src="./images/logo.png" class="animation a1 logo" alt="Logo">
        <h2 class="animation a1">Iniciar Sesión</h2>
      </div>
      <div>
        <form action="" method="post" class="form">
          <input type="text" class="form-field animation a3" placeholder="Usuario" pattern="[0-9]{8}"
            title="Ingrese un DNI válido de 8 dígitos" required name="dni">
          <input type="password" class="form-field animation a4" placeholder="Contraseña" required name="contrasena">
          <p class="animation a5 reset__password"><a href="#">¿Olvidaste tu contraseña?</a></p>
          <button class="animation a6" type="submit" id="liveToastBtn">Ingresar</button>
        </form>
        <span class="text__alert">
          <?php echo $mensaje; ?>
        </span>
      </div>
    </div>
    <div class="right"></div>
  </div>



</body>

</html>