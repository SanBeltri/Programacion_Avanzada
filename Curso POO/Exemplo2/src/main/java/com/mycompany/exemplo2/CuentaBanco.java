
package com.mycompany.exemplo2;

import java.util.HashSet;

public class CuentaBanco {
 public int numeroCuenta;
    private String tipo;
    private String cliente;
    private float saldo; 
    private boolean status;
        

public void abrirCuenta(String t){
    this.setTipo(t);
    this.setStatus(true);
    if ("CC".equals(t)){
        this.setSaldo(50);
        
      }else if ("CP".equals(t)){
        this.setSaldo(150);
    }
    System.out.println("Cuenta abierta con exito");
}
public void cerrarCuenta(){
if(this.getSaldo()>0){
    System.out.println("La cuenta no puede ser cerrada porque aun tiene dinero");
}else if (this.getSaldo()<0){
            System.out.println("La cuenta no puede ser cerrada porque aun tiene debito");
            } else{
    this.setStatus(false);
    System.out.println("cuenta cerrada con exito");
}

}
public void depositar(float v){
    if (this.getStatus()){
        //this.saldo = this.saldo+v;
        this.setSaldo(this.getSaldo()+v);
        System.out.println("No se puede depositar en una cuenta cerrada");
    }

    public void sacar(float v){
if(this.getStatus())
    }
    public void pagarmes(){
    
}
// Metodos especiales
public CuentaBanco(){
this.setSaldo(0);
this.setStatus(false);
}

    public int getNumeroCuenta() {
        return numeroCuenta;
    }

    public void setNumeroCuenta(int numeroCuenta) {
        this.numeroCuenta = numeroCuenta;
    }

    public String getTipo() {
        return tipo;
    }

    public void setTipo(String tipo) {
        this.tipo = tipo;
    }

    public String getCliente() {
        return cliente;
    }

    public void setCliente(String cliente) {
        this.cliente = cliente;
    }

    public float getSaldo() {
        return saldo;
    }

    public void setSaldo(float saldo) {
        this.saldo = saldo;
    }

    public boolean getStatus() {
        return status;
    }

    public void setStatus(boolean status) {
        this.status = status;
    }

}