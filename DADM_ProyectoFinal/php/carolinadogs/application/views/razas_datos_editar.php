<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>PET WORLD MENU</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/tec.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<meta name="description" content="Sistema para el seguimiento en el aula del instituto tecnologico de tepic.">
	<meta name="author" content="Fernando Manuel Avila Cataño">
	<meta name="theme-color" content="#FFFFFF">
	<meta name="msapplication-navbutton-color" content="#FFFFFF">
	<meta name="apple-mobile-web-app-status-bar-style" content="white">
	<link href="<?php echo base_url(); ?>css/bootstrap.min.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>css/font-awesome.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>css/animate.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>css/fontello.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>css/perritoslogin.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>css/dataTables.bootstrap4.min.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>css/responsive.bootstrap4.min.css" type="text/css" rel="stylesheet" />
</head>
<body>
	<div class="">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-7">
								<h4 class="card-title">EDITAR RAZA  <b> <?php echo $RAZAS[0]->nombre_raza; ?> </b> </h4>
							</div>
							<div class="col-md-5">
								<a class="btn btn-danger"  href="<?php echo base_url(); ?>index.php/Sistema/salir"><i class="fa fa-sign-out" aria-hidden="true"></i> <?php echo "".$this->session->userdata('nombre'); ?>  CERRAR SESION</a>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<form class="" action="<?php echo base_url(); ?>index.php/Sistema/actualizar_raza/<?php echo $RAZAS[0]->idrazamascota; ?>" method="post">
											<div class="form-group">
												<label for="exampleFormControlTextarea1">Caracter:</label>
												<textarea class="form-control" id="caracter" name="caracter" rows="3">
													<?php echo $RAZAS[0]->caracter; ?>
												</textarea>
											</div>
											<div class="form-group">
												<label for="exampleFormControlTextarea1">Salud:</label>
												<textarea class="form-control" id="salud" name="salud" rows="3">
													<?php echo $RAZAS[0]->salud; ?>
												</textarea>
											</div>
											<div class="form-group">
												<label for="exampleFormControlTextarea1">Caracteristicas:</label>
												<textarea class="form-control" id="caracteristicas" name="caracteristicas" rows="3">
													<?php echo $RAZAS[0]->caracteristicas; ?>
												</textarea>
											</div>
											<div class="form-group">
												<label for="exampleFormControlTextarea1">Utilidad:</label>
												<textarea class="form-control" id="utilidad" name="utilidad" rows="3">
													<?php echo $RAZAS[0]->utilidad; ?>
												</textarea>
											</div>
											<div class="form-group">
												<label for="exampleFormControlFile1">Foto:</label>
												<input type="file" class="form-control-file" name="foto" id="foto">
											</div>
											<button type="submit"  class="btn btn-success" name="button">GUARDAR</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tether.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#tablausuarios').DataTable({
		"language": {
			"url": "<?php echo base_url(); ?>js/datatables/usuarios.json"
		},
		"order": [[ 0, "desc" ]]
	});
} );
</script>
</html>
