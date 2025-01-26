
class Egreso extends Dato {
    static contadorEgresos = 0;

    constructor(descripcion, valor) {
        super(descripcion, valor);
        this._id = ++Egreso.contadorEgresos; //Usamos el incremento en ambas para que vaya 1-2-3...
    }

    get id() {
        return this._id;
    }
}