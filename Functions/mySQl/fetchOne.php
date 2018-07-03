<?php
mysql_connect('localhost','root','root');
mysql_select_db('mr');
function fetchOne($table,$settings=array('fields'=>'*')){
/*	
    if(array_key_exists($settings['where'])){
		$sql .= ' WHERE ' . $settings['where'];
	}
	if(array_key_exists($settings['group'])){
		$sql .= ' GROUP BY ' . $settings['group'];
	}
	if(array_key_exists($settings['having'])){
		$sql .= ' HAVING ' . $settings['having'];
	}
	if(array_key_exists($settings['order'])){
		$sql .= ' ORDER BY ' . $settings['order'];
	}
	if(array_key_exists($settings['limit'])){
		$sql .= ' LIMIT ' . $settings['limit'];
	}
*/
	$sql = 'SELECT ' . $settings['fields'] . ' FROM ' . $table . 
	       (array_key_exists($settings['where'])?' WHERE ' . $settings['where']:NULL) . 
	       (array_key_exists($settings['group'])?' GROUP BY ' . $settings['group']:NULL) . 
		   (array_key_exists($settings['having'])?' HAVING ' . $settings['having']:NULL) . 
		   (array_key_exists($settings['order'])?' ORDER BY ' . $settings['order']:NULL) . 
		   (array_key_exists($settings['limit'])?' LIMIT ' . $settings['limit']:NULL); 
	return $sql;
	

}