public class CPU {
    // 4 atributos
    private String marca;
    private String modelo;
    private int frecuenciaMHz;
    private int temperaturaC;

    // Constructor
    public CPU(String marca, String modelo, int frecuenciaMHz, int temperaturaC) {
        this.marca = marca;
        this.modelo = modelo;
        this.frecuenciaMHz = frecuenciaMHz;
        this.temperaturaC = temperaturaC;
    }

    // 4 métodos (sin contar getters/setters)
    public void medirTemp() {
        System.out.println("CPU " + modelo + " → temp actual: " + temperaturaC + "°C");
    }

    public void overclock(int incrementoMHz) {
        frecuenciaMHz += incrementoMHz;
        System.out.println("CPU " + modelo + " → nueva freq: " + frecuenciaMHz + " MHz");
    }

    public int leerFrecuencia() {
        return frecuenciaMHz;
    }

    public void enfriar(int bajadaC) {
        temperaturaC -= bajadaC;
        System.out.println("CPU " + modelo + " → temp enfriada a: " + temperaturaC + "°C");
    }

    // Getters y setters (no cuentan en los 4 métodos)
    public String getMarca() { return marca; }
    public void setMarca(String marca) { this.marca = marca; }
    public String getModelo() { return modelo; }
    public void setModelo(String modelo) { this.modelo = modelo; }
    public int getFrecuenciaMHz() { return frecuenciaMHz; }
    public void setFrecuenciaMHz(int frecuenciaMHz) { this.frecuenciaMHz = frecuenciaMHz; }
    public int getTemperaturaC() { return temperaturaC; }
    public void setTemperaturaC(int temperaturaC) { this.temperaturaC = temperaturaC; }
}
