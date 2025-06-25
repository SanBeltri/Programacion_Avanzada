public abstract class FabricaComputador {
    public abstract Procesador crearProcesador();
    public abstract Memoria crearMemoria();
    public abstract Almacenamiento crearAlmacenamiento();
    public abstract Grafica crearGrafica();
    public abstract Computador crearComputador(Procesador p, Memoria m, Almacenamiento d, Grafica g);
}
