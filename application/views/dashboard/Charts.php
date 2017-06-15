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
								<option value="1">Falhas Operadora</option>
								<option value="2">Falhas Internas</option>
								<option value="3">Responsável por falhas</option>
								<option value="4">Incidentes por Lojas</option>
							</select>
						</div>
						<div class="input-daterange input-group" id="datepicker">
                            <input type="text" placeholder="Informe a data inicial" title="O Formato informad" required pattern="^[0-9]{4}-[0-9]{2}-[0-9]{2}$" class="j-date j-dtIni input-sm form-control col-md-2" name="dataIni">
                            <span class="input-group-addon">a</span>
                            <input type="text" placeholder="Informe a data final" required pattern="^[0-9]{4}-[0-9]{2}-[0-9]{2}$" class="j-date j-dtFim input-sm form-control col-md-2" name="dataFim">
                        </div>
						<div class="form-group">
	                       <button type="button" class="btn btn-danger btn-gerar">Gerar</button>
	                    </div>

					</main>
				</div>				
			</div>
			<div class="row">
				<div class="col-md-12">
					<div id="chart"></div>
				</div>
			</div>
	</div>

	<script src="<?php echo base_url('/assets/js/jquery-2.2.4.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/jquery.mobile.custom.min.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>   
 	<script src="<?php echo base_url('/assets/js/bootstrap-datepicker.min.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/bootstrap-datepicker.pt-BR.min.js') ?>" charset="UTF-8"></script>
    <script src="<?php echo base_url('/assets/js/charts.js') ?>"></script>
    <script>
		    $('.j-date').datepicker({
		        format: 'yyyy-mm-dd',
		        language: 'pt-BR',
		        orientation: 'bottom auto',
		        autoclose: true
		     });
    </script>
</body>
</html>