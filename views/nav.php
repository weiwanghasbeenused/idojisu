<? 
	$menu_version = isset($_GET['menu']) ? $_GET['menu'] : 1;
	$header_class .= 'menu-version-' . $menu_version;

	$menu_items_raw = $oo->children(0);
	$menu_items = array();
	foreach($menu_items_raw as $m_item)
	{
		if(substr($m_item['name1'], 0, 1) != '.')
			$menu_items[] = $m_item;
	}
?>
<header class="<?= $header_class; ?>">
	<? if($menu_version == 1){
		?><div id="logo-container"><a href = '/'><img id="logo" src = "/media/svg/logo-light-grey.svg"></a></div><?
	} ?>
	<div id="header-wrapper">
		<? foreach($menu_items as $m_item){
			$url = '/' . $m_item['url'];
			$isDropdown = !(strpos($m_item['deck'], '[dropdown]') === false);
			$this_class = 'menu-item-container blink-hover-zone';
			if($isDropdown)
				$this_class .= ' submenu-parent';
			?><div class="<?= $this_class; ?>"><? 
			if($isDropdown){
				$submenu_items = $oo->children($m_item['id']);
				?><span class="menu-item " ><span class="blink-container"></span><?= $m_item['name1']; ?><span class="blink-container"></span></span>
				<div class="submenu-container">
					<? foreach($submenu_items as $sm_item){
						if(substr($m_item['name1'], 0, 1) != '.')
						{
							$sub_url = $url . '/' . $sm_item['url'];
							?>
							<div class="submenu-item-container blink-hover-zone"><a class="submenu-item" href="<?= $sub_url; ?>" ><span class="blink-container"></span><?= $sm_item['name1']; ?><span class="blink-container"></span></a></div>
							<?
						}
					} ?>
				</div><?
			}else{
				?><a class="menu-item" href="<?= $url; ?>"><span class="blink-container"></span><?= $m_item['name1']; ?><span class="blink-container"></span></a><?
			} ?></div><?
		} ?>
		<? if($menu_version == 2){
			?><div id="logo-container"><a href = '/'><img id="logo" src = "/media/svg/logo-light-grey.svg"></a></div><?
		} ?>
	</div>
</header>
<script>
	

		var sSubmenu_parent = document.getElementsByClassName('submenu-parent');
		
		if(sSubmenu_parent.legnth != 0)
		{
			[].forEach.call(sSubmenu_parent, function(el, i){
				el.addEventListener('click', function(){
					if(isOnePageMenu){
						console.log(sSubmenu_parent[0]);
						el.classList.toggle('expanded');
					}
				});
			});
		}

</script>