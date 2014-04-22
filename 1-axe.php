<?php

require_once '../simple_html_dom.php';

$result = array();
$html = file_get_html('http://axe-level-1.herokuapp.com/');

$tr_list = $html->find('tr');

for($i = 1; $i < sizeof($tr_list); $i++) {
	$temp_tr = $tr_list[$i]->find('td');
	$temp_result = new StdClass;
	$temp_result->grades = new StdClass;

	$temp_result->name = urlencode($temp_tr[0]->innertext);

	$temp_result->grades->{urlencode('國語')} = (int)$temp_tr[1]->innertext;
	$temp_result->grades->{urlencode('數學')} = (int)$temp_tr[2]->innertext;
	$temp_result->grades->{urlencode('自然')} = (int)$temp_tr[3]->innertext;
	$temp_result->grades->{urlencode('社會')} = (int)$temp_tr[4]->innertext;
	$temp_result->grades->{urlencode('健康教育')} = (int)$temp_tr[5]->innertext;

	$result[] = $temp_result;
}

echo urldecode(json_encode($result));

?>
