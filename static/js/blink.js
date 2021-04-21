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