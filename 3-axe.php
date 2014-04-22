<?php

require_once '../simple_html_dom.php';

$result = array();

$cookie = '';

for($i = 1; $i < 76+1; $i++) {
	$url = ($i === 1)? 'http://axe-level-1.herokuapp.com/lv3/': 'http://axe-level-1.herokuapp.com/lv3/?page=next';

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
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

}

echo urldecode(json_encode($result));
?>
