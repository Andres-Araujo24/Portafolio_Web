//Creando arreglos
const ingresos = [
    new Ingreso('Salario', 30000),
    new Ingreso('Venta Coche', 15000)
];

const egresos = [
    new Egreso('Renta Departamento', 1200),
    new Egreso('Ropa', 400)
];


let cargarApp = () => {
    cargarCabecero(); //Para que se actualice el monto de la cabecera cada que se haga cambios
    cargarIngresos();
    cargarEgresos();
    agregarDato();
}

let totalIngresos = () => {
    let totalIngreso = 0;

    for(let ingreso of ingresos) { //Iterando por  cada elemento del arreglo ingreso
        totalIngreso += ingreso.valor; //Para que se vayan sumando los valores de los ingresos en la variable
    }
    return totalIngreso; //Para que lo retorne el total
}

let totalEgresos = () => {
    let totalEgreso = 0;

    for(let egreso of egresos) {
        totalEgreso += egreso.valor; //Para que se vayan sumando los valores de los egresos en la variable
    }
    return totalEgreso; //Para que lo retorne el total
}

let cargarCabecero = () => {
    let presupuesto = totalIngresos() - totalEgresos();
    let porcentajeEgreso = totalEgresos() / totalIngresos();

    //Recuperando los elementos
    document.getElementById('presupuesto').innerHTML = formatoMoneda(presupuesto); //Modificamos el valor que se encontraba con ese ID
    document.getElementById('porcentaje').innerHTML = formatoPorcentaje(porcentajeEgreso);
    document.getElementById('ingresos').innerHTML = formatoMoneda(totalIngresos());
    document.getElementById('egresos').innerHTML = formatoMoneda(totalEgresos());

}

const formatoMoneda = (valor) => { //Recibimos el valor que vamos a modificar
    return valor.toLocaleString('en-US', {style: 'currency', currency: 'USD', minimumFractionDigits: 2});
}

const formatoPorcentaje = (valor) => {
    return valor.toLocaleString('en-US', {style: 'percent', minimumFractionDigits: 2});
}


//Lista de ingresos y egresos

const cargarIngresos = () => {
    let ingresosHTML = '';
    for(let ingreso of ingresos) {
        ingresosHTML += crearIngresoHTML(ingreso);
    }

    document.getElementById("lista-ingresos").innerHTML = ingresosHTML
}

const crearIngresoHTML = (ingreso) => { //Para cada elemento de ingreso se generara este codigo
    let ingresoHTML = `
        <div class="elemento limpiarEstilos">
            <div class="elemento_descripcion">${ingreso.descripcion}</div>
                <div class="derecha limpiarEstilos">
                    <div class="elemento_valor">+ ${formatoMoneda(ingreso.valor)}</div>
                        <div class="elemento_eliminar">
                            <button class="elemento_eliminar--btn">
                                <ion-icon name="close-circle-outline"
                                onclick="eliminarIngreso(${ingreso.id})"></ion-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    return ingresoHTML;
}

const eliminarIngreso = (id) => { //Parametro a pasar
    //Utiliza ingreso como variable para recorrer/buscar en el arreglo de ingresos, con esa variable podemos acceder a los atributos de ingreso, usaremos el ingreso.id para recuperar el objeto, vemos si coincide con el id que proporcionamos y si coincide pues devuelve el indice del arreglo del objeto encontrado
    let indiceEliminar = ingresos.findIndex(ingreso => ingreso.id === id);
    ingresos.splice(indiceEliminar, 1); //Indicando que eliminara un solo elemento
    cargarCabecero();
    cargarIngresos(); 
}



const cargarEgresos = () => {
    let egresosHTML = '';
    for(let egreso of egresos) {
        egresosHTML += crearEgresoHTML(egreso);
    }

    document.getElementById("lista-egresos").innerHTML = egresosHTML
}

const crearEgresoHTML = (egreso) => {
    let egresoHTML = `
        <div class="elemento limpiarEstilos">
            <div class="elemento_descripcion">${egreso.descripcion}</div>
                <div class="derecha limpiarEstilos">
                    <div class="elemento_valor">- ${formatoMoneda(egreso.valor)}</div>
                        <div class="elemento_porcentaje">${formatoPorcentaje(egreso.valor / totalEgresos())}</div>
                            <div class="elemento_eliminar">
                                <button class="elemento_eliminar--btn">
                                    <ion-icon name="close-circle-outline"
                                    onclick="eliminarEgreso(${egreso.id})"></ion-icon>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    return egresoHTML;
}

const eliminarEgreso = (id) => { 
    let indiceEliminar = egresos.findIndex(egreso => egreso.id === id);
    egresos.splice(indiceEliminar, 1); 
    cargarCabecero();
    cargarEgresos(); 
}


//Agregar datos sea ingreso o egreso
let agregarDato = () => {
    //Recuperando el formulario
    let forma = document.forms["forma"];
    //Recuperando estos objetos
    let tipo = forma["tipo"];
    let descripcion = forma["descripcion"];
    let valor = forma["valor"];
    //Validando que los valores no son nulos
    if(descripcion.value !== '' && valor.value !== '') { //Con el .value entramos a las propiedades
        if(tipo.value === "ingreso") {
            ingresos.push( new Ingreso(descripcion.value, +valor.value )); //Agregando un nuevo ingreso. El + para convertirlo en un tipo numero por si venia como string.
            cargarCabecero();
            cargarIngresos();
        }
        else if(tipo.value === "egreso") {
            egresos.push( new Egreso(descripcion.value, +valor.value )); 
            cargarCabecero();
            cargarEgresos();
        }
    }
}