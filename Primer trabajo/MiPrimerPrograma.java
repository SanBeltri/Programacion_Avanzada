public class MiPrimerPrograma {
    public static void main(String args[]) {
        // 4 CPUs
        CPU cpu1 = new CPU("Intel", "i5-10400", 2900, 45);
        CPU cpu2 = new CPU("AMD",   "Ryzen5-3600", 3600, 50);
        CPU cpu3 = new CPU("Intel", "i7-10700K", 3800, 55);
        CPU cpu4 = new CPU("AMD",   "Ryzen7-5800X", 3800, 48);

        cpu1.medirTemp();
        System.out.println(cpu1.leerFrecuencia());
        cpu1.overclock(300);
        cpu1.enfriar(10);
        System.out.println();

        // 4 memorias
        Memoria m1 = new Memoria("Kingston", 8,  "DDR4", 2666);
        Memoria m2 = new Memoria("Corsair", 16, "DDR4", 3200);
        Memoria m3 = new Memoria("GSkill",  32, "DDR4", 3600);
        Memoria m4 = new Memoria("Crucial", 8,  "DDR3", 1600);

        m1.mostrarSpecs();
        m1.limpiar();
        m1.ampliar(4);
        System.out.println(m1.usoEstimado(2048) + "% usado");
        System.out.println();

        // 4 discos
        Disco d1 = new Disco("Seagate", 1000, "HDD", 7200);
        Disco d2 = new Disco("WD",       500,  "HDD", 5400);
        Disco d3 = new Disco("Samsung",  250,  "SSD",  0);
        Disco d4 = new Disco("Kingston", 128,  "SSD",  0);

        d1.mostrarSpecs();
        d1.formatear();
        d1.escribir(100);
        d1.leer(50);
        System.out.println();

        // 4 GPUs
        GPU g1 = new GPU("NVIDIA", "RTX3060", 12, 1320);
        GPU g2 = new GPU("AMD",    "RX6600",   8, 1960);
        GPU g3 = new GPU("NVIDIA", "GTX1660",  6, 1530);
        GPU g4 = new GPU("AMD",    "RX580",    8, 1400);

        g1.mostrarSpecs();
        g1.renderizar("escena 3D");
        g1.overclock(50);
        g1.actualizarDriver("21.7.1");
    }
}
