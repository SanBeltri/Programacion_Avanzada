public class Servidor extends Computador {
    Servidor(Procesador p, Memoria m, Almacenamiento d, Grafica g) {
        super(p, m, d, g);
        System.out.println("El computador Servidor fue ensamblado correctamente.");
    }

    public void ensamblar() {
        System.out.println("Servidor encendido.");
        getProcesador().mostrar();
        getMemoria().mostrar();
        getDisco().mostrar();
        getGrafica().mostrar();
    }
}
