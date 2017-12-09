package mx.edu.ittepic.dadm_proyectofinal;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ListView;
import android.widget.Toast;

import com.rahuljanagouda.statusstories.StatusStoriesActivity;

import org.json.JSONArray;
import org.json.JSONException;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

public class tinderpet extends AppCompatActivity implements  AsyncResponse {
    tinderAdaptador adater;
    ArrayList<mascota> elemento;
    ArrayList<mascota> elementos;
    ListView Menu_lista;
    ConexionWeb conexionWeb;
    String idusuarios="";
    String imagenesMostrar[];
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tinderpet);
      //  setTitle("Tinder Pet");
        SharedPreferences prefs =  getSharedPreferences("INFO_USUARIO", Context.MODE_PRIVATE);
        idusuarios = prefs.getString("idusuarios", "0");
        Menu_lista = (ListView) findViewById(R.id.tinderlista);
        elemento = getElemento();
        cargarMascotas();

    }
    public boolean onCreateOptionsMenu(Menu m){
        getMenuInflater().inflate(R.menu.tindermenu,m);
        return true;
    }
    public boolean onOptionsItemSelected(MenuItem mi){
        switch (mi.getItemId()){
            case R.id.pet:
                   Intent a = new Intent(tinderpet.this, StatusStoriesActivity.class);
                a.putExtra(StatusStoriesActivity.STATUS_RESOURCES_KEY, imagenesMostrar);
                a.putExtra(StatusStoriesActivity.STATUS_DURATION_KEY, 3000L);
                a.putExtra(StatusStoriesActivity.IS_IMMERSIVE_KEY, true);
                a.putExtra(StatusStoriesActivity.IS_CACHING_ENABLED_KEY, true);
                a.putExtra(StatusStoriesActivity.IS_TEXT_PROGRESS_ENABLED_KEY, true);
                startActivity(a);
                break;
        }
        return true;
    }
    private ArrayList<mascota> getElemento() {
        elementos = new ArrayList<mascota>();
        return elementos;
    }
    public void cargarMascotas() {
        try {
            conexionWeb = new ConexionWeb(tinderpet.this);
            conexionWeb.agregarVariables("idusuarios", idusuarios);
            URL direcciopn = new URL("http://caropetworld.xyz/index.php/Sistema/tinder_pet");
            conexionWeb.execute(direcciopn);
        } catch (MalformedURLException e) {
            Toast.makeText(tinderpet.this, e.getMessage(), Toast.LENGTH_LONG).show();
        }
    }
    public void procesarRespuesta(String r) {
        if(r.equals("no_mascotas")){
            Toast.makeText(tinderpet.this,"Aun no hay mascotas para hacer matchs", Toast.LENGTH_LONG).show();
        }else
        {
            if(r.equals("CORA") || r.equals("Like")){
                System.out.println("PETICION!!!");
            }else
            {
                try{
                    JSONArray  arrayjson = new JSONArray(r);
                    imagenesMostrar= new String[arrayjson.length()];
                    for(int i = 0; i < arrayjson.length(); i++){
                        imagenesMostrar[i]=arrayjson.getJSONObject(i).getString("foto_mas");
                        elementos.add(new mascota(Integer.parseInt(arrayjson.getJSONObject(i).getString("idmascota")),arrayjson.getJSONObject(i).getString("nombre"),arrayjson.getJSONObject(i).getString("edad"),arrayjson.getJSONObject(i).getString("sexo"),arrayjson.getJSONObject(i).getString("razamascota_idrazamascota"),arrayjson.getJSONObject(i).getString("tipo_mascota_idtipo_mascota"),arrayjson.getJSONObject(i).getString("foto_mas"),arrayjson.getJSONObject(i).getString("megusta"),arrayjson.getJSONObject(i).getString("nomegusta")));
                    }
                    adater= new tinderAdaptador(this, elementos, new tinderAdaptador.botonClick() {
                        @Override
                        public void onBtnClick(int position) {
                            if(  adater.getCorazon()){
                                int valor=Integer.parseInt(elementos.get(position).getCoraz())  ;
                                adater.ponerConrazon(""+(valor+1));
                                elementos.get(position).setCoraz(""+(valor+1));
                                try {
                                    conexionWeb = new ConexionWeb(tinderpet.this);
                                    conexionWeb.agregarVariables("idmascota",""+ elementos.get(position).getidmascota());
                                    URL direcciopn = new URL("http://caropetworld.xyz/index.php/Sistema/CorazonUp");
                                    conexionWeb.execute(direcciopn);
                                } catch (MalformedURLException e) {
                                    Toast.makeText(tinderpet.this, e.getMessage(), Toast.LENGTH_LONG).show();
                                }
                                adater.notifyDataSetChanged();
                                System.out.println("MATCH"+position);
                            }else
                            {
                                int valor=Integer.parseInt(elementos.get(position).getCoraz())  ;
                                if(valor>0){
                                    elementos.get(position).setCoraz(""+(valor-1));
                                    adater.ponerConrazon(""+(valor-1));
                                    try {
                                        conexionWeb = new ConexionWeb(tinderpet.this);
                                        conexionWeb.agregarVariables("idmascota",""+ elementos.get(position).getidmascota());
                                        URL direcciopn = new URL("http://caropetworld.xyz/index.php/Sistema/CorazonDown");
                                        conexionWeb.execute(direcciopn);
                                    } catch (MalformedURLException e) {
                                        Toast.makeText(tinderpet.this, e.getMessage(), Toast.LENGTH_LONG).show();
                                    }
                                }
                                System.out.println("des MATCH"+position);
                                adater.notifyDataSetChanged();
                            }
                        }
                    }, new tinderAdaptador.botonClick() {
                        @Override
                        public void onBtnClick(int position) {
                            if( adater.getlikee()){

                                try {
                                    int valor=Integer.parseInt(elementos.get(position).getLike())  ;
                                    elementos.get(position).setLike(""+(valor+1));
                                    adater.notifyDataSetChanged();
                                    System.out.println("MATCH"+position);
                                    conexionWeb = new ConexionWeb(tinderpet.this);
                                    conexionWeb.agregarVariables("idmascota",""+ elementos.get(position).getidmascota());
                                    URL direcciopn = new URL("http://caropetworld.xyz/index.php/Sistema/likeUp");
                                    conexionWeb.execute(direcciopn);
                                } catch (MalformedURLException e) {
                                    Toast.makeText(tinderpet.this, e.getMessage(), Toast.LENGTH_LONG).show();
                                }

                            }else
                            {
                                int valor=Integer.parseInt(elementos.get(position).getLike()) ;
                                if(valor>0){
                                    elementos.get(position).setLike(""+(valor-1));
                                    try {
                                        conexionWeb = new ConexionWeb(tinderpet.this);
                                        conexionWeb.agregarVariables("idmascota",""+ elementos.get(position).getidmascota());
                                        URL direcciopn = new URL("http://caropetworld.xyz/index.php/Sistema/likeDown");
                                        conexionWeb.execute(direcciopn);
                                    } catch (MalformedURLException e) {
                                        Toast.makeText(tinderpet.this, e.getMessage(), Toast.LENGTH_LONG).show();
                                    }
                                }
                                adater.notifyDataSetChanged();
                                System.out.println("des MATCH"+position);
                            }
                        }
                    });
                    Menu_lista.setAdapter(adater);
                //    adater.notifyDataSetChanged();
                }catch (JSONException e){

                }
            }

        }
    }
}
