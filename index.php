<?
$uri = explode('/', $_SERVER['REQUEST_URI']);

require_once("views/head.php");
if (!$uri[1])
	require_once("views/home.php");
elseif ($uri[1] == 'collection' && count($uri < 4))
	require_once("views/list.php");
elseif ($uri[1] == 'collection' && count($uri >= 4))
	require_once("views/detail.php");
else 
    require_once("views/main.php");
require_once("views/badge.php");
require_once("views/foot.php");
?>
