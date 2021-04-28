var wW_pre = wW;
var wH_pre = wH;

window.addEventListener('resize', function(){
	
	wW_pre = wW;
	wH_pre = wH;
	wW = window.innerWidth;
	wH = window.innerHeight;

	if(wW < critical_w_menu){
		if(!isOnePageMenu)
			isOnePageMenu = true;
	}
	else{
		if(isOnePageMenu)
		{
			isOnePageMenu = false;
			var sSubmenu_parent_expanded = document.querySelectorAll('.submenu-parent.expanded');
			if(sSubmenu_parent_expanded.length != 0)
			{
				[].forEach.call(sSubmenu_parent_expanded, function(el, i){
					el.classList.remove('expanded');
				});
			}
		}
	}
});