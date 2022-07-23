<?php

require_once './Services/Maqe.php';
require_once './Services/WalkingCommand.php';

(new Maqe(new WalkingCommand($_SERVER['argv'])))->run();
