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
                                <li class="nav-item"> <a class="nav-link" href="./registrar-usuarios.php">Registrar
                                        usuarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="./perfil-usuarios.php">Editar
                                        usuarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="./roles.php">Editar Rol</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="./gestion-usuarios.php">Gestión de
                                        usuarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="./lista-usuarios.php">Lista de
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
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <br>
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title">Editar Rol de Usuarios</h4>
                                <div class="d-flex ">
                                    <form action="" method="post" class="d-flex">
                                        <input type="text" name="dni" placeholder="Ingresar DNI" class="form-control" />
                                        <button type="submit" value="Buscar" name="operaciones" class="btn btn-primary mx-2">Buscar</button>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Dni
                                            </th>
                                            <th>
                                                Apellidos
                                            </th>
                                            <th>
                                                Nombres
                                            </th>

                                            <th>
                                                Estatus
                                            </th>
                                            <th>
                                                Asignar Rol
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include '../../database/database.php';

                                        $dni = '';
                                        $rol = '';
                                        $mensaje = '';
                                        $usuario_dni = '';

                                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                            $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
                                            $rol = isset($_POST['rol']) ? $_POST['rol'] : '';
                                        }

                                        if (isset($_POST['operaciones'])) {
                                            if ($_POST['operaciones'] == 'Buscar') {
                                                $SedeId = $_SESSION['usuario']['Sede_Id'];
                                                $RolId = $_SESSION['usuario']['Rol_id'];
                                                if ($RolId == 4) {
                                                    $consulta = "SELECT * FROM Usuarios WHERE Usuario_dni='$dni'";
                                                } else {
                                                    $consulta = "SELECT * FROM Usuarios WHERE Usuario_dni='$dni' and Sede_Id ='$SedeId'";
                                                }
                                                if ($resultado = $conexion->query($consulta)) {
                                                    while ($fila = $resultado->fetch_assoc()) {
                                                        $dni = $fila['Usuario_dni'];
                                                        $rolactual = $fila['Rol_id'];
                                                        switch ($rolactual) {
                                                            case 1:
                                                                $rolresultado = 'Asistente';
                                                                break;
                                                            case 2:
                                                                $rolresultado = 'Profesor';
                                                                break;
                                                            case 3:
                                                                $rolresultado = 'Estudiante';
                                                                break;
                                                            case 4:
                                                                $rolresultado = 'Administrador';
                                                                break;
                                                        }
                                                        echo '
        <tr>
            <td>' . $fila['Usuario_dni'] . '</td>
            <td>' . $fila['Usuario_apellidos'] . '</td>
            <td>' . $fila['Usuario_nombres'] . '</td>
            <td>' . $rolresultado . '</td>
            <td>
                <div class="d-flex">
                    <form action="' . $_SERVER['PHP_SELF'] . '" method="post" class="d-flex">
                        <input type="hidden" name="usuario_dni" value="' . $dni . '">';
                                                        if ($RolId == 4) {
                                                            echo '<select name="rol" class="form-control">
                                    <option>Elegir Rol</option>
                                    <option value="3">Estudiante</option>
                                    <option value="2">Profesor</option>
                                    <option value="1">Asistente</option>
                                    <option value="4">Administrador</option>
                                  </select>';
                                                        } else {
                                                            echo '<select name="rol" class="form-control">
                                    <option>Elegir Rol</option>
                                    <option value="3">Estudiante</option>
                                    <option value="2">Profesor</option>
                                  </select>';
                                                        }

                                                        echo '<button type="submit" name="operaciones" value="actualizar" class="btn btn-success mx-2">Asignar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>';
                                                    }
                                                } else {
                                                    echo "No existe";
                                                }
                                            }

                                            if ($_POST['operaciones'] == 'actualizar') {
                                                $rol = $_POST['rol'];
                                                $usuario_id = $_POST['usuario_dni'];
                                                $consulta = "UPDATE Usuarios SET Rol_id ='$rol' WHERE Usuario_dni ='$usuario_id'";
                                                if ($conexion->query($consulta)) {
                                                    $mensaje = "✅ Rol actualizado correctamente";
                                                } else {
                                                    $mensaje = "❌ Error al actualizar";
                                                }
                                            }
                                        }

                                        ?>

                                    </tbody>
                                </table>
                                <span>
                                    <br>
                                    <?php echo $mensaje; ?>
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