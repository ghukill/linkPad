<?php
// add link to Solr
$linkURL = $_GET['linkURL'];

//get URL title from <head> meta
preg_match('/<title>(.+)<\/title>/',file_get_contents($linkURL),$matches);
$linkTitle = $matches[1];
if (strlen($linkTitle) === 0) {
	$linkTitle = "[Unknown Title]";
}

$cs = "curl -v 'http://localhost:8983/solr/linkPad/update/?commit=true' -H 'Content-type:text/xml' --data-binary '<add><doc><field name=\"last_modified\">NOW</field><field name=\"linkURL\">$linkURL</field><field name=\"linkTitle\">$linkTitle</field></doc></add>'";
$last_line = exec($cs);


?>
