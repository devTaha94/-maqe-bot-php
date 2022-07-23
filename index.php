<?php

require_once './Services/Maqe.php';
require_once './Services/WalkingCommand.php';

$maqe = new Maqe(new WalkingCommand($_SERVER['argv']));
$maqe->run();
