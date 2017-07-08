<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TesteCisco extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('SSH');
    }

    public function Conecta() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ip'])):
            @$this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ip']);
            if ($this->ssh->Status == "Desconectado"):
                echo "1";
            elseif ($this->ssh->Auth == FALSE):
                echo "2";
            else:
                echo "3";
            endif;
        endif;
    }

    public function getPing() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRoute'])):
            if (filter_var($IN['ipDest'], FILTER_VALIDATE_IP) == true and filter_var($IN['ipRoute'], FILTER_VALIDATE_IP) == true):
                @$this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ipRoute']);
                $Ping = $this->ssh->exeCommand("ping {$IN['ipDest']}");
                array_shift($Ping);
                $a = 0;
                $STR = NULL;
                foreach ($Ping as $P):
                    $Ping[$a] = "<p>{$P}</p>";
                    $STR .= $Ping[$a];
                endforeach;

                echo $STR;
            else:
                echo "Isso não parece ser um ip válido!";
            endif;
        else:
            echo "Isso não parece ser um ip válido!";
        endif;
    }

    public function getArp() {

        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRouter'])):
            @$this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ipRouter']);
            $ARP = $this->ssh->exeCommand("sh arp");

            array_shift($ARP);
            $a = 0;
            $STR = NULL;
            foreach ($ARP as $P):
                $ARP[$a] = "<p class='rs'>{$P}</p>";
                $STR .= $ARP[$a];
            endforeach;

            echo $STR;
        endif;
    }

    public function getBgp() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRouter'])):
            @$this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ipRouter']);
            $BGP = $this->ssh->exeCommand("sh bgp summary");
            $a = 0;
            $STR = NULL;
            foreach ($BGP as $P):
                $BGP[$a] = "<p class='rs'>{$P}</p>";
                $STR .= $BGP[$a];
            endforeach;

            echo $STR;
        endif;
    }

    public function getInterfaces() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRouter'])):
            @$this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ipRouter']);
            $INT = $this->ssh->exeCommand("sh ip int brief");
            $a = 0;
            $STR = NULL;
            foreach ($INT as $P):
                $INT[$a] = "<p class='rs'>{$P}</p>";
                $STR .= $INT[$a];
            endforeach;

            echo $STR;
            
            die();
            $Interfaces = "
                <div class=\"table-responsive\">
                    <table class=\"table table-striped\">
                        <thead class=\"table-custom\">
                            <tr class=\"tb-color\">
                                <th>Interface</th>
                                <th>Endereço IP</th>
                                <th>Status (Fisico)</th>
                                <th>Status (Lógico)</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach ($IntBrief as $info):
                $Interfaces .= "<tr>";
                $Interfaces .= "<td><a class='j-interface' id='{$info[0]}'>{$info[0]}</a></td>";
                $Interfaces .= "<td>{$info[1]}</td>";
                $Interfaces .= "<td>{$info[4]}</td>";
                $Interfaces .= "<td>{$info[5]}</td>";
                $Interfaces .= "</tr>";
            endforeach;
            $Interfaces .= "</tbody>
                    </table>
                </div>";

            echo $Interfaces;
        endif;
    }

    public function getNeighbors() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRouter'])):
           @$this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ipRouter']);
            $NEI = $this->ssh->exeCommand("sh cdp nei");
            $a = 0;
            $STR = NULL;
            foreach ($NEI as $P):
                $NEI[$a] = "<p class='rs'>{$P}</p>";
                $STR .= $NEI[$a];
            endforeach;

            echo $STR;
            
            die();

            if ($Nei != false):
                $Neighbors = "
                <div class=\"table-responsive\">
                    <table class=\"table table-striped\">
                        <thead class=\"table-custom\">
                            <tr class=\"tb-color\">
                                <th>ID do Dispositivo</th>
                                <th>Interface Local</th>
                                <th>Modelo</th>
                                <th>ID da Porta</th>
                            </tr>
                        </thead>
                        <tbody>";
                foreach ($Nei as $info):
                    $Neighbors .= "<tr>";
                    $Neighbors .= "<td>{$info[0]}</td>";
                    $Neighbors .= "<td>{$info[1]}</td>";
                    $Neighbors .= "<td>{$info[6]}</td>";
                    $Neighbors .= "<td>{$info[7]}</td>";
                    $Neighbors .= "</tr>";
                endforeach;
                $Neighbors .= "</tbody>
                    </table>
                </div>";
            else:
                $Neighbors = "Não foram encontrados outros equipamentos cisco na rede.";
            endif;
            echo $Neighbors;
        endif;
    }

    public function getintDetail() {

        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRouter'])):
            $Router = new cisco_ssh("{$IN['ipRouter']}", 'henrique.souza', 'Isa32:18');
            $Router->connect();
            $Detalhes = $Router->show_int($IN['interface']);

            $IntDetails = "
                <div class=\"table-responsive\">
                    <table class=\"table table-striped\">
                        <thead class=\"table-custom\">
                            <tr class=\"tb-color\">
                                <th>Interface</th>
                                <th>Status</th>
                                <th>Descrição</th>
                                <th>MTU</th>
                                <th>Banda</th>
                                <th>CRC</th>
                                <th>Erro Input</th>
                                <th>Erro Out</th>
                                <th>Colisões</th>
                                <th>Reset</th>
                            </tr>
                        </thead>
                        <tbody>";
            $IntDetails .= "<tr>";
            @$IntDetails .= "<td>{$Detalhes['interface']}</td>";
            @$IntDetails .= "<td>{$Detalhes['status']}</td>";
            @$IntDetails .= "<td>{$Detalhes['description']}</td>";
            @$IntDetails .= "<td>{$Detalhes['mtu']}</td>";
            @$IntDetails .= "<td>{$Detalhes['bandwidth']}</td>";
            @$IntDetails .= "<td>{$Detalhes['crc']}</td>";
            @$IntDetails .= "<td>{$Detalhes['in_error']}</td>";
            @$IntDetails .= "<td>{$Detalhes['out_error']}</td>";
            @$IntDetails .= "<td>{$Detalhes['collision']}</td>";
            @$IntDetails .= "<td>{$Detalhes['reset']}</td>";
            $IntDetails .= "</tr>";
            $IntDetails .= "</tbody>
                    </table>
                </div>";
            echo $IntDetails;
        endif;
    }

    public function getTopTalkers() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRouter'])):
            $Router = new cisco_ssh("{$IN['ipRouter']}", 'henrique.souza', 'Isa32:18');
            $Router->connect();
            $TopTalkers = $Router->topTalkers();

            $Top = "
                <div class=\"table-responsive\">
                    <table class=\"table table-striped\">
                        <thead class=\"table-custom\">
                            <tr class=\"tb-color\">
                                <th>Interface de Origem</th>
                                <th>IP de Origem</th>
                                <th>Interface de destino</th>
                                <th>IP de destino</th>
                                <th>Bytes</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach ($TopTalkers as $info):
                $Top .= "<tr>";
                $Top .= "<td>{$info[0]}</td>";
                $Top .= "<td>{$info[1]}</td>";
                $Top .= "<td>{$info[2]}</td>";
                $Top .= "<td>{$info[3]}</td>";
                $Top .= "<td>{$info[7]}</td>";
                $Top .= "</tr>";
            endforeach;
            $Top .= "</tbody>
                    </table>
                </div>";

            echo $Top;
        endif;
    }

    public function getCommand() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRouter'])):
            $Router = new cisco_ssh("{$IN['ipRouter']}", 'henrique.souza', 'Isa32:18');
            $Router->connect();
            echo $Router->exec($IN['command']);
        endif;
    }

}
