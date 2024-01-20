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
$modulo = '';
$nota1 = '';
$nota2 = '';
$nota3 = '';
$promedio = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
    $fcreacion = isset($_POST['fcreacion']) ? $_POST['fcreacion'] : '';
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : '';
    $sede = isset($_POST['sede']) ? $_POST['sede'] : '';
    $curso = isset($_POST['curso']) ? $_POST['curso'] : '';
    $idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : '';
    $modulo =  isset($_POST['modulo']) ? $_POST['modulo'] : '';

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
                    $cursoreg = $datos['Curso_Id'];
                }
            }
            $conexion->close();
        }
        if ($_POST['operaciones'] == 'Registrar') {
            $Nota_status = 1;
            $Nota_fecha = date('Y-m-d');
            $nota1 = floatval($_POST["nota1"]);
            $nota2 = floatval($_POST["nota2"]);
            $nota3 = floatval($_POST["nota3"]);
            $promedio = ($nota1 + $nota2 + $nota3) / 3;

            $consulta_total = $conexion->query("SELECT COUNT(*) as total FROM Notas");
            $total_registros = $consulta_total->fetch_assoc()['total'];

            $nuevo_codigo = 'ntsil-' . str_pad($total_registros + 1, 4, '0', STR_PAD_LEFT);

            $consulta = $conexion->query("INSERT INTO Notas(Notas_Codigo,Usuario_id,Modulo_id,Nota_1,Nota_2,Nota_3,Nota_status,Nota_fecha,Notas_Promedio) VALUES('$nuevo_codigo','$idUsuario','$modulo','$nota1','$nota2','$nota3','$Nota_status','$Nota_fecha','$promedio')");

            if ($consulta) {
                $mensaje = "✅ Registrado con éxito";
            } else {
                $mensaje = "❌ Error al registrar";
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                                <li class="nav-item"> <a class="nav-link" href="./registrar-nota.php">Registrar Notas</a></li>
                                <li class="nav-item"> <a class="nav-link" href="./lista-notas.php">Lista de Notas</a></li>
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
                                    <h4 class="card-title">Registrar Notas de Alumnos</h4>
                                </div>
                                <div class="d-flex ">
                                    <form action="" method="post" class="d-flex">
                                        <input type="text" name="codigo" placeholder="Ingresar Matrícula" class="form-control" />
                                        <button type="submit" value="Buscar" name="operaciones" class="btn btn-primary mx-2">Buscar</button>
                                    </form>
                                </div>
                                <hr>
                                <br>
                                <form class="form-sample" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row" hidden>
                                                <label class="col-sm-3 col-form-label">Id</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="idUsuario" value="<?php echo $idUsuario; ?>" />
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
                                                <label class="col-sm-3 col-form-label">Apellidos</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="apellidos" required value="<?php echo $apellidos; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nombres</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nombres" required value="<?php echo $nombres; ?>" />
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
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Código de Módulo</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="modulo" required>
                                                        <option>Elige una opción</option>
                                                        <?php

                                                        switch ($cursoreg) {
                                                            case 1:
                                                                echo '<option value="1">Estrategias Didácticas y Programa curricular de Educación Inicial</option>
                                                                <option value="2">Terapia de Lenguaje</option>
                                                                <option value="3">Problema de aprendizaje y educación especial </option>
                                                                <option value="4">Ambientación de aula y materiales didácticos </option>
                                                                <option value="5">Enfoque pedagógico del nivel de educación inicial y primaria. </option>
                                                                <option value="6">Danza y canciones infantiles </option>
                                                                <option value="7">Proyección Social </option>
                                                                <option value="8">Inglés y literatura Infantil</option>
                                                                <option value="9">Nutrición escolar y primeros auxilios</option>
                                                                <option value="10">Psicomotricidad y psicología del niño</option>
                                                                <option value="11">Tutoría educativa y redacción técnica </option>
                                                                <option value="12">Estimulación temprana</option>
                                                                ';
                                                                break;
                                                            case 2:
                                                                echo '<option value="13">Anatomía Funcional Bioseguridad y atención en urgencias y emergencias</option>
                                                                <option value="14">Primeros Auxilios e inyectoterapia</option>
                                                                <option value="15">Semiologia y farmacología </option>
                                                                <option value="16">Triaje y atención de urgencias </option>
                                                                <option value="17">Inyectables</option>
                                                                <option value="18">Técnicas de tendido de cama y aseo del paciente</option>
                                                                <option value="19">Asistencia y cuidado infantil</option>
                                                                <option value="20">Asistencia y cuidado del adulto mayor</option>
                                                                <option value="21">Situación de salud</option>
                                                                <option value="22">Colocación de vías endovenosas</option>
                                                                <option value="23">Colocación de vías endovenosas</option>
                                                                <option value="24">Proyecto final </option>
                                                                ';
                                                                break;
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nota 1</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nota1" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nota 2</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nota2" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nota 3</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nota3" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2" name="operaciones" value="Registrar">
                            Registrar
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