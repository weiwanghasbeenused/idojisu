var sBlinking_container = document.getElementsByClassName('blink-container');
if(sBlinking_container.length != 0 )
{
	var delay_range = [0, 100];
	[].forEach.call(sBlinking_container, function(el, i){
		var isDelay = false;
		if(el.getAttribute('isDelay') == '1'){
			isDelay = true;
		}
		var this_blink = document.createElement('DIV');
		this_blink.className = 'blink';
		el.appendChild(this_blink);
	});
	
}

var sRandom_blink_hover_zone = document.getElementsByClassName('random-blink-hover-zone');



if(sRandom_blink_hover_zone.length != 0)
{
	var padding = 20;
	var blink_container_w = 50;
	var blink_container_h = 20;
	var rect_dev_x = 0.3;
	var rect_dev_y = 0.4;
	window.addEventListener('load', function(){
		[].forEach.call(sRandom_blink_hover_zone, function(el, i){
			var this_blink_container = el.querySelectorAll('.blink-container');
			var rect_w = el.offsetWidth - 2 * padding - blink_container_w;
			var rect_h = el.offsetHeight - 2 * padding - blink_container_h;
			el.addEventListener('mouseenter', function(){
				if(el.classList.contains('look'))
				{
					[].forEach.call(this_blink_container, function(e, j){
						var this_left = padding + rect_w * Math.random();
						var this_top = padding + rect_h * Math.random();
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
				else
				{
					[].forEach.call(this_blink_container, function(e, j){
						var this_left = padding + (el.offsetWidth - 2*padding) * Math.random();
						var this_top = padding + (el.offsetHeight - 2*padding) * Math.random();
						e.style.left = this_left + 'px';
						e.style.top = this_top + 'px';
					});
				}
			});
		});
	});
}