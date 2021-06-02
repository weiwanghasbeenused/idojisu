<?
	$images_arr = array();
	$children = $oo->children($item['id']);
	$accessory_items = array();
	$gallery_items = array();
	foreach($children as $child)
	{
		if($child['url'] == 'accessory' && substr($child['name1'], 0, 1) != '.')
			$accessory_items = $child;
		elseif($child['url'] == 'gallery' && substr($child['name1'], 0, 1) != '.')
			$gallery_items = $child;
	}
	$detail_text = wysiwygClean($item['body']);
	$gallery_media = $oo->media($gallery_items['id']);

	$hidden_tag = '[hidden]';
	$media = $oo->media($item['id']);
	if(count($media) > 0)
	{
		foreach( $media as $m ){
			if(strpos($m['caption'], $hidden_tag) === false ){
				$default_src = m_src($m);
				$default_alt = $media['caption'] == '' ? 'Thumbnail of '.$child['name1'] : $media['caption'];
			}
		}
	}
	$figure_with_accessory_src = array();
	$accessory_children = $oo->children($accessory_items['id']);
	foreach($accessory_children as $a_child)
	{

		if(strtolower($a_child['name1']) == 'figure with accessory'){
			$figure_with_accessory_media = $oo->media($a_child['id']);
			foreach($figure_with_accessory_media as $a_m)
			{
				$figure_with_accessory_src[$a_m['caption']] = m_src($a_m);
			}
		}
	}

	$bracket_pattern = '#\[(.*)\](.*)#is';
	$showedGalleryHint = isset($_COOKIE['showedGalleryHint']);

    $uri_temp = $uri;
    array_pop($uri_temp);
    $this_season_url = implode('/', $uri_temp);
    array_shift($uri_temp);
    $this_season_name = $oo->get(end($oo->urls_to_ids($uri_temp)))['name1'];
    
?>
<div id="detail-layout-container" class="main-container">
	<aside id="left-side-container"></aside><main id="season-detail-container" class="container" viewing="default">
		<div id="season-detail-sticky-container">
			<h1 class="detail-blockname"><?= $item['name1']; ?></h1>
			<div id="gallery-default-toggle" class="detail-blockname">&otimes;</div>
			<div id="accessory-container">
				<h2 class="detail-blockname">Items</h2>
				<h2 id="items-toggle" class="blink-hover-zone detail-blockname list-toggle"><span class="blink-container"></span>Items<span class="blink-container"></span></h2>
				<? if(!empty($accessory_items)){
					$accessory_media = $oo->media($accessory_items['id']);
					if(count($accessory_media) > 0)
					{
						?><div id="accessory-item-container"><?
						foreach($accessory_media as $key => $m)
						{
							$src = m_src($m);						
							preg_match_all($bracket_pattern, $m['caption'], $item_info);
		 					$rank = $item_info[1][0];
							$name = $item_info[2][0];
							$alt = $name;
							$images_arr[] = m_url($m);
							$class = 'accessory-item';
							if( ($key+1) % 2 == 0)
								$class .= ' 2n-th-accessory-item';
							if( ($key+1) % 3 == 0)
								$class .= ' 3n-th-accessory-item';
							?><div class="<?= $class; ?>" figure-src="<?= $figure_with_accessory_src[$m['caption']]; ?>">
								<div class="accessory-item-img" style="background-image:url(<?= $src; ?>);"></div>
								<div class="accessory-item-info">
									<p><?= $name; ?></p>
									<div id="rank-container">
										<? for($i = 0; $i < $rank; $i++){
											?><span class="rank active"></span><?
										} 
										for($i = 0; $i< 5-$rank; $i++ )
										{
											?><span class="rank"></span><?
										}
										?>

									</div>
								</div>
							</div>
							<?
						}
						?></div><?
					}
					?><?
				} ?>
			</div><div id="gallery-container">
				<h2 class="detail-blockname">Gallery</h2>
				<h2 id="gallery-toggle" class="blink-hover-zone detail-blockname list-toggle"><span class="blink-container"></span>Gallery<span class="blink-container"></span></h2>
				<? if(count($gallery_media) > 0){
					?><div id="gallery-item-container"><?
					foreach($gallery_media as $m)
					{
						if(substr($m['caption'], 0, 1) != '.')
						{
							$src = m_src($m);
							$url = m_url($m);
							$images_arr[] = m_url($m);
							?><div class="gallery-option fade" style="background-image:url(<?= $src; ?>);" img-url="<?= $url; ?>"></div><?
						}
					}
					?></div><?
				} ?>
			</div>
		</div>
		<div id="gallery-frame" class="detail-block image-frame-container">
			<? foreach($gallery_media as $key => $m){
				$images_arr[] = m_url($m);
				?><img id="gallery-image-<?= $key; ?>" class="gallery-image" alt="<?= $m['caption']; ?>" src="<?= m_url($m); ?>" ><?
			} ?>
			<? foreach($accessory_media as $key => $m){
				$images_arr[] = $figure_with_accessory_src[$m['caption']];
				?><div id="accessory-frame-<?= $key; ?>" class="image-frame contain" style="background-image:url(<?= $figure_with_accessory_src[$m['caption']]; ?>);"></div><?
			} ?>
			<div id="image-frame-default" class="image-frame contain" style="background-image:url(<?= $default_src; ?>);"></div>
			<div id="gallery-hint">
				<div id="gallery-hint-center-holder" class="centered">
					<p class="large-text">Click on image to loop through the gallery/items.</p>
					<div class="text-btn-holder"><span id="btn-close-hint" class="text-btn">okay</span></div>
				</div>
			</div>
		</div>
		<div id="detail-container">
			<h2 class="detail-blockname">Details</h2>
			<p id="detail-text"><?= $detail_text; ?></p>
		</div>
	</main><aside id="right-side-container">
		
	</aside>
