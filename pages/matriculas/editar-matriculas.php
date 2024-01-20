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
$dni = '';
$codigo = '';
$fcreacion = '';
$apellidos = '';
$nombres = '';
$sede = '';
$curso = '';
$cursoreg = '';
$idUsuario = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
    $fcreacion = isset($_POST['fcreacion']) ? $_POST['fcreacion'] : '';
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : '';
    $sede = isset($_POST['sede']) ? $_POST['sede'] : '';
    $curso = isset($_POST['curso']) ? $_POST['curso'] : '';
    $idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : '';

    if (isset($_POST['operaciones'])) {
        if ($_POST['operaciones'] == 'Buscar') {
            if ($conexion) {
                $SedeId = $_SESSION['usuario']['Sede_Id'];
                $RolId = $_SESSION['usuario']['Rol_id'];
                if ($RolId == 4) {
                    $consulta = $conexion->query("SELECT Usuarios.*, Matriculas.*
                    FROM Usuarios
                    LEFT JOIN Matriculas ON Usuarios.Usuario_id = Matriculas.Usuario_Id
                    WHERE Matriculas.Matricula_Codigo = '$codigo'");
                } else {
                    $consulta = $conexion->query("SELECT Usuarios.*, Matriculas.Curso_Id
                    FROM Usuarios
                    LEFT JOIN Matriculas ON Usuarios.Usuario_id = Matriculas.Usuario_Id
                    WHERE Matriculas.Matricula_Codigo = '$codigo' and Sede_Id ='$SedeId'");
                }

                if ($datos = $consulta->fetch_assoc()) {
                    $idUsuario = $datos['Usuario_id'];
                    $dni = $datos['Usuario_dni'];
                    $nombres = $datos['Usuario_nombres'];
                    $apellidos = $datos['Usuario_apellidos'];
                    $sede = $datos['Sede_Id'];
                    $fregistro = $datos['Matricula_Fecha'];
                    $cursoreg = $datos['Curso_Id'];
                }
            }
            $conexion->close();
        }

        if ($_POST['operaciones'] == 'Actualizar') {
            if ($conexion) {
                $consulta = $conexion->query("
                UPDATE Matriculas 
                SET 
                    Curso_Id = '$curso',
                    Matricula_Fecha='$fcreacion'
                WHERE Matricula_Codigo = '$codigo'");

                if ($consulta) {
                    $mensaje = "✅ Actualizado con éxito";
                } else {
                    $mensaje = "❌ Error al actualizar";
                }
            }
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
                                <li class="nav-item"> <a class="nav-link" href="./registro-matricula.php">Matricular
                                        alumno</a></li>
                                <li class="nav-item"> <a class="nav-link" href="./lista-matriculas.php">Lista
                                        Matriculas</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="./editar-matriculas.php">Editar
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
                                    <h4 class="card-title">Editar Matrícula</h4>
                                    <div class="d-flex ">
                                        <form action="" method="post" class="d-flex">
                                            <input type="text" name="codigo" placeholder="Ingresar Matrícula" class="form-control" />
                                            <button type="submit" value="Buscar" name="operaciones" class="btn btn-primary mx-2">Buscar</button>
                                        </form>
                                    </div>
                                </div>
                                <form class="form-sample" method="post">
                                    <p class="card-description">
                                        Información Personal
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row" hidden>
                                                <label class="col-sm-3 col-form-label">Id</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Dni</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="dni" required value="<?php echo $dni; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Fecha de Matrícula</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" name="fcreacion" required value="<?php echo $fregistro; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Apellidos</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="apellidos" required value="<?php echo $apellidos; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nombres</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nombres" required value="<?php echo $nombres; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Sede</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="sede" required>
                                                        <option <?php echo ($sede == '' ? 'selected' : ''); ?>>Elige una
                                                            opción</option>
                                                        <?php
                                                        $SedeId = $_SESSION['usuario']['Sede_Id'];
                                                        $RolId = $_SESSION['usuario']['Rol_id'];
                                                        if ($RolId == 4) {
                                                            echo '<option value="1" ' . ($sede == '1' ? 'selected' : '') . '>
                                                            Chincha</option>
                                                        <option value="2" ' . ($sede == '2' ? 'selected' : '') . '>
                                                            Cañete</option>
                                                        <option value="3" ' . ($sede == '3' ? 'selected' : '') . '>
                                                            Pisco</option>
                                                        <option value="4" ' . ($sede == '4' ? 'selected' : '') . '>
                                                            Ica</option>
                                                        <option value="5" ' . ($sede == '5' ? 'selected' : '') . '>
                                                            Cajamarca</option>
                                                        <option value="6" ' . ($sede == '6' ? 'selected' : '') . '>
                                                            Arequipa</option>';
                                                        } else {
                                                            switch ($SedeId) {
                                                                case 1:
                                                                    echo '<option value="1" ' . ($sede == '1' ? 'selected' : '') . '>Chincha</option>';
                                                                    break;
                                                                case 2:
                                                                    echo '<option value="2" ' . ($sede == '2' ? 'selected' : '') . '>Cañete</option>';
                                                                    break;
                                                                case 3:
                                                                    echo '<option value="3" ' . ($sede == '3' ? 'selected' : '') . '>Pisco</option>';
                                                                    break;
                                                                case 4:
                                                                    echo '<option value="4" ' . ($sede == '4' ? 'selected' : '') . '>Ica</option>';
                                                                    break;
                                                                case 5:
                                                                    echo '<option value="5" ' . ($sede == '5' ? 'selected' : '') . '>Cajamarca</option>';
                                                                    break;
                                                                case 6:
                                                                    echo '<option value="6" ' . ($sede == '6' ? 'selected' : '') . '>Arequipa</option>';
                                                                    break;
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Curso</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="curso" required>
                                                        <option <?php echo ($cursoreg == '' ? 'selected' : ''); ?>>Elige
                                                            una
                                                            opción</option>
                                                        <option value="1" <?php echo ($cursoreg == '1' ? 'selected' : '') ?>>
                                                            Auxiliar de Educación</option>
                                                        <option value="2" <?php echo ($cursoreg == '2' ? 'selected' : '') ?>>
                                                            Auxiliar de Enfermería</option>
                                                        <option value="3" <?php echo ($cursoreg == '3' ? 'selected' : '') ?>>
                                                            Inyectoterapia</option>
                                                        <option value="4" <?php echo ($cursoreg == '4' ? 'selected' : '') ?>>
                                                            Auxiliar de Fisioterapia y Rehabilitación
                                                        </option>
                                                        <option value="5" <?php echo ($cursoreg == '5' ? 'selected' : '') ?>>
                                                            Podología
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="operaciones" value="Actualizar">
                                        Actualizar
                                    </button>
                                </form>
                                <span>
                                    <?php echo $mensaje ?>
                                </span>
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