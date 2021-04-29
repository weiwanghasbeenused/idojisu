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
<main id="season-lobby-container" class="container">
	<? if(count($children) > 0){
		?><div id="looks-container" class="slideshow-container horizontal-slideshow-container"><div class="hidden"><?
		$children_count = count($children) > 10 ? count($children) : '0' . count($children);
		foreach($children as $key => $look)
		{
			$media = $oo->media($look['id']);
			$thumbnail = false;
			if(count($media) > 0)
			{
				foreach( $media as $m ){
					if(strpos($m['caption'], $tag_thumbnail) !== false ){
						$thumbnail = m_url($m);
						$thumbnail_alt = substr($media['caption'], strpos($media['caption'], $tag_thumbnail) + strlen($tag_thumbnail));
						$thumbnail_alt = $thumbnail_alt == '' ? 'Thumbnail of '.$look['name1'] : $thumbnail_alt;
					}
				}
			}
				

			$url = implode('/', $uri) . '/' . $look['url'];
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
					?><p><?= $look['name1']; ?></p><?
				}
				?><p class="look-idx"><?= $idx; ?> / <?= $children_count; ?></p><?
			?></a><?
		}
		?></div></div></div><?
	} ?>
</main>