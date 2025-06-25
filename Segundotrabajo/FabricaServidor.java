public class FabricaServidor extends FabricaComputador {
    public Procesador crearProcesador() {
        return new Intel();
    }

    public Memoria crearMemoria() {
        return new RAM32GB();
    }

    public Almacenamiento crearAlmacenamiento() {
        return new HDD();
    }

    public Grafica crearGrafica() {
        return new Nvidia();
    }

    public Computador crearComputador(Procesador p, Memoria m, Almacenamiento d, Grafica g) {
        return new Servidor(p, m, d, g);
    }
}
