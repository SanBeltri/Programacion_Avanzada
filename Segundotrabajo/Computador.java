public abstract class Computador {
    private Procesador procesador;
    private Memoria memoria;
    private Almacenamiento disco;
    private Grafica grafica;

    Computador(Procesador p, Memoria m, Almacenamiento d, Grafica g) {
        this.procesador = p;
        this.memoria = m;
        this.disco = d;
        this.grafica = g;
    }

    public abstract void ensamblar();

    public Procesador getProcesador() {
        return procesador;
    }

    public Memoria getMemoria() {
        return memoria;
    }

    public Almacenamiento getDisco() {
        return disco;
    }

    public Grafica getGrafica() {
        return grafica;
    }
}
