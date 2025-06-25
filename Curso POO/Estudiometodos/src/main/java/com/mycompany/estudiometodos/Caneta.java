
package com.mycompany.estudiometodos;

public class Caneta {
    private String modelo;
    private float ponta;
    private boolean tampada;
    private String cor;
    
    public Caneta(String m, String c, float p){  //metodo constructor
        this.tampar();
        this.cor = c;
        this.modelo = m;
        this.setPonta(p);
        
        
         
    }
    public void tampar() {
        this.tampada = true;
    }
    public void destampar(){
        this.tampada = false;
    }
    public String getModelo(){
        return this.modelo;
        
    }
    public void setModelo(String m){
        this.modelo = m;
    }
    public float getPonta(){
        return this.ponta;
    }
    public void setPonta(float p){
            this.ponta =p;
    }
    public void status(){
        System.out.println("SOBRE A CANETA");
        System.out.println("Modelo:"+this.getModelo());
        System.out.println("ponta:"+this.getPonta());
        System.out.println("Tampada:"+this.tampada);
        System.out.println("Cor:"+this.cor);
                
    }
}

