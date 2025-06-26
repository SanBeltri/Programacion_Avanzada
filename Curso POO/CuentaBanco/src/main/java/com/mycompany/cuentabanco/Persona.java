package com.mycompany.cuentabanco;

import java.util.Date;

public class Persona {

    private static int contador = 1;

    private int numeroPersona;
    private String nombre;
    private String cedula;
    private String correo;
    private Date fechaCreacionCuenta;

    public Persona(String nombre, String cedula, String correo) {
        this.numeroPersona = Persona.contador++;
        this.nombre = nombre;
        this.cedula = cedula;
        this.correo = correo;
        this.fechaCreacionCuenta = new Date();
    }

    public int getNumeroPersona() {
        return numeroPersona;
    }

    public String getNombre() {
        return nombre;
    }

    public String getCedula() {
        return cedula;
    }

    public String getCorreo() {
        return correo;
    }

    public Date getFechaCreacionCuenta() {
        return fechaCreacionCuenta;
    }

    public String toString() {
        return "\nNombre: " + nombre +
               "\nCédula: " + cedula +
               "\nCorreo: " + correo +
               "\nFecha de creación: " + Utils.fechaAString(fechaCreacionCuenta);
    }
}