</div>
<div id="season-nav">
    <a href="<?= $this_season_url; ?>" class="blink-hover-zone">
        <svg id="season-nav-arrow" class="arrow-small"version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
            <polygon fill="#A0A7AB" class="st0" points="7,9 7,7 9,7 9,5 11,5 11,3 7,3 7,5 5,5 5,7 3,7 3,9 1,9 1,11 3,11 3,13 5,13 5,15 7,15 7,17 11,17 
            11,15 9,15 9,13 7,13 7,11 5,11 5,9 "/>
        </svg>
        <span id="season-nav-text" >back to <?= $this_season_name; ?><span class="blink-container"></span></span>
    </a>
</div>
<style>
.list-toggle .blink-container
{
    margin-top: 7px;
}
#detail-layout-container
{
    padding-top: 49px;
    border-bottom: 1px solid var(--light-grey);
    padding-bottom: 0;
    /*margin-bottom: 30px;*/
}
#detail-layout-container aside
{
    background-color: #000;
}

.accessory-item-img,
.gallery-option.fade,
#image-frame-default
{
    -webkit-transition: opacity .75s;
       -moz-transition: opacity .75s;
         -o-transition: opacity .75s;
            transition: opacity .75s;
}

body.loading #detail-layout-container .accessory-item-img,
body.loading #detail-layout-container .gallery-option,
body.loading #detail-layout-container #image-frame-default
{
    opacity: 0;
}
.detail-blockname
{
    text-align: center;
    padding: 5px 10px;
    border-top: 1px solid var(--light-grey);
    border-bottom: 1px solid var(--light-grey);
    background-color: #000;
}
h1.detail-blockname,
#gallery-default-toggle
{
    border-bottom: none;
}
#season-detail-sticky-container
{
    position: fixed;
    width: 100vw;
    max-width: 100%;
    top: 49px;
    z-index: 900;
    background-color: #000;
}
#gallery-frame {
    height: 70vh;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}
