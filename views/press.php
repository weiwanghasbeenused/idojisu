<?
	$seasons = $oo->children($item['id']);
	$children = array();
	$date = array();
	foreach($seasons as $season)
	{
		$s_children = $oo->children($season['id']);
		foreach($s_children as &$child)
		{
			$child['season'] = $season['name1']; 
			$children[] = $child;
			$date[] = $child['begin'];
		}
		unset($child);
	}
	array_multisort($date, SORT_DESC, $children);
?>

<main id="press-container" class="main-container">
	<section >
		<ul id="" class="large-text">
			<? foreach($children as $child){
				if(substr($child['name1'], 0, 1) != '.')
				{
					$name_arr = explode('[]', $child['name1']);
					$platform = strtoupper($name_arr[0]);
					$season = $child['season'];
					$title = strtoupper($name_arr[1]);
					$date = date('m/d/Y', strtotime($child['begin']));
					$url = stripBracket($child['notes']);
				?><li class="press-item"><a class="press-link blink-hover-zone" href="<?= $url; ?>" target="_blank"><?
				?><p class="press-detail date"><?= $date; ?></p><p class="press-detail title"><?= $title; ?><span class="blink-container"></span></p><p class="press-detail platform"><?= $season . ' ' . $platform; ?></p></a></li><?
				}
			} ?>
		</ul>
	</section>
</main>
<script>
	
</script>