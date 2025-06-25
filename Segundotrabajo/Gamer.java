public class Gamer extends Computador {
    Gamer(Procesador p, Memoria m, Almacenamiento d, Grafica g) {
        super(p, m, d, g);
        System.out.println("El computador Gamer fue ensamblado correctamente.");
    }

    public void ensamblar() {
        System.out.println("Computador Gamer encendido.");
        getProcesador().mostrar();
        getMemoria().mostrar();
        getDisco().mostrar();
        getGrafica().mostrar();
    }
}