.image-frame-container
{
    position: relative;
}
.image-frame
{
    position: absolute;


}
#gallery-frame .image-frame
{
    height: 100%;
    width: 100%;
    display: none;
}
#gallery-frame .image-frame.viewing
{
    display: block;
    z-index: 10;
}
main[viewing="default"] #image-frame-default
{
    display: block;
    z-index: 5;
}
main[viewing="items"] #gallery-frame #image-frame-default
{
    display: none;
}
.gallery-image
{
    display: none;
    cursor: pointer;
}
.gallery-image.viewing
{
    display: block;
}
#gallery-hint
{
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, .8);
    width: 100%;
    height: 100%;
    z-index: 50;
    opacity: 0;
    visibility: hidden;
}
.viewing-hint #gallery-hint
{
    visibility: initial;
    opacity: 1;
    -webkit-transition: opacity: .35s;
       -moz-transition: opacity: .35s;
         -o-transition: opacity: .35s;
            transition: opacity: .35s;
}
#accessory-item-container
{
    -webkit-flex-wrap: wrap;
       -moz-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
         -o-flex-wrap: wrap;
            flex-wrap: wrap;
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    position: absolute;
    width: 100vw;
    height: 0;
    overflow: hidden;
    background-color: #000;
    max-height: 60vh;
    -webkit-transform: translate(0 ,-100%);
       -moz-transform: translate(0 ,-100%);
        -ms-transform: translate(0 ,-100%);
         -o-transform: translate(0 ,-100%);
            transform: translate(0 ,-100%);
    z-index: -1;
}
div[viewing-list="items"] #accessory-item-container
{
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    transform: translate(0 ,0);
    -webkit-transition: -webkit-transform .35s;
       -moz-transition: -moz-transform .35s;
         -o-transition: -o-transform .35s;
            transition: -webkit-transform .35s;
            transition: transform .35s;
    height: auto;
    overflow: scroll;
}
.accessory-item
{
    display: inline-block;
    width: 33%;
    /*border-top: 1px solid var(--light-grey);*/
    border-right: 1px solid var(--light-grey);
    border-bottom: 1px solid var(--light-grey);
    cursor:pointer;
}
.accessory-item:nth-child(3n)
{
    border-right: none;
}
.noTouchScreen .accessory-item:hover,
.accessory-item.active
{
    background-color: var(--sky-blue);
    color: #000;
}
.noTouchScreen .accessory-item:hover .accessory-item-info,
.accessory-item.active .accessory-item-info
{
    border-top: 1px solid #000;
}
#rank-container
{
    margin-top: 5px;
}
.rank
{
    display: inline-block;
    width: 20px;
    height: 20px;
    background-image: url(../../media/svg/blink_1-outline-light.svg);
    background-size: 100%;
}
.rank.active
{
    background-image: url(../../media/svg/blink_1-light.svg);
}
.noTouchScreen .accessory-item:hover .rank,
.accessory-item.active .rank
{
    background-image:url(../../media/svg/blink_1-light.svg);
}
.noTouchScreen .accessory-item:hover .rank.active
{
    -webkit-animation: blinking_1 .75s infinite linear;
    animation: blinking_1 .75s infinite linear;
}
.accessory-item.active .rank.active
{
    background-image:url(../../media/svg/blink_1.svg);
}
.accessory-item-img
{
    height: 120px;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    
}

.accessory-item-info
{
    text-align: center;
    padding: 5px;
    border-top: 1px solid var(--light-grey);
}

#gallery-item-container
{
    position: absolute;
    right: 0;
    width: 100vw;
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-flex-wrap: wrap;
       -moz-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
         -o-flex-wrap: wrap;
            flex-wrap: wrap;
    background-color: #000;
    -webkit-transform: translate(0, -100%);
       -moz-transform: translate(0, -100%);
        -ms-transform: translate(0, -100%);
         -o-transform: translate(0, -100%);
    transform: translate(0, -100%);
    height: 0;
    overflow: hidden;
    z-index: -1;
    max-height: 60vh;
}
div[viewing-list="gallery"] #gallery-item-container
{
    -webkit-transform: translate(0, 0);
       -moz-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
         -o-transform: translate(0, 0);
            transform: translate(0, 0);
    -webkit-transition: -webkit-transform .35s;
       -moz-transition: -moz-transform .35s;
         -o-transition: -o-transform .35s;
            transition: -webkit-transform .35s;
            transition: transform .35s;
    height: auto;
    overflow: scroll;
}
.gallery-option
{
    background-color: #fff;
    cursor: pointer;
    width: 25%;
    height: 150px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
.gallery-option.active
{
    opacity: 0.5;
}

#gallery-default-toggle
{
    display: none;
    cursor:pointer;
    font-size: 1.25em;
}
.noTouchScreen #gallery-default-toggle:hover
{
    background-color: var(--sky-blue);
    color: #000;
}

main[viewing="gallery"] #gallery-default-toggle,
main[viewing="items"] #gallery-default-toggle
{
    display: block;
}
main[viewing="gallery"] h1.detail-blockname,
main[viewing="items"] h1.detail-blockname
{
    display: none;
}
main[viewing="gallery"] #gallery-frame {
    height: auto;
}

