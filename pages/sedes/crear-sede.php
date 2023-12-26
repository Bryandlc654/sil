<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Redirige a la página de inicio de sesión o maneja la situación según sea necesario
    header("Location: ../../index.php");
    exit();
}

// Ahora puedes acceder a la información del usuario usando $_SESSION['usuario']
$usuario = $_SESSION['usuario'];


include '../../database/database.php';

$mensaje = '';
$nombre_sede = '';
$direccion = '';
$institucion = '';
$distrito = '';
$provincia = '';
$departamento = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_sede = isset($_POST['nombre_sede']) ? $_POST['nombre_sede'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $institucion = isset($_POST['institucion']) ? $_POST['institucion'] : '';
    $distrito = isset($_POST['distrito']) ? $_POST['distrito'] : '';
    $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : '';
    $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';

    if ($conexion) {
        $consulta = $conexion->query("INSERT INTO Sedes(Sede_nombre,Sede_direccion,Sede_institucion,Sede_distrito,Sede_provincia,Sede_departamento) VALUES('$nombre_sede','$direccion','$institucion','$distrito','$provincia','$departamento')");
        if ($consulta) {
            $mensaje = "✅ Sede registrada con éxito";
        } else {
            $mensaje = "❌ Error al registrar";
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
    <title>ISIL</title>
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
                <a class="navbar-brand brand-logo mr-5" href="../dashboard/dashboard.php"><img
                        src="../../images/logo.png" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="../dashboard/dashboard.php"><img
                        src="../../images/logosidebard.png" alt="logo" /></a>
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
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="../profile/profile.php">
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
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
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
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                            aria-controls="ui-basic">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Usuarios</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="../usuarios/registrar-usuarios.php">Registrar
                                        usuarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../usuarios/perfil-usuarios.php">Editar
                                        usuarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../usuarios/roles.php">Editar Rol</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="../usuarios/gestion-usuarios.php">Gestión de
                                        usuarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../usuarios/lista-usuarios.php">Lista de
                                        usuarios</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#cursos" aria-expanded="false"
                            aria-controls="#cursos">
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
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#sedes" aria-expanded="false"
                            aria-controls="#sedes">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Sedes</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="sedes">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="./crear-sede.php">Registrar
                                        Sede</a></li>
                                <li class="nav-item"> <a class="nav-link" href="./lista-sedes.php">Lista de
                                        Sedes</a></li>
                                <li class="nav-item"> <a class="nav-link" href="./editar-sede.php">Editar
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
                                    <h4 class="card-title">Registrar Sedes</h4>
                                    <span>
                                        <?php echo $mensaje ?>
                                    </span>
                                </div>
                                <form class="form-sample" method="post" enctype="multipart/form-data">
                                    <p class="card-description">
                                        Información de Sede
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nombre</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nombre_sede" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Dirección</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="direccion" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Institución</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="institucion" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Distrito</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="distrito" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Provincia</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="provincia" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Departamento</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="departamento" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2">
                                        Registrar
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