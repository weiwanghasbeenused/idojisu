var wW_pre = wW;
var wH_pre = wH;
var resize_timer = null;

// homepage
var sLanding_video = false;
var sLanding_video_container = document.getElementById('landing-video-container');
if(sLanding_video_container != undefined)
	sLanding_video = sLanding_video_container.querySelector('video');
window.addEventListener('resize', function(){
	clearTimeout(resize_timer);
	resize_timer = setTimeout(function(){
		wW = window.innerWidth;
		wH = window.innerHeight;
		if(wW < critical_w_menu){
			if(!isMobileLayout)
				isMobileLayout = true;
		}
		else{
			if(isMobileLayout)
			{
				isMobileLayout = false;
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
		if(sLanding_video)
			resizeSizeToCover(sLanding_video, sLanding_video_container);
		
	}, 1000);
	
});