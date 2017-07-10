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
            $this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ip']);
            if ($this->ssh->Status == "Desconectado"):
                echo "1";
            elseif ($this->ssh->Auth == FALSE):
                echo "2";
            else:
                echo "3";
            endif;
        else:
            echo "IP de Lan não encontrado";
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
            $BGP = $this->ssh->exeCommand("sh ip bgp sum");

            $a = 0;
            $STR = NULL;
            foreach ($BGP as $P):
                $BGP[$a] = "<p>{$P}</p>";
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
                $INT[$a] = array_values(array_filter(explode(" ", $P)));
                $a++;
            endforeach;

            array_shift($INT);
            unset($INT[0]);
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
            foreach ($INT as $info):
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
                $NEI[$a] = "<p>{$P}</p>";
                $STR .= $NEI[$a];
            endforeach;

            echo $STR;
        else:
            echo "Os dados enviados são inválidos.";
        endif;
    }

    public function getintDetail() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRouter'])):
            @$this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ipRouter']);
            $INT = $this->ssh->exeCommand("sh int {$IN['interface']}");
            $INT = array_map('trim', $INT);
            $a = 0;
            $STR = NULL;
            foreach ($INT as $DT):
                $INT[$a] = "<p>{$DT}</p>";
                $STR .= $INT[$a];
                $a++;
            endforeach;

            echo $STR;
        else:
            echo "Os dados enviados são inválidos.";    
        endif;
    }

    public function getTopTalkers() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and ! empty($IN['ipRouter'])):
            @$this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ipRouter']);
            $Talk = $this->ssh->exeCommand("sh ip flow top-talkers");
            array_shift($Talk);
            $a = 0;
            $STR = NULL;
            foreach ($Talk as $Top):
                $Talk[$a] = "<p class='rs'>{$Top}</p>";
                $STR .= $Talk[$a];
                $a++;
            endforeach;
            echo $STR;
        else:
            echo "Os dados enviados são inválidos.";    
        endif;
    }

    public function getCommand() {
        $IN = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($IN) and !empty($IN['ipRouter']) and !empty($IN['command'])):
            @$this->ssh->Connection('henrique.souza', 'Isa32:18', 22, $IN['ipRouter']);
            $CMD = $this->ssh->exeCommand($IN['command']);           
            $a = 0;
            $STR = NULL;
            foreach ($CMD as $T):
                $CMD[$a] = "<p class='rs'>{$T}</p>";
                $STR .= $CMD[$a];
                $a++;
            endforeach;

            echo $STR;
        else:
            echo "Os dados enviados são inválidos.";
        endif;
    }

}
