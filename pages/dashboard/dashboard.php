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

$consultaestudiantesdeschincha = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 1 and Rol_id = 3";
$resultadoTotalestudianteschincha = $conexion->query($consultaestudiantesdeschincha);
$datosTotalestudianteschincha = $resultadoTotalestudianteschincha->fetch_assoc();
$totalestudianteschincha = $datosTotalestudianteschincha['totalUsuarios'];

$consultaprofesoreschincha = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 1 and Rol_id = 2";
$resultadoTotalprofesoreschincha = $conexion->query($consultaprofesoreschincha);
$datosTotalprofesoreschincha = $resultadoTotalprofesoreschincha->fetch_assoc();
$totalprofesoreschincha = $datosTotalprofesoreschincha['totalUsuarios'];

$consultaestudiantesdescañ = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 2 and Rol_id = 3";
$resultadoTotalestudiantescañ = $conexion->query($consultaestudiantesdescañ);
$datosTotalestudiantescañ = $resultadoTotalestudiantescañ->fetch_assoc();
$totalestudiantescañ = $datosTotalestudiantescañ['totalUsuarios'];

$consultaprofesorescañ = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 2 and Rol_id = 2";
$resultadoTotalprofesorescañ = $conexion->query($consultaprofesorescañ);
$datosTotalprofesorescañ = $resultadoTotalprofesorescañ->fetch_assoc();
$totalprofesorescañ = $datosTotalprofesorescañ['totalUsuarios'];

$consultaestudiantesdespis = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 3 and Rol_id = 3";
$resultadoTotalestudiantespis = $conexion->query($consultaestudiantesdespis);
$datosTotalestudiantespis = $resultadoTotalestudiantespis->fetch_assoc();
$totalestudiantespis = $datosTotalestudiantespis['totalUsuarios'];

$consultaprofesorespis = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 3 and Rol_id = 2";
$resultadoTotalprofesorespis = $conexion->query($consultaprofesorespis);
$datosTotalprofesorespis = $resultadoTotalprofesorespis->fetch_assoc();
$totalprofesorespis = $datosTotalprofesorespis['totalUsuarios'];

$consultaestudiantesdesica = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 4 and Rol_id = 3";
$resultadoTotalestudiantesica = $conexion->query($consultaestudiantesdesica);
$datosTotalestudiantesica = $resultadoTotalestudiantesica->fetch_assoc();
$totalestudiantesica = $datosTotalestudiantesica['totalUsuarios'];

$consultaprofesoresica = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 4 and Rol_id = 2";
$resultadoTotalprofesoresica = $conexion->query($consultaprofesoresica);
$datosTotalprofesoresica = $resultadoTotalprofesoresica->fetch_assoc();
$totalprofesoresica = $datosTotalprofesoresica['totalUsuarios'];

$consultaestudiantesdescaj = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 5 and Rol_id = 3";
$resultadoTotalestudiantescaj = $conexion->query($consultaestudiantesdescaj);
$datosTotalestudiantescaj = $resultadoTotalestudiantescaj->fetch_assoc();
$totalestudiantescaj = $datosTotalestudiantescaj['totalUsuarios'];

$consultaprofesorescaj = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 5 and Rol_id = 2";
$resultadoTotalprofesorescaj = $conexion->query($consultaprofesorescaj);
$datosTotalprofesorescaj = $resultadoTotalprofesorescaj->fetch_assoc();
$totalprofesorescaj = $datosTotalprofesorescaj['totalUsuarios'];

$consultaestudiantesdesare = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 6 and Rol_id = 3";
$resultadoTotalestudiantesare = $conexion->query($consultaestudiantesdesare);
$datosTotalestudiantesare = $resultadoTotalestudiantesare->fetch_assoc();
$totalestudiantesare = $datosTotalestudiantesare['totalUsuarios'];

$consultaprofesoresare = "SELECT COUNT(*) as totalUsuarios FROM Usuarios where Sede_id = 6 and Rol_id = 2";
$resultadoTotalprofesoresare = $conexion->query($consultaprofesoresare);
$datosTotalprofesoresare = $resultadoTotalprofesoresare->fetch_assoc();
$totalprofesoresare = $datosTotalprofesoresare['totalUsuarios'];

