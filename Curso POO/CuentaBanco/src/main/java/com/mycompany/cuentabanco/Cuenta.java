package com.mycompany.cuentabanco;

public class Cuenta {

    private static int contadorCuentas = 1;

    private int numeroCuenta;
    private Persona persona;
    private Double saldo = 0.0;

    public Cuenta(Persona persona) {
        this.numeroCuenta = Cuenta.contadorCuentas++;
        this.persona = persona;
    }

    public int getNumeroCuenta() {
        return numeroCuenta;
    }

    public Persona getPersona() {
        return persona;
    }

    public Double getSaldo() {
        return saldo;
    }

    public void depositar(Double valor) {
        if (valor > 0) {
            saldo += valor;
            System.out.println("Depósito realizado con éxito.");
        } else {
            System.out.println("No se pudo realizar el depósito.");
        }
    }

    public void retirar(Double valor) {
        if (valor > 0 && saldo >= valor) {
            saldo -= valor;
            System.out.println("Retiro realizado con éxito.");
        } else {
            System.out.println("No se pudo realizar el retiro.");
        }
    }

    public void transferir(Cuenta destino, Double valor) {
        if (valor > 0 && saldo >= valor) {
            this.saldo -= valor;
            destino.saldo += valor;
            System.out.println("Transferencia realizada con éxito.");
        } else {
            System.out.println("No se pudo realizar la transferencia.");
        }
    }

    public String toString() {
        return "\nCuenta N°: " + numeroCuenta +
               "\nCliente: " + persona.getNombre() +
               "\nCédula: " + persona.getCedula() +
               "\nCorreo: " + persona.getCorreo() +
               "\nSaldo: " + Utils.doubleAString(saldo) + "\n";
    }
}
