var wW_pre = wW;
var wH_pre = wH;

window.addEventListener('resize', function(){
	
	
	setTimeout(function(){
		if(window.innerWidth == wW && window.innerHeight == wH)
		{
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
					body.classList.remove('viewing-menu');
				}
			}
		}
		else
		{
			wW = window.innerWidth;
			wH = window.innerHeight;
		}
	}, 250);
	
});