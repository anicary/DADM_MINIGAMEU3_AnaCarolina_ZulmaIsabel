package mx.edu.ittepic.dadm_u4_anacarolinamondragonrangel_pbd;

import android.content.Intent;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class AgregarCliente extends AppCompatActivity {
    BD db;
    EditText nombre, dom, col;
    String name, domicilio, colonia;
    Button agregar;
    Intent intent;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_agregar_cliente);
        setTitle("Agregar nuevo cliente");
        db = new BD(AgregarCliente.this, "reparacionCelular", null, 1);
        nombre = (EditText) findViewById(R.id.nombre);
        dom = (EditText) findViewById(R.id.domicilio);
        col = (EditText) findViewById(R.id.colonia);
        agregar = (Button) findViewById(R.id.agregar);
        agregar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                name = nombre.getText().toString();
                domicilio = dom.getText().toString();
                colonia = col.getText().toString();
                try {
                    SQLiteDatabase base = db.getWritableDatabase();
                    String query1 = "INSERT INTO cliente VALUES (null,'NOMBRE','DOMICILIO','COLONIA')";
                    query1 = query1.replace("NOMBRE", name);
                    query1 = query1.replace("DOMICILIO",domicilio);
                    query1 = query1.replace("COLONIA", colonia);
                    base.execSQL(query1);
                    intent = new Intent(AgregarCliente.this, ListaClientes.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    startActivity(intent);
                    finish();
                }catch (SQLException e){
                    Toast.makeText(AgregarCliente.this, e.getMessage(), Toast.LENGTH_LONG).show();
                }
            }
        });
    }

}