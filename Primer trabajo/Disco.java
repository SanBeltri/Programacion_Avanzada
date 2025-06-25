public class Disco {
    // 4 atributos
    private String marca;
    private int capacidadGB;
    private String tipo;    // HDD o SSD
    private int rpm;        

    // Constructor
    public Disco(String marca, int capacidadGB, String tipo, int rpm) {
        this.marca = marca;
        this.capacidadGB = capacidadGB;
        this.tipo = tipo;
        this.rpm = rpm;
    }

    // 4 métodos
    public void mostrarSpecs() {
        String extras = tipo.equals("HDD") ? (" @" + rpm + "rpm") : "";
        System.out.println("Disco " + tipo + " " + capacidadGB + "GB" + extras);
    }

    public void formatear() {
        System.out.println("Formateando disco " + marca);
    }

    public void escribir(int mb) {
        System.out.println("Escribiendo " + mb + " MB en " + marca);
    }

    public void leer(int mb) {
        System.out.println("Leyendo " + mb + " MB de " + marca);
    }

    // Getters y setters
    public String getMarca() { return marca; }
    public void setMarca(String marca) { this.marca = marca; }
    public int getCapacidadGB() { return capacidadGB; }
    public void setCapacidadGB(int capacidadGB) { this.capacidadGB = capacidadGB; }
    public String getTipo() { return tipo; }
    public void setTipo(String tipo) { this.tipo = tipo; }
    public int getRpm() { return rpm; }
    public void setRpm(int rpm) { this.rpm = rpm; }
}
