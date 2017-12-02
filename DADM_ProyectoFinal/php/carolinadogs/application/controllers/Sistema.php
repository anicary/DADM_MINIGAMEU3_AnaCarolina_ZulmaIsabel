<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sistema extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('Usuarios');
		$this->load->model('Mascotas');
		$this->load->model('Razas');
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('session', 'form_validation'));
	}
	public function index()
	{
		if ($this->session->userdata('tipo')=='1') {
			redirect(base_url().'index.php/Sistema/menu_sistema');
		}else {
			$this->load->view('inicio');
		}
	}
	public function inicio_sesion()
	{
		$correo_usuario = $this->input->post('correo');
		$contrasena= sha1($this->input->post('contrasena'));
		$datosusuario=$this->Usuarios->loginusuario($correo_usuario,$contrasena);
		if ($datosusuario) {
			$datos = array(
				'is_logued_in' => TRUE,
				'idusuarios' => $datosusuario[0]->idusuarios,
				'nombre' =>$datosusuario[0]->nombre." ".$datosusuario[0]->apellidos,
				'correo' => $datosusuario[0]->correo,
				'tipo' => $datosusuario[0]->tipo,
			);
			$this->session->set_userdata($datos);
			$this->Usuarios->actualizarultima_sesion($datosusuario[0]->idusuarios,"".date('Y-m-d H:i:s'));
			redirect(base_url().'index.php/Sistema/menu_sistema');
		}else {
			$this->load->view('inicio');
		}
	}
	public function inicio_sesion_android()
	{
		$correo_usuario = $this->input->post('correo');
		$contrasena= sha1($this->input->post('contrasena'));
		$datosusuario=$this->Usuarios->loginusuario($correo_usuario,$contrasena);
		if ($datosusuario) {
			if($datosusuario[0]->activo != 0){
				$this->Usuarios->actualizarultima_sesion($datosusuario[0]->idusuarios,"".date('Y-m-d H:i:s'));
				echo json_encode($datosusuario);
			}else {
				echo "usuario-desactivado";
			}
		}else {
			echo "error-inicio";
		}
	}
	public function menu_sistema()
	{
		if ($this->session->userdata('tipo')=='1') {
			$this->load->view('menu');
		}else {
			redirect(base_url().'index.php');
		}
	}
	public function registro_usuario()
	{
		if($this->input->post('nombre')!=""){
			$datos= array(
				'nombre' => $this->input->post('nombre'),
				'apellidos' => $this->input->post('apellidos'),
				'correo' => $this->input->post('correo'),
				'contrasena' => sha1($this->input->post('contrasena')),
				'sexo' =>"F",
				'tipo' => 2,
				'activo' => 1,
				'fecha_creacion' => date('Y-m-d H:i:s'),
				'estado' => $this->input->post('estado'),
				'municipio' =>$this->input->post('municipio'),
				'perfil_foto' =>"http://carolina.x10host.com/archivos/fotos/perfil.jpg"
			);
			$correo=$this->input->post('correo');
			if($this->Usuarios->verificarCorreo($correo)==false){
				$contrasena=sha1($this->input->post('contrasena'));
				$this->Usuarios->insertarUsuario($datos);
				$datos=$this->Usuarios->loginusuario($correo,$contrasena);
				if ($datos) {
					$this->Usuarios->actualizarultima_sesion($datos[0]->idusuarios,"".date('Y-m-d H:i:s'));
					echo json_encode($datos);
				}
			}else {
				echo "duplicado";
			}
		}
	}
	public function editar_usuario()
	{
		if($this->input->post('nombre')!=""){
			$id = $this->input->post("idusuarios");
			$datos= array(
				'nombre' => $this->input->post('nombre'),
				'apellidos' => $this->input->post('apellidos'),
				'correo' => $this->input->post('correo')
			);
			$this->Usuarios->editarUsuario($datos,$id);
		}


	}
	public function borrarUsuario($id)
	{
		$this->Usuarios->borrarUSUARIO($id);
		redirect(base_url().'index.php/Sistema/usuarios');
	}
	public function usuarios()
	{
		if ($this->session->userdata('tipo')=='1') {
			$datos["USUARIOS"]=$this->Usuarios->cargarUsuarios();
			$this->load->view('usuarios',$datos);
		}else {
			redirect(base_url().'index.php');
		}
	}
	public function salir() {
		if ($this->session->userdata('tipo')=='1') {
			$this->session->sess_destroy();
			redirect(base_url().'index.php/');
		}else {
			redirect(base_url().'index.php');
		}
	}
	public function cambiar_foto()
	{
		if($this->input->post('idusuarios')!=""){
			$id = $this->input->post("idusuarios");
			$decoded=base64_decode($this->input->post('foto'));
			file_put_contents($this->input->post('idusuarios')."fotoperfil.jpg",$decoded);
			$urlenvarserver=base_url()."".$this->input->post('idusuarios')."fotoperfil.jpg";
			$datos= array(
				'perfil_foto' => $urlenvarserver
			);
			$this->Usuarios->editarUsuario($datos,$id);
			echo "actualizado";
		}
	}
	public function obtenerdatosusuario()
	{
		$datos=	$this->Usuarios->datosdelusuario($id = $this->input->post("idusuarios"));
		echo json_encode($datos);
	}
	public function registro_mascota()
	{
		if($this->input->post('nombre')!=""){
			$tempId = $this->Mascotas->obtenerUltmas();
			$nom;
			if($tempId[0]->maximo){
				$nom=$tempId[0]->maximo;
			}else {
				$nom=1;
			}
			//$archivo="archivos/fotos/mascotas/";
			//$archivo="";
			$decoded=base64_decode($this->input->post('foto_mas'));
			file_put_contents($archivo."".$this->input->post('idusuarios')."mascota".$nom.".jpg",$decoded);
			$urlenvarserver=base_url()."".$this->input->post('idusuarios')."mascota".$nom.".jpg";
			$datos= array(
				'nombre' => $this->input->post('nombre'),
				'sexo' => $this->input->post('sexo'),
				'edad' => $this->input->post('edad'),
				'foto_mas' => $urlenvarserver,
				'tipo_mascota_idtipo_mascota' => $this->input->post('tipo_mascota_idtipo_mascota'),
				'razamascota_idrazamascota' => $this->input->post('razamascota_idrazamascota')
			);
			$this->Mascotas->insertarMascotas($datos);
			$tempId = $this->Mascotas->obtenerUltmas();
			$datos2= array(
				'usuarios_idusuarios' => $this->input->post('idusuarios'),
				'mascota_idmascota' =>$tempId[0]->maximo,
				'fecha_agregado' =>date('Y-m-d H:i:s')
			);
			$this->Mascotas->insertarMascotasRelacion($datos2);
		}
	}
	public function cargarMascotas()
	{
		if($this->input->post('idusuarios')!=""){
			$datos=$this->Mascotas->obtenerMascoasUsuario($this->input->post('idusuarios'));
			if($datos){
				echo json_encode($datos);
			}else {
				echo "no-mascotas";
			}
		}
	}
	public function eliminar_mascota()
	{
		if ($this->input->post('idmascota')!="") {
			$this->Mascotas->borrarmascota($this->input->post('idmascota'),$this->input->post('idusuarios'));
			echo "eliminado";
		}
	}
	public function razas_datos()
	{
		if ($this->session->userdata('tipo')=='1') {
			$datos["RAZAS"]=$this->Razas->getRazas();
			$this->load->view('razas_datos',$datos);
		}else {
			$this->load->view('inicio');
		}
	}
	public function editar_raza( )
	{
		# code...
	}
}
