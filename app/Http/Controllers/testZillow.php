<?php 
$output = shell_exec('casperjs --ignore-ssl-errors=true --ssl-protocol=any zillowScrape.js');

echo $output;
/*
$xml=simplexml_load_string($output) or die("Error: Cannot create object");
print '<pre>';
var_dump($xml->message);
print '</pre>';*/

?>