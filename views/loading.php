<?

?>

<div id="mask-loading" class="fullpage">
	<div id="loading-icon-holder">
		<svg id="loading-icon-1" class="loading-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:#A0A7AB;}
			</style>
			<polygon class="st0" points="17,9 15,9 15,7 13,7 13,5 11,5 11,3 11,1 9,1 9,3 9,5 9,5 7,5 7,7 5,7 5,9 3,9 1,9 1,11 3,11 5,11 
				5,13 7,13 7,15 9,15 9,17 9,19 11,19 11,17 11,15 13,15 13,13 15,13 15,11 17,11 19,11 19,9 "/>
		</svg>
		<svg id="loading-icon-2" class="loading-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:#A0A7AB;}
			</style>
			<g>
				<rect x="15" y="3" class="st0" width="2" height="2"/>
				<rect x="3" y="3" class="st0" width="2" height="2"/>
				<rect x="15" y="14.9" class="st0" width="2" height="2"/>
				<rect x="3" y="14.9" class="st0" width="2" height="2"/>
				<polygon class="st0" points="17,9 15,9 13,9 13,7 11,7 11,5 11,3.1 11,3 11,1.1 9,1.1 9,3 9,3.1 9,5 9,7 7,7 7,9 5,9 3,9 1,9 1,11 
					3,11 5,11 7,11 7,13 9,13 9,14.9 9,15 9,16.9 9,18.9 11,18.9 11,16.9 11,15 11,14.9 11,13 13,13 13,11 15,11 17,11 19,11 19,9 	"/>
			</g>
		</svg>
		<svg id="loading-icon-3" class="loading-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:#A0A7AB;}
			</style>
			<rect x="17" y="1" class="st0" width="2" height="2"/>
			<rect x="1" y="1" class="st0" width="2" height="2"/>
			<rect x="17" y="16.9" class="st0" width="2" height="2"/>
			<rect x="1" y="16.9" class="st0" width="2" height="2"/>
			<rect x="9" y="9" class="st0" width="2" height="2"/>
			<g>
				<rect x="9" y="1.1" class="st0" width="2" height="5.9"/>
				<polygon class="st0" points="7,9 5,9 3,9 1,9 1,11 3,11 5,11 7,11 	"/>
				<polygon class="st0" points="9,13 9,14.9 9,15 9,16.9 9,18.9 11,18.9 11,16.9 11,15 11,14.9 11,13 	"/>
				<polygon class="st0" points="17,9 15,9 13,9 13,11 15,11 17,11 19,11 19,9 	"/>
			</g>
		</svg>
		<svg id="loading-icon-4" class="loading-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
			<style type="text/css">
				.st0{fill:#A0A7AB;}
			</style>
			<rect x="17" y="1" class="st0" width="2" height="2"/>
			<rect x="1" y="1" class="st0" width="2" height="2"/>
			<rect x="17" y="16.9" class="st0" width="2" height="2"/>
			<rect x="1" y="16.9" class="st0" width="2" height="2"/>
			<rect x="9" y="9" class="st0" width="2" height="2"/>
		</svg>
	</div>
</div>

<style>
#mask-loading
{
    background-color: rgba(0,0,0,.75);
    visibility: hidden;
    opacity: 0;
    z-index: 950;
    -webkit-transition: opacity .5s;
       -moz-transition: opacity .5s;
         -o-transition: opacity .5s;
            transition: opacity .5s;
}
body.fadeout #mask
{
    visibility: initial;
    opacity: 1;
    -webkit-transition: opacity .35s;
       -moz-transition: opacity .35s;
         -o-transition: opacity .35s;
            transition: opacity .35s;
}
body.loading #mask-loading
{
    visibility: initial;
    opacity: 1;
    -webkit-transition: none;
       -moz-transition: none;
         -o-transition: none;
            transition: none;
}
.loading-icon
{
	width: 100%;
	display: none;
}
#loading-icon-1
{
	display: block;
}
#loading-icon-holder
{
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
       -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
         -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    display: none;
    transform-origin: center;
}
.loading #loading-icon-holder
{
    display: block;
}
</style>
<script>
	var sLoading_icon = document.querySelectorAll('#loading-icon-holder .loading-icon');
	var loading_icon_count = sLoading_icon.length;
	var loading_timer = false;
	var loading_counter = 0;
	// loading_timer = setInterval(function(){
	// 	sLoading_icon[loading_counter].style.display = 'none';
	// 	loading_counter = (loading_counter+1)%loading_icon_count;
	// 	sLoading_icon[loading_counter].style.display = 'block';
	// }, 250);
	loading_timer = animateLoadingIcons(sLoading_icon);
	function animateLoadingIcons(icons){
		var count = icons.length;
		var counter = 0;
		return setInterval(function(){
			icons[counter].style.display = 'none';
			counter = (counter+1)%count;
			icons[counter].style.display = 'block';
		}, 250);
	}
	function removeLoading(){
		if(body.classList.contains('loading'))
		{
			body.classList.remove('loading');
			setTimeout(function(){
				var fade = document.getElementsByClassName('fade');
				while(fade.length > 0)
					fade[0].classList.remove('fade');
			}, 750);
		}
	}
	window.addEventListener('load', function(){ 
		<? if($isHome) { ?>
			
				var sLanding_video_container = document.getElementById('landing-video-container');
				if(sLanding_video_container != undefined){			
					setTimeout(function(){
						sLanding_video = sLanding_video_container.querySelector('video');
						if(wW >= wH)
							resizeSizeToCover(sLanding_video, sLanding_video_container);
						sLanding_video.play();
					}, 250);
				}
		<? } ?>
		clearInterval(loading_timer);
		removeLoading(); 
	});
</script>
