<?php
    session_start();

    // Verificar si usuario está logueado
    if (isset($_SESSION['usuario'])) {
        // Obtener datos del usuario desde sesión
        $usuario = $_SESSION['usuario'];
        $rol = isset($usuario['rol']) ? $usuario['rol'] : 'Rol no disponible';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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

    .contact-container {
        max-width: 600px;
        margin: 50px auto;
    }

    /* Estilos para la tarjeta de registro */
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

    .form-control::placeholder {
        color: #6b7280 !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        font-size: 12px !important;
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
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 0 25px rgba(230, 57, 70, 0.8),
            0 5px 15px rgba(0, 0, 0, 0.3) !important;
        color: #ffffff !important;
    }

    /* Estilos para enlaces */
    a {
        color: #a8dadc !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
        position: relative;
    }

    a:hover {
        color: #e63946 !important;
        text-shadow: 0 0 10px rgba(230, 57, 70, 0.8) !important;
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
    }

    .alert-success a {
        color: #2a9d8f !important;
        font-weight: bold !important;
    }

    .alert-success a:hover {
        color: #e9f5db !important;
        text-shadow: 0 0 10px rgba(42, 157, 143, 0.8) !important;
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
                    <li class="nav-item"><a class="nav-link" href="./sucursal.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Sucursales</a></li>
                    <li class="nav-item"><a class="nav-link active" href="./Inicio_sesion.php" style="color: #e63946 !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid #e63946 !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8) !important;">Inicio de sesion</a></li>
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

    <!-- Formulario de registro -->
    <div class="container contact-container">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Registro</h2>

            <?php
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success text-center">REGISTRO EXITOSO - <a href="./Inicio_sesion.php">INICIA SESIÓN</a></div>';
                    unset($_SESSION['success_message']);
                }
            ?>

            <form action="../controlador/acciones_usuario.php?accion=registrar" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="INGRESE UN NOMBRE" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="documento" class="form-label">Documento:</label>
                    <input type="number" class="form-control" id="documento" placeholder="INGRESE SU DOCUMENTO" name="documento" required>
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol:</label>
                    <select name="rol" id="rol" class="form-control" required>
                        <option value="Cliente">CLIENTE</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo:</label>
                    <input type="email" class="form-control" id="correo" placeholder="INGRESE SU CORREO" name="correo" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="contrasena" placeholder="INGRESE LA CONTRASEÑA" name="contrasena" required>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Telefono:</label>
                    <input type="number" class="form-control" id="telefono" placeholder="INGRESE EL TELEFONO" name="telefono" required>
                </div>
                <div class="mb-3 text-center">
                    <a href="./Inicio_sesion.php" style="color: #a8dadc !important; text-transform: uppercase !important; letter-spacing: 1px !important;">¿YA TIENES CUENTA?</a>
                </div>

                <button type="submit" class="btn w-100">REGISTRAR</button>
            </form>
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
      

<script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.js"></script>
</body>
</html>