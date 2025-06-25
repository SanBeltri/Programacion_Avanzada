public class FabricaOficina extends FabricaComputador {
    public Procesador crearProcesador() {
        return new Intel();
    }

    public Memoria crearMemoria() {
        return new RAM16GB();
    }

    public Almacenamiento crearAlmacenamiento() {
        return new HDD();
    }

    public Grafica crearGrafica() {
        return new Radeon();
    }

    public Computador crearComputador(Procesador p, Memoria m, Almacenamiento d, Grafica g) {
        return new Oficina(p, m, d, g);
    }
}
