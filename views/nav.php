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
	<nav id="menu">
		<? foreach($menu_items as $m_item){
			$url = '/' . $m_item['url'];
			$isDropdown = !(strpos($m_item['deck'], '[dropdown]') === false);
			$this_class = 'menu-item-container blink-hover-zone';
			if($isDropdown)
				$this_class .= ' submenu-parent';
			$isActive = ($uri[1] == $m_item['url']); 
			if($isActive)
				$this_class .= ' active';
			?><div class="<?= $this_class; ?>"><? 
			if($isDropdown){
				$submenu_items = $oo->children($m_item['id']);
				?><span class="menu-item " ><span class="blink-container"></span><?= $m_item['name1']; ?><span class="blink-container"></span></span>
				<div class="submenu-container">
					<? foreach($submenu_items as $sm_item){
						if(substr($m_item['name1'], 0, 1) != '.')
						{
							$sub_url = $url . '/' . $sm_item['url'];
							$isSubActive = $isActive && ($uri[2] === $sm_item['url']);
							$this_subclass = 'submenu-item-container blink-hover-zone';
							if($isSubActive)
								$this_subclass .= ' active';
							?>
							<div class="<?= $this_subclass; ?>"><a class="submenu-item" href="<?= $sub_url; ?>" ><span class="blink-container"></span><?= $sm_item['name1']; ?><span class="blink-container"></span></a></div>
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
	</nav>
	<div id="menu-toggle">
		<div id="first-menu-icon-bar" class="menu-icon-bar"></div>
		<div id="second-menu-icon-bar" class="menu-icon-bar"></div>
		<div id="last-menu-icon-bar" class="menu-icon-bar"></div>
		<div id="cross">
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 40 40" style="enable-background:new 0 0 40 40;" xml:space="preserve">
				<polygon fill="#A2A9AD" points="25,19 25,17 27,17 27,15 29,15 29,13 31,13 31,11 33,11 33,9 29,9 29,11 27,11 27,13 25,13 25,15 
	23,15 23,17 21,17 21,19 19,19 19,17 17,17 17,15 15,15 15,13 13,13 13,11 11,11 11,9 7,9 7,11 9,11 9,13 11,13 11,15 13,15 13,17 
	15,17 15,19 17,19 17,21 15,21 15,23 13,23 13,25 11,25 11,27 9,27 9,29 7,29 7,31 11,31 11,29 13,29 13,27 15,27 15,25 17,25 
	17,23 19,23 19,21 21,21 21,23 23,23 23,25 25,25 25,27 27,27 27,29 29,29 29,31 33,31 33,29 31,29 31,27 29,27 29,25 27,25 27,23 
	25,23 25,21 23,21 23,19 "/>
			</svg>
		</div>
	</div>
</header>
<div id="menu-background" class="fullpage"></div>
<script>
	var sSubmenu_parent = document.getElementsByClassName('submenu-parent');
	
	if(sSubmenu_parent.legnth != 0)
	{
		[].forEach.call(sSubmenu_parent, function(el, i){
			el.addEventListener('click', function(){
				if(isMobileLayout){
					el.classList.toggle('expanded');
				}
			});
		});
	}
	var menu_toggle = document.getElementById('menu-toggle');
	menu_toggle.addEventListener('click', function(){
		body.classList.toggle('viewing-menu');
	});
</script>
<div id="chrome-mask"></div>
<div id="mask" class="fullpage"><span id="btn-close-mask" class="text-btn">close</span></div>
