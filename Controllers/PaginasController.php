<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {
        //Cuando visitamos index, llamamos al model y le decimos que muestre 3 propiedades y luego la pasamos a la vista
        $propiedades = Propiedad::get(3); //Para que muestre solo 3 propiedades
        $inicio = true; //Esto es para tener la imagen en el header de inicio, ya que requiere que tenga esta variable para agregarlo

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router) {
        
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {
        $id = validarRedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router) {
        $router->render('paginas/blog');
    }

    public static function entrada(Router $router) {
        $router->render('paginas/entrada');
    }

    public static function contacto(Router $router) {
        $mensaje = null;
        //Para enviar Email
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];

            //Crear instancia de PHPMailer
            $mail = new PHPMailer();

            //Configurar SMTP, el protocolo para envios de Emails
            $mail->isSMTP(); //Para envios de correros
            $mail->Host = 'sandbox.smtp.mailtrap.io'; //El dominio, te lo da Mailtrap, que es donde recibiremos o enviaremos correos.
            $mail->SMTPAuth = true; //Para la autenticacion mia en Mailtrap
            $mail->Username = '4ad69036aea5a2'; //Mi username
            $mail->Password = 'a8825a2964665e'; //Mi password
            $mail->SMTPSecure = 'tls'; //Para Emails seguros, no encriptados pero seguros
            $mail->Port = '2525'; //Puerto al que se conectara en Mailtrap

            //Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com', 'BienesRaices.com'); //Quien envia el Email
            $mail->addAddress('admin@bienesraices.com'); //A que Email llegara ese correo
            $mail->Subject = 'Tienes un nuevo mensaje'; //El mensaje que va a llegar, lo primero que se va a leer

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //Definir contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>'; 
            $contenido .= '<p>Nombre: '. $respuestas['nombre'] . '</p>'; 

            //Enviar de forma condicional algunos campos de email o telefono
            if($respuestas['contacto' === 'telefono']) {
                $contenido .= '<p>Eligio ser contactado por Telefono</p>';
                $contenido .= '<p>Telefono: '. $respuestas['telefono'] . '</p>'; 
                $contenido .= '<p>Fecha: '. $respuestas['fecha'] . '</p>'; 
                $contenido .= '<p>Hora: '. $respuestas['hora'] . '</p>'; 
            } else {
                //Es email, entonces agregamos el campo de Email
                $contenido .= '<p>Eligio ser contactado por Email</p>'; 
                $contenido .= '<p>E-mail: '. $respuestas['email'] . '</p>'; 
            }
           
            $contenido .= '<p>Mensaje: '. $respuestas['mensaje'] . '</p>'; 
            $contenido .= '<p>Vende o Compra: '. $respuestas['tipo'] . '</p>'; 
            $contenido .= '<p>Precio o Presupuesto: $'. $respuestas['precio'] . '</p>'; 
            $contenido .= '</html>';

            


            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            //Enviar el email
            if($mail->send()) {
                $mensaje = "Mensaje Enviado Correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar...";
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}