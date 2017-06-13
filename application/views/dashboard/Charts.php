<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-css/dashboard/Charts.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css') ?>">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>DashBoard - Estatíticas</title>
</head>
<body>
	<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<header>
						<h1>DashBoard - Estátisticas</h1>	
					</header>
					<main>
						<div class="form-group option-chart">
							<label for="">Escolha um tipo de estatística:</label>
							<select class="form-control sl-tpchart j-tpchart">
								<option value="">Selecione...</option>
								<option value="1">Analitico Falhas x Lojas</option>
								<option value="2">Falhas Operadora</option>
								<option value="3">Falhas Internas</option>
								<option value="4">Falhas por Tipo</option>
								<option value="5">Eventos por Loja</option>
							</select>
						</div>
					</main>
				</div>				
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="relChart">
						
						<div class="chart">
							
						</div>
						
					</div>
				</div>
			</div>
	</div>

	<script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>   
 	<script src="<?php echo base_url('/assets/js/bootstrap-datepicker.min.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/bootstrap-datepicker.pt-BR.min.js') ?>" charset="UTF-8"></script>
    <script src="<?php echo base_url('/assets/js/charts.js') ?>"></script>
</body>
</html>