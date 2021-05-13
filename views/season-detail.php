<?
	$images_arr = array();
	$children = $oo->children($item['id']);
	$accessory_items = array();
	$gallery_items = array();
	$detail_items = array();
	foreach($children as $child)
	{
		if($child['url'] == 'accessory' && substr($child['name1'], 0, 1) != '.')
			$accessory_items = $child;
		elseif($child['url'] == 'gallery' && substr($child['name1'], 0, 1) != '.')
			$gallery_items = $child;
		elseif($child['url'] == 'details' && substr($child['name1'], 0, 1) != '.')
			$detail_items = $child;
	}
	$detail_text = wysiwygClean($detail_items['body']);
	$gallery_media = $oo->media($gallery_items['id']);

	$tag_thumbnail = '[thumbnail]';
	$media = $oo->media($item['id']);
	if(count($media) > 0)
	{
		foreach( $media as $m ){
			if(strpos($m['caption'], $tag_thumbnail) !== false ){
				$default_src = m_src($m);
				$default_alt = substr($media['caption'], strpos($media['caption'], $tag_thumbnail) + strlen($tag_thumbnail));
				$default_alt = $default_alt == '' ? 'Thumbnail of '.$child['name1'] : $default_alt;
			}
		}
	}
	$figure_with_accessory_src = array();
	$accessory_children = $oo->children($accessory_items['id']);
	foreach($accessory_children as $a_child)
	{

		if(strtolower($a_child['name1']) == 'figure with accessory'){
			$figure_with_accessory_media = $oo->media($a_child['id']);
			foreach($figure_with_accessory_media as $a_m)
			{
				$figure_with_accessory_src[$a_m['caption']] = m_src($a_m);
			}
		}
	}

	$bracket_pattern = '#\[(.*)\](.*)#is';

?>
<div id="detail-layout-container" class="main-container">
	<aside id="left-side-container"></aside><main id="season-detail-container" class="container" viewing="default">
		<div id="season-detail-sticky-container">
			<h1 class="detail-blockname"><?= $item['name1']; ?></h1>
			<div id="gallery-default-toggle" class="detail-blockname">&otimes;</div>
			<div id="accessory-container">
				<h2 class="detail-blockname">Items</h2>
				<h2 id="items-toggle" class="blink-hover-zone detail-blockname list-toggle"><span class="blink-container"></span>Items<span class="blink-container"></span></h2>
				<? if(!empty($accessory_items)){
					$accessory_media = $oo->media($accessory_items['id']);
					if(count($accessory_media) > 0)
					{
						?><div id="accessory-item-container"><?
						foreach($accessory_media as $m)
						{
							$src = m_src($m);						
							preg_match_all($bracket_pattern, $m['caption'], $item_info);
		 					$rank = $item_info[1][0];
							$name = $item_info[2][0];
							$alt = $name;
							$images_arr[] = m_url($m);
							?><div class="accessory-item" figure-src="<?= $figure_with_accessory_src[$m['caption']]; ?>">
								<div class="accessory-item-img" style="background-image:url(<?= $src; ?>);"></div>
								<div class="accessory-item-info">
									<p><?= $name; ?></p>
									<div id="rank-container">
										<? for($i = 0; $i < $rank; $i++){
											?><span class="rank active"></span><?
										} 
										for($i = 0; $i< 5-$rank; $i++ )
										{
											?><span class="rank"></span><?
										}
										?>

									</div>
								</div>
							</div>
							<?
						}
						?></div><?
					}
					?><?
				} ?>
			</div><div id="gallery-container">
				<h2 class="detail-blockname">Gallery</h2>
				<h2 id="gallery-toggle" class="blink-hover-zone detail-blockname list-toggle"><span class="blink-container"></span>Gallery<span class="blink-container"></span></h2>
				<? if(count($gallery_media) > 0){
					?><div id="gallery-item-container"><?
					foreach($gallery_media as $m)
					{
						if(substr($m['caption'], 0, 1) != '.')
						{
							$src = m_src($m);
							$url = m_url($m);
							$images_arr[] = m_url($m);
							?><div class="gallery-option" style="background-image:url(<?= $src; ?>);" img-url="<?= $url; ?>"></div><?
						}
					}
					?></div><?
				} ?>
			</div>
		</div>
		<div id="gallery-frame" class="detail-block image-frame-container">
			<? foreach($gallery_media as $key => $m){
				$images_arr[] = m_url($m);
				?><img id="gallery-image-<?= $key; ?>" class="gallery-image" alt="<?= $m['caption']; ?>" src="<?= m_url($m); ?>" ><?
			} ?>
			<? foreach($accessory_media as $key => $m){
				$images_arr[] = $figure_with_accessory_src[$m['caption']];
				?><div id="accessory-frame-<?= $key; ?>" class="image-frame contain" style="background-image:url(<?= $figure_with_accessory_src[$m['caption']]; ?>);"></div><?
			} ?>
			<div id="image-frame-default" class="image-frame contain" style="background-image:url(<?= $default_src; ?>);"></div>
		</div>
		<div id="detail-container">
			<h2 class="detail-blockname">Details</h2>
			<p id="detail-text"><?= $detail_text; ?></p>
		</div>
	</main><aside id="right-side-container">
		
	</aside>
</div>
<script type="text/javascript" src="/static/js/detail-gallery.js"></script>
<script>
	var images_arr = <?= json_encode($images_arr); ?>;
	var idx_to_callback = parseInt( 3 * images_arr.length / 4);
	preloadImage(images_arr, removeLoading, idx_to_callback);

	var default_src = '<?= $default_src; ?>';
	var sSeason_detail_container = document.getElementById('season-detail-container');
	var sSeason_detail_sticky_container = document.getElementById('season-detail-sticky-container');
	var sGallery_option = document.getElementsByClassName('gallery-option');
	var sGallery_image = document.getElementsByClassName('gallery-image');
	var sAccessory_item = document.getElementsByClassName('accessory-item');
	var sImage_frame = document.getElementsByClassName('image-frame');
	var sItems_toggle = document.getElementById('items-toggle');
	var sGallery_toggle = document.getElementById('gallery-toggle');
	var mask = document.getElementById('mask');

	gallery_init(sGallery_option, sGallery_image, sSeason_detail_sticky_container, sSeason_detail_container);
	items_init(sAccessory_item, sImage_frame, sSeason_detail_sticky_container, sSeason_detail_container);
	toggle_init();
	if(!isMobileLayout)
	{
		var sAccessory_container = document.getElementById('accessory-container');
		var sGallery_container = document.getElementById('gallery-container');
		var sDetail_container = document.getElementById('detail-container');

		var sRight_side_container = document.getElementById('right-side-container');
		var sLeft_side_container = document.getElementById('left-side-container');

		sRight_side_container.appendChild(sDetail_container);
		sRight_side_container.appendChild(sGallery_container);
		sLeft_side_container.appendChild(sAccessory_container);

	}
	else
	{
		if(mask != undefined)
		{
			mask.addEventListener('click', function(){
				sSeason_detail_sticky_container.setAttribute('viewing-list', 'none');
				body.classList.remove('fadeout');
				sItems_toggle.classList.remove('active');
				sGallery_toggle.classList.remove('active');
			});
		}
	}
	window.addEventListener('load', function(){ 
		removeLoading(); 
	});
</script>