#detail-text
{
    padding: 20px 20px 20px 20px;
}
#accessory-container,
#gallery-container
{
    width: 50%;
    display: inline-block;
    background-color: #000;
}
#accessory-container
{
    border-right: 1px solid var(--light-grey);
}
#accessory-container > h2:first-child,
#gallery-container > h2:first-child
{
    display: none;
}
#items-toggle.active,
#gallery-toggle.active
{
    background-color: var(--sky-blue);
    color: #000;
}
#season-detail-container
{
    padding-top: 63px;
}
#gallery-hint-center-holder
{
    width: 75%;
    height: 200px;
}
#gallery-hint-center-holder .text-btn-holder
{
    margin-top: 50px;
}
#season-nav a
{
    display: block;
    text-align: center;
    padding: 5px 10px;
}
#season-nav-arrow, 
#season-nav-text
{
    vertical-align: top;
}
#season-nav-text
{
    margin-top: 2px;
}
.arrow-small
{
    width: 24px;
}
#season-nav-text .blink-container
{
    margin-top: 8px;
    min-width: 40px;
}
.noTouchScreen #season-nav .blink-hover-zone:hover polygon
{
    fill: #000;
}
.noTouchScreen #season-nav .blink-hover-zone:hover
{
    color: #000;
    background-color: var(--sky-blue);
}
@media screen and (min-width: 768px) {
    #detail-layout-container
    {
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-wrap: wrap;
           -moz-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
             -o-flex-wrap: wrap;
                flex-wrap: wrap;
        padding-top: 130px;
        height: calc( 100vh - 34px);
        overflow: hidden;
    }
    #detail-layout-container aside
    {
        -webkit-box-flex: 1;
        width: 24.5%;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
        -webkit-overflow-scrolling: touch;
        max-height: 100%;
        overflow-y: scroll;
    }
    #detail-layout-container aside .detail-blockname,
    #detail-layout-container main #season-detail-sticky-container
    {
        position: -webkit-sticky;
        position: sticky;
        top: 0px;
    }
    #detail-layout-container aside,
    #detail-layout-container main
    {
        scrollbar-color: var(--light-grey) transparent;
    }
    #detail-layout-container aside::-webkit-scrollbar,
    #detail-layout-container main::-webkit-scrollbar {
        width: 5px;
    }
    #detail-layout-container aside::-webkit-scrollbar-track,
    #detail-layout-container main::-webkit-scrollbar-track {
        background-color: transparent;
        border-top: 1px solid var(--light-grey);
    }
    #detail-layout-container aside::-webkit-scrollbar-thumb,
    #detail-layout-container main::-webkit-scrollbar-thumb {
        background-color: var(--light-grey);
    }
    #detail-layout-container main
    {
        -webkit-box-flex: 2;
        width: 50%;
        -webkit-flex: 2;
        -ms-flex: 2;
        flex: 2;
        border-left: 1px solid var(--light-grey);
        border-right: 1px solid var(--light-grey);
        -webkit-overflow-scrolling: touch;
        max-height: 100%;
        overflow-y: scroll;
        /*border-top: 1px solid var(--light-grey);*/
    }
    #season-detail-container
    {
        padding-top: 0;
    }
    h1.detail-blockname, #gallery-default-toggle
    {
        border-bottom: 1px solid var(--light-grey);
    }
    #gallery-frame
    {
        height: calc(100% - 34px);
    }
    #gallery-frame .detail-blockname
    {
        border-top: 1px solid var(--light-grey);
    }
    #accessory-container
    {
        /*border-bottom: 1px solid var(--light-grey);*/
        border-right: none;
        display: block;
        width: initial;
        padding-bottom: 20px;
    }
    #accessory-container > h2:first-child
    {
        display: block;
    }
    #accessory-container > #items-toggle
    {
        display: none;
    }
    #accessory-item-container
    {
        position: static;
        width: auto;
        max-height: none;
        height: auto;
        -webkit-transform: none;
           -moz-transform: none;
            -ms-transform: none;
             -o-transform: none;
                transform: none;
    }
    .accessory-item
    {
        width: 100%;
        border-right: none;
    }
    .accessory-item-img
    {
        height: 150px;
    }
    .accessory-item-info
    {
        padding: 10px;
    }
    #rank-container {
        margin-top: 10px;
    }
    .rank {
        margin-right: 3px;
    }
    .rank:last-child {
        margin-right: 0;
    }
    #gallery-container
    {
        width: initial;
        display: block;
        padding-bottom: 20px;
    }
    #gallery-item-container
    {
        -webkit-transform: none;
           -moz-transform: none;
            -ms-transform: none;
             -o-transform: none;
                transform: none;
        position: static;
        width: auto;
        max-height: none;
        height: auto;
        overflow: visible;
    }
    .gallery-option
    {
        width: 50%;
        display: inline-block;
        height: 150px;
    }
    #detail-text
    {
        padding: 10px 10px 20px 10px;
    }
}

