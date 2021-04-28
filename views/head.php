<?
// open-records-generator
require_once('open-records-generator/config/config.php');
require_once('open-records-generator/config/url.php');

$db = db_connect("guest");
$oo = new Objects();
$mm = new Media();
$ww = new Wires();
$uu = new URL();

if($uu->id)
	$item = $oo->get($uu->id);
else
	$item = $oo->get(0);
$name = ltrim(strip_tags($item["name1"]), ".");
$nav = $oo->nav($uu->ids);
$show_menu = false;
if($uu->id) {
	$is_leaf = empty($oo->children_ids($uu->id));
	$internal = (substr($_SERVER['HTTP_REFERER'], 0, strlen($host)) === $host);	
	if(!$is_leaf && $internal)
		$show_menu = true;
} else  
    if ($uri[1])  
        $uu->id = -1; 

$isHome = $uri[1] ? false : true;


?><!DOCTYPE html>
<html>
	<head>
		<title>I DO JISU</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="/static/css/ibm-plex-mono.css">
		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="apple-touch-icon" href="/media/png/touchicon.png" />
		<link rel="stylesheet" href="https://use.typekit.net/hpl4nwi.css">
	</head>
	<body>
		<script src="/static/js/_touchScreen.js"></script>
		<script src="/static/js/_global.js"></script>
		<script src="/static/js/_resize.js"></script>
