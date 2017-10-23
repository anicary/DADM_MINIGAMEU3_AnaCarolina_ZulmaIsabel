package mx.edu.ittepic.dadm_u3_adivinanza_ana_carolina_mondragon_rangel;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.telephony.SmsManager;
import android.telephony.SmsMessage;
import android.widget.Toast;

/**
 * Created by UsuarioPrueba on 22/10/2017.
 */


public class ReceptorSMS extends BroadcastReceiver {
    int intento=0;
    String [][] adivinanza ={
            {"QUE TIENE EL REY EN LA PANSA??","OMBLIGO","EL OMBLIGO"},
            {"LANA SUBE LANA BAJA, QUE ES?","LA NAVAJA","NAVAJA"},
    };
    @Override
    public void onReceive(Context context, Intent intent) {
        //Toast.makeText(context,"SI ESTA TRABAJANDO EL RECIVER", Toast.LENGTH_SHORT).show();
        Bundle b = intent.getExtras();
        try {
            if (b != null) {
                final Object[] entrantes =(Object[]) b.get("pdus");
                for (int i=0; i<entrantes.length; i++){
                    SmsMessage mensaje = SmsMessage.createFromPdu((byte[])entrantes[i]);
                    String numero, contenido;

                    numero = mensaje.getDisplayOriginatingAddress();
                    contenido = mensaje.getDisplayMessageBody();

                    if(contenido.startsWith("!ADIVINANZA")){
                        if(intento!=3) {
                            SmsManager sms = SmsManager.getDefault();
                            sms.sendTextMessage(numero, null, "se a recibido un saludo, gracias.", null, null);
                        }
                    }

                    Toast.makeText(context,"Recibido dese: "+numero+"Contenido: " +contenido,Toast.LENGTH_SHORT).show();

                }
            }
        }catch (Exception e){
            Toast.makeText(context,"NO SE PUDO LEER EL SMS ENTRANTE", Toast.LENGTH_SHORT).show();
        }
    }
}
