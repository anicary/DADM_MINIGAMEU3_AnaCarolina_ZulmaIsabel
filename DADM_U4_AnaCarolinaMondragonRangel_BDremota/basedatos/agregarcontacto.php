<?php
/* DATOS DEL SERVIDOR */
$contrasna="Carolina21";
$ususario="u146418920_caro";
$host="mysql.hostinger.mx";
$base="u146418920_andro";

/* CONECTANDO AL SERVIDOR */
$conexion=mysqli_connect($host,$usuario,$contrasna);
if(!$conexion){
	echo "La conexion fallo";
	return;
}tBD=mysqli_select_db($conexion,$base);
if(!$selectBD){
	echo "Base de datos no encontrada";
	return;
}
/*OBTENER DATOS DEL ANDROD POST*/
$nombre=$_POST["nombre"];
$domicilio=$_POST["domicilio"];
$telefono=$_POST["telefono"];
$correo=$_POST["correo"];
/* INSERTAR EN LA BASE*/
$resultadoInsertar=mysqli_query($conexion,"INSERT INTO Persona values(0,'$nombre','$domicilio','$telefono','$correo')");
if($resultadoInsertar){
	 /*SI SE INSERTO*/
}else{
	 /*NO SE INSERTO*/
	echo "ERROR";
}
?>
