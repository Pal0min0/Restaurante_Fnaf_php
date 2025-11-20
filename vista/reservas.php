<?php
    session_start();

    // Verificar si usuario está logueado
    if (isset($_SESSION['usuario'])) {
        // Obtener datos del usuario desde sesión
        $usuario = $_SESSION['usuario'];
        $rol = isset($usuario['rol']) ? $usuario['rol'] : 'Rol no disponible';
        $id_usuario = isset($usuario['id_usuario']) ? $usuario['id_usuario'] : 'ID no disponible';
    }

    $mesasStr = $_GET['mesas'];
    $id_sucursal = $_GET['id_sucursal'];

    // Convertimos el string en un array
    $mesasSeleccionadas = explode(',', $mesasStr);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.js"></script>
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

    /* Estilos para la tarjeta de reserva */
    .card {
        background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important;
        border: 3px solid #2a2a3e !important;
        border-radius: 20px !important;
        box-shadow: 
            0 0 40px rgba(230, 57, 70, 0.5),
            inset 0 0 50px rgba(0, 0, 0, 0.6) !important;
        position: relative;
        overflow: hidden;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' /%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.05'/%3E%3C/svg%3E");
        pointer-events: none;
        animation: static 0.5s infinite;
    }

    @keyframes static {
        0% { opacity: 0.03; }
        50% { opacity: 0.08; }
        100% { opacity: 0.03; }
    }

    h2, h4 {
        color: #e63946 !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        text-shadow: 0 0 10px rgba(230, 57, 70, 0.8) !important;
        margin-bottom: 15px !important;
        position: relative;
        z-index: 2;
    }

    h2 {
        letter-spacing: 3px !important;
        text-shadow: 
            0 0 15px rgba(230, 57, 70, 0.9),
            0 0 30px rgba(230, 57, 70, 0.6),
            3px 3px 6px rgba(0, 0, 0, 0.9) !important;
        animation: flicker 4s infinite alternate;
        font-weight: bold !important;
    }

    /* Estilos para formularios */
    .form-label {
        color: #a8dadc !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        font-size: 14px !important;
        margin-bottom: 8px !important;
        font-weight: bold !important;
    }

    .form-control {
        background: rgba(10, 10, 10, 0.7) !important;
        border: 2px solid #2a2a3e !important;
        color: #a8dadc !important;
        border-radius: 8px !important;
        padding: 12px 15px !important;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5) !important;
        transition: all 0.3s ease !important;
    }

    .form-control:focus {
        border-color: #e63946 !important;
        box-shadow: 
            inset 0 0 10px rgba(0, 0, 0, 0.5),
            0 0 15px rgba(230, 57, 70, 0.5) !important;
        background: rgba(15, 15, 15, 0.8) !important;
        color: #a8dadc !important;
    }

    /* Estilos para botones */
    .btn {
        background: linear-gradient(135deg, #e63946 0%, #c1121f 100%) !important;
        border: 2px solid #2a2a3e !important;
        box-shadow: 0 0 15px rgba(230, 57, 70, 0.5) !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        color: #a8dadc !important;
        padding: 12px 25px !important;
        font-weight: bold !important;
        transition: all 0.3s ease !important;
        position: relative;
        z-index: 2;
        margin: 5px 0 !important;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 0 25px rgba(230, 57, 70, 0.8),
            0 5px 15px rgba(0, 0, 0, 0.3) !important;
        color: #ffffff !important;
    }

    .btn-danger {
        background: linear-gradient(135deg, #1a535c 0%, #0f1626 100%) !important;
        border: 2px solid #2a2a3e !important;
        box-shadow: 0 0 15px rgba(26, 83, 92, 0.5) !important;
    }

    .btn-danger:hover {
        box-shadow: 
            0 0 25px rgba(26, 83, 92, 0.8),
            0 5px 15px rgba(0, 0, 0, 0.3) !important;
    }

    .btn:disabled {
        opacity: 0.6;
        transform: none !important;
        box-shadow: 0 0 10px rgba(230, 57, 70, 0.3) !important;
    }

    /* Estilos para checkbox */
    .form-check-input {
        background: rgba(10, 10, 10, 0.7) !important;
        border: 2px solid #2a2a3e !important;
    }

    .form-check-input:checked {
        background-color: #e63946 !important;
        border-color: #e63946 !important;
    }

    .form-check-label {
        color: #a8dadc !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        font-size: 14px !important;
    }

    /* Alertas */
    .alert-success {
        background: linear-gradient(135deg, #1a535c 0%, #0f1626 100%) !important;
        border: 2px solid #2a9d8f !important;
        color: #a8dadc !important;
        border-radius: 10px !important;
        box-shadow: 0 0 20px rgba(42, 157, 143, 0.4) !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        text-align: center !important;
    }

    .alert-success a {
        color: #2a9d8f !important;
        font-weight: bold !important;
    }

    .alert-success a:hover {
        color: #e9f5db !important;
        text-shadow: 0 0 10px rgba(42, 157, 143, 0.8) !important;
    }

    /* Modal styles */
    .modal-content {
        background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important;
        border: 3px solid #2a2a3e !important;
        border-radius: 15px !important;
        box-shadow: 0 0 40px rgba(230, 57, 70, 0.5) !important;
        color: #a8dadc !important;
    }

    .modal-header {
        border-bottom: 2px solid #2a2a3e !important;
    }

    .modal-title {
        color: #e63946 !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
    }

    .btn-close {
        filter: invert(1) !important;
    }
</style>
<body>

    <!-- Fondo -->
    <img id="fondo" src="./img/fondo.jpg" alt="Fondo del menú" class="w-100">

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
                    <li class="nav-item"><a class="nav-link active" href="./sucursales.php" style="color: #e63946 !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid #e63946 !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8) !important;">Sucursales</a></li>
                    <li class="nav-item"><a class="nav-link" href="./Inicio_sesion.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Inicio de sesion</a></li>
                    <?php
                        if(isset($usuario) && isset($usuario['rol']) && $usuario['rol'] === 'Administrador'){
                            echo '
                                <li class="nav-item"><a class="nav-link" href="./perfil_admin.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
                            ';
                        }
                        else{
                            echo '
                                <li class="nav-item"><a class="nav-link" href="./perfil.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
                            ';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulario de Reserva -->
    
    <div style="margin: 50px;">
        <div class="container">
            <div class="row">

                <!-- Datos de la reserva -->
                <div class="col-md">
                    <div class="card shadow p-4">
                        <h2 class="text-center mb-4">Datos de reserva</h2>

                        <?php
                            $visible = false;

                            if (isset($_SESSION['success_message'])) {
                                echo '<div class="alert alert-success">RESERVA CREADA - <a href="./reservas_cliente.php">VER RESERVA</a></div>';
                                unset($_SESSION['success_message']);
                                $visible = true;
                            }
                        ?>

                        <form action="../controlador/acciones_reserva.php?accion=crear" method="POST">
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha:</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="hora" class="form-label">Hora:</label>
                                <input type="time" class="form-control" id="hora" name="hora" required min="09:00" max="21:00">
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    RECORDARME
                                </label>
                            </div>

                            <input type="text" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>" hidden>
                            <input type="text" name="id_sucursal" id="id_sucursal" value="<?php echo $id_sucursal ?>" hidden>
                            <?php foreach($mesasSeleccionadas as $mesa): ?>
                                <input type="hidden" name="mesas[]" value="<?php echo $mesa; ?>">
                            <?php endforeach; ?>

                            <?php if(!$visible): ?>
                                <button type="submit" class="btn w-100">RESERVAR</button>
                                <a href="sucursales.php" class="btn btn-danger w-100">CANCELAR</a>
                            <?php else: ?>
                                <button type="submit" class="btn w-100" disabled>RESERVA CONFIRMADA</button>
                            <?php endif; ?>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de boton de reserva -->
    <div class="modal" id="myModal">
    <div class="modal-dialog mx-auto d-block">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title">RESERVA EXITOSA</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          LE LLEGARA UN CORREO DE CONFIRMACIÓN.
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
        </div>
  
      </div>
    </div>
    </div>
    </div>

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

</body>
</html>