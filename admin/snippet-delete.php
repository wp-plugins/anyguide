<?php
global $wpdb;

$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$anyguide_snippetId = abs(intval($_GET['snippetId']));
$anyguide_pageno = abs(intval($_GET['pageno']));

if($anyguide_snippetId=="" || !is_numeric($anyguide_snippetId)) {
	header("Location:".admin_url('admin.php?page=anyguide-manage'));
	exit();
}

$snippetCount = $wpdb->query($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'anyguide_short_code WHERE id=%d LIMIT 0,1',$anyguide_snippetId )) ;

if($snippetCount==0) {
	header("Location:".admin_url('admin.php?page=anyguide-manage&any_msg=2'));
	exit();
} else {
	$wpdb->query($wpdb->prepare( 'DELETE FROM  '.$wpdb->prefix.'anyguide_short_code  WHERE id=%d',$anyguide_snippetId)) ;
	header("Location:".admin_url('admin.php?page=anyguide-manage&any_msg=3&pagenum='.$anyguide_pageno));
	exit();
}

?>