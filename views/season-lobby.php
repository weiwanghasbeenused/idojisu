<?
	$children = $oo->children($item['id']);
	foreach($children as $key => &$child)
	{
		if(substr($child['name1'], 0, 1) == '.')
			unset($children[$key]);
	}
	unset($child);
	$tag_thumbnail = '[thumbnail]';
?>
<main id="season-lobby-container" class="container main-container">
	<? if(count($children) > 0){
		?>
		<div id="looks-container" class="slideshow-container horizontal-slideshow-container">
			<div id="slideshow-carrier">
			<div class="hidden"><?
		$children_count = count($children) > 10 ? count($children) : '0' . count($children);
		foreach($children as $key => $child)
		{
			$media = $oo->media($child['id']);
			$thumbnail = false;
			if(count($media) > 0)
			{
				foreach( $media as $m ){
					if(strpos($m['caption'], $tag_thumbnail) !== false ){
						$thumbnail = m_url($m);
						$thumbnail_alt = substr($media['caption'], strpos($media['caption'], $tag_thumbnail) + strlen($tag_thumbnail));
						$thumbnail_alt = $thumbnail_alt == '' ? 'Thumbnail of '.$child['name1'] : $thumbnail_alt;
					}
				}
			}

			$url = implode('/', $uri) . '/' . $child['url'];
			$blink_count = rand(4, 7);
			$idx = ($key+1) >= 10 ? $key+1 : '0' . ($key+1);

			?></div><div class="look blink-hover-zone random-blink-hover-zone">
				<? for($i = 0; $i < $blink_count ; $i++){
					?><span class="blink-container random-blink-container"></span><?
				} ?><a href="<?= $url; ?>"><?
				if($thumbnail)
				{
					?><img class="thumbnail" src="<?= $thumbnail; ?>" alt="<?= $thumbnail_alt; ?>"><?
				}
				else
				{
					?><p><?= $child['name1']; ?></p><?
				}
				?><p class="look-idx"><?= $idx; ?> / <?= $children_count; ?></p><?
			?></a><?
		}
		?></div></div></div>
			<div class="slideshow-control-container">
				<div id = "prev" class="slideshow-control-element"></div>
				<div id = "next" class="slideshow-control-element"></div>
			</div>
		</div><?
	} ?>
</main>
<script>
	var sHorizontal_slideshow_container = document.getElementsByClassName('horizontal-slideshow-container')[0];
	var next = document.getElementById('next');
	var prev = document.getElementById('prev');
	var horizontal_slideshow_interval = document.getElementsByClassName('look')[0].offsetWidth;
	var sSlideshow_carrier = document.getElementById('slideshow-carrier');
	var current_slideshow_x = sHorizontal_slideshow_container.scrollLeft;
	var current_slideshow_idx = parseInt(current_slideshow_x / horizontal_slideshow_interval);
	var slides_count = <?= $children_count; ?>;
	
	next.addEventListener('click', function(){
		current_slideshow_idx = next_slide(sHorizontal_slideshow_container, horizontal_slideshow_interval, slides_count);
	});
	prev.addEventListener('click', function(){
		current_slideshow_idx = prev_slide(sHorizontal_slideshow_container, horizontal_slideshow_interval);
	});

	function init_horizontal_slideshow(){
		horizontal_slideshow_interval = document.getElementsByClassName('look')[0].innerWidth;
	}
	function next_slide(slideshow_container, interval, max_count){
		var idx = (parseInt(slideshow_container.scrollLeft / interval) + 1);
		if(idx > max_count - 1)
		{
			idx = max_count - 1;
		}
		else
		{
			var slideshow_x = idx * interval;
			// console.log(current_slideshow_x);
			slideshow_container.scrollTo({
				top: 0,
				left: slideshow_x,
				behavior: 'smooth'
			});
		}
		return idx;
	}
	function prev_slide(slideshow_container, interval, max_count=false){
		var idx = (parseInt((slideshow_container.scrollLeft-5) / interval));
		if(idx < 0)
		{
			idx = 0;
		}
		else
		{
			current_slideshow_x = idx * interval;
			// console.log(current_slideshow_x);
			slideshow_container.scrollTo({
				top: 0,
				left: current_slideshow_x,
				behavior: 'smooth'
			});
		}
	}
</script>
