<?
	$tag_hidden = '[hidden]';
	$media = $oo->media($item['id']);
	$feature = false;
	$poster = false;
	foreach($media as $m)
	{
		if(strpos($m['caption'], $tag_hidden) === false){
			if($m['type'] == 'mp4' || $m['type'] == 'wav' || $m['type'] == 'mov')
				$feature = $m;
			else if( strtolower($m['type']) == 'jpg' || strtolower($m['type']) == 'png' || strtolower($m['type']) == 'git')
				$poster = '/media/' . m_pad($m['id']) . '.' . $m['type'];
		}
	}

	$tag_thumbnail = '[thumbnail]';
	$images_arr = array();

	$children = $oo->children($item['id']);
	foreach($children as $key => &$child)
	{
		if(substr($child['name1'], 0, 1) == '.')
			unset($children[$key]);
		else
		{
			$media = $oo->media($child['id']);
			$thumbnail = false;
			$thumbnail_alt = false;
			if(count($media) > 0)
			{
				foreach( $media as $m ){
					if(strpos($m['caption'], $tag_hidden) === false ){
						$thumbnail = m_url($m);
						$thumbnail_alt = substr($m['caption'], strpos($m['caption'], $tag_thumbnail) + strlen($tag_thumbnail));
						$thumbnail_alt = empty($thumbnail_alt) ? 'Thumbnail of '.$child['name1'] : $thumbnail_alt;
					}
				}
				$images_arr[] = $thumbnail;
			}
			$child['thumbnail'] = $thumbnail;
			$child['thumbnail_alt'] = $thumbnail_alt;
		}
	}
	unset($child);
?>
<main id="season-lobby-container" class="container main-container">
	<? if(count($children) > 0){
		?>
		<div id="looks-container" class="slideshow-container horizontal-slideshow-container">
			<div id="slideshow-carrier">
			<div class="hidden"><?
		$children_count = count($children) > 10 ? count($children) : '0' . count($children);
		foreach($children as $key => $child)
		{
			$url = implode('/', $uri) . '/' . $child['url'];
			$blink_count = rand(4, 7);
			$idx = ($key+1) >= 10 ? $key+1 : '0' . ($key+1);
			$thumbnail = $child['thumbnail'];
			$thumbnail_alt = $child['thumbnail_alt'];
			if($key == count($children) - 1)
				$class .= 'last-look';
			?></div><div <?= $key == count($children) - 1 ? 'id="last-look"' : ''; ?> class="look blink-hover-zone random-blink-hover-zone">
				<? for($i = 0; $i < $blink_count ; $i++){
					?><span class="blink-container random-blink-container"></span><?
				} ?><a class="look-link" href="<?= $url; ?>"><?
				if($thumbnail)
				{
					?><img class="look-image thumbnail" src="<?= $thumbnail; ?>" alt="<?= $thumbnail_alt; ?>"><?
				}
				else
				{
					?><p><?= $child['name1']; ?></p><?
				}
				?><p class="look-idx"><?= $idx; ?> / <?= $children_count; ?></p><?
			?></a><?
		}
		?></div></div></div>
			<div class="slideshow-control-container">
				<div id = "prev" class="slideshow-control-element"></div>
				<div id = "next" class="slideshow-control-element"></div>
			</div>
		</div><?
	} ?>
	<? if($feature){
		?><figure id="feature-video-container" data-fullscreen="false">
			<video id="feature-video" muted loop buffered playsinline controls <?= $poster ? 'poster="' .  $poster . '"' : ''; ?> >
				<source src="<?= m_url($feature); ?>" type="video/<?= $feature['type']; ?>">
				Your browser doesn't support HTML 5 video.
			</video>
			<div id="video-controls" data-state="hidden">
				<button id="playpause" class="video-controls-btn" type="button" data-state="play">
					<svg version="1.1" id="play-graphic" class="video-controls-graphic playpause-graphic" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
	 					<title>Play the video</title>
						<style type="text/css">
							.st0{fill:#A0A7AB;}
						</style>
						<polygon class="st0" points="17,9 17,8 15,8 15,7 13,7 13,6 11,6 11,5 9,5 9,4 7,4 7,3 5,3 5,2 3,2 3,1 1,1 1,19 3,19 3,18 5,18 
							5,17 7,17 7,16 9,16 9,15 11,15 11,14 13,14 13,13 15,13 15,12 17,12 17,11 19,11 19,9 "/>
					</svg>
					<svg version="1.1" id="pause-graphic" class="video-controls-graphic playpause-graphic" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
	 					<title>Pause the video</title>
						<style type="text/css">
							.st0{fill:#A0A7AB;}
						</style>
						<g>
							<rect x="4" y="2" class="st0" width="4" height="16"/>
							<rect x="12" y="2" class="st0" width="4" height="16"/>
						</g>
					</svg>
			   </button>
			   <div id="progress-container">
			      <progress id="progress" value="0" min="0">
			         <span id="progress-bar"></span>
			      </progress>
			   </div>
			   <button id="fs" class="video-controls-btn" type="button" data-state="go-fullscreen">
			   	<svg version="1.1" id="fullscreen-graphic" class="video-controls-graphic" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
		   		<title>Toggle fullscreen</title>
				<style type="text/css">
					.st0{fill:#A0A7AB;}
				</style>
				<path class="st0" d="M7,13H5v2h2V13z M9,11H7v2h2V11z M11,9H9v2h2V9z M13,7h-2v2h2V7z M15,5h-2v2h2V5z M7,7V5H5v2H7z M9,9V7H7v2H9z
					 M11,11V9H9v2H11z M13,13v-2h-2v2H13z M15,15v-2h-2v2H15z M8,17v2H3H1v-2v-5h2v5H8z M19,12v5v2h-2h-5v-2h5v-5H19z M8,3H3v5H1V3V1h2
					h5V3z M19,1v2v5h-2V3h-5V1h5H19z"/>
				</svg>
			   </button>
			</div>
			<div id="video-controls-mask" data-state=""></div>
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
		</figure><?
	} ?>
</main>
<style>
.horizontal-slideshow-container
{
    -webkit-overflow-scrolling: touch;
    overflow-x: auto;
}
.horizontal-slideshow-container::-webkit-scrollbar {
    display: none;
}
#slideshow-carrier
{
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
    display: flex;
    -webkit-flex-wrap: nowrap;
	   -moz-flex-wrap: nowrap;
	    -ms-flex-wrap: nowrap;
	     -o-flex-wrap: nowrap;
	        flex-wrap: nowrap;
    /*overflow-y: hidden; */
}
#looks-container
{
    border-bottom: 1px solid var(--light-grey);
    border-top: 1px solid var(--light-grey);
    font-family: ibm_plex_mono, sans-serif;

}
.look
{
    vertical-align: middle;
    width: 57vw;
    -webkit-box-flex: 0 0 auto;
    -webkit-flex: 0 0 auto;
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
    border-right: 1px solid var(--light-grey);
    padding: 20px 0;
    overflow: hidden;
}
#last-look
{
    border-right: none;
}
.look-link
{
    display: block;
}
.look-image
{
	display: block;
    opacity: 1;
    -webkit-transition: opacity .75s;
       -moz-transition: opacity .75s;
         -o-transition: opacity .75s;
            transition: opacity .75s;
}
body.loading .look img{
    opacity: 0;
}
.noTouchScreen .look:hover
{
    background-color: var(--sky-blue);
}
.noTouchScreen .look:hover a
{
    color: #000;
}
.look-idx
{
    text-align: center;
    padding: 20px 20px 0 20px;
}
.slideshow-control-container
{
    padding: 10px 20px;
    text-align: right;
}
.slideshow-control-element
{
    width: 40px;
    height: 40px;
    background-image: url(../../media/svg/arrow_1.svg);
    background-size: 40px 40px;
    background-position: center;
    background-repeat: no-repeat;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    display: inline-block;
    margin-left: 20px;
}
.noTouchScreen .slideshow-control-element:hover
{
    border-bottom: 2px solid var(--light-grey);
    -webkit-animation: arrow_next .75s infinite linear;
    animation: arrow_next .75s infinite linear;
}

#prev
{
    transform-origin: center;
    -webkit-transform: scale(-1, 1);
       -moz-transform: scale(-1, 1);
        -ms-transform: scale(-1, 1);
         -o-transform: scale(-1, 1);
            transform: scale(-1, 1);
    /*float: left;*/
}
#video-controls
{
	padding: 10px;
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
    display: flex;
	margin-top: -44px;
	
}
#video-controls[data-state=hidden] {
	pointer-events: none;
	-webkit-transition: opacity .35s;
       -moz-transition: opacity .35s;
         -o-transition: opacity .35s;
            transition: opacity .35s;
	opacity: 0;
}
#video-controls:after
{
	content: ' ';
	display: block;
	clear: both;
	height: 0;
}
.video-controls-btn {
   border:none;
   cursor:pointer;
   background:transparent;
   background-size:contain;
   background-repeat:no-repeat;
}
#playpause
{
	width: 24px;
	height: 24px;
	position: absolute;
	top: 50%;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
       -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
         -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
	z-index: 10;
}

.playpause-graphic
{
	display: none;
}
#playpause[data-state="play"] #play-graphic
{
	display: block;
}

#playpause[data-state="pause"] #pause-graphic
{
	display: block;
}
#progress-container
{
	position: relative;
	padding: 8px 15px 0 15px;
	-webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
	flex: 1;
	z-index: 10;
}
#progress {
   display:block;
   width:100%;
   height:6px;
   margin-top:0.125rem;
   color:#000;
   background-color: #000;
   cursor: pointer;
}
#progress[data-state="fake"] {
   background:var(--light-grey);
   height:20px;
}
#progress-bar {
   width:0%;
   height:100%;
   display:inline-block;
   background-color:#000;
}
#progress-bar:after
{
	display: block;
	content: " ";
	position: absolute;
	width: 12px;
	height: 10px;
	background-color: #fff;
}
#progress::-moz-progress-bar {
   background-color:var(--light-grey);
}
#progress::-webkit-progress-bar { 
	background: #000; 
}
#progress::-webkit-progress-value {
   background-color:var(--light-grey);
}
#feature-video-container
{
	position: relative;
}
#fs
{
	position: relative;
	z-index: 10;
	width: 24px;
	height: 24px;
}
.video-controls-graphic:hover .st0
{
	fill: var(--sky-blue);
}
#video-controls-mask
{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, .65);
	z-index: 5;
	-webkit-transition: opacity .35s;
       -moz-transition: opacity .35s;
         -o-transition: opacity .35s;
            transition: opacity .35s;
	pointer-events: none;
}
#video-controls-mask[data-state="hidden"]
{

	/*visibility: hidden;*/
	opacity: 0;
}
#loading-icon-holder
{
	display: none;
	position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
       -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
         -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
    width: 20px;
    height: 20px;
    transform-origin: center;
}
.preplay #loading-icon-holder
{
	display: block;
}
@media screen and (min-width: 768px) {
	#progress
	{
		height: 4px;
	}
	#playpause
	{
		width: 40px;
		height: 40px;
	}
	#fs
	{
		margin-right: 10px;
	}
	#video-controls
	{
		margin-top: -48px;

	}
	#progress-container
	{
		padding-top: 9px;
	}
    .look
    {
        width: 30vw;
        padding: 20px 10px;
    }
}
@media screen and (min-width: 1100px) {

    .look
    {
        width: 22vw;
    }
}
</style>
<script>
	var images_arr = <?= json_encode($images_arr); ?>;
	if(images_arr.length != 0)
		preloadImage(images_arr, removeLoading);
	var sHorizontal_slideshow_container = document.getElementsByClassName('horizontal-slideshow-container')[0];
	var next = document.getElementById('next');
	var prev = document.getElementById('prev');
	var horizontal_slideshow_interval = document.getElementsByClassName('look')[0].offsetWidth;
	var sSlideshow_carrier = document.getElementById('slideshow-carrier');
	var current_slideshow_x = sHorizontal_slideshow_container.scrollLeft;
	var current_slideshow_idx = parseInt(current_slideshow_x / horizontal_slideshow_interval);
	var slides_count = <?= $children_count; ?>;
	var isIos = iOS();

	next.addEventListener('click', function(){
		current_slideshow_idx = next_slide(sHorizontal_slideshow_container, horizontal_slideshow_interval, slides_count);
	});
	prev.addEventListener('click', function(){
		current_slideshow_idx = prev_slide(sHorizontal_slideshow_container, horizontal_slideshow_interval);
	});

	function init_horizontal_slideshow(){
		horizontal_slideshow_interval = document.getElementsByClassName('look')[0].innerWidth;
	}
	function next_slide(slideshow_container, interval, max_count){
		var idx = (parseInt(slideshow_container.scrollLeft / interval) + 1);
		if(idx > max_count - 1)
		{
			idx = max_count - 1;
		}
		else
		{
			var slideshow_x = idx * interval;
			var amount = slideshow_x - slideshow_container.scrollLeft;
			SmoothHorizontalScrolling(slideshow_container, 250, amount, slideshow_container.scrollLeft);
		}
		return idx;
	}
	function prev_slide(slideshow_container, interval, max_count=false){
		var idx = (parseInt((slideshow_container.scrollLeft-5) / interval));
		if(idx < 0)
		{
			idx = 0;
		}
		else
		{
			current_slideshow_x = idx * interval;
			var amount = current_slideshow_x - slideshow_container.scrollLeft;
			SmoothHorizontalScrolling(slideshow_container, 250, amount, slideshow_container.scrollLeft);
		}
	}
	function SmoothHorizontalScrolling(e, time, amount, start) {
	    var eAmt = amount / 100;
	    var curTime = 0;
	    var scrollCounter = 0;
	    while (curTime <= time) {
	        window.setTimeout(SHS_B, curTime, e, scrollCounter, eAmt, start);
	        curTime += time / 100;
	        scrollCounter++;
	    }
	}

	var videoContainer = document.getElementById('feature-video-container');
	var video = document.getElementById('feature-video');
	var videoControls = document.getElementById('video-controls');
	var playpause = document.getElementById('playpause');
	var mute = document.getElementById('mute');
	var stop = document.getElementById('stop');
	var progress = document.getElementById('progress');
	var progressBar = document.getElementById('progress-bar');
	var fullscreen = document.getElementById('fs');
	var videoControlsMask = document.getElementById('video-controls-mask');
	var videoControls_timer = null;
	var hasPlayed = false;

	
	videoControls.setAttribute('data-state', 'visible');
	video.removeAttribute('controls');
	var supportsProgress = (document.createElement('progress').max !== undefined);
	if (!supportsProgress) progress.setAttribute('data-state', 'fake');
	

	window.addEventListener('load', function(){
		var fullScreenEnabled = !!(document.fullscreenEnabled || document.mozFullScreenEnabled || document.msFullscreenEnabled || document.webkitSupportsFullscreen || document.webkitFullscreenEnabled || document.createElement('video').webkitRequestFullScreen || video.webkitSupportsFullscreen);
		if (!fullScreenEnabled)
			fullscreen.style.display = 'none';
	});

	
	var changeButtonState = function(type) {
	   // Play/Pause button
	   if (type == 'playpause') {
	      if (video.paused || video.ended) {
	         playpause.setAttribute('data-state', 'play');
	      }
	      else {
	         playpause.setAttribute('data-state', 'pause');
	      }
	   }
	}
	video.addEventListener('play', function() {
		if(!hasPlayed) {
			hasPlayed = true;
			videoContainer.classList.remove('preplay');
		}
		changeButtonState('playpause');
	}, false);
	video.addEventListener('pause', function() {
	   changeButtonState('playpause');
	}, false);
	playpause.addEventListener('click', function(e) {
		if(!hasPlayed)
			videoContainer.classList.add('preplay');
		if (video.paused || video.ended){
			video.play();
			toggleVideoControls(videoControls, videoControlsMask);
		} 
		else{
			video.pause();
			toggleVideoControls(videoControls, videoControlsMask, 1000);
		} 
		
	});
	progress.addEventListener('click', function(e) {
		var pos = (e.pageX  - (this.offsetLeft + this.offsetParent.offsetLeft)) / this.offsetWidth;
		video.currentTime = pos * video.duration;
	});
	fullscreen.addEventListener('click', function(e) {
		handleFullscreen();
	});
	var handleFullscreen = function() {
		if (isFullScreen()) {
			if (video.webkitSupportsFullscreen) video.webkitExitFullscreen();
			else if (document.exitFullscreen) document.exitFullscreen();
			else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
			else if (document.webkitCancelFullScreen) document.webkitCancelFullScreen();
			else if (document.msExitFullscreen) document.msExitFullscreen();
			setFullscreenData(false);
		}
		else {
			if (video.webkitSupportsFullscreen) video.webkitEnterFullscreen();
			else if (videoContainer.requestFullscreen) videoContainer.requestFullscreen();
			else if (videoContainer.mozRequestFullScreen) videoContainer.mozRequestFullScreen();
			else if (videoContainer.webkitRequestFullScreen) videoContainer.webkitRequestFullScreen();
			else if (videoContainer.msRequestFullscreen) videoContainer.msRequestFullscreen();
			setFullscreenData(true);
		}
	}
	function toggleFullscreen() {
		if(video.requestFullScreen){
			video.requestFullScreen();
		} else if(video.webkitRequestFullScreen){
			video.webkitRequestFullScreen();
		} else if(video.mozRequestFullScreen){
			video.mozRequestFullScreen();
		}
	}
	var isFullScreen = function() {
		return !!(document.fullscreen || document.webkitIsFullScreen || document.mozFullScreen || document.msFullscreenElement || document.fullscreenElement || video.webkitDisplayingFullscreen);
	}
	var setFullscreenData = function(state) {
		videoContainer.setAttribute('data-fullscreen', !!state);
		toggleVideoControls(videoControls, videoControlsMask, 1000);
	}
	document.addEventListener('fullscreenchange', function(e) {
		setFullscreenData(!!(document.fullscreen || document.fullscreenElement));
	});
	document.addEventListener('webkitfullscreenchange', function() {
		setFullscreenData(!!document.webkitIsFullScreen);
	});
	document.addEventListener('mozfullscreenchange', function() {
		setFullscreenData(!!document.mozFullScreen);
	});
	document.addEventListener('msfullscreenchange', function() {
		setFullscreenData(!!document.msFullscreenElement);
	});
	video.addEventListener('timeupdate', function() {
		if (!progress.getAttribute('max')) progress.setAttribute('max', video.duration);
		progress.value = video.currentTime;
		progressBar.style.width = Math.floor((video.currentTime / video.duration) * 100) + '%';
	});

	video.addEventListener('click', function(){
		if(video.played.length != 0)
		{
			toggleVideoControls(videoControls, videoControlsMask);
		}
	}, false);

	function toggleVideoControls(controls, mask, delay=false)
	{
		clearTimeout(videoControls_timer);
		if(!delay)
		{
			if(controls.getAttribute('data-state') == 'hidden'){
				controls.setAttribute('data-state', 'visible');
				mask.setAttribute('data-state', 'visible');
			}
			else if(controls.getAttribute('data-state') == 'visible'){
				controls.setAttribute('data-state', 'hidden');
				mask.setAttribute('data-state', 'hidden');
			}
		}
		else
		{
			videoControls_timer = setTimeout(function(){
				if(controls.getAttribute('data-state') == 'hidden'){
					controls.setAttribute('data-state', 'visible');
					mask.setAttribute('data-state', 'visible');
				}
				else if(controls.getAttribute('data-state') == 'visible'){
					controls.setAttribute('data-state', 'hidden');
					mask.setAttribute('data-state', 'hidden');
				}
			}, delay);
		}
		
	}
	function iOS() {
	  return [
	    'iPad Simulator',
	    'iPhone Simulator',
	    'iPod Simulator',
	    'iPad',
	    'iPhone',
	    'iPod'
	  ].includes(navigator.platform)
	  // iPad on iOS 13 detection
	  || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
	}
</script>
