public class Oficina extends Computador {
    Oficina(Procesador p, Memoria m, Almacenamiento d, Grafica g) {
        super(p, m, d, g);
        System.out.println("El computador de Oficina fue ensamblado correctamente.");
    }

    public void ensamblar() {
        System.out.println("Computador de Oficina encendido.");
        getProcesador().mostrar();
        getMemoria().mostrar();
        getDisco().mostrar();
        getGrafica().mostrar();
    }
}
