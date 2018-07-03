<?php
header('content-type:text/html;charset=utf-8');

function getChineseWeek(){
	
	$weeksArray = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
	
	$dayOfWeek = date('w');
	
	return $weeksArray[$dayOfWeek];
	
}