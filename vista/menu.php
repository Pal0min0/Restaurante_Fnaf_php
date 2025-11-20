<?php
session_start();
require_once "../controlador/menu_controlador.php";

$menuControlador = new Menu_controlador();
$lista_menu = $menuControlador->listar_menu();

// Verificar si el usuario está logueado
$usuario = $_SESSION['usuario'] ?? null;
$rol = $usuario['rol'] ?? 'Invitado';

// Agrupar por tipo de menú
$tipos = [];
foreach ($lista_menu as $plato) {
    $tipos[$plato['tipo_menu']][] = $plato;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menú | Fazbear Entertainment</title>
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
        transform: translateY(-5px) !important;
    }

    .card-header {
        background: linear-gradient(135deg, #e63946 0%, #c1121f 100%) !important;
        border: 2px solid #2a2a3e !important;
        box-shadow: 0 0 20px rgba(230, 57, 70, 0.6) !important;
    }

    .form-select {
        background: rgba(10, 10, 10, 0.8) !important;
        border: 2px solid #2a2a3e !important;
        color: #a8dadc !important;
        border-radius: 8px !important;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5) !important;
    }

    .form-select:focus {
        border-color: #e63946 !important;
        box-shadow: 
            inset 0 0 10px rgba(0, 0, 0, 0.5),
            0 0 15px rgba(230, 57, 70, 0.5) !important;
        background: rgba(15, 15, 15, 0.9) !important;
    }

    .form-control {
        background: rgba(10, 10, 10, 0.8) !important;
        border: 2px solid #2a2a3e !important;
        color: #a8dadc !important;
        border-radius: 8px !important;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5) !important;
    }

    .btn {
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        font-weight: bold !important;
        transition: all 0.3s ease !important;
    }

    .btn-outline-info {
        border-color: #e63946 !important;
        color: #e63946 !important;
    }

    .btn-outline-info:hover {
        background: #e63946 !important;
        border-color: #e63946 !important;
        color: #0a0a0a !important;
        box-shadow: 0 0 15px rgba(230, 57, 70, 0.7) !important;
    }

    .btn-ordenar {
        background: linear-gradient(135deg, #e63946 0%, #c1121f 100%) !important;
        border: 2px solid #2a2a3e !important;
        color: #a8dadc !important;
        box-shadow: 0 0 15px rgba(230, 57, 70, 0.5) !important;
    }

    .btn-ordenar:hover {
        background: linear-gradient(135deg, #c1121f 0%, #e63946 100%) !important;
        box-shadow: 0 0 25px rgba(230, 57, 70, 0.8) !important;
        transform: scale(1.05) !important;
    }
</style>

<body>

  <img id="fondo" src="./img/fondo.jpg" alt="Fondo del menú">

  <!-- Navbar -->
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
          <li class="nav-item"><a class="nav-link active" href="#" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Menú</a></li>
          <li class="nav-item"><a class="nav-link" href="./sucursales.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Sucursales</a></li>
          <li class="nav-item"><a class="nav-link" href="./Inicio_sesion.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Inicio de sesión</a></li>
          <?php if ($rol === 'Administrador'): ?>
            <li class="nav-item"><a class="nav-link" href="./perfil_admin.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="./perfil.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Contenido -->
  <div class="container mt-4">
    <h1 class="text-center mb-4" style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 4px !important; text-shadow: 0 0 20px rgba(230, 57, 70, 0.9), 0 0 40px rgba(230, 57, 70, 0.6), 4px 4px 8px rgba(0, 0, 0, 0.9) !important; animation: flicker 4s infinite alternate; font-weight: bold !important; position: relative; z-index: 2;">Menú Fazbear</h1>

    <!-- Filtro -->
    <div class="text-center mb-5">
      <label class="me-2 h5" style="color: #a8dadc !important; text-transform: uppercase !important; letter-spacing: 1px !important;">Filtrar por tipo:</label>
      <select id="filtro" class="form-select d-inline-block w-auto" style="border-color: #e63946 !important;">
        <option value="todos">Todos</option>
        <?php foreach (array_keys($tipos) as $tipo): ?>
          <option value="<?= strtolower(str_replace(' ', '_', $tipo)) ?>">
            <?= htmlspecialchars($tipo) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Secciones del menú -->
    <?php foreach ($tipos as $tipo => $platos): 
      $idTipo = strtolower(str_replace(' ', '_', $tipo));
    ?>
      <div class="seccion-menu" id="seccion_<?= $idTipo ?>">

        <div class="card-header text-center text-white rounded-pill mb-4">
          <h2 class="h4 my-2" style="text-transform: uppercase !important; letter-spacing: 2px !important; text-shadow: 0 0 10px rgba(0, 0, 0, 0.8) !important;"><?= htmlspecialchars($tipo) ?></h2>
        </div>

        <div class="row justify-content-center">

        <?php foreach ($platos as $p): ?>
          <div class="col-md-4 mb-4">

            <div class="card shadow"
                 data-id="<?= $p['id_menu'] ?>"
                 data-nombre="<?= htmlspecialchars($p['nombre']) ?>"
                 data-precio="<?= $p['precio'] ?>"
                 data-imagen="<?= htmlspecialchars($p['imagen']) ?>">

              <img class="card-img-top"
                   src="../uploads/<?= htmlspecialchars($p['imagen']) ?>"
                   alt="<?= htmlspecialchars($p['nombre']) ?>"
                   style="height: 250px; object-fit: cover; border-top-left-radius:12px; border-top-right-radius:12px; border-bottom: 2px solid #2a2a3e !important;">

              <div class="card-body text-center">

                <h4 class="card-title" style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 1px !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.5) !important;"><?= htmlspecialchars($p['nombre']) ?></h4>
                <h5 class="text-primary" style="color: #a8dadc !important; font-weight: bold !important; text-shadow: 0 0 10px rgba(168, 218, 220, 0.3) !important;">$<?= number_format($p['precio'], 0, ',', '.') ?></h5>
                <p class="card-text" style="color: #8d99ae !important; font-size: 14px !important;"><?= htmlspecialchars($p['descripcion']) ?></p>

                <div class="d-flex justify-content-center mt-3">
                  <button class="btn btn-outline-info btn-sm menos">−</button>
                  <input type="text" class="form-control text-center mx-2 cantidad" value="0" style="width: 50px; background: rgba(10, 10, 10, 0.8) !important; border: 2px solid #2a2a3e !important; color: #a8dadc !important;" readonly>
                  <button class="btn btn-outline-info btn-sm mas">+</button>
                </div>

                <button class="btn btn-ordenar mt-3" style="display:none;">Añadir al pedido</button>

              </div>

            </div>

          </div>
        <?php endforeach; ?>

        </div>
      </div>
    <?php endforeach; ?>

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

  <script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // --- Filtro funcional ---
    const filtro = document.getElementById('filtro');
    const secciones = document.querySelectorAll('.seccion-menu');

    filtro.addEventListener('change', () => {
      const valor = filtro.value;
      secciones.forEach(sec => {
        sec.style.display = (valor === 'todos' || sec.id === 'seccion_' + valor)
          ? 'block'
          : 'none';
      });
    });

    // --- Control de cantidades ---
    document.querySelectorAll('.card').forEach(card => {
      const mas = card.querySelector('.mas');
      const menos = card.querySelector('.menos');
      const cantidad = card.querySelector('.cantidad');
      const boton = card.querySelector('.btn-ordenar');

      mas.addEventListener('click', () => {
        cantidad.value = parseInt(cantidad.value) + 1;
        boton.style.display = "inline-block";
      });

      menos.addEventListener('click', () => {
        if (cantidad.value > 0) cantidad.value--;
        if (cantidad.value == 0) boton.style.display = "none";
      });
    });

    // --- Agregar al carrito ---
    document.querySelectorAll('.card').forEach(card => {
      const boton = card.querySelector('.btn-ordenar');

      boton.addEventListener('click', () => {
        const cantidad = card.querySelector('.cantidad').value;

        if (cantidad <= 0) return alert("Selecciona una cantidad");

        fetch('../controlador/carrito_controlador.php', {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams({
            accion: "agregar",
            id: card.dataset.id,
            nombre: card.dataset.nombre,
            precio: card.dataset.precio,
            cantidad: cantidad,
            imagen: card.dataset.imagen
          })
        })
        .then(r => r.json())
        .then(() => {
          alert(card.dataset.nombre + " añadido al carrito");
        });
      });
    });
  </script>

</body>
</html>