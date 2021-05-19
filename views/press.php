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
<style>
.press-link
{
    display: block;
    padding: 20px 20px;
    border-bottom: 1px solid var(--light-grey);
}
.press-detail.date
{
    margin-bottom: 20px;
}

.press-detail.platform
{
    margin-top: 20px;
}
.noTouchScreen .press-link:hover
{
    background-color: var(--sky-blue);
    color: #000;
}
.press-link.active .blink
{
    animation: blinking_1 .75s infinite linear;
}
@media screen and (min-width: 768px) {
	.press-link
    {
        display: flex;
        flex-wrap: nowrap;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .press-detail.date
    {
        width: 170px;
        margin-bottom: 0;
    }
    .press-detail.title
    {
        padding-right: 30px;
        flex: 1;
    }
    .press-detail.platform
    {
        margin-top: 0;
        width: 320px;
        text-align: right;
    }
    .press-detail.title .blink-container
    {
        margin-top: 11px;
    }
}
</style>
<script>
	var sPress_link = document.getElementsByClassName('press-link');
	if(sPress_link.length > 0)
	{
		[].forEach.call(sPress_link, function(el, i){
			el.addEventListener('click', function(){
				if(!el.classList.contains('active'))
				{
					var activeSibling = document.querySelector('.press-link.active');
					if(activeSibling != null)
						activeSibling.classList.remove('active');
					el.classList.add('active');
				}
				
			});
		});
	}
</script>