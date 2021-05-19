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
    margin-top: 45px;
}
@media screen and (min-width: 768px) {

    .sky-group
    {
        width: 100vw;
        height: 100vh;
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

	var sSky_canvas = document.getElementById('sky-canvas');
	if(sSky_canvas != undefined)
	{
		sSky_canvas.width = wW;
		sSky_canvas.height = wH;
		var ctx = sSky_canvas.getContext('2d');
		var skyElement_arr = {};
		skyElement_arr['blue'] = [];
		skyElement_arr['white'] = [];
		for(j = 0; j < blue_count; j++)
		{

			var this_left = parseInt(wW * getRandomInt(0, 100) / 100);
			var this_top = parseInt(wH * getRandomInt(0, 100) / 100);
			var this_w = parseInt(wW * getRandomInt(6, 18) / 100);
			var this_h = parseInt(wH * getRandomInt(6, 18) / 100);
			var this_skyBlue = {
				x: this_left,
				y: this_top,
				width: this_w,
				height: this_h
			};
			skyElement_arr['blue'].push(this_skyBlue);
		}
		
		for(j = 0; j < white_count; j++)
		{
			var this_left = parseInt(wW * getRandomInt(0, 100) / 100);
			var this_top = parseInt(wH * getRandomInt(0, 100) / 100);
			var this_w = parseInt(wW * getRandomInt(3, 15) / 100);
			var this_h = parseInt(wH * getRandomInt(3, 15) / 100);
			var this_skyWhite = {
				x: this_left,
				y: this_top,
				width: this_w,
				height: this_h
			};
			skyElement_arr['white'].push(this_skyWhite);
		}

		class skyElement{
			constructor( x, y, width, height){
				this.x = x
    			this.y = y
    			this.width = width
    			this.height = height
			}
			print(){
				const {
					x, y, width, height
			    } = this
			    ctx.beginPath();
				ctx.ellipse(x, y, width, height, 0, 0, 2 * Math.PI);
				ctx.fill();
			}
		}
		start();
		function start(){
			ctx.fillStyle = "rgba(170, 220, 255, .85)";
			for(i = 0; i < blue_count; i++)
			{
				var this_skyElement = new skyElement(
					skyElement_arr['blue'][i]['x'], 
					skyElement_arr['blue'][i]['y'], 
					skyElement_arr['blue'][i]['width'],
					skyElement_arr['blue'][i]['height']
				);
				this_skyElement.print();
			}

			ctx.fillStyle = "rgba(255, 255, 255)";
			for(i = 0; i < white_count; i++)
			{
				var this_skyElement = new skyElement(
					skyElement_arr['white'][i]['x'], 
					skyElement_arr['white'][i]['y'], 
					skyElement_arr['white'][i]['width'],
					skyElement_arr['white'][i]['height']
				);
				this_skyElement.print();
			}
			setInterval(draw, 100);
		}
		
		function draw(){
			var ctx = document.getElementById('sky-canvas').getContext('2d');
			ctx.clearRect(0, 0, sSky_canvas.width, sSky_canvas.height);
			ctx.fillStyle = "rgba(170, 220, 255, .85)";
			for(i = 0; i < blue_count; i++)
			{
				skyElement_arr['blue'][i]['x'] = skyElement_arr['blue'][i]['x']-1;
				var this_skyElement = new skyElement(
					skyElement_arr['blue'][i]['x'], 
					skyElement_arr['blue'][i]['y'], 
					skyElement_arr['blue'][i]['width'],
					skyElement_arr['blue'][i]['height']
				);
				this_skyElement.print();
			}
			ctx.fillStyle = "rgba(255, 255, 255)";
			for(i = 0; i < white_count; i++)
			{
				skyElement_arr['white'][i]['x'] = skyElement_arr['white'][i]['x'] - 1;
				var this_skyElement = new skyElement(
					skyElement_arr['white'][i]['x'], 
					skyElement_arr['white'][i]['y'], 
					skyElement_arr['white'][i]['width'],
					skyElement_arr['white'][i]['height']
				);
				this_skyElement.print();
			}
		}
	}
	sSky_container.addEventListener('click', function(){
		blow(sSky_group, 5000);
	});
</script>