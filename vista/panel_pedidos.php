<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verificar si usuario está logueado
    if (!isset($_SESSION['usuario'])) {
        header("Location: Inicio_sesion.php");
        exit();
    }

    //Obtener las resevas de los clientes
    require_once "../controlador/pedido_controlador.php";
                        
    $pedido_controlador = new Pedido_controlador();
    $lista_pedidos = $pedido_controlador->listar_pedidos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<style> 
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Courier New', monospace;
        background: #0a0a0a;
        color: #a8dadc;
        position: relative;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* Fondo de imagen con overlay oscuro */
    #fondo {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -2;
        opacity: 0.15;
        filter: brightness(0.3) contrast(1.2);
    }

    /* Efecto de scanlines estilo cámara de seguridad */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: repeating-linear-gradient(
            0deg,
            rgba(0, 0, 0, 0.15) 0px,
            rgba(0, 0, 0, 0.15) 1px,
            transparent 1px,
            transparent 2px
        );
        pointer-events: none;
        z-index: 999;
    }

    /* Efecto de vignette oscuro */
    body::after {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, transparent 40%, rgba(0, 0, 0, 0.8) 100%);
        pointer-events: none;
        z-index: 998;
    }

    @keyframes flicker {
        0%, 18%, 22%, 25%, 53%, 57%, 100% {
            opacity: 1;
            text-shadow: 
                0 0 20px rgba(230, 57, 70, 0.9),
                0 0 40px rgba(230, 57, 70, 0.6),
                4px 4px 8px rgba(0, 0, 0, 0.9);
        }
        20%, 24%, 55% {
            opacity: 0.7;
            text-shadow: none;
        }
    }

    .card {
        background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important;
        border: 3px solid #2a2a3e !important;
        border-radius: 15px !important;
        box-shadow: 
            0 0 25px rgba(230, 57, 70, 0.4),
            inset 0 0 30px rgba(0, 0, 0, 0.5) !important;
        transition: all 0.3s ease !important;
        overflow: hidden;
    }

    .card:hover {
        border-color: #e63946 !important;
        box-shadow: 
            0 0 35px rgba(230, 57, 70, 0.7),
            inset 0 0 30px rgba(0, 0, 0, 0.5) !important;
    }

    .table {
        background: rgba(22, 33, 62, 0.7) !important;
        border: 2px solid #2a2a3e !important;
        border-radius: 10px !important;
        color: #a8dadc !important;
    }

    .table th {
        background: linear-gradient(135deg, #e63946 0%, #c1121f 100%) !important;
        color: #a8dadc !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        border-color: #2a2a3e !important;
    }

    .table td {
        border-color: #2a2a3e !important;
        background: rgba(10, 10, 10, 0.5) !important;
    }

    .alert-success {
        background: linear-gradient(135deg, #1a535c 0%, #0f1626 100%) !important;
        border: 2px solid #4ecdc4 !important;
        color: #a8dadc !important;
        box-shadow: 0 0 15px rgba(78, 205, 196, 0.5) !important;
    }

    .btn {
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        font-weight: bold !important;
        transition: all 0.3s ease !important;
    }
</style>
<body>
    <!-- Fondo -->
   
    <img id="fondo" src="./img/fondo.jpg" alt="">

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.9), inset 0 0 50px rgba(0, 0, 0, 0.5), 0 0 30px rgba(230, 57, 70, 0.3) !important; border-bottom: 3px solid #2a2a3e !important; padding: 15px 0 !important; position: relative; z-index: 1000;">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./img/logo.png" alt="logo" style="width: 150px; border: 3px solid #2a2a3e !important; box-shadow: 0 0 20px rgba(230, 57, 70, 0.4), inset 0 0 20px rgba(0, 0, 0, 0.5) !important; transition: all 0.3s ease !important;" class="rounded-pill">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="./menu.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Menú</a></li>
                    <li class="nav-item"><a class="nav-link" href="./sucursales.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Sucursal</a></li>
                    <li class="nav-item"><a class="nav-link" href="./Inicio_sesion.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Inicio de sesion</a></li>
                    <li class="nav-item"><a class="nav-link active" href="./perfil.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Segunda barra de navegacion -->        
    <nav class="navbar navbar-expand-lg navbar-dark" style="margin:10px 20px !important; border-radius: 20px !important; border: 3px solid #2a2a3e !important; background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important; box-shadow: 0 0 30px rgba(230, 57, 70, 0.4), inset 0 0 40px rgba(0, 0, 0, 0.5) !important;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav2">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav2">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="./perfil_admin.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
                    <li class="nav-item"><a class="nav-link" href="./panel_usuarios.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="./panel_menu.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="./panel_sucursal.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Sucursales</a></li>
                    <li class="nav-item"><a class="nav-link" href="./panel_reservas.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Reservas</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Pedidos</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Panel de Pedidos -->
    
    <div class="container mt-3 mb-4">

        <h2 class="text-center mb-4" style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 3px !important; text-shadow: 0 0 15px rgba(230, 57, 70, 0.9), 0 0 30px rgba(230, 57, 70, 0.6), 3px 3px 6px rgba(0, 0, 0, 0.9) !important; animation: flicker 4s infinite alternate; font-weight: bold !important; position: relative; z-index: 2;">Pedidos</h2>

        <div class="text-center m-3">
            <a href="../controlador/generar_pdf.php" class="btn" target="_blank" style="background: linear-gradient(135deg, #e63946 0%, #c1121f 100%) !important; border: 2px solid #2a2a3e !important; box-shadow: 0 0 20px rgba(230, 57, 70, 0.6) !important; text-transform: uppercase !important; letter-spacing: 2px !important; color: #a8dadc !important; font-weight: bold !important; padding: 12px 20px !important;">
                Descargar PDF
            </a>
        </div>

            <?php
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success">Pedido Cancelado o Editado</div>';
                    unset($_SESSION['success_message']);
                }
            ?>

        <?php
            if (empty($lista_pedidos)) {
                echo '
                    <h2 class="text-center mb-4" style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important;">No hay Pedidos</h2>
                ';
                return; 
            }

            foreach($lista_pedidos as $p){

                $deshabilitar = $p['estado'] === 'Entregado' ? 'disabled' : '';

                echo '
                    <div class="card shadow p-4 mb-4">
                        <h2 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 1px !important;">Pedido: '.$p['codigo'].'</h2> 
                        <h4 style="color: #a8dadc !important;">Fecha: '.$p['fecha'].'</h4>
                        <h4 style="color: #a8dadc !important;">Estado: <span style="color: '.($p['estado'] === "Entregado" ? "#4ecdc4" : "#ff9e00").' !important; text-shadow: 0 0 10px '.($p['estado'] === "Entregado" ? "rgba(78, 205, 196, 0.7)" : "rgba(255, 158, 0, 0.7)").' !important;">'.$p['estado'].'</span></h4>

                        <hr style="border: 2px solid #e63946 !important; box-shadow: 0 0 10px rgba(230, 57, 70, 0.6) !important;">

                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button class="btn" onclick="Mostrar('.$p['id_pedido'].')" style="background: linear-gradient(135deg, #2a2a3e 0%, #1a1a2e 100%) !important; border: 2px solid #e63946 !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.4) !important; text-transform: uppercase !important; letter-spacing: 1px !important; color: #a8dadc !important; font-weight: bold !important; padding: 10px 15px !important;">Ver más</button>
                            </div>
                        </div>

                        <hr style="border: 2px solid #e63946 !important; box-shadow: 0 0 10px rgba(230, 57, 70, 0.6) !important;">

                        <div id="masInfo_'.$p['id_pedido'].'"  style="display:none;">
                            <h4 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 1px !important;">Datos Usuario</h4>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Direccion</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>'.$p['nombres'].'</td>
                                        <td>'.$p['Correo'].'</td>
                                        <td>'.$p['telefono'].'</td>
                                        <td>'.$p['direccion'].'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-center mt-3">

                            <form class="col-auto" method="POST" action="../controlador/acciones_pedido.php?accion=editar_esta_entregado"
                                onsubmit="return editar_estado(\''.$p['id_pedido'].'\', \''.addslashes($p['nombres']).'\')">

                                <input type="hidden" name="id_pedido" value="'.$p['id_pedido'].'">

                                <button type="submit" class="btn" '.$deshabilitar.' style="background: linear-gradient(135deg, #1a535c 0%, #0f1626 100%) !important; border: 2px solid #4ecdc4 !important; box-shadow: 0 0 15px rgba(78, 205, 196, 0.5) !important; text-transform: uppercase !important; letter-spacing: 1px !important; color: #a8dadc !important; font-weight: bold !important; padding: 10px 15px !important; margin: 0 5px !important;">Entregado</button>
                            </form>

                            <form class="col-auto" method="POST" action="../controlador/acciones_pedido.php?accion=eliminar"
                                onsubmit="return eliminarReserva(\''.$p['id_pedido'].'\', \''.addslashes($p['nombres']).'\')">

                                <input type="hidden" name="id_pedido" value="'.$p['id_pedido'].'">

                                <button type="submit" class="btn" style="background: linear-gradient(135deg, #6a1b1b 0%, #0f1626 100%) !important; border: 2px solid #e63946 !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.5) !important; text-transform: uppercase !important; letter-spacing: 1px !important; color: #a8dadc !important; font-weight: bold !important; padding: 10px 15px !important; margin: 0 5px !important;">Eliminar</button>
                            </form>
                        </div>
                    </div>
                ';
            }

            echo '
                <script>
                    function eliminarReserva(id_pedido, nombre) {
                        return confirm(`¿Estás seguro de cancelar el pedido de ${nombre}?`);
                    }

                    function editar_estado(id_pedido, nombre) {
                        return confirm(`¿Estás seguro de editar el pedido de ${nombre}?`);
                    }
                </script>
            '
        ?>
    </div>

    <script>
        function Mostrar(id_reserva) {
            const div = document.getElementById('masInfo_' + id_reserva);
            div.style.display = div.style.display === 'none' ? 'block' : 'none';
        }
    </script>


    <!-- Footer -->

    <footer class="text-center footer-style" style="background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important; border: 3px solid #2a2a3e !important; border-radius: 20px !important; box-shadow: 0 0 40px rgba(230, 57, 70, 0.4), inset 0 0 50px rgba(0, 0, 0, 0.5) !important; margin: 50px auto 30px !important; padding: 40px 20px !important; position: relative; z-index: 10;">
        <div class="container">
          <div class="row">
         
         <div class="col-md-4 footer-col">
         <h4 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important; margin-bottom: 20px !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8), 2px 2px 4px rgba(0, 0, 0, 0.9) !important;"><b>Contacto</b></h4>
         <p style="color: #8d99ae !important; text-transform: uppercase !important; letter-spacing: 1px !important; font-size: 14px !important; line-height: 1.8 !important;">
            <b style="color: #a8dadc !important;">Correo:</b> fazbear@entertaiment.com
            <br>      
            <br>
            <b style="color: #a8dadc !important;">Celular:</b> 316 4020478 
            <br>
            <br>
            <b style="color: #a8dadc !important;">Número telefónico:</b> (061) 01001 678594
         </p>
          </div>
      
          <div class="col-md-4 footer-col">
              <h4 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important; margin-bottom: 20px !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8), 2px 2px 4px rgba(0, 0, 0, 0.9) !important;"><b>Punto de venta</b></h4>
              <p style="color: #8d99ae !important; text-transform: uppercase !important; letter-spacing: 1px !important; font-size: 14px !important; line-height: 1.8 !important;">
                  <b style="color: #a8dadc !important;">Bogotá</b> Cra. 7 #158 - 03
                  <br>
                  <br>
                  <b style="color: #a8dadc !important;">Lunes - Viernes:</b> 7am - 4pm
                  <br>
                  <br>
                  <b style="color: #a8dadc !important;">Sábado:</b> 7am - 2pm
              </p>
          </div>
      
          <div class="col-md-4 footer-col">
              <h4 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important; margin-bottom: 20px !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8), 2px 2px 4px rgba(0, 0, 0, 0.9) !important;"><b>Nuestras redes</b></h4>
              <ul class="list-inline d-flex" style="align-items: center; padding: 10px;">
                  <li>
                      <img src="./img/feis.jpg" class="img-fluid" alt="feis" style="width: 80px; margin-right: 10px; border: 2px solid #2a2a3e !important; border-radius: 8px !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important; transition: all 0.3s ease !important; filter: brightness(0.9);">
                  </li>
                  <li>
                      <img src="./img/insta.jpg" class="img-fluid" alt="insta" style="width: 80px; margin-left: 10px; margin-right: 10px; border: 2px solid #2a2a3e !important; border-radius: 8px !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important; transition: all 0.3s ease !important; filter: brightness(0.9);">
                  </li>
                  <li>
                      <img src="./img/wasat.jpg" class="img-fluid" alt="yutu" style="width: 80px; margin-left: 10px; border: 2px solid #2a2a3e !important; border-radius: 8px !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important; transition: all 0.3s ease !important; filter: brightness(0.9);">
                  </li>
              </ul>
          </div>
      </footer>
       </div>
      </div>
      

<script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.js"></script>
</body>
</html>