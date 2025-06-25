public class FabricaGamer extends FabricaComputador {
    public Procesador crearProcesador() {
        return new AMD();
    }

    public Memoria crearMemoria() {
        return new RAM32GB();
    }

    public Almacenamiento crearAlmacenamiento() {
        return new SSD();
    }

    public Grafica crearGrafica() {
        return new Nvidia();
    }

    public Computador crearComputador(Procesador p, Memoria m, Almacenamiento d, Grafica g) {
        return new Gamer(p, m, d, g);
    }
}
