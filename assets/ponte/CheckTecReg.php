<?php
require('../../application/third_party/Func.php');
$Band = ChecaBandeira($_POST['loja']);
$RespTec = CheckRespTec($_POST['uf'], $Band);
$Dados = [
	'Band' => $Band,
	'RespTec' => $RespTec
];


echo json_encode($Dados);

