<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/tec-cad.css')?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<title>Cadastro Responsáveis Técnicos - SISNOC</title>
</head>
<body>	
	<div class="container-fluid">
		<div class="row">
			<div class="contorno col-xs-10 ">
				<h3>Dados do Responsável</h3>
				<form action="" method="POST" class="edit-resp">
				<div class="control-input col-xs-10">
					
						<div class="form-group col-md-2 col-xs-12">
							<label for="nome" class="col-xs-2 control-label">Nome:</label>
							<input type="text" value="<?php if(!empty($Dados[0]['resp_nome'])): echo $Dados[0]['resp_nome']; else:  endif;?>" name="" id="nome" class="form-control input-sm j_edit-resp-tec">
							
						</div>

						<div class="form-group col-md-2 col-xs-6">
							<label for="corp" class="col-md-2 control-label">Corporativo:</label>
							<input type="tel" value="<?php if(!empty($Dados[0]['resp_corp'])): echo $Dados[0]['resp_corp']; else:  endif;?>" name="" id="corp" class="form-control input-sm j_edit-resp-tec">
						</div>

						<div class="form-group col-md-2 col-xs-6">
							<label for="mail" class="col-md-2 control-label">E-mail:</label>
							<input type="email" value="<?php if(!empty($Dados[0]['resp_email'])): echo $Dados[0]['resp_email']; else:  endif;?>"" name="" id="mail" class="form-control input-sm j_edit-resp-tec">
						</div>

						<?php 
							if(!empty($Dados)):								
								echo "<input type='hidden' value=\"{$Dados[0]['resp_cod']}\" class='cod' id='cod'>";
							else:
								echo "<input type='hidden' value='new' name='new' class='novo'>";
							endif;
						?>
									
				</div>
				<div class="btn-area-resp col-xs-5">
					<button class="btn btn-danger"><i class="fa fa-floppy-o" aria-hidden="true"> Salvar</i></button>
				</div>
				</form>	
			</div>
			<div id="mdlinfo11" class="modal fade" role="dialog">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header custom-modal">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h3 class="modal-title">SISNOC Informa:</h3>
								</div>
								<div class="modal-body">
									<p>Dados atualizados com sucesso!!!</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default j_btn-tec-conf" data-dismiss="modal">OK</button>
								</div>
							</div>
						</div>
				</div>
				<div id="mdlinfo12" class="modal fade" role="dialog">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header custom-modal">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h3 class="modal-title">SISNOC Informa:</h3>
								</div>
								<div class="modal-body">
									<p>Houve uma falha na gravação dos dados ou não houve atualização nos dados.</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default j_btn-tec-conf" data-dismiss="modal">OK</button>
								</div>
							</div>
						</div>
				</div>
			
		</div>
	</div>	
	<script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
</body>
</html>