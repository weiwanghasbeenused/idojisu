var isViewingGallery = false;


function gallery_init(elements=false, image=false, toggle=false){
	elements = elements || document.getElementsByClassName('gallery-option');
	image = image || document.getElementById('gallery-image');
	toggle = toggle || document.getElementById('gallery-default-toggle');
	if(!elements || !image || !toggle)
		return false;

	var default_url = image.getAttribute('img-url');
	var sGallery_toggle = document.getElementById('gallery-toggle');
	[].forEach.call(elements, function(el, i){
		el.addEventListener('click', function(){
			if(el.classList.contains('active'))
			{
				body.classList.remove('viewing-gallery');
				el.classList.remove('active');
			}
			else
			{
				body.classList.add('viewing-gallery');
				if(isWebLayout)
				{
					body.classList.remove('viewing-gallery-list');
					body.classList.remove('fadeout');
				}
				var activeSibling = el.parentNode.querySelector('.gallery-option.active');
				if(activeSibling != null)
					activeSibling.classList.remove('active');
				el.classList.add('active');
				image.src = el.getAttribute('img-url');
			}

			if(sGallery_toggle != null)
				sGallery_toggle.classList.remove('active');
			
		});
	});

	toggle.addEventListener('click', function(){
		body.classList.remove('viewing-gallery');
		var activeThumbnail = elements[0].parentNode.querySelector('.active');
		activeThumbnail.classList.remove('active');
		// image.src = default_url;
	});
}
function items_init(elements=false, frame=false, toggle=false)
{
	elements = elements || document.getElementsByClassName('accessory-item');
	toggle = toggle || document.getElementById('gallery-default-toggle');
	frame = frame || document.getElementById('gallery-frame');
	if(!elements || !toggle || !frame)
		return false;
	var sItems_toggle = document.getElementById('items-toggle');
	[].forEach.call(elements, function(el, i){
		el.addEventListener('click', function(){
			console.log('click item');
			if(el.classList.contains('active'))
			{
				body.classList.remove('viewing-items');
				el.classList.remove('active');
				frame.style.backgroundImage = 'url(' + default_src + ')';
			}
			else
			{
				body.classList.add('viewing-items');
				if(isWebLayout)
				{
					body.classList.remove('viewing-items-list');
					body.classList.remove('fadeout');
				}
				var activeSibling = el.parentNode.querySelector('.accessory-item.active');
				console.log(activeSibling);
				if(activeSibling != null)
					activeSibling.classList.remove('active');
				el.classList.add('active');
				frame.style.backgroundImage = 'url("' + el.getAttribute('figure-src') + '")';
			}

			if(sItems_toggle != null)
				sItems_toggle.classList.remove('active');
		});
		toggle.addEventListener('click', function(){
			body.classList.remove('viewing-items');
			var activeThumbnail = elements[0].parentNode.querySelector('.active');
			activeThumbnail.classList.remove('active');
			// image.src = default_url;
		});
	});

}