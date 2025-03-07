//Listener, y con el DOM, es que haya cargado toda la pagina, luego de ese evento, ejecutaremos las funciones
document.addEventListener('DOMContentLoaded', function() {
    eventListeners();
    darkMode();
});

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');
    //Le pondre un event listener para cuando demos click en el logo de menu, ejecutara la funcion para que aparezca la navegacion
    mobileMenu.addEventListener('click', navegacionResponsive); //Creamos la funcion aparte.

    //Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]') //Seleccionando los input con este name.
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto)) //iterando cada uno y agregandole el EventListener
    
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');
    //Esto hace que si no la tiene la agrega y si la tiene la elimina
    navegacion.classList.toggle('mostrar');
}

function darkMode() {
    //Esto es usando la preferencia del usuario, cambiara automaticamente entre claro y oscuro
    const prefiereDarkMode = window.matchMedia("(prefers-color=scheme: dark)");
    //Matches, dice si es true o false, dependiendo como el usuario tenga su pc en modo claro u oscuro
    if(prefiereDarkMode.matches) {
        document.body.classList.add("dark-mode"); //Si le gusta oscuro, directamente pondra el dark-mode
    } else {
        document.body.classList.remove("dark-mode"); //Caso contrario, lo eliminara
    }

    prefiereDarkMode.addEventListener("change", function() { //Cuando hagan el cambio desde la pc
        if(prefiereDarkMode.matches) {
            document.body.classList.add("dark-mode"); 
        } else {
            document.body.classList.remove("dark-mode"); 
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    //Le agregamos un listener de click para poder hacer el cambio
    botonDarkMode.addEventListener('click', function() { //Creamos la funcion ahi mismo.
        document.body.classList.toggle('dark-mode'); //Para que lo agregue en el body.
        //Y esa clase, tendra ciertos estilos para que cambie a modo oscuro.
    });
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');
    //Viendo cual de las dos opciones selecciono
    if(e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <label for="telefono">Numero De Teléfono</label>
            <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">

            <p>Elija la fecha y hora para la llamada</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    } else {
        contactoDiv.innerHTML = `
            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" required>
        `;
    }
}