public class GPU {
    // 4 atributos
    private String marca;
    private String modelo;
    private int vramGB;
    private double clockMHz;

    // Constructor
    public GPU(String marca, String modelo, int vramGB, double clockMHz) {
        this.marca = marca;
        this.modelo = modelo;
        this.vramGB = vramGB;
        this.clockMHz = clockMHz;
    }

    // 4 métodos
    public void mostrarSpecs() {
        System.out.println("GPU " + modelo + " → VRAM: " + vramGB + "GB, clock: " + clockMHz + "MHz");
    }

    public void renderizar(String escena) {
        System.out.println("GPU " + modelo + " renderizando: " + escena);
    }

    public void overclock(double extraMHz) {
        clockMHz += extraMHz;
        System.out.println("GPU " + modelo + " → nuevo clock: " + clockMHz + "MHz");
    }

    public void actualizarDriver(String version) {
        System.out.println("GPU " + modelo + " → driver actualizado a v" + version);
    }

    // Getters y setters
    public String getMarca() { return marca; }
    public void setMarca(String marca) { this.marca = marca; }
    public String getModelo() { return modelo; }
    public void setModelo(String modelo) { this.modelo = modelo; }
    public int getVramGB() { return vramGB; }
    public void setVramGB(int vramGB) { this.vramGB = vramGB; }
    public double getClockMHz() { return clockMHz; }
    public void setClockMHz(double clockMHz) { this.clockMHz = clockMHz; }
}
