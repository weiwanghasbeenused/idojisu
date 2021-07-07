<?
	$home_id = end($oo->urls_to_ids(array('home')));
	$media = $oo->media($home_id);
	if(!empty($media))
	{
		foreach($media as $m)
		{
			if($m['type'] == 'mp4' || $m['type'] == 'wav' || $m['type'] == 'mov')
				$landing_video = $m;
			else if( strtolower($m['type']) == 'jpg' || strtolower($m['type']) == 'png' || strtolower($m['type']) == 'git')
				$landing_video_poster = '/media/' . m_pad($m['id']) . '.' . $m['type'];
		}
	}
?>

<main>
<? if(isset($landing_video)){ ?>
<div id="landing-video-container">
	<video id="landing-video" muted loop buffered playsinline <?= isset($landing_video_poster) ? 'poster="' .  $landing_video_poster . '"' : ''; ?> >
		<source src="<?= m_url($landing_video); ?>" type="video/<?= $landing_video['type']; ?>">
		Your browser doesn't support HTML 5 video.
	</video>
	<div id="video-control"></div>
</div>
<? } ?>
</main>
<style>

#landing-video-container
{
    position: relative;
    height: 100vh;
    overflow: hidden;

}
#landing-video
{
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
       -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
         -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
    /*margin-top: 50px;*/
}
@media (orientation: portrait) {
  #landing-video
  {
  	height: 100%;
  	width: auto;
  }
}
@media screen and (min-width: 768px) {
    #menu,
	#logo-container
	{
		background-color: transparent;
	}
	.noTouchScreen header
    {
        background-color: transparent;
    }
    .noTouchScreen header:hover
    {
    	-webkit-transition: background-color .5s;
	       -moz-transition: background-color .5s;
	         -o-transition: background-color .5s;
	            transition: background-color .5s;
        background-color: #000;
    }
}

</style>
<script>
	function resizeSizeToCover(subject, frame=false) {
		if(!frame)
			frame = subject.parentNode;
		var r_subject = subject.offsetHeight / subject.offsetWidth;
		var r_frame = frame.offsetHeight / frame.offsetWidth;
		if(r_subject > r_frame && subject.style.width != '100%')
		{
			subject.style.width = '100%';
			subject.style.height = 'auto';
		}
		else if(r_subject < r_frame && subject.style.height != '100%')
		{
			subject.style.width = 'auto';
			subject.style.height = '100%';
		}
	}
</script>