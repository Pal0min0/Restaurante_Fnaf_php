<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="./Js/jquery-3.7.1.min.js"></script>
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
                    <li class="nav-item"><a class="nav-link" href="./sucursales.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Sucursales</a></li>
                    <li class="nav-item"><a class="nav-link" href="./Inicio_sesion.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Inicio de sesion</a></li>
                    <li class="nav-item"><a class="nav-link active" href="" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
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
                    <li class="nav-item"><a class="nav-link" href="./perfil.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Perfil</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Carrito</a></li>
                    <li class="nav-item"><a class="nav-link" href="./historial.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Historial de Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="./reservas_cliente.php" style="color: #a8dadc !important; font-size: 14px !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; padding: 10px 15px !important; border: 2px solid transparent !important; border-radius: 4px !important; margin: 0 5px !important; transition: all 0.3s ease !important; position: relative !important; overflow: hidden !important;">Reservas</a></li>
                </ul>
            </div>
        </div>
        </nav>

        
        
        <!-- Perfil -->
        <div id="perfil" class="container" style="display: none; background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important; border-radius: 30px !important; border: 3px solid #2a2a3e !important; box-shadow: 0 0 40px rgba(230, 57, 70, 0.4), inset 0 0 50px rgba(0, 0, 0, 0.6) !important; margin: 20px auto !important; position: relative; overflow: hidden;">
            <div class="d-flex" style=" align-items: center; gap: 50px; padding: 20px;">
                <img class="rounded-pill" src="./img/perfil.jpg" alt="perfil" style="width: 120px; border: 3px solid #2a2a3e !important; box-shadow: 0 0 20px rgba(230, 57, 70, 0.4) !important; transition: all 0.3s ease;">
                <div>
                    <h2 style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 3px !important; text-shadow: 0 0 15px rgba(230, 57, 70, 0.9), 0 0 30px rgba(230, 57, 70, 0.6), 3px 3px 6px rgba(0, 0, 0, 0.9) !important; font-weight: bold !important; margin: 0 !important;">Roberto Gomez</h2>
                    <hr style="border: 2px solid #e63946 !important; box-shadow: 0 0 10px rgba(230, 57, 70, 0.6) !important;">
                    <p style="color: #8d99ae !important; text-transform: uppercase !important; letter-spacing: 1.5px !important; font-size: 16px !important; margin: 0 !important;">Usuario antiguo</p>
                </div>
            </div>
        </div>

        <!-- Carrito -->
       <?php
            require_once "../modelo/carrito.php";
            $carritoModelo = new Carrito_modelo();

            $id_usuario = $_SESSION["usuario"]["id_usuario"];
            $carrito = $carritoModelo->listar($id_usuario);
        ?>
        
        <div class="container rounded mb-4" style="padding: 30px; margin-top: 30px; background: linear-gradient(135deg, #16213e 0%, #0f1626 100%) !important; border-radius: 20px !important; border: 6px dashed #e63946 !important; box-shadow: 0 0 40px rgba(230, 57, 70, 0.5), inset 0 0 50px rgba(0, 0, 0, 0.6) !important; position: relative; overflow: hidden;">
            <h1 class="text-center mb-4" style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 4px !important; text-shadow: 0 0 20px rgba(230, 57, 70, 0.9), 0 0 40px rgba(230, 57, 70, 0.6), 4px 4px 8px rgba(0, 0, 0, 0.9) !important; animation: flicker 4s infinite alternate; font-weight: bold !important; position: relative; z-index: 2; margin: 20px 0 !important;">Carrito de Compras</h1>
        
            <?php if (empty($carrito)): ?>
                <h3 class="text-center" style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.8) !important;">Tu carrito está vacío</h3>
            
            <?php else: ?>
            
                <?php foreach ($carrito as $item): ?>
                <div class="row mb-4 p-3" id="item-<?php echo $item['id_menu']; ?>" style="border: 2px dashed #e63946 !important; border-radius: 10px; background: rgba(22, 33, 62, 0.7) !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.3) !important;">
                    <div class="col-md-3 text-center">
                        <img src="../uploads/<?php echo $item['imagen']; ?>" class="img-fluid rounded" style="width: 100px; border: 2px solid #2a2a3e !important; box-shadow: 0 0 10px rgba(230, 57, 70, 0.3) !important;">
                        <h4 style="color: #a8dadc !important; margin-top: 10px;"><?php echo $item['nombre']; ?></h4>
                    </div>
                
                    <div class="col-md-6">
                        <h4 style="color: #a8dadc !important;">Cantidad: <?php echo $item['cantidad']; ?></h4>
                        <h5 class="precio-item"
                            data-precio="<?php echo $item['precio']; ?>"
                            data-cantidad="<?php echo $item['cantidad']; ?>" 
                            style="color: #e63946 !important; text-shadow: 0 0 10px rgba(230, 57, 70, 0.5) !important;">
                            Total: $<?php echo number_format($item['precio'] * $item['cantidad'], 0, ',', '.'); ?>
                        </h5>
                    </div>
                
                    <div class="col-md-3 text-center">
                        <button class="btn btn-danger eliminar" data-id="<?php echo $item['id_menu']; ?>" style="background: linear-gradient(135deg, #e63946 0%, #c1121f 100%) !important; border: 2px solid #2a2a3e !important; box-shadow: 0 0 15px rgba(230, 57, 70, 0.5) !important; text-transform: uppercase !important; letter-spacing: 1px !important;">Eliminar</button>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <hr style="border: 2px solid #e63946 !important; box-shadow: 0 0 10px rgba(230, 57, 70, 0.6) !important;">
                <h3 id="totalCarrito" class="text-end" style="color: #e63946 !important; text-transform: uppercase !important; letter-spacing: 2px !important; text-shadow: 0 0 15px rgba(230, 57, 70, 0.8) !important;">
                    Total general: 
                    $<?php 
                        echo number_format(array_sum(array_map(fn($i)=>$i['precio']*$i['cantidad'], $carrito)), 0, ',', '.');
                    ?>
                </h3>

                <div class="d-flex justify-content-end">
                    <a href="./pagos.php?total=<?php echo array_sum(array_map(fn($i)=>$i['precio']*$i['cantidad'], $carrito)); ?>" 
                    class="btn btn-primary btn-lg" style="background: linear-gradient(135deg, #e63946 0%, #c1121f 100%) !important; border: 2px solid #2a2a3e !important; box-shadow: 0 0 20px rgba(230, 57, 70, 0.6) !important; text-transform: uppercase !important; letter-spacing: 2px !important;">
                        Hacer Compra
                    </a>
                </div>
                
            <?php endif; ?>


        </div>
                
        <script>

        function actualizarTotalCarrito() {
            let total = 0;

            document.querySelectorAll(".precio-item").forEach(pre => {
                const precio = parseInt(pre.dataset.precio);
                const cantidad = parseInt(pre.dataset.cantidad);
                total += precio * cantidad;
            });

            const totalElement = document.getElementById("totalCarrito");
            if (totalElement) {
                totalElement.textContent = "Total general: $" + total.toLocaleString();
            }
        }

        document.querySelectorAll(".eliminar").forEach(btn => {
            btn.addEventListener("click", () => {

                const id = btn.dataset.id;

                fetch("../controlador/carrito_controlador.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({
                        accion: "eliminar",
                        id: id
                    })
                })
                .then(r => r.json())
                .then(resp => {

                    if (resp.status === "ok") {

                        // Quitar visualmente el item del carrito
                        const item = document.getElementById("item-" + id);
                        if (item) item.remove();

                        // Recalcular total general
                        actualizarTotalCarrito();
                        window.location.reload()
                    }
                });

            });
        });
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

</body>
</html>