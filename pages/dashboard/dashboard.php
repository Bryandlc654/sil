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

$consultausuarios = "SELECT COUNT(*) as totalUsuarios FROM Usuarios";
$resultadoTotalusuarios = $conexion->query($consultausuarios);
$datosTotalusuarios = $resultadoTotalusuarios->fetch_assoc();
$totalusuarios = $datosTotalusuarios['totalUsuarios'];

$consultaestudiantes = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Rol_id = 3";
$resultadoTotalestudiantes = $conexion->query($consultaestudiantes);
$datosTotalestudiantes = $resultadoTotalestudiantes->fetch_assoc();
$totalestudiantes = $datosTotalestudiantes['totalUsuarios'];

$consultaestudiantesdes = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Rol_id = 3 and Usuario_status = 0";
$resultadoTotalestudiantesdes = $conexion->query($consultaestudiantesdes);
$datosTotalestudiantesdes = $resultadoTotalestudiantesdes->fetch_assoc();
$totalestudiantesdes = $datosTotalestudiantesdes['totalUsuarios'];

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
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="dashboard.php"><img src="../../images/logo.png" class="mr-2"
            alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="dashboard.php"><img src="../../images/logosidebard.png"
            alt="logo" /></a>
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
              <a class="dropdown-item" href="./logout.php">
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
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
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
                <li class="nav-item"> <a class="nav-link" href="../usuarios/roles.php">Editar Rol</a></li>
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
                <li class="nav-item"> <a class="nav-link" href="../sedes/crear-sede.php">Registrar Sede</a></li>
                <li class="nav-item"> <a class="nav-link" href="../sedes/lista-sedes.php">Lista de Sedes</a></li>
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
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Hola,
                    <?php
                    $nombreUsuario = $_SESSION['usuario']['Usuario_nombres'];
                    echo $nombreUsuario; ?>
                  </h3>
                  <h6 class="font-weight-normal" id="fechaActual"></h6>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="../../images/people.png" alt="people" class="img_dashboard">
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Total de Usuarios</p>
                      <p class="fs-30 mb-2">
                        <?php echo $totalusuarios ?>
                      </p>
                      <p>Usuarios Registrados</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total de Estudiantes</p>
                      <p class="fs-30 mb-2">
                        <?php echo $totalestudiantes ?>
                      </p>
                      <p>Estudiantes Registrados</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Estudiantes Deshabilitados</p>
                      <p class="fs-30 mb-2">
                        <?php echo $totalestudiantesdes ?>
                      </p>
                      <p>Estudiantes</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Total Cursos</p>
                      <p class="fs-30 mb-2">0</p>
                      <p>Cursos</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Estudiantes por sede</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>N°</th>
                          <th>Sede</th>
                          <th>Cursos</th>
                          <th>Estudiantes</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Chincha</td>
                          <td>4</td>
                          <td>9</td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Cañete</td>
                          <td>4</td>
                          <td>9</td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Pisco</td>
                          <td>4</td>
                          <td>9</td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>Ica</td>
                          <td>4</td>
                          <td>9</td>
                        </tr>
                        <tr>
                          <td>5</td>
                          <td>Cajamarca</td>
                          <td>4</td>
                          <td>9</td>
                        </tr>


                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../../js/datetime.js"></script>
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/codeEditor.js"></script>
  <script src="../../js/tabs.js"></script>
  <script src="../../js/tooltips.js"></script>
  <script src="../../js/documentation.js"></script>
  <!-- End custom js for this page-->
</body>

</html>