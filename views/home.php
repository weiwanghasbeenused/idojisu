<?
	$blue_count = 8;
	$white_count = 2;
	$group_count = 6;
	$size = array();
?>

<main>
	<div id="sky-container">
		<?
			for($i = 0; $i < $group_count; $i++)
			{
				?><div class="sky-group">
					<?
					for($j = 0; $j < $blue_count; $j++)
					{
						$w = rand(6, 18);
						$h = rand(6, 18);
						$left = rand(0, 100);
						$top = rand(0, 100);
						$size[] = array('w' => $w, 'h' => $h);
						$style="width:".$w."%;height:".$h."%;top:".$top."vh;left:".$left."vw;"; 

						?><div class="sky-element sky-blue" style="<?= $style; ?>"></div><?
					}
					for($j = 0; $j < $white_count; $j++)
					{
						$w = rand(5, 18);
						$h = rand(5, 18);
						$left = rand(0, 100);
						$top = rand(0, 100);
						$size[] = array('w' => $w, 'h' => $h);
						$style="width:".$w."%;height:".$h."%;top:".$top."vh;left:".$left."vw;"; 

						?><div class="sky-element sky-white" style="<?= $style; ?>"></div><?
					}
					?>
				</div><?
			}
			
		?>
	</div>
	<!-- <div id="landing-video-container">
		<video muted autoplay>
			<source src="">
		</video>
	</div> -->
</main>
<script>
	var sSky_blue = document.getElementsByClassName('sky-blue');
	var sSky_white = document.getElementsByClassName('sky-white');
	var sSky_container = document.getElementById('sky-container');
	var sSky_group = document.getElementsByClassName('sky-group');
	var direction;
	var isFloating = false;
	var float_min = 10;
	var float_max = 15;
	var float_maxmin = float_max - float_min;
	var speed = 8;
	var sky_timer;
	
	[].forEach.call(sSky_group, function(el, i){
		el.style.transform = 'translate3d(0, 0, 0)';
	});
	
	sSky_container.addEventListener('mouseover', function(){
		if(!isFloating)
		{
			isFloating = true;
			
		}
	});

	
	wind(sSky_group, 5000);

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
</script>