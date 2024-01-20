<?php
include '../../database/database.php';

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    // Si la sesión no está iniciada, redirigir a la página de login
    header("Location: ../../index.php");
    exit();
}

$mensaje = '';
$dni = '';
$fcreacion = '';
$apellidos = '';
$nombres = '';
$genero = '';
$fnacimiento = '';
$direccion = '';
$distrito = '';
$provincia = '';
$departamento = '';
$celular = '';
$correo = '';
$foto = '';
$rol = '';
$sede = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
    $fcreacion = isset($_POST['fcreacion']) ? $_POST['fcreacion'] : '';
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : '';
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
    $fnacimiento = isset($_POST['fnacimiento']) ? $_POST['fnacimiento'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $distrito = isset($_POST['distrito']) ? $_POST['distrito'] : '';
    $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : '';
    $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';
    $celular = isset($_POST['celular']) ? $_POST['celular'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $rol = isset($_POST['rol']) ? $_POST['rol'] : '';
    $sede = isset($_POST['sede']) ? $_POST['sede'] : '';

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_nombre = $_FILES['foto']['name'];
        $foto_extension = strtolower(pathinfo($foto_nombre, PATHINFO_EXTENSION));

        // Array de extensiones permitidas
        $extensiones_permitidas = ['jpg', 'jpeg', 'png'];

        // Verificar la extensión del archivo
        if (in_array($foto_extension, $extensiones_permitidas)) {
            $ruta_destino = '../../fotos/' . $foto_nombre;

            // Mover el archivo a la carpeta de destino
            move_uploaded_file($foto_tmp, $ruta_destino);

            // Guardar la ruta en la variable $foto para almacenarla en la base de datos
            $foto = $ruta_destino;
        } else {
            $mensaje = "⚠️ Error de formato de imagen";
        }
    }

    if ($conexion && empty($mensaje)) {
        if (empty($foto)) {
            $consulta = $conexion->query("
        UPDATE Usuarios 
        SET 
            Usuario_dni = '$dni',
            Usuario_nombres = '$nombres',
            Usuario_apellidos = '$apellidos',
            Usuario_fnacimiento = '$fnacimiento',
            Usuario_fcreacion = '$fcreacion',
            Usuario_sexo = '$genero',
            Usuario_direccion = '$direccion',
            Usuario_distrito = '$distrito',
            Usuario_provincia = '$provincia',
            Usuario_departamento = '$departamento',
            Usuario_celular = '$celular',
            Usuario_correo = '$correo',
            Rol_id = '$rol'
            Sede_Id = '$sede'
        WHERE Usuario_id = '$dni'
    ");
        } else {
            $consulta = $conexion->query("
        UPDATE Usuarios 
        SET 
            Usuario_dni = '$dni',
            Usuario_nombres = '$nombres',
            Usuario_apellidos = '$apellidos',
            Usuario_fnacimiento = '$fnacimiento',
            Usuario_fcreacion = '$fcreacion',
            Usuario_sexo = '$genero',
            Usuario_direccion = '$direccion',
            Usuario_distrito = '$distrito',
            Usuario_provincia = '$provincia',
            Usuario_departamento = '$departamento',
            Usuario_celular = '$celular',
            Usuario_correo = '$correo',
            Usuario_foto = '$foto',
            Rol_id = '$rol'
            Sede_Id = '$sede'
        WHERE Usuario_id = '$dni'
    ");
        }
        if ($consulta) {
            $mensaje = "✅ Actualizado con éxito";
        } else {
            $mensaje = "❌ Error al actualizar";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SIL</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../vendors/feather/feather.css">
    <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="../template/vendors/codemirror/codemirror.css">
    <link rel="stylesheet" href="../template/vendors/codemirror/ambiance.css">
    <link rel="stylesheet" href="../template/vendors/pwstabs/jquery.pwstabs.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="../../css/login.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/logosidebard.png" type="image/x-icon">
</head>

<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="../dashboard/dashboard.php"><img src="../../images/logo.png" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="../dashboard/dashboard.php"><img src="../../images/logosidebard.png" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <?php
                            $fotoUsuario = isset($_SESSION['usuario']['Usuario_foto']) ? $_SESSION['usuario']['Usuario_foto'] : null;

                            if ($fotoUsuario && file_exists($fotoUsuario)) {
                                // Si hay una foto en la base de datos y el archivo existe, mostrarla
                                echo '<img src="' . $fotoUsuario . '" alt="Foto de perfil" class="img-perfil">';
                            } else {
                                // Si no hay foto en la base de datos o el archivo no existe, mostrar la foto por defecto
                                echo '<img src="../../fotos/user.png" alt="Foto de perfil por defecto">';
                            }
                            ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="./profile.php">
                                <i class="ti-settings text-primary"></i>
                                Editar Perfil
                            </a>
                            <a class="dropdown-item" href="../dashboard/logout.php">
                                <i class="ti-power-off text-primary"></i>
                                Cerrar Sesión
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial:../../partials/_sidebar.html -->
        <div class="container-fluid page-body-wrapper">

            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../dashboard/dashboard.php">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Usuarios</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../usuarios/registrar-usuarios.php">Registrar
                                        usuarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../usuarios/perfil-usuarios.php">Editar
                                        usuarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../usuarios/roles.php">Editar Rol</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="../usuarios/gestion-usuarios.php">Gestión de
                                        usuarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../usuarios/lista-usuarios.php">Lista de
                                        usuarios</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#cursos" aria-expanded="false" aria-controls="#cursos">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Cursos</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="cursos">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../cursos/crear-cursos.php">Registrar
                                        Cursos</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../cursos/lista-cursos.php">Lista de
                                        Cursos</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../cursos/editar-cursos.php">Editar
                                        Cursos</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#modulos" aria-expanded="false" aria-controls="#modulos">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Módulos</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="modulos">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../modulos/crear-modulos.php">Registrar
                                        Módulos</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../modulos/lista-modulos.php">Lista de
                                        Módulos</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../modulos/editar-modulos.php">Editar
                                        Módulos</a></li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#matriculas" aria-expanded="false" aria-controls="#matriculas">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Matrículas</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="matriculas">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../matriculas/registro-matricula.php">Matricular
                                        alumno</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../matriculas/lista-matriculas.php">Lista Matriculas</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="../matriculas/editar-matriculas.php">Editar
                                        Matriculas</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#notas" aria-expanded="false" aria-controls="#notas">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Notas</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="notas">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../notas/registrar-nota.php">Registrar Notas</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../notas/lista-notas.php">Lista de Notas</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#sedes" aria-expanded="false" aria-controls="#sedes">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Sedes</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="sedes">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../sedes/crear-sede.php">Registrar
                                        Sede</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../sedes/lista-sedes.php">Lista de
                                        Sedes</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../sedes/editar-sede.php">Editar
                                        Sedes</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../profile/profile.php">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Editar Perfil</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div id="cuerpo" class="content-wrapper">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">Editar Perfil</h4>
                                    <span>
                                        <?php echo $mensaje ?>
                                    </span>
                                </div>
                                <form class="form-sample" method="post" enctype="multipart/form-data">
                                    <p class="card-description">
                                        Información Personal
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Dni</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="dni" required value="<?php echo $usuario['Usuario_dni']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Fecha de Registro</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" name="fcreacion" required value="<?php echo $usuario['Usuario_fcreacion']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Apellidos</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="apellidos" required value="<?php echo $usuario['Usuario_apellidos']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nombres</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nombres" required value="<?php echo $usuario['Usuario_nombres']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Género</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="genero">
                                                        <option <?php echo ($usuario['Usuario_sexo'] == '' ? 'selected' : ''); ?>>Elige una opción</option>
                                                        <option value="m" <?php echo ($usuario['Usuario_sexo'] == 'm' ? 'selected' : ''); ?>>Masculino</option>
                                                        <option value="f" <?php echo ($usuario['Usuario_sexo'] == 'f' ? 'selected' : ''); ?>>Femenino</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Fecha de Nacimiento</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" name="fnacimiento" required value="<?php echo $usuario['Usuario_fnacimiento']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="card-description">
                                        Información de Contacto
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Dirección</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" placeholder="Av. / Cl. / Jr. / Psje. / CP. / AH." name="direccion" value="<?php echo $usuario['Usuario_direccion']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Distrito</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="distrito" value="<?php echo $usuario['Usuario_distrito']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Provincia</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="provincia" value="<?php echo $usuario['Usuario_provincia']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Departamento</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="departamento" value="<?php echo $usuario['Usuario_departamento']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Celular</label>
                                                <div class="col-sm-9">
                                                    <input type="phone" class="form-control" name="celular" required value="<?php echo $usuario['Usuario_celular']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Correo</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" name="correo" value="<?php echo $usuario['Usuario_correo']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="card-description">
                                        Información de Usuario
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Foto</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control file-upload-info" name="foto">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Rol de Usuario</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="rol" required>
                                                        <option <?php echo ($usuario['Rol_id'] == '' ? 'selected' : ''); ?>>Elige una opción</option>
                                                        <option value="3" <?php echo ($usuario['Rol_id'] == '3' ? 'selected' : ''); ?>>Estudiante</option>
                                                        <option value="2" <?php echo ($usuario['Rol_id'] == '2' ? 'selected' : ''); ?>>Profesor</option>
                                                        <option value="1" <?php echo ($usuario['Rol_id'] == '1' ? 'selected' : ''); ?>>Administrador</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sede</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="rol" required>
                                                    <option <?php echo ($usuario['Sede_Id'] == '' ? 'selected' : ''); ?>>
                                                        Elige una
                                                        opción</option>
                                                    <option value="1" <?php echo ($usuario['Sede_Id'] == '1' ? 'selected' : ''); ?>>
                                                        Chincha</option>
                                                    <option value="2" <?php echo ($usuario['Sede_Id'] == '2' ? 'selected' : ''); ?>>
                                                        Cañete</option>
                                                    <option value="3" <?php echo ($usuario['Sede_Id'] == '3' ? 'selected' : ''); ?>>
                                                        Pisco</option>
                                                    <option value="4" <?php echo ($usuario['Sede_Id'] == '4' ? 'selected' : ''); ?>>
                                                        Ica</option>
                                                    <option value="5" <?php echo ($usuario['Sede_Id'] == '5' ? 'selected' : ''); ?>>
                                                        Cajamarca</option>
                                                    <option value="6" <?php echo ($usuario['Sede_Id'] == '5' ? 'selected' : ''); ?>>
                                                        Arequipa</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2">
                                        Actualizar
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <!-- endinject -->
</body>

</html>