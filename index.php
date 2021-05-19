<?
$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,'?');
$uri = explode('/', $requestclean);

require_once('views/head.php');
require_once('views/nav.php');
if(!$uri[1] || $uri[1] == 'collection')
	require_once('views/loading.php');
if (!$uri[1])
	require_once('views/home.php');
elseif ($uri[1] == 'collection' && count($uri) < 4)
	require_once('views/season-lobby.php');
elseif ($uri[1] == 'collection' && count($uri) >= 4)
	require_once('views/season-detail.php');
elseif ($uri[1] == 'about'|| $uri[1] == 'contact')
	require_once('views/text.php');
elseif ($uri[1] == 'press')
	require_once('views/press.php');
else 
    require_once('views/main.php');
require_once('views/foot.php');
?>