$consultacursos = "SELECT COUNT(*) as totalCursos FROM Cursos";
$resultadoTotalcursos = $conexion->query($consultacursos);
$datosTotalcursos = $resultadoTotalcursos->fetch_assoc();
$totalcursos = $datosTotalcursos['totalCursos'];

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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    .fw-bold {
      font-weight: 600;
    }

    .container-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 3rem;
      width: 3rem;
      border-radius: 100%;
    }

    .bg-purple {
      background-color: #7da0fac4;
      color: #4747a1;
    }

    .card-icon {
      font-size: 24px;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="dashboard.php"><img src="../../images/logo.png" class="mr-2" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="dashboard.php"><img src="../../images/logosidebard.png" alt="logo" /></a>
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
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
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
                    $RolId = $_SESSION['usuario']['Rol_id'];
                    echo $nombreUsuario; ?>
                  </h3>
                  <?php
                  $rolresultado = '';
                  switch ($RolId) {
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
                  ?>
                  <h6 class="font-weight-normal">(
                    <?php echo $rolresultado ?>)
                  </h6>
                  <h6 class="font-weight-normal" id="fechaActual"></h6>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 mb-4 stretch-card transparent">
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
            <div class="col-md-3 mb-4 stretch-card transparent">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Total de Estudiantes</p>
                  <p class="fs-30 mb-2">
                    <?php echo $totalestudiantes ?>
                  </p>
                  <p>Estudiantes Registrados</p>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Estudiantes Deshabilitados</p>
                  <p class="fs-30 mb-2">
                    <?php echo $totalestudiantesdes ?>
                  </p>
                  <p>Estudiantes</p>
                </div>
              </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Total Cursos</p>
                  <p class="fs-30 mb-2">
                    <?php echo $totalcursos ?>
                  </p>
                  <p>Cursos</p>
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
                          <th>Profesores</th>
                          <th>Estudiantes</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Chincha</td>
                          <td>
                            <?php echo $totalprofesoreschincha ?>
                          </td>
                          <td>
                            <?php echo $totalestudianteschincha ?>
                          </td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Cañete</td>
                          <td>
                            <?php echo $totalprofesorescañ ?>
                          </td>
                          <td>
                            <?php echo $totalestudiantescañ ?>
                          </td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Pisco</td>
                          <td>
                            <?php echo $totalprofesorespis ?>
                          </td>
                          <td>
                            <?php echo $totalestudiantespis ?>
                          </td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>Ica</td>
                          <td>
                            <?php echo $totalprofesoresica ?>
                          </td>
                          <td>
                            <?php echo $totalestudiantesica ?>
                          </td>
                        </tr>
                        <tr>
                          <td>5</td>
                          <td>Cajamarca</td>
                          <td>
                            <?php echo $totalprofesorescaj ?>
                          </td>
                          <td>
                            <?php echo $totalestudiantescaj ?>
                          </td>
                        </tr>
                        <tr>
                          <td>6</td>
                          <td>Arequipa</td>
                          <td>
                            <?php echo $totalprofesoresare ?>
                          </td>
                          <td>
                            <?php echo $totalestudiantesare ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Carrusel -->
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                  <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <div class="row">
                          <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                            <div class="ml-xl-4 mt-3">
                              <p class="card-title">Facebook Sede Chincha</p>
                              <h1 class="text-primary">1722</h1>
                              <h3 class="font-weight-500 mb-xl-4 text-primary">Seguidores</h3>
                              <hr>
                              <h1 class="text-primary">1406</h1>
                              <h3 class="font-weight-500 mb-xl-4 text-primary">Me gusta</h3>

                            </div>
                          </div>
                          <div class="col-md-12 col-xl-9">
                            <div class="row">
                              <div class="col-md-6 border-right">
                                <div class="table-responsive mb-3 mb-md-0 mt-3">
                                  <div>
                                    <canvas id="myChart"></canvas>
                                  </div>
                                  <script>
                                    const data = {
                                      labels: ['Mujeres', 'Hombres'],
                                      datasets: [{
                                        label: '% de Seguidores',
                                        data: [87.4, 12.6],
                                        borderWidth: 1,
                                        backgroundColor: ['#CB4335', '#1F618D'],
                                      }]
                                    };

                                    const ctx = document.getElementById('myChart');

                                    new Chart(ctx, {
                                      type: 'pie',
                                      data: data,
                                      options: {
                                        plugins: {
                                          legend: {
                                            onHover: handleHover,
                                            onLeave: handleLeave
                                          }
                                        }
                                      }
                                    });

                                    // Append '4d' to the colors (alpha channel), except for the hovered index
                                    function handleHover(evt, item, legend) {
                                      legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
                                        colors[index] = index === item.index || color.length === 9 ? color : color + '4D';
                                      });
                                      legend.chart.update();
                                    }

                                    // Removes the alpha channel from background colors
                                    function handleLeave(evt, item, legend) {
                                      legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
                                        colors[index] = color.length === 9 ? color.slice(0, -2) : color;
                                      });
                                      legend.chart.update();
                                    }
                                  </script>
                                </div>
                              </div>
                              <div class="col-md-6 mt-3">
                                <canvas id="north-america-chart"></canvas>
                                <div id="north-america-legend"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
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


  <script type="text/javascript">
    (function() {
      var head = document.getElementsByTagName("head").item(0);
      var script = document.createElement("script");

      var src = (document.location.protocol == 'https:' ?
        'https://www.formilla.com/scripts/feedback.js' :
        'http://www.formilla.com/scripts/feedback.js');

      script.setAttribute("type", "text/javascript");
      script.setAttribute("src", src);
      script.setAttribute("async", true);

      var complete = false;

      script.onload = script.onreadystatechange = function() {
        if (!complete && (!this.readyState ||
            this.readyState == 'loaded' ||
            this.readyState == 'complete')) {
          complete = true;
          Formilla.guid = 'cs44cc19-c5b9-4364-a8f5-3aed81e2e4e9';
          Formilla.loadWidgets();
        }
      };

      head.appendChild(script);
    })();
  </script>

  <!-- plugins:js -->
  <script src="./js/charts.js"></script>
  <script src="../../js/datetime.js"></script>
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/codeEditor.js"></script>
  <script src="../../js/tabs.js"></script>
  <script src="../../js/tooltips.js"></script>
  <!-- End custom js for this page-->
</body>

</html>