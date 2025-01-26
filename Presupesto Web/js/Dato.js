//Clase padre para ingresos y egresos
class Dato {
    constructor(descripcion, valor) {//Tendra un atributo que va a compartir la clase de ingreso y egreso
        this._descripcion = descripcion;
        this._valor = valor;
    } //Definiendo los atributos

    get descripcion() {
        return this._descripcion; //Regresando el atributo de nuestra clase
    }
    set descripcion(descripcion) { //Para poder acceder a estos atributos publicos
        this._descripcion = descripcion; //Modificamos descripcion con el parametros que estamos recibiendo
    }

    get valor() {
        return this._valor;
    }
    set valor(valor) {
        this._valor = valor;
    }
}