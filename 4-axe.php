<?php

require_once '../simple_html_dom.php';

$result = array();
$last_url = '';

for($i = 1; $i < 24+1; $i++) {
	$url = 'http://axe-level-4.herokuapp.com/lv4/?page='.$i;

	//$header = 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';

	$ch = curl_init($url);

	if($i !== 1) 
		curl_setopt($ch, CURLOPT_REFERER, $last_url);

	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.73.11 (KHTML, like Gecko) Version/7.0.1 Safari/537.73.11');
	//curl_setopt($ch, CURLOPT_HEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$page = curl_exec($ch);

	$html = str_get_html($page);

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

	$last_url = $url;

}

echo urldecode(json_encode($result));
?>
