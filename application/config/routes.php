<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/* Rotas Principais */
$route['default_controller'] = 'Start';
$route['validacao'] = 'Start/validacao';

/* Rotas relacionadas ao Menu Principal */
$route['menuprincipal'] = 'Start/menu';
$route['cad-link'] = 'Start/cadlink';
$route['tec-cad'] = 'Start/tecCad';
$route['manager'] = 'Start/manager';
$route['checklink'] = 'Start/checklink';


/* Rotas relacionadas ao Chamados */
$route['chamado'] = 'Chamado/chamado';
$route['busca'] = 'Search/search';
$route['save'] = 'Save/SaveCh';
$route['logoff'] = 'Start/sair';
$route['update'] = 'UpdateCh/update';
$route['verchamado'] = 'Ocorrencia/ConsultaCh';

/* Rotas relacionadas aos Relatórios */
$route['relatorios'] = 'Start/relatorios';
$route['rel/Geral'] = 'Relatorios/Geral';
$route['rel/Sms'] = 'Relatorios/relSms';
$route['rel/Loja'] = 'Relatorios/relLoja';
$route['rel/DispInter'] = 'Relatorios/relDispInter';

/* Rotas relacionadas a tela de ocorrências diárias */
$route['ocorrencias-diarias'] = 'Start/chToday';

/* Rotas relacionadas a Tela de busca de informações */
$route['consulta-loja'] = 'Start/consultaFilial';

/* Rotas relacionadas ao Dashboard */
$route['dashboard'] = 'DashBoard/Inicio';
$route['home'] = 'DashBoard/Home';
$route['operadora'] = 'DashBoard/operadora';
$route['getUpdate'] = 'DashBoard/poolingOperadora';
$route['per'] = 'DashBoard/periodoTopLojas';
$route['getChChart'] = 'DashBoard/getOcorrenciasChart';
$route['geraModal'] = 'DashBoard/geraModal';
$route['listenFilas'] = 'DashBoard/poolingOperadoraFilas';
$route['tecSemep'] = 'DashBoard/tecSemep';
$route['homepooling'] = 'DashBoard/PoolingHome';
$route['energia'] = 'DashBoard/energia';
$route['charts'] = 'DashBoard/Geracharts';
$route['anaFalhaLoja'] = 'DashBoard/falhasLojas';

/* Consulta Lojas via URL */
$route['buscaUrlLojas'] = 'Search/GetInfoLojasUrl';



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
