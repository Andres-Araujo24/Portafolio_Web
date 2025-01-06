//Creando la seccion Galeria
document.addEventListener('DOMContentLoaded', function() {
    navegacionFija()
    crearGaleria()
    resaltarEnlace()
    scrollNav()
})

function navegacionFija() {
    const header = document.querySelector('.header')
    const sobreFestival = document.querySelector('.sobre-festival')

    window.addEventListener('scroll', function() { //Para que escuche por el scroll
        if(sobreFestival.getBoundingClientRect().bottom < 1) { //Esto nos da la coordenada, si es menor a 1 paso x parte de la pagina.
            header.classList.add('fixed')
        } else {
            header.classList.remove('fixed')
        }
    }) 
}

function  crearGaleria() {
    const cantidad_imagenes = 16
    const galeria = document.querySelector('.galeria-imagenes')

    for(let i = 1; i <= cantidad_imagenes; i++) {
        const imagen = document.createElement('PICTURE')
        imagen.innerHTML = `
            <source srcset="build/img/gallery/thumb/${i}.avif" type="image/avif">
            <source srcset="build/img/gallery/thumb/${i}.webp" type="image/webp">
            <img loading="lazy" width="200" height="300" src="build/img/gallery/thumb/${i}.jpg" alt="imagen galeria">
        `;

        //Event Handler, detecta y responde a la interaccion de un usuario, en este caso un click
        imagen.onclick = function() { //Tiene function porque esta tomando un parametro.
            mostrarImagen(i);
        }

        galeria.appendChild(imagen) //Agregandole cada una de las imagenes
    }
}

function mostrarImagen(i) {
    const imagen = document.createElement('PICTURE')
    imagen.innerHTML = `
            <source srcset="build/img/gallery/full/${i}.avif" type="image/avif">
            <source srcset="build/img/gallery/full/${i}.webp" type="image/webp">
            <img loading="lazy" width="200" height="300" src="build/img/gallery/full/${i}.jpg" alt="imagen galeria">
        `;

    //Generar Modal, el fondo que se oscurece cuando seleccionas una imagen
    const modal = document.createElement('DIV')
    modal.classList.add('modal')
    modal.onclick = cerrarModal 

    modal.appendChild(imagen) //Agregando la imagen al modal

    //Boton para cerrar modal
    const cerrarModalBtn = document.createElement('BUTTON')
    cerrarModalBtn.textContent = 'X'
    cerrarModalBtn.classList.add('btn-cerrar')
    cerrarModalBtn.onclick = cerrarModal
    modal.appendChild(cerrarModalBtn)

    //Agregar al HTML
    const body = document.querySelector('body') //Seleccionamos el body y le agregamos modal
    body.classList.add('overflow-hidden')
    body.appendChild(modal)

}

function cerrarModal() {
    const modal = document.querySelector('.modal')
    modal.classList.add('fade-out')
    

    setTimeout(() => {
        modal?.remove(); //Si existe la clase modal, eliminala.  
        
        const body = document.querySelector('body') 
        body.classList.remove('overflow-hidden')
    }, 500);
}

function resaltarEnlace() {
    document.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('section')
        const navLinks = document.querySelectorAll('.navegacion-principal a')

        let actual = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop //Distancia de los sections con respecto al body
            const sectionHeight = section.clientHeight //Size de los sections

            if (window.scrollY >= (sectionTop - sectionHeight / 3)) {  //Para detectar cual section esta mas visible
                actual = section.id
            }
        })

        navLinks.forEach(link => { //Para recorrer los enlaces
            link.classList.remove('active')
            if (link.getAttribute('href') === '#' + actual) { //Detectamos cual tiene el valor igual al actual y le agregamos la siguiente clase.
                link.classList.add('active')
            }
        })
    })
}

function scrollNav() { //Para que me lleve a la seccion que le de click y con animaciones
    const navLinks = document.querySelectorAll('.navegacion-principal a')

    navLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault()

            const sectionScroll = e.target.getAttribute('href')
            const section = document.querySelector(sectionScroll)

            section.scrollIntoView({behavior: 'smooth'})
        })
    })
}