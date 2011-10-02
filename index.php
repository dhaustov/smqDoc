
<?php
require_once 'Config.php';

$conf = Config::singleton();
echo $conf->DbName();
echo $conf->DbPassword();
$conf2 = Config::singleton();
echo $conf2->DbHostName();
echo $_GET["par"];

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
