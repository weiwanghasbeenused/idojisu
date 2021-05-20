<?
	$home_id = end($oo->urls_to_ids(array('home')));
	$media = $oo->media($home_id);
	if(!empty($media))
	{
		foreach($media as $m)
		{
			if(strpos($m['caption'], '[landing]') !== false)
				$landing_video = $m;
		}
	}
	$blue_count = 7;
	$white_count = 2;
	$group_count = 0;
	$size = array();
	$useSvg = isset($_GET['useSvg']);
	$useCanvas = isset($_GET['useCanvas']);
	$speed = 5;
	$duration_init = 5;
	$distance = $speed * $duration_init;
	$attributeName = 'transform';

?>

<main>
	<div id="sky-container">
		<?
			for($i = 0; $i < $group_count; $i++)
			{
				?><div class="sky-group"><?
			
				for($j = 0; $j < $blue_count; $j++)
				{
					
					$left = rand(0, 100);
					$top = rand(0, 100);
					$w = rand(10, 24);
					$h = rand(10, 24);
					// $w = rand(35, 60);
					// $h = rand(35, 60);
					$style="width:".$w."%;height:".$h."%;top:".$top."vh;left:".$left."vw;"; 
					?><div class="sky-element sky-blue blur" style="<?= $style; ?>"></div><div class="sky-element sky-blue" style="<?= $style; ?>"></div><?
					
				}
				for($j = 0; $j < $white_count; $j++)
				{
					$w = rand(10, 24);
					$h = rand(10, 24);
					$left = rand(0, 100);
					$top = rand(0, 100);
					// $w = rand(35, 60);
					// $h = rand(35, 60);
					$style="width:".$w."%;height:".$h."%;top:".$top."vh;left:".$left."vw;"; 
					?><div class="sky-element sky-white blur" style="<?= $style; ?>"></div><div class="sky-element sky-white" style="<?= $style; ?>"></div><?
				}

			?></div><?
			}
		?>
	</div>
	<? if(isset($landing_video)){
		?>
		<div id="landing-video-container">
			<video id="landing-video" muted loop buffered playsinline>
				<source src="<?= m_url($landing_video); ?>" type="video/<?= $landing_video['type']; ?>">
				Your browser doesn't support HTML 5 video.
			</video>
			<div id="video-control"></div>
		</div>
		<?
	} ?>
	
</main>
<style>

#sky-container
{
    position: absolute;
    width: 100vw;
    max-width: 100%;
    height: 100vh;
    overflow: hidden;
    z-index: 10;
    display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
    display: flex;
    /*animation: sky 20s alternate linear infinite;*/
    /*filter: blur(60px);*/
}
#sky-canvas
{
    filter: blur(60px);
}

div.sky-element{
    filter: blur(40px);
    position: absolute;
    border-radius: 50%;
    /*background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;*/
}
div.sky-element.blur
{
    filter: blur(60px);
}
div.sky-element.sky-blue
{
    background-color: rgba(170, 220, 255, 1);
    /*background-image: url(../../media/png/blur-blue-2.png);*/
    z-index: 10;
}
div.sky-element.sky-white
{
    background-color: rgba(255, 255, 255, 1);
    /*background-image: url(../../media/png/blur-white.png);*/
    z-index: 500;
}
#sSky_canvas
{
    width: 100%;
    height: 100%;
}

.sky-group
{
    /*position: absolute;*/
    transition-timing-function: linear;
    /*width: 120vw;*/
    /*height: 120vh;*/
    -webkit-box-flex: 1;
    /*width: 24.5%;*/
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
}

#landing-video-container
{
    position: relative;
    height: 100vh;
    overflow: hidden;

}
#landing-video
{
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
       -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
         -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
    /*margin-top: 50px;*/
}
@media screen and (min-width: 768px) {

    .sky-group
    {
        width: 100vw;
        height: 100vh;
    }
    #menu,
	#logo-container
	{
		background-color: transparent;
	}
	.noTouchScreen header
    {
        background-color: transparent;
    }
    .noTouchScreen header:hover
    {
        /*background-color: rgba(0,0,0,.75);*/
        transition: background-color .5s;
        background-color: #000;
    }
}

