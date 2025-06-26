package com.mycompany.cuentabanco;

import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

public class Utils {

    static NumberFormat formatoNumero = new DecimalFormat("$ #,##0.00");
    static SimpleDateFormat formatoFecha = new SimpleDateFormat("dd/MM/yyyy");

    public static String fechaAString(Date fecha) {
        return formatoFecha.format(fecha);
    }

    public static String doubleAString(Double valor) {
        return formatoNumero.format(valor);
    }
}
