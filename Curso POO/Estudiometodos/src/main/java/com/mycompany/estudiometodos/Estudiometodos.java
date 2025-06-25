
package com.mycompany.estudiometodos;


public class Estudiometodos {

    public static void main(String[] args) {
      Caneta C1= new Caneta("bic", "Azul",0.5f) ;
      //C1.setModelo("Bic");
      //C1.setPonta(0.6f);
      //C1.ponta = 0.6f
      C1.status();
      Caneta C2= new Caneta("bic2", "Amarelo",0.3f);
      C2.status();
    }
}