</style>
<script>
	var useSvg = <?= json_encode($useSvg); ?>;
	var useCanvas = <?= json_encode($useCanvas); ?>;
	var sSky_blue = document.getElementsByClassName('sky-blue');
	var sSky_white = document.getElementsByClassName('sky-white');
	var sSky_container = document.getElementById('sky-container');
	var sSky_group = document.getElementsByClassName('sky-group');
	var direction;
	var isFloating = false;
	var float_min = 10;
	var float_max = 15;
	var float_maxmin = float_max - float_min;
	var speed = <?= $speed; ?>;
	var sky_timer;
	var group_count = <?= $group_count; ?>;
	var blue_count = 6;
	var white_count = 6;

	if(!useCanvas){
		[].forEach.call(sSky_group, function(el, i){
			el.style.transform = 'translate3d(0, 0, 0)';
		});
	}
		
	function wind(groups, duration){
		[].forEach.call(groups, function(el, i){
			var direction = getRandomInt(0, 3);
			var transition = parseInt(duration / 100)/10;
			el.style.transition = 'transform '+transition+'s';
			var style = window.getComputedStyle(el);
			var matrix = new WebKitCSSMatrix(style.transform);
			
			var x = matrix.m41;
			var y = matrix.m42;
			var distance = transition * speed;
			// console.log(distance);
			
			if(direction == 0){
				if(el.offsetTop > 0.5 * wH)
					var this_transform = 'translate3d('+x+'px,-'+(y-distance)+'px,0)';
				else
					var this_transform = 'translate3d('+x+'px,'+(y+distance)+'px,0)';
			}
			else if(direction == 1){
				if(el.offsetLeft > 0.5 * wW)
					var this_transform = 'translate3d('+(x-distance)+'px,'+y+'px,0)';
				else
					var this_transform = 'translate3d('+(x+distance)+'px,'+y+'px,0)';
			}
			else if(direction == 2){
				if(el.offsetTop < -(0.5 * wH))
					var this_transform = 'translate3d('+x+'px,'+(y+distance)+'px,0)';
				else
					var this_transform = 'translate3d('+x+'px,'+(y-distance)+'px,0)';
			}
			else if(direction == 3){
				if(el.offsetLeft < -(0.5 * wW))
					var this_transform = 'translate3d('+(x+distance)+'px,'+y+'px,0)';
				else
					var this_transform = 'translate3d('+(x-distance)+'px,'+y+'px,0)';
				
			}
		 	el.style.transform = this_transform;
		});
		var next_duration = parseInt( (float_maxmin * Math.random() + float_min) * 1000);

		setTimeout(function(){
			wind(groups, next_duration);
		}, duration);
	}
	function blow(groups, duration){
		[].forEach.call(groups, function(el, i){
			if(i%2 == 0)
			{
				var this_transform = 'translate3d(-80%, 0, 0)';

			}
			else
			{
				var this_transform = 'translate3d(80%, 0, 0)';
			}
			var this_transition = (duration + 250 * i) / 1000;
			el.style.transition = 'transform ' + this_transition+'s';
			el.style.transform = this_transform;
		});
	}

	
	sSky_container.addEventListener('click', function(){
		blow(sSky_group, 5000);
	});
	function resizeSizeToCover(subject, frame=false) {
		if(!frame)
			frame = subject.parentNode;
		var r_subject = subject.offsetHeight / subject.offsetWidth;
		var r_frame = frame.offsetHeight / frame.offsetWidth;
		if(r_subject > r_frame && subject.style.width != '100%')
		{
			subject.style.width = '100%';
			subject.style.height = 'auto';
		}
		else if(r_subject < r_frame && subject.style.height != '100%')
		{
			subject.style.width = 'auto';
			subject.style.height = '100%';
		}
	}
</script>