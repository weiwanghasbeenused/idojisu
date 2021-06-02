<?
	$home_id = end($oo->urls_to_ids(array('home')));
	$media = $oo->media($home_id);
	if(!empty($media))
	{
		foreach($media as $m)
		{
			if(strpos($m['caption'], '[landing]') !== false)
				$landing_video = $m;
		}
	}
?>

<main>
<? if(isset($landing_video)){ ?>
<div id="landing-video-container">
	<video id="landing-video" muted loop buffered playsinline>
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