@media screen and (min-width: 1100px) {

    .gallery-option
    {
        width: 33.3%;
    }
    .accessory-item
    {
        width: 50%;
        border-right: 1px solid var(--light-grey);
    }
    .accessory-item:nth-child(3n)
    {
        border-right: 1px solid var(--light-grey);
    }
    .accessory-item:nth-child(even)
    {
        border-right: none;
    }
}

@media screen and (min-width: 2000px) {

    .gallery-option
    {
        width: 25%;
        height: 200px;
    }
    .accessory-item
    {
        width: 33.33%;
        border-right: 1px solid var(--light-grey);
    }
    .accessory-item-img
    {
        height: 200px;
    }
    .accessory-item:nth-child(3n)
    {
        border-right: none;
    }
    .accessory-item:nth-child(even)
    {
        border-right: 1px solid var(--light-grey);
    }
}

</style>
<script type="text/javascript" src="/static/js/detail-gallery.js"></script>
<script type="text/javascript" src="/static/js/_cookie.js"></script>
<script>
	var images_arr = <?= json_encode($images_arr); ?>;
	var idx_to_callback = parseInt( 3 * images_arr.length / 4);
	preloadImage(images_arr, removeLoading, idx_to_callback);

	var default_src = '<?= $default_src; ?>';
	var sSeason_detail_container = document.getElementById('season-detail-container');
	var sSeason_detail_sticky_container = document.getElementById('season-detail-sticky-container');
	var sGallery_option = document.getElementsByClassName('gallery-option');
	var sGallery_image = document.getElementsByClassName('gallery-image');
	var sAccessory_item = document.getElementsByClassName('accessory-item');
	var sImage_frame = document.getElementsByClassName('image-frame');
	var sItems_toggle = document.getElementById('items-toggle');
	var sGallery_toggle = document.getElementById('gallery-toggle');
	var mask = document.getElementById('mask');
	var sGallery_frame = document.getElementById('gallery-frame');

	gallery_init(sGallery_option, sGallery_image, sSeason_detail_sticky_container, sSeason_detail_container);
	items_init(sAccessory_item, sImage_frame, sSeason_detail_sticky_container, sSeason_detail_container);
	toggle_init();
	if(!isMobileLayout)
	{
		var sAccessory_container = document.getElementById('accessory-container');
		var sGallery_container = document.getElementById('gallery-container');
		var sDetail_container = document.getElementById('detail-container');

		var sRight_side_container = document.getElementById('right-side-container');
		var sLeft_side_container = document.getElementById('left-side-container');

		sRight_side_container.appendChild(sDetail_container);
		sRight_side_container.appendChild(sGallery_container);
		sLeft_side_container.appendChild(sAccessory_container);

	}
	else
	{
		if(mask != undefined)
		{
			mask.addEventListener('click', function(){
				sSeason_detail_sticky_container.setAttribute('viewing-list', 'none');
				body.classList.remove('fadeout');
				sItems_toggle.classList.remove('active');
				sGallery_toggle.classList.remove('active');
			});
		}
	}
	var showedGalleryHint = <?= json_encode($showedGalleryHint); ?>;
	function displayHint(){
		if(!showedGalleryHint)
		{
			setCookie('showedGalleryHint', true, 7);
			sGallery_frame.classList.add('viewing-hint');
			showedGalleryHint = getCookie('showedGalleryHint');
		}
	}
	var sBtn_close_hint = document.getElementById('btn-close-hint');
	var sGallery_hint = document.getElementById('gallery-hint');
	if(sBtn_close_hint != undefined)
	{
		sBtn_close_hint.addEventListener('click', function(){
			sGallery_frame.classList.remove('viewing-hint');
		});
	}
	var gallery_triggers = document.querySelectorAll('.gallery-option, .accessory-item');
	if(!showedGalleryHint && gallery_triggers.length != 0 && isMobileLayout)
	{
		[].forEach.call(gallery_triggers, function(el, i){
			el.addEventListener('click', function(){
				displayHint();
			});
		});
	}
	
</script>