<?php
    session_start();

    // Verificar si usuario está logueado
    if (isset($_SESSION['usuario'])) {
        // Obtener datos del usuario desde sesión
        $usuario = $_SESSION['usuario'];
        $rol = isset($usuario['rol']) ? $usuario['rol'] : 'Rol no disponible';
    }
    else{
        echo "
            <script>
                alert('No has iniciado sesion')
                window.location.href = '../vista/sucursales.php'
            </script>
        ";
        return;
    }


    $id_sucursal = $_GET['id_sucursal'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre nosotros</title>
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

    /* Estilos para la selección de mesas */
    .contenedor_mesas {
        max-width: 1200px;
        margin: 50px auto;
        padding: 30px;
        background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important;
        border: 3px solid #2a2a3e !important;
        border-radius: 20px !important;
        box-shadow: 
            0 0 40px rgba(230, 57, 70, 0.5),
            inset 0 0 50px rgba(0, 0, 0, 0.6) !important;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .contenedor_mesas::before {
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

    .contenedor_mesas h1 {
        color: #e63946 !important;
        text-transform: uppercase !important;
        letter-spacing: 3px !important;
        text-shadow: 
            0 0 15px rgba(230, 57, 70, 0.9),
            0 0 30px rgba(230, 57, 70, 0.6),
            3px 3px 6px rgba(0, 0, 0, 0.9) !important;
        animation: flicker 4s infinite alternate;
        font-weight: bold !important;
        margin-bottom: 30px !important;
        position: relative;
        z-index: 2;
    }

    #caja_mesas {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 15px;
        margin: 30px 0;
        padding: 20px;
    }

    .mesas {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #1a535c 0%, #0f1626 100%) !important;
        border: 2px solid #2a2a3e !important;
        border-radius: 10px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a8dadc !important;
        font-weight: bold !important;
        font-size: 18px !important;
        cursor: pointer;
        transition: all 0.3s ease !important;
        box-shadow: 
            inset 0 0 10px rgba(0, 0, 0, 0.5),
            0 0 10px rgba(168, 218, 220, 0.3) !important;
        text-transform: uppercase !important;
        position: relative;
        z-index: 2;
    }

    .mesas:hover {
        border-color: #e63946 !important;
        box-shadow: 
            inset 0 0 10px rgba(0, 0, 0, 0.5),
            0 0 20px rgba(230, 57, 70, 0.6) !important;
        transform: scale(1.05);
    }

    .mesas.seleccionada {
        background: linear-gradient(135deg, #e63946 0%, #c1121f 100%) !important;
        border-color: #a8dadc !important;
        color: #0a0a0a !important;
        box-shadow: 
            inset 0 0 10px rgba(0, 0, 0, 0.5),
            0 0 25px rgba(230, 57, 70, 0.8) !important;
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.7) !important;
    }

    .mesas.ocupada {
        background: linear-gradient(135deg, #6a1b1b 0%, #0f1626 100%) !important;
        border-color: #e63946 !important;
        color: #8d99ae !important;
        cursor: not-allowed;
        box-shadow: 
            inset 0 0 10px rgba(0, 0, 0, 0.7),
            0 0 15px rgba(230, 57, 70, 0.4) !important;
        opacity: 0.7;
    }

    .mesas.ocupada:hover {
        transform: none;
        border-color: #e63946 !important;
        box-shadow: 
            inset 0 0 10px rgba(0, 0, 0, 0.7),
            0 0 15px rgba(230, 57, 70, 0.4) !important;
    }

    .boton_siguiente {
        background: linear-gradient(135deg, #e63946 0%, #c1121f 100%) !important;
        border: 2px solid #2a2a3e !important;
        color: #a8dadc !important;
        padding: 15px 40px !important;
        font-size: 18px !important;
        font-weight: bold !important;
        text-transform: uppercase !important;
        letter-spacing: 2px !important;
        border-radius: 10px !important;
        cursor: pointer;
        transition: all 0.3s ease !important;
        box-shadow: 0 0 20px rgba(230, 57, 70, 0.6) !important;
        margin-top: 20px;
        position: relative;
        z-index: 2;
    }

    .boton_siguiente:hover {
        background: linear-gradient(135deg, #c1121f 0%, #e63946 100%) !important;
        box-shadow: 0 0 30px rgba(230, 57, 70, 0.8) !important;
        transform: scale(1.05);
        color: #0a0a0a !important;
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
                    <li class="nav-item"><a class="nav-link active" href="./sucursales.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Sucursales</a></li>
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
    

   
    <!-- Mesas -->
     <div class="contenedor_mesas">
        <h1>Seleccione su mesa</h1>
        <div id="caja_mesas"></div>

        <button class="boton_siguiente" onclick="Finalizar_Seleccion()">Siguiente</button>
     </div>

    <script>

        const id_sucursal = <?= json_encode($id_sucursal) ?>;
        const caja = document.getElementById("caja_mesas");
        const mesas_seleccionadas = [];   // mesas que el usuario elige ahora
        let mesasBD = [];                 // mesas ya guardadas en BD

        mesasBD = [];

        // 1. Traer mesas que están en la BD
        fetch(`../controlador/acciones_mesas.php?accion=listar&id_sucursal=${id_sucursal}&t=${Date.now()}`)
        .then(res => res.json())
        .then(data => {
            console.log("MESAS ACTUALES:", data);
            mesasBD = data.map(m => Number(m.numero_mesa));
            cargarMesas();
        });


        // 2. Generar las 30 mesas y marcar las que están en BD
        function cargarMesas() {

            let html = "";

            for (let i = 1; i <= 30; i++) {
                const estaEnBD = mesasBD.includes(i);

                html += `
                    <div 
                        class="mesas ${estaEnBD ? 'ocupada' : ''}" 
                        onclick="Seleccionar(this, ${i}, ${estaEnBD})"
                    >
                        ${i}
                    </div>
                `;
            }

            caja.innerHTML = html;
        }


        function Seleccionar(div, numero, estaEnBD) {

            // No permitir seleccionar mesas ya registradas en BD
            if (estaEnBD) {
                alert("Esta mesa ya fue reservada.");
                return;
            }

            div.classList.toggle("seleccionada");

            if (div.classList.contains("seleccionada")) {
                mesas_seleccionadas.push(numero);
            } else {
                const index = mesas_seleccionadas.indexOf(numero);
                if (index > -1) mesas_seleccionadas.splice(index, 1);
            }
        }


        function Finalizar_Seleccion() {

            if (mesas_seleccionadas.length === 0) {
                alert("Seleccione al menos una mesa");
                return;
            }

            const mesasStr = mesas_seleccionadas.join(",");

            window.location.href =
                "../vista/reservas.php?id_sucursal=" + id_sucursal +
                "&mesas=" + encodeURIComponent(mesasStr);
        }

    </script>

     


    <!-- Footer -->

    <footer class="text-center footer-style py-2" style="background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important; border: 3px solid #2a2a3e !important; border-radius: 20px !important; box-shadow: 0 0 40px rgba(230, 57, 70, 0.4), inset 0 0 50px rgba(0, 0, 0, 0.5) !important; margin: 50px auto 30px !important; padding: 40px 20px !important; position: relative; z-index: 10;">
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
              <ul class="list-inline d-flex" style="justify-content: center; align-items: center; padding: 10px;">
                  <li>
                      <img src="./img/feis.jpg" type="button" class="btn btn-primary" data-bs-toggle="tooltip" title="www.facebook.com" alt="feis" style="width: 80px; margin-right: 10px; border: 2px solid #2a2a3e !important; border-radius: 8px !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important; transition: all 0.3s ease !important; filter: brightness(0.9);">
                  </li>
                  <li>
                      <img src="./img/insta.jpg" type="button" class="btn btn-primary" data-bs-toggle="tooltip" title="www.instagram.com" alt="insta" style="width: 80px; margin-left: 10px; margin-right: 10px; border: 2px solid #2a2a3e !important; border-radius: 8px !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important; transition: all 0.3s ease !important; filter: brightness(0.9);">
                  </li>
                  <li>
                      <img src="./img/wasat.jpg" type="button" class="btn btn-primary" data-bs-toggle="tooltip" title="wwww.wa.me.325346.com" alt="wasat" style="width: 80px; margin-left: 10px; border: 2px solid #2a2a3e !important; border-radius: 8px !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important; transition: all 0.3s ease !important; filter: brightness(0.9);">
                  </li>
              </ul>
          </div>
      </footer>
       </div>
      </div>

      <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

<script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>