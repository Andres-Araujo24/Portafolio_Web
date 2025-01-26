
class Ingreso extends Dato {
    static contadorIngresos = 0;

    constructor(descripcion, valor) {
        super(descripcion, valor);
        this._id = ++Ingreso.contadorIngresos; //Nuestro id que sera un elemento estatico lo definimos arriba.
    }

    //Solo tendra get para regresar el valor en caso necesario
    get id() {
        return this._id;
    }
}