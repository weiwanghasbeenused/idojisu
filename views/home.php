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
	$blue_count = 1;
	$white_count = 0;
	$group_count = 1;
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
		if($useSvg)
		{
			?>
			<svg id="cloud-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 1080">
  <defs>
    <style>
      .cls-1 {
        fill: #c6dff1;
      }
    </style>
  </defs>
  <path class="cls-1" d="M0,1080H427.51a71.43,71.43,0,0,0-26.05-32.09q-5.26-3.62-10.69-6.62c41.14-20,141.08-71.83,205.73-33.83,39,22.93,94.11,16.44,132-5.31L761.11,1080H1920V0H0ZM99.65,73.9c38.67-71,118.1-35.46,246.66,6.07a192,192,0,0,0-29,18.38c-91.49,70.19-116.45,242.91-38.39,304.43,58.33,46,106.85-2.37,145.23,57.57s99.81,93.85,226.49,82,148.68-37,151.64-76.5c3.84-51.26-86.22-66.9-85.1-176.66.9-87.35-55.64-158.3-130.49-198.1C614.49,80.58,644.26,69,688,64.44c119.88-12.62,974.8-6.31,1085.21-6.31s37.07,302.06,74.14,437.71,74.13,327.3-142,314.68c-45.28-2.64-82,2.06-112.06,11.93,10.13-28.86,11.14-64.14.46-102.23-36.28-129.34,78.87-97.8,82.81-242.12s-86-160.89-145.12-132.5-143.7,3.72-139.59-49.69c5.52-71.77-83.63-121.65-170.35-82-119.09,54.42-145.91,129.34-64.68,198.75,35.35,30.19,93.86,54.42,168.78,65.46-76.5,15.77-126.19,126.19-122.24,175.87-37.86,11.83-201.12,91.49-184.55,183s263.41,71.77,380.14,32.34c35.1,20.48,67.82,28.72,96.28,27.37-31.28,46.15-43.62,101.51-58,141.8-30.76,86-320.2,6.31-382.51-74.14-52.85-68.24-175.51-89.36-290.47-48.95-34.61-64.7-128.8-29.42-165.83-75.88C560.6,792,511.49,721.81,428.53,734.34c-68,10.25-168.62,57.7-188.5,182.72-7.06,44.42-2.72,76.26,8.55,98.31-49.92-5.66-97.79-21.16-134-87.33C40.5,792.38,56.27,153.56,99.65,73.9Z"/>
</svg>

			<?
		}
		else
		{
			for($i = 0; $i < $group_count; $i++)
			{
				?><div class="sky-group"><?
			
				for($j = 0; $j < $blue_count; $j++)
				{
					
					$left = rand(0, 100);
					$top = rand(0, 100);
					$w = rand(10, 24);
					$h = rand(10, 24);
					$w = 50;
					$h = 50;
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
#cloud-1
{
	filter: blur(40px);
	animation: float 30s linear forwards;

    width: 150%;
    height: 150%;
    top: -200px;
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
    animation: float 30s linear forwards;
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
@keyframes float
{
	0%{
		transform: translate(0, 0);
	}
	100%
	{
		transform: translate(-500px, 0);
	}
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