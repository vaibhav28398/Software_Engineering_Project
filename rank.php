<?php
$domain=$_GET['domain'];
$link='https://www.alexa.com/siteinfo/'.$domain;
$html = file_get_contents($link);
$dom = new DOMDocument;
@$dom->loadHTML($html);
$finder = new DomXPath($dom);
$classname = 'metrics-data';
$nodes = $finder->query("//*[contains(@class, '$classname')]");
echo "<tr>";
echo "<td>".$domain."</td>";
echo "<td>".$nodes[0]->nodeValue."</td>";
echo "</tr>";

?>