<?php
    session_start();
    require_once "../controlador/pedido_controlador.php";

    $controlador = new Pedido_controlador();

    $id_usuario = $_SESSION['usuario']['id_usuario'] ?? 0;

    $pedidos = $controlador->listar_pedidos_usuario($id_usuario);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pedidos</title>
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
</style>
<body>

<img id="fondo" src="./img/fondo.jpg" alt="">

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.9), inset 0 0 50px rgba(0, 0, 0, 0.5), 0 0 30px rgba(230, 57, 70, 0.3) !important; border-bottom: 3px solid #2a2a3e !important; padding: 15px 0 !important; position: relative; z-index: 1000;">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="./img/logo.png" style="width: 150px; border: 3px solid #2a2a3e !important; box-shadow: 0 0 20px rgba(230, 57, 70, 0.4), inset 0 0 20px rgba(0, 0, 0, 0.5) !important; transition: all 0.3s ease !important;" class="rounded-pill">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../index.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="./menu.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Menú</a></li>
                <li class="nav-item"><a class="nav-link" href="./sucursales.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Sucursales</a></li>
                <li class="nav-item"><a class="nav-link" href="./Inicio_sesion.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Inicio de sesión</a></li>
                <li class="nav-item"><a class="nav-link active" href="" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
            </ul>
        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark" style="margin:10px 20px !important; border-radius: 20px !important; border: 3px solid #2a2a3e !important; background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important; box-shadow: 0 0 30px rgba(230, 57, 70, 0.4), inset 0 0 40px rgba(0, 0, 0, 0.5) !important;">
    <div class="container">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link" href="./perfil.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
            <li class="nav-item"><a class="nav-link" href="./carrito.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Carrito</a></li>
            <li class="nav-item"><a class="nav-link active" href="#" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Historial de Pedidos</a></li>
            <li class="nav-item"><a class="nav-link" href="./reservas_cliente.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Reservas</a></li>
        </ul>
    </div>
</nav>

<!-- HISTORIAL -->
<div class="container mt-5">
    <h2 class="text-center mb-4" style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 3px !important; text-shadow: 0 0 15px rgba(230, 57, 70, 0.9), 0 0 30px rgba(230, 57, 70, 0.6), 3px 3px 6px rgba(0, 0, 0, 0.9) !important; animation: flicker 4s infinite alternate; font-weight: bold !important; position: relative; z-index: 2;">Historial de pedidos</h2>

    <?php if (empty($pedidos)): ?>
        <div class="alert text-center" style="background: linear-gradient(135deg, #1a535c 0%, #0f1626 100%) !important; border: 2px solid #e63946 !important; color: #a8dadc !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.5) !important; text-transform: uppercase !important; letter-spacing: 1px !important;">No tienes pedidos aún.</div>
    <?php endif; ?>
    
    <?php foreach ($pedidos as $p): ?>

        <?php if ($p['estado'] == 'En proceso'): ?>
        
            <div class="container my-4">
                <div class="card shadow-lg" style="background: linear-gradient(135deg, #1a535c 0%, #0f1626 100%) !important; border: 3px solid #e63946 !important; border-radius: 15px !important; box-shadow: 0 0 25px rgba(230, 57, 70, 0.6), inset 0 0 30px rgba(0, 0, 0, 0.5) !important;">
                    <div class="card-body p-4">
                        <h3 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8) !important;"><b>Pedido #<?= $p['codigo'] ?></b></h3>
                        <hr style="border: 2px solid #e63946 !important; box-shadow: 0 0 10px rgba(230, 57, 70, 0.6) !important;">

                        <p style="font-size: 16px; color: #a8dadc !important; text-transform: uppercase !important; letter-spacing: 1px !important;">
                            <b style="color: #e63946 !important;">Código:</b> <?= $p['codigo'] ?><br><br>
                            <b style="color: #e63946 !important;">Fecha:</b> <?= $p['fecha'] ?><br><br>
                            <b style="color: #e63946 !important;">Estado:</b> <span style="color: #ff9e00 !important; text-shadow: 0 0 10px rgba(255, 158, 0, 0.7) !important;"><?= $p['estado'] ?></span><br><br>
                        </p>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <div class="container my-4">
                <div class="card shadow-lg" style="background: linear-gradient(135deg, #1a535c 0%, #0f1626 100%) !important; border: 3px solid #4ecdc4 !important; border-radius: 15px !important; box-shadow: 0 0 25px rgba(78, 205, 196, 0.6), inset 0 0 30px rgba(0, 0, 0, 0.5) !important;">
                    <div class="card-body p-4">
                        <h3 style="color: #4ecdc4 !important; text-transform: uppercase !important; letter-spacing: 2px !important; text-shadow: 0 0 10px rgba(78, 205, 196, 0.8) !important;"><b>Pedido #<?= $p['codigo'] ?></b></h3>
                        <hr style="border: 2px solid #4ecdc4 !important; box-shadow: 0 0 10px rgba(78, 205, 196, 0.6) !important;">

                        <p style="font-size: 16px; color: #a8dadc !important; text-transform: uppercase !important; letter-spacing: 1px !important;">
                            <b style="color: #4ecdc4 !important;">Código:</b> <?= $p['codigo'] ?><br><br>
                            <b style="color: #4ecdc4 !important;">Fecha:</b> <?= $p['fecha'] ?><br><br>
                            <b style="color: #4ecdc4 !important;">Estado:</b> <span style="color: #4ecdc4 !important; text-shadow: 0 0 10px rgba(78, 205, 196, 0.7) !important;"><?= $p['estado'] ?></span><br><br>
                        </p>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    <?php endforeach; ?>

</div>

<!-- FOOTER -->
<footer class="text-center footer-style py-2" style="background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important; border: 3px solid #2a2a3e !important; border-radius: 20px !important; box-shadow: 0 0 40px rgba(230, 57, 70, 0.4), inset 0 0 50px rgba(0, 0, 0, 0.5) !important; margin: 50px auto 30px !important; padding: 40px 20px !important; position: relative; z-index: 10;">

    <div class="container">
        <div class="row">

            <div class="col-md-4 footer-col">
                <h4 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important; margin-bottom: 20px !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8), 2px 2px 4px rgba(0, 0, 0, 0.9) !important;"><b>Contacto</b></h4>
                <p style="color: #8d99ae !important; text-transform: uppercase !important; letter-spacing: 1px !important; font-size: 14px !important; line-height: 1.8 !important;">
                    <b style="color: #a8dadc !important;">Correo:</b> fazbear@entertaiment.com<br><br>
                    <b style="color: #a8dadc !important;">Celular:</b> 316 4020478<br><br>
                    <b style="color: #a8dadc !important;">Teléfono:</b> (061) 01001 678594
                </p>
            </div>

            <div class="col-md-4 footer-col">
                <h4 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important; margin-bottom: 20px !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8), 2px 2px 4px rgba(0, 0, 0, 0.9) !important;"><b>Punto de venta</b></h4>
                <p style="color: #8d99ae !important; text-transform: uppercase !important; letter-spacing: 1px !important; font-size: 14px !important; line-height: 1.8 !important;">
                    <b style="color: #a8dadc !important;">Bogotá</b> Cra. 7 #158 - 03<br><br>
                    <b style="color: #a8dadc !important;">Lunes - Viernes:</b> 7am - 4pm<br><br>
                    <b style="color: #a8dadc !important;">Sábado:</b> 7am - 2pm
                </p>
            </div>

            <div class="col-md-4 footer-col">
                <h4 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important; margin-bottom: 20px !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8), 2px 2px 4px rgba(0, 0, 0, 0.9) !important;"><b>Nuestras redes</b></h4>
                <ul class="list-inline d-flex" style="justify-content: center;">
                    <li>
                        <img src="./img/feis.jpg" style="width: 80px; margin: 0 10px; border: 2px solid #2a2a3e !important; border-radius: 8px !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important; transition: all 0.3s ease !important; filter: brightness(0.9);">
                    </li>
                    <li>
                        <img src="./img/insta.jpg" style="width: 80px; margin: 0 10px; border: 2px solid #2a2a3e !important; border-radius: 8px !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important; transition: all 0.3s ease !important; filter: brightness(0.9);">
                    </li>
                    <li>
                        <img src="./img/wasat.jpg" style="width: 80px; margin: 0 10px; border: 2px solid #2a2a3e !important; border-radius: 8px !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important; transition: all 0.3s ease !important; filter: brightness(0.9);">
                    </li>
                </ul>
            </div>

        </div>
    </div>
</footer>

</body>
</html>