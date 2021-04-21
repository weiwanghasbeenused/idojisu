<? 
	$menu_version = isset($_GET['menu']) ? $_GET['menu'] : 1;
	$header_class .= 'menu-version-' . $menu_version;

	$menu_items_raw = $oo->children(0);
	$menu_items = array();
	foreach($menu_items_raw as $item)
	{
		if(substr($item['name1'], 0, 1) != '.')
			$menu_items[] = $item;
	}
?>
<header class="<?= $header_class; ?>">
	<? if($menu_version == 2){
		?><div id="logo-container"><a href = '/'><img id="logo" src = "/media/svg/logo-light-grey.svg"></a></div><?
	} ?>
	<div id="header-wrapper">
		<? foreach($menu_items as $item){
			$url = '/' . $item['url'];
			$isDropdown = !(strpos($item['deck'], '[dropdown]') === false);
			?><div class="menu-item-container blink-hover-zone"><? if($isDropdown){
				?><span class="menu-item" ><span class="blink-container"></span><?= $item['name1']; ?><span class="blink-container"></span></span><?
			}else{
				?><a class="menu-item" href="<?= $url; ?>"><span class="blink-container"></span><?= $item['name1']; ?><span class="blink-container"></span></a><?
			} ?></div><?
		} ?>
		<? if($menu_version == 1){
			?><div id="logo-container"><a href = '/'><img id="logo" src = "/media/svg/logo-light-grey.svg"></a></div><?
		} ?>
	</div>
</header>