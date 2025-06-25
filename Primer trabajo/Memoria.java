public class Memoria {
    // 4 atributos
    private String marca;
    private int capacidadGB;
    private String tipo;       // DDR3, DDR4, DDR5…
    private int velocidadMHz;

    // Constructor
    public Memoria(String marca, int capacidadGB, String tipo, int velocidadMHz) {
        this.marca = marca;
        this.capacidadGB = capacidadGB;
        this.tipo = tipo;
        this.velocidadMHz = velocidadMHz;
    }

    // 4 métodos
    public void mostrarSpecs() {
        System.out.println("RAM " + tipo + " " + capacidadGB + "GB @" + velocidadMHz + "MHz");
    }

    public void limpiar() {
        System.out.println("Liberando memoria RAM de " + marca);
    }

    public void ampliar(int extraGB) {
        capacidadGB += extraGB;
        System.out.println("RAM " + marca + " → nueva capacidad: " + capacidadGB + "GB");
    }

    public int usoEstimado(int usadoMB) {
        int pct = (usadoMB * 100) / (capacidadGB * 1024);
        return pct;
    }

    // Getters y setters
    public String getMarca() { return marca; }
    public void setMarca(String marca) { this.marca = marca; }
    public int getCapacidadGB() { return capacidadGB; }
    public void setCapacidadGB(int capacidadGB) { this.capacidadGB = capacidadGB; }
    public String getTipo() { return tipo; }
    public void setTipo(String tipo) { this.tipo = tipo; }
    public int getVelocidadMHz() { return velocidadMHz; }
    public void setVelocidadMHz(int velocidadMHz) { this.velocidadMHz = velocidadMHz; }
}
