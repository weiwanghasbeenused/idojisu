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
	$group_count = 4;
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
				<svg width="100vw" height="100vh">
					<!-- <defs>
						<filter id="filterblur" x="-150%" y="-150%" width="400%" height="400%">
							<feGaussianBlur in="SourceGraphic" stdDeviation="50" />
						</filter>
					</defs> -->
				<?
				for($i = 0; $i < $group_count; $i++)
				{

					$direction = rand(0, 3);
					if($direction == 0){
						$this_translate = 'translate(' . $distance . ', 0)';
					}
					else if($direction == 1){
						$this_translate = 'translate(0, ' . $distance . ')';
					}
					else if($direction == 2){
						$this_translate = 'translate(' . -$distance . ', 0)';
					}
					else if($direction == 3){
						$this_translate = 'translate(0, ' . -$distance . ')';
					}
					?><g id="sky-group-<?= $i; ?>" transform="translate(0, 0)" class="sky-group">
						<?
						$color = 'rgba(170, 220, 255, .85)';
						for($j = 0; $j < $blue_count; $j++)
						{
							$w = rand(6, 18)/2;
							$h = rand(6, 18)/2;
							$left = rand(0, 100) - $w;
							$top = rand(0, 100) - $h;
							$style='rx="'.$w.'%" ry="'.$h.'%" cy="'.$top.'vh" cx="'.$left.'vw" fill="'.$color.'"';
							?><ellipse class="sky-element sky-blue" filter="" <?= $style; ?>/><?

						}
						$color = 'white';
						for($j = 0; $j < $white_count; $j++)
						{
							$w = rand(5, 18)/2;
							$h = rand(5, 18)/2;
							$left = rand(0, 100) - $w;
							$top = rand(0, 100) - $h;
							$style='rx="'.$w.'%" ry="'.$h.'%" cy="'.$top.'vh" cx="'.$left.'vw" fill="'.$color.'"'; 

							?><ellipse class="sky-element sky-white" filter="" <?= $style; ?> /><?
						}
					?></g>
					<?
				}
				?></svg><?
			}
			else if($useCanvas)
			{
				?><canvas id="sky-canvas"></canvas><?
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
			}			
		?>
	</div>
	<? if(isset($landing_video)){
		?>
		<div id="landing-video-container">
			<video muted autoplay>
				<source src="<?= m_url($landing_video); ?>" type="video/mp4">
				Your browser doesn't support HTML 5 video.
			</video>
			<div id="video-control"></div>
		</div>
		<?
	} ?>
	
</main>
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
	// var blue_count = <?= $blue_count; ?>;
	// var white_count = <?= $white_count; ?>;
	var group_count = <?= $group_count; ?>;
	var blue_count = 6;
	var white_count = 6;
	
	if(!useCanvas){
		[].forEach.call(sSky_group, function(el, i){
			el.style.transform = 'translate3d(0, 0, 0)';
		});
	}
	

	// wind(sSky_group, 5000);
	
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
			// var sSky_canvas = document.getElementById('sky-canvas');
			// var ctx = sSky_canvas.getContext('2d');
			// for(i = 0; i < group_count; i++)
			// {
			// 	console.log(blue_count);
			// 	ctx.fillStyle = "rgba(170, 220, 255, .85)";
			// 	for(j = 0; j < blue_count; j++)
			// 	{

			// 		var this_left = parseInt(wW * getRandomInt(0, 100) / 100);
			// 		var this_top = parseInt(wH * getRandomInt(0, 100) / 100);
			// 		var this_w = parseInt(wW * getRandomInt(6, 18) / 100);
			// 		var this_h = parseInt(wH * getRandomInt(6, 18) / 100);
			// 		ctx.beginPath();
			// 		ctx.ellipse(this_left, this_top, this_w, this_h, 0, 0, 2 * Math.PI);
			// 		ctx.fill();
			// 	}
				
			// 	ctx.fillStyle = "rgba(255, 255, 255, 1)";
			// 	for(j = 0; j < white_count; j++)
			// 	{
			// 		var this_left = parseInt(wW * getRandomInt(0, 100) / 100);
			// 		var this_top = parseInt(wH * getRandomInt(0, 100) / 100);
			// 		var this_w = parseInt(wW * getRandomInt(6, 18) / 100);
			// 		var this_h = parseInt(wH * getRandomInt(6, 18) / 100);
			// 		ctx.beginPath();
			// 		ctx.ellipse(this_left, this_top, this_w, this_h, 0, 0, 2 * Math.PI);
			// 		ctx.fill();
			// 	}
			// }
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
			// window.requestAnimationFrame(draw);
		}
		
	}
	var sLanding_video_container = document.getElementById('landing-video-container');
	if(sLanding_video_container != undefined){
		sLanding_video = sLanding_video_container.querySelector('video');
		resizeSizeToCover(sLanding_video, sLanding_video_container);
	}
</script>