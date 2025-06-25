public class Tecnico {
    public Computador ensamblarComputador(FabricaComputador fabrica) {
        return fabrica.crearComputador(
            fabrica.crearProcesador(),
            fabrica.crearMemoria(),
            fabrica.crearAlmacenamiento(),
            fabrica.crearGrafica()
        );
    }
}
