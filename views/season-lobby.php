<?
	$tag_feature = '[feature]';
	$media = $oo->media($item['id']);
	$feature = false;
	foreach($media as $m)
	{
		if(strpos($m['caption'], $tag_feature) !== false ){
			$feature = $m;
		}
	}
	$tag_thumbnail = '[thumbnail]';
	$images_arr = array();

	$children = $oo->children($item['id']);
	foreach($children as $key => &$child)
	{
		if(substr($child['name1'], 0, 1) == '.')
			unset($children[$key]);
		else
		{
			$media = $oo->media($child['id']);
			$thumbnail = false;
			$thumbnail_alt = false;
			if(count($media) > 0)
			{
				foreach( $media as $m ){
					if(strpos($m['caption'], $tag_thumbnail) !== false ){
						$thumbnail = m_url($m);
						$thumbnail_alt = substr($m['caption'], strpos($m['caption'], $tag_thumbnail) + strlen($tag_thumbnail));
						$thumbnail_alt = empty($thumbnail_alt) ? 'Thumbnail of '.$child['name1'] : $thumbnail_alt;
					}
				}
				if(!$thumbnail){
					$thumbnail = m_url($media[0]);
					$thumbnail_alt = substr($m['caption'], strpos($m['caption'], $tag_thumbnail) + strlen($tag_thumbnail));
						$thumbnail_alt = $media[0]['caption'];
						$thumbnail_alt = empty($thumbnail_alt) ? 'Thumbnail of '.$child['name1'] : $thumbnail_alt;
				}
				$images_arr[] = $thumbnail;
			}
			$child['thumbnail'] = $thumbnail;
			$child['thumbnail_alt'] = $thumbnail_alt;
		}
	}
	unset($child);
	
	
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
			$url = implode('/', $uri) . '/' . $child['url'];
			$blink_count = rand(4, 7);
			$idx = ($key+1) >= 10 ? $key+1 : '0' . ($key+1);
			$thumbnail = $child['thumbnail'];
			$thumbnail_alt = $child['thumbnail_alt'];
			if($key == count($children) - 1)
				$class .= 'last-look';
			?></div><div <?= $key == count($children) - 1 ? 'id="last-look"' : ''; ?> class="look blink-hover-zone random-blink-hover-zone">
				<? for($i = 0; $i < $blink_count ; $i++){
					?><span class="blink-container random-blink-container"></span><?
				} ?><a class="look-link" href="<?= $url; ?>"><?
				if($thumbnail)
				{
					?><img class="look-image thumbnail" src="<?= $thumbnail; ?>" alt="<?= $thumbnail_alt; ?>"><?
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
	<? if($feature){
		?><div id="feature-video-container">
			<video id="feature-video" autoplay muted loop buffered playsinline>
				<source src="<?= m_url($feature); ?>" type="video/<?= $feature['type']; ?>">
				Your browser doesn't support HTML 5 video.
			</video>
		</div><?
	} ?>
</main>
<style>
.horizontal-slideshow-container
{
    -webkit-overflow-scrolling: touch;
    overflow-x: auto;
}
.horizontal-slideshow-container::-webkit-scrollbar {
    display: none;
}
#slideshow-carrier
{
    display: flex;
    flex-wrap: nowrap;
    /*overflow-y: hidden; */
}
#looks-container
{
    border-bottom: 1px solid var(--light-grey);
    border-top: 1px solid var(--light-grey);
    font-family: ibm_plex_mono, sans-serif;

}
.look
{
    vertical-align: middle;
    /*display: inline-block;*/
    width: 57vw;
    flex: 0 0 auto;
    border-right: 1px solid var(--light-grey);
    padding: 20px 0;
    overflow: hidden;
}
#last-look
{
    border-right: none;
}
.look-link
{
    display: block;
}
.look-image
{
    opacity: 1;
    -webkit-transition: opacity .75s;
       -moz-transition: opacity .75s;
         -o-transition: opacity .75s;
            transition: opacity .75s;
}
body.loading .look img{
    opacity: 0;
}
.noTouchScreen .look:hover
{
    background-color: var(--sky-blue);
}
.noTouchScreen .look:hover a
{
    color: #000;
}
.thumbnail
{
    display: block;
}
.look-idx
{
    text-align: center;
    padding: 20px 20px 0 20px;
}
.slideshow-control-container
{
    padding: 10px 20px;
    text-align: right;
}
.slideshow-control-element
{
    width: 40px;
    height: 40px;
    background-image: url(../../media/svg/arrow_1.svg);
    background-size: 40px 40px;
    background-position: center;
    background-repeat: no-repeat;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    display: inline-block;
    margin-left: 20px;
}
.noTouchScreen .slideshow-control-element:hover
{
    border-bottom: 2px solid var(--light-grey);
    animation: arrow_next .75s infinite linear;
}

#prev
{
    transform-origin: center;
    -webkit-transform: scale(-1, 1);
       -moz-transform: scale(-1, 1);
        -ms-transform: scale(-1, 1);
         -o-transform: scale(-1, 1);
            transform: scale(-1, 1);
    /*float: left;*/
}
@media screen and (min-width: 768px) {

    .look
    {
        width: 30vw;
        padding: 20px 10px;
    }
}
@media screen and (min-width: 1100px) {

    .look
    {
        width: 22vw;
    }
}
</style>
<script>
	var images_arr = <?= json_encode($images_arr); ?>;
	if(images_arr.length != 0)
		preloadImage(images_arr, removeLoading);
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
			var amount = slideshow_x - slideshow_container.scrollLeft;
			SmoothHorizontalScrolling(slideshow_container, 250, amount, slideshow_container.scrollLeft);
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
			var amount = current_slideshow_x - slideshow_container.scrollLeft;
			SmoothHorizontalScrolling(slideshow_container, 250, amount, slideshow_container.scrollLeft);
		}
	}
</script>
