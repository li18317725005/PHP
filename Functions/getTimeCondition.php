<?php
/*时间计算*/
function getTimeCondition(){
	//今日
	$now_time = date('Y-m-d', time()); //当前时间
	$where_1['add_time'] = array( array('gt',$now_time . ' 00:00:00'), array('lt', $now_time . ' 23:59:59') ); //今日

	//本周
	$timestr = time();
    $now_day = date('w', $timestr);
    //获取一周的第一天，注意第一天应该是星期天
    $sunday_str = $timestr - $now_day*60*60*24;
    $sunday = date('Y-m-d', $sunday_str);
    //获取一周的最后一天，注意最后一天是星期六
    $strday_str = $timestr + (6-$now_day)*60*60*24;
    $strday = date('Y-m-d', $strday_str);
    $where_2['add_time'] = array( array('gt', $sunday . ' 00:00:00'), array('lt', $strday . ' 23:59:59') ); //本周

    //本月
	$beginThismonth = mktime(0,0,0,date('m'),1,date('Y')); //本月开始的时间戳
	$endThismonth = mktime(23,59,59,date('m'),date('t'),date('Y')); //本月结束的时间戳
	$month_start = date('Y-m-d H:i:s', $beginThismonth);
	$month_end = date('Y-m-d H:i:s', $endThismonth);
	$where_3['add_time'] = array( array('gt', $month_start), array('lt', $month_end) ); //本月

	$where['where_1'] = $where_1;
	$where['where_2'] = $where_2;
	$where['where_3'] = $where_3;
	return $where;
}