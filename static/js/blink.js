var sBlinking_container = document.getElementsByClassName('blink-container');
if(sBlinking_container.length != 0 )
{
	var delay_range = [0, 100];
	[].forEach.call(sBlinking_container, function(el, i){
		var isDelay = false;
		if(el.getAttribute('isDelay') == '1')
			isDelay = true;
		var this_blink = document.createElement('DIV');
		this_blink.className = 'blink';
		el.appendChild(this_blink);
	});
}
var sRandom_blink_hover_zone = document.getElementsByClassName('random-blink-hover-zone');
if(sRandom_blink_hover_zone.length != 0)
{
	if( document.querySelector('.random-blink-hover-zone.look') != null )
	{
		var padding = 20;
		var blink_container_w = 50;
		var blink_container_h = 20;
		var rect_dev_x = 0.3;
		var rect_dev_y = 0.4;
	}
	if( document.querySelector('.random-blink-hover-zone#logo') != null ){
		var positions = [
			[[-10, -20], [-5, -17], [7, -22], [15, -24]],
			[[-15, -15], [-2, -14], [-5, -22], [10, -30]],
			[[7, -24], [-16, -14], [20, -34], [30, -20]],
			[[27, -20], [7, -12], [-8, -18], [-8, -20]],
			[[40, -30], [-26, -5], [14, -24], [5, -26]],
			[[5, -24], [-4, -15], [50, -30], [-18, -15]],
			[[-20, -18], [27, -18], [40, -36], [60, -20]],
			[[67, -26], [12, -20], [68, -32], [17, -17]]
		];
		var position_index_keep = [false, false];
		var position_index = parseInt(positions.length * Math.random());
	}
	window.addEventListener('load', function(){
		[].forEach.call(sRandom_blink_hover_zone, function(el, i){
			var this_blink_container = el.querySelectorAll('.blink-container');
			var rect_w = el.offsetWidth - 2 * padding - blink_container_w;
			var rect_h = el.offsetHeight - 2 * padding - blink_container_h;
			el.addEventListener('mouseenter', function(){
				if(el.classList.contains('look'))
				{
					[].forEach.call(this_blink_container, function(e, j){
						var this_left = parseInt(padding + rect_w * Math.random());
						var this_top = parseInt(padding + rect_h * Math.random());
						if(j == 0)
						{
							this_left = this_left * rect_dev_x;
							this_top = this_top * rect_dev_y;
						}
						else if(j == 1)
						{
							this_left = padding + rect_w - (this_left  * rect_dev_x);
							this_top = this_top * rect_dev_y;
						}
						else if(j == 2)
						{
							this_left = this_left * rect_dev_x;
							this_top =  padding + rect_h - (this_top * rect_dev_y);
						}
						else if(j == 3)
						{
							this_left = padding + rect_w - (this_left  * rect_dev_x);
							this_top = padding + rect_h - (this_top * rect_dev_y);
						}
						e.style.left = this_left + 'px';
						e.style.top = this_top + 'px';
					});
				}
				else if(el.id == 'logo')
				{
					
					while( position_index_keep.includes(position_index) )
						position_index = parseInt(positions.length * Math.random());
					position_index_keep.push(position_index);
					position_index_keep.shift();
					var this_position = positions[position_index];
					[].forEach.call(this_blink_container, function(e, j){
						if(j == 0)
						{
							e.style.left = this_position[j][0] + 'px';
							e.style.top  = this_position[j][1] + 'px';
						}
						else if(j == 1)
						{
							e.style.right = this_position[j][0] + 'px';
							e.style.top   = this_position[j][1] + 'px';
						}
						else if(j == 2)
						{
							e.style.right = this_position[j][0] + 'px';
							e.style.bottom   = this_position[j][1] + 'px';
						}
						else
						{
							e.style.left = this_position[j][0] + 'px';
							e.style.bottom   = this_position[j][1] + 'px';
						}
					});
				}
			});
		});
	});
}