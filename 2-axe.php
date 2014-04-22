<?php

require_once '../simple_html_dom.php';

$result = array();

for($i = 1; $i < 12+1; $i++) {
	$html = file_get_html('http://axe-level-1.herokuapp.com/lv2/?page='.$i);

	foreach($html->find('tr') as $tr_dom) {
		$row = new StdClass;
		$td_doms = $tr_dom->find('td');

		if('鄉鎮' == $td_doms[0]->innertext){ 
			continue;
		}

		$row->town = urlencode($td_doms[0]->innertext);
		$row->village = urlencode($td_doms[1]->innertext);
		$row->name = urlencode($td_doms[2]->innertext);

		$result[] = $row;
	}

}

echo urldecode(json_encode($result));
?>
