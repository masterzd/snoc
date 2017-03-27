<?php

require('../../application/models/Shorthand.php');

$Request = new Shorthand;
$Exe = $Request->getUsers($_POST);


var_dump($Exe);