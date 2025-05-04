<?php
// composer require erusev/parsedown

require 'Parsedown.php';
$Parsedown = new Parsedown();
echo $Parsedown->text(file_get_contents('ws_everest.md'));
?>
