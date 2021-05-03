<?
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
	$detail_text = strip_tags($detail_text, '<br><a><div><i><b><strong><emphasis>');
	$detail_text = replaceDivs($detail_text);
	$gallery_media = $oo->media($gallery_items['id']);

	$tag_thumbnail = '[thumbnail]';
	$media = $oo->media($item['id']);
	if(count($media) > 0)
	{
		foreach( $media as $m ){
			if(strpos($m['caption'], $tag_thumbnail) !== false ){
				$default = m_url($m);
				$default_alt = substr($media['caption'], strpos($media['caption'], $tag_thumbnail) + strlen($tag_thumbnail));
				$default_alt = $default_alt == '' ? 'Thumbnail of '.$child['name1'] : $default_alt;
			}
		}
	}
	$bracket_pattern = '#\[(.*)\](.*)#is';

?>
<div id="detail-layout-container" class="main-container">
	<aside id="left-side-container">
		
	</aside><main id="season-detail-container" class="container">
		<div id="season-detail-sticky-container">
			<h1 class="detail-blockname"><?= $item['name1']; ?></h1>
			<div id="gallery-default-toggle" class="detail-blockname">&otimes;</div>
			<div id="accessory-container">
				<h2 class="detail-blockname">Items</h2>
				<h2 id="items-toggle" class="blink-hover-zone detail-blockname"><span class="blink-container"></span>Items<span class="blink-container"></span></h2>
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
							?><div class="accessory-item">
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
				<h2 id="gallery-toggle" class="blink-hover-zone detail-blockname"><span class="blink-container"></span>Gallery<span class="blink-container"></span></h2>
				<? if(count($gallery_media) > 0){
					?><div id="gallery-item-container"><?
					foreach($gallery_media as $m)
					{
						if(substr($m['caption'], 0, 1) != '.')
						{
							$src = m_src($m);
							$url = m_url($m);
							?><div class="gallery-option" style="background-image:url(<?= $src; ?>);" img-url="<?= $url; ?>"></div><?
						}
					}
					?></div><?
				} ?>
			</div>
		</div>
		<div id="gallery-frame" class="detail-block">
			<img id="gallery-image" class="detail-image" src="<?= $default; ?>" alt="<?= $default_alt; ?>" img-url="<?= $default; ?>">
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
	gallery_init();
	if(!isWebLayout)
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
		var sItems_toggle = document.getElementById('items-toggle');
		var sGallery_toggle = document.getElementById('gallery-toggle');
		var mask = document.getElementById('mask');

		if(sItems_toggle != undefined)
		{
			sItems_toggle.addEventListener('click', function(){
				if(body.classList.contains('viewing-items-list'))
				{
					body.classList.remove('viewing-items-list');
					body.classList.remove('fadeout');
				}
				else
				{
					body.classList.add('viewing-items-list');
					body.classList.remove('viewing-gallery-list');
					sGallery_toggle.classList.remove('active');
					body.classList.add('fadeout');
				}
				sItems_toggle.classList.toggle('active');
			});
			
		}
		
		if(sGallery_toggle != undefined)
		{
			sGallery_toggle.addEventListener('click', function(){
				if(body.classList.contains('viewing-gallery-list'))
				{
					body.classList.remove('viewing-gallery-list');
					body.classList.remove('fadeout');
				}
				else
				{
					body.classList.add('viewing-gallery-list');
					body.classList.remove('viewing-items-list');
					sItems_toggle.classList.remove('active');
					body.classList.add('fadeout');
				}
				sGallery_toggle.classList.toggle('active');
			});
		}

		if(mask != undefined)
		{
			mask.addEventListener('click', function(){
				body.classList.remove('viewing-items-list');
				body.classList.remove('viewing-gallery-list');
				body.classList.remove('fadeout');
				sItems_toggle.classList.remove('active');
				sGallery_toggle.classList.remove('active');
			});
		}
	}
</script>