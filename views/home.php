<?
	$blue_count = 7;
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
						$w = rand(20, 200);
						$h = rand(20, 200);
						$left = rand(0, 100);
						$top = rand(0, 100);
						$size[] = array('w' => $w, 'h' => $h);
						$style="width:".$w."px;height:".$h."px;top:".$top."vh;left:".$left."vw;"; 

						?><div class="sky-element sky-blue" style="<?= $style; ?>"></div><?
					}
					for($j = 0; $j < $white_count; $j++)
					{
						$w = rand(60, 200);
						$h = rand(60, 200);
						$left = rand(0, 100);
						$top = rand(0, 100);
						$size[] = array('w' => $w, 'h' => $h);
						$style="width:".$w."px;height:".$h."px;top:".$top."vh;left:".$left."vw;"; 

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
	var float_min = 5;
	var float_max = 10;
	var float_maxmin = float_max - float_min;
	var speed = 10;
	
	[].forEach.call(sSky_group, function(el, i){
		el.style.transform = 'translate3d(5px, 7px, 0)';
	});
	
	sSky_container.addEventListener('mouseover', function(){
		if(!isFloating)
		{
			isFloating = true;
			[].forEach.call(sSky_group, function(el, i){
				direction = getRandomInt(0, 3);
				duration = parseInt(10*(float_maxmin * Math.random())) / 10 + float_min;
				el.style.transition = 'transform '+duration+'s';
				var style = window.getComputedStyle(el);
				var matrix = new WebKitCSSMatrix(style.transform);
				
				var x = matrix.m41;
				var y = matrix.m42;
				// console.log(x, y);
				var distance = duration * speed;
				// console.log(distance);
				
				if(direction == 0){
					var this_transform = 'translate3d('+x+'px,'+(y+distance)+'px,0)';
				}
				else if(direction == 1){
					var this_transform = 'translate3d('+(x+distance)+'px,'+y+'px,0)';
				}
				else if(direction == 2){
					var this_transform = 'translate3d('+x+'px,'+(y-distance)+'px,0)';
				}
				else if(direction == 3){
					var this_transform = 'translate3d('+(x-distance)+'px,'+y+'px,0)';
				}
			 	el.style.transform = this_transform;
			});
			setTimeout(()=>isFloating = false, 5000);
		}
	});
	// [].forEach.call(sSky_blue, function(el, i){
	// 	 direction = getRandomInt(0, 3)
	// 	 if(direction == 0)
	// 	 	el.style.transform = parseInt(el.style.top) + 1 + 'px';
	// 	 else if(direction == 1)
	// 	 	el.style.left = parseInt(el.style.left) + 1 + 'px';
	// 	 else if(direction == 2)
	// 	 	el.style.top = parseInt(el.style.top) - 1 + 'px';
	// 	 else if(direction == 3)
	// 	 	el.style.left = parseInt(el.style.left) - 1 + 'px';
	// });
	var style = window.getComputedStyle(sSky_blue[0]);
	var matrix = new WebKitCSSMatrix(style.transform);
	console.log(matrix);
</script>