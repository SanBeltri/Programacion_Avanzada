
package com.mycompany.cuentabanco;

import java.util.ArrayList;
import java.util.Scanner;

public class CuentaBanco {

    static Scanner input = new Scanner(System.in);
    static ArrayList<Cuenta> cuentas = new ArrayList<>();

    public static void main(String[] args) {
        menu();
    }

    public static void menu() {
        System.out.println("\n----- Bienvenido al Banco -----");
        System.out.println("1 - Crear cuenta");
        System.out.println("2 - Depositar");
        System.out.println("3 - Retirar");
        System.out.println("4 - Transferir");
        System.out.println("5 - Listar cuentas");
        System.out.println("6 - Salir");

        int opcion = input.nextInt();
        switch (opcion) {
            case 1 -> crearCuenta();
            case 2 -> depositar();
            case 3 -> retirar();
            case 4 -> transferir();
            case 5 -> listar();
            case 6 -> System.exit(0);
            default -> {
                System.out.println("Opción no válida.");
                menu();
            }
        }
    }

    public static void crearCuenta() {
        input.nextLine(); // limpiar buffer
        System.out.print("Nombre: ");
        String nombre = input.nextLine();
        System.out.print("Cédula: ");
        String cedula = input.nextLine();
        System.out.print("Correo: ");
        String correo = input.nextLine();

        Persona persona = new Persona(nombre, cedula, correo);
        Cuenta cuenta = new Cuenta(persona);
        cuentas.add(cuenta);
        System.out.println("Cuenta creada con éxito.");
        menu();
    }

    public static Cuenta buscarCuenta(int numero) {
        for (Cuenta c : cuentas) {
            if (c.getNumeroCuenta() == numero) return c;
        }
        return null;
    }

    public static void depositar() {
        System.out.print("Número de cuenta: ");
        int numero = input.nextInt();
        Cuenta cuenta = buscarCuenta(numero);

        if (cuenta != null) {
            System.out.print("Valor a depositar: ");
            double valor = input.nextDouble();
            cuenta.depositar(valor);
        } else {
            System.out.println("Cuenta no encontrada.");
        }
        menu();
    }

    public static void retirar() {
        System.out.print("Número de cuenta: ");
        int numero = input.nextInt();
        Cuenta cuenta = buscarCuenta(numero);

        if (cuenta != null) {
            System.out.print("Valor a retirar: ");
            double valor = input.nextDouble();
            cuenta.retirar(valor);
        } else {
            System.out.println("Cuenta no encontrada.");
        }
        menu();
    }

    public static void transferir() {
        System.out.print("Número de cuenta origen: ");
        int origen = input.nextInt();
        Cuenta cuentaOrigen = buscarCuenta(origen);

        System.out.print("Número de cuenta destino: ");
        int destino = input.nextInt();
        Cuenta cuentaDestino = buscarCuenta(destino);

        if (cuentaOrigen != null && cuentaDestino != null) {
            System.out.print("Valor a transferir: ");
            double valor = input.nextDouble();
            cuentaOrigen.transferir(cuentaDestino, valor);
        } else {
            System.out.println("Una o ambas cuentas no fueron encontradas.");
        }
        menu();
    }

    public static void listar() {
        if (cuentas.isEmpty()) {
            System.out.println("No hay cuentas registradas.");
        } else {
            for (Cuenta cuenta : cuentas) {
                System.out.println(cuenta);
            }
        }
        menu();
    }
}
