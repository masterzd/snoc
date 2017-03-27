<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sendsms extends CI_Controller {
    /* Atributo que armazena os recursos do codeigniter */

    private $CI;
    /* Atributo responsável por armazenar um vetor com os telefones */
    private $Contatos;
    /* Atributo responsável por armazenar osn dados do chamado */
    private $InfoCh;
    /* Atributo responsável por armazenar um vetor com os dados da loja */
    private $InfoLoja;
    /* Atributo responsável por armazenar os resultados do envio do SMS */
    public $Resultado;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('Crud');
    }

    public function setContato($Contatos) {
        $Contatos = array_filter($Contatos);
        if ($Contatos == null):
            $this->Resultado['mensagem'] = 'Não é possível enviar sms. A loja não possue numeros de Telefones associados a ela.';
            return false;
        else:
            $this->Contatos = $Contatos;
        endif;
    }

    public function setInfoCh($InfoCh) {
        if (is_array($InfoCh)):
            $this->InfoCh = $InfoCh;
        else:
            $this->Resultado['mensagem'] = 'Falha ao carregar os dados da chamado.';
            return false;
        endif;
    }

    public function setInfoLoja($infoLoja) {
        if (is_array($infoLoja)):
            $this->InfoLoja = $infoLoja;
        else:
            $this->Resultado['mensagem'] = 'Falha ao carregar os dados da loja.';
            return false;
        endif;
    }

    public function sms(array $Contatos, array $InfoCh, array $infoLoja, $Etapa) {
        $this->setContato($Contatos);
        $this->setInfoCh($InfoCh);
        $this->setInfoLoja($infoLoja);

        $Permission = $this->configSMS();
        if ($Permission == true):
            $Msg = $this->contentSMS($Etapa);
            if ($Msg == null):
                $Mensagem = array('result' => false, 'mensagem' => 'Não é possível enviar mensagem. Falha ao obter o conteúdo da mensagem.');
                return $Mensagem;
            endif;
            $Exe = $this->send($Msg);
            return $Exe;
        else:
            return true;
        endif;
    }

    /* Método para checar se o envio de sms está permitido */

    private function configSMS() {
        $this->CI->Crud->calldb('tb_conf', 'SELECT', 0);
        if ($this->CI->Crud->Results['Dados'][0]['c_sms'] == 'S'):
            return true;
        else:
            return false;
        endif;
    }

    /* Método pra verificar a mensagem que vai ser usada */

    private function contentSMS($tpMessage) {
        if ($tpMessage == 1):
            $Mensagem = "NOC Informa:(Loja:{$this->InfoLoja['Loja']['lj_num']} , Regional:{$this->InfoLoja['Loja']['r_cod']})Detectamos um problema em sua filial. Estamos Atuando para resolver.";
        elseif ($tpMessage == 2):
            $Mensagem = "NOC Informa: (Loja:{$this->InfoLoja['Loja']['lj_num']} , Regional:{$this->InfoLoja['Loja']['r_cod']})O Problema detectado no link {$this->InfoLoja['Link']['cir_link']} foi Resolvido. Chamado SISNOC:{$this->InfoCh['o_cod']}";
        elseif ($tpMessage == 3):
            $Mensagem = "NOC Informa:(Loja:{$this->InfoLoja['Loja']['lj_num']} , Regional:{$this->InfoLoja['Loja']['r_cod']})O problema e causado pela operadora {$this->InfoLoja['Link']['cir_oper']} no link {$this->InfoLoja['Link']['cir_link']}. Abriremos um chamado. Chamado SISNOC:{$this->InfoCh['o_cod']}";
        elseif ($tpMessage == 4):
            $Mensagem = "NOC Informa:(Loja:{$this->InfoLoja['Loja']['lj_num']} , Regional:{$this->InfoLoja['Loja']['r_cod']})O problema é uma falha interna da loja. Um tecnico entrará em contato. Chamado SISNOC:{$this->InfoCh['o_cod']}";
        elseif ($tpMessage == 5):
            $Mensagem = "NOC Informa:(Loja:{$this->InfoLoja['Loja']['lj_num']}, Regional:{$this->InfoLoja['Loja']['r_cod']}) Chamado aberto com a operadora. Protocolo: {$this->InfoCh['o_prot_op']}. Previsao de Normalizacao:{$this->InfoCh['o_prazo']}. Chamado SISNOC:{$this->InfoCh['o_cod']}";
        elseif ($tpMessage == 6):
            $Mensagem = "NOC Informa:(Loja:{$this->InfoLoja['Loja']['lj_num']}, Regional:{$this->InfoLoja['Loja']['r_cod']}) O link da filial nao está funcionando por falta de energia. Aguardando normalizacao. Chamado SISNOC: {$this->InfoCh['o_cod']}";
        elseif ($tpMessage == 7):
            $Mensagem = "NOC Informa:(Loja:{$this->InfoLoja['Loja']['lj_num']}, Regional:{$this->InfoLoja['Loja']['r_cod']})O problema e uma falha interna da loja. Aberto Chamado SEMEP. Chamado SISNOC: {$this->InfoCh['o_cod']}";
        endif;
        return $Mensagem;
    }

    /* Gravar log de envio de sms */

    private function logSMS($DadosSMS) {
        $this->CI->Crud->calldb('tb_sms', 'INSERT', $DadosSMS);
    }

    /* Enviar SMS */

    private function send($Mensagem) {

        $Mensagem = str_replace(' ', '%20', $Mensagem);
        foreach ($this->Contatos as $Num):

            $cURL = curl_init("https://www.mpgateway.com/v_3_00/sms/smspush/enviasms.aspx?Credencial=860F7D1569FD5C445706A84D0358F5612E3EF235&Token=3F902a&Principal_User=SISNOCRE&Aux_User=SISNOCRE&Mobile=55$Num&Send_Project=N&Message=$Mensagem");
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, 0);
            $resultado = curl_exec($cURL);
            $resposta = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
            $Arr = [
                'sms_sit_env' => $resultado,
                'sms_num' => $Num,
                'sms_date' => date('Y-m-d H:i:s'),
                'sms_loja' => $this->InfoLoja['Loja']['lj_num'],
                'sms_ch' => $this->InfoCh['o_cod']
            ];

            $this->logSMS($Arr);

            if ($resultado != '000'):
                $this->Resultado ['status'][] = FALSE;
            else:
                $this->Resultado ['status'][] = TRUE;
            endif;

        endforeach;

        if (in_array(FALSE, $this->Resultado['status'])):
            return array('result' => false, 'mensagem' => 'Não foi possível enviar o SMS para um ou mais destinatários.');
        else:
            return true;
        endif;
    }

}
