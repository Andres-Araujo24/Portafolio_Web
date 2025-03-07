<?php
//Si la sesion no existe, con isset, inicia la sesion
if (!isset($_SESSION)) {
    session_start();
}
//Si el login esta como true, lo pondra true; y si el usuario no esta autenticado pues false
$auth = $_SESSION['login'] ?? false;
if (!isset($inicio)) {
    $inicio = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="../build/css/app.css">
</head>

<body>
    <!--Evaluamos la variable inicio que esta en index.php, si esta como true entonces agregara el string inicio y si es false un string vacio.-->
    <header class="header <?php echo $inicio ? "inicio" : ""; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="Logo">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="Logo de menu">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Modo oscuro">

                    <nav class="navegacion">
                        <a href="/nosotros">Nosotros</a>
                        <a href="/propiedades">Anuncios</a>
                        <a href="/blog">Blog</a>
                        <a href="/contacto">Contacto</a>
                        <!--Si auth esta como true-->
                        <?php if ($auth): ?>
                            <a href="/logout">Cerrar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div><!--Barra-->


            <?php
            //Si posee inicio en true, ejecuta y sino pues pon cadenas vacias  
            echo $inicio ? "<h1>Venta de Casas y Departamentos Exclusivos de Lujos</h1>" : "";
            ?>
        </div>
    </header>



    <?php echo $contenido; ?>



    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="/nosotros">Nosotros</a>
                <a href="/propiedades">Anuncios</a>
                <a href="/blog">Blog</a>
                <a href="/contacto">Contacto</a>
            </nav>
        </div>
        <p class="copyright">Todos los derechos reservados <?php echo date('Y'); ?> &copy;</p>
    </footer>

    <script src="../build/js/bundle.min.js"></script>
</body>

</html>