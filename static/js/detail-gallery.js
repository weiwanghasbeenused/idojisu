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
			window.scrollTo(0, 0);
			if(el.classList.contains('active'))
			{
				body.classList.remove('viewing-gallery');
				el.classList.remove('active');
			}
			else
			{
				body.classList.add('viewing-gallery');
				body.classList.remove('viewing-items');
				var activeAccessory_item = document.querySelector('.accessory-item.active');
				if(activeAccessory_item != null)
					activeAccessory_item.classList.remove('active');
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
}
function items_init(elements=false, frame=false)
{
	elements = elements || document.getElementsByClassName('accessory-item');
	frame = frame || document.getElementById('gallery-frame');
	if(!elements || !frame)
		return false;
	var sItems_toggle = document.getElementById('items-toggle');
	[].forEach.call(elements, function(el, i){
		el.addEventListener('click', function(){
			window.scrollTo(0, 0);
			if(el.classList.contains('active'))
			{
				body.classList.remove('viewing-items');
				el.classList.remove('active');
				frame.style.backgroundImage = 'url(' + default_src + ')';
			}
			else
			{
				body.classList.add('viewing-items');
				body.classList.remove('viewing-gallery');
				var activeGallery_option = document.querySelector('.gallery-option.active');
				if(activeGallery_option != null)
					activeGallery_option.classList.remove('active');
				if(isWebLayout)
				{
					body.classList.remove('viewing-items-list');
					body.classList.remove('fadeout');
				}
				var activeSibling = el.parentNode.querySelector('.accessory-item.active');
				if(activeSibling != null)
					activeSibling.classList.remove('active');
				el.classList.add('active');
				frame.style.backgroundImage = 'url("' + el.getAttribute('figure-src') + '")';
			}

			if(sItems_toggle != null)
				sItems_toggle.classList.remove('active');
		});
		
	});
}
function toggle_init(toggle = false, frame = false){
	toggle = toggle || document.getElementById('gallery-default-toggle');
	frame = frame || document.getElementById('gallery-frame');
	var sItems_toggle = document.getElementById('items-toggle');
	var sGallery_toggle = document.getElementById('gallery-toggle');
	if(!toggle || !frame)
		return false;
	toggle.addEventListener('click', function(){
		body.classList.remove('viewing-items');
		body.classList.remove('viewing-gallery');
		if(isWebLayout)
		{
			body.classList.remove('viewing-items-list');
			body.classList.remove('viewing-gallery-list');
			body.classList.remove('fadeout');
			sItems_toggle.classList.remove('active');
			sGallery_toggle.classList.remove('active');
		}
		var activeAccessory_item = document.querySelector('.accessory-item.active');
		if(activeAccessory_item != null)
			activeAccessory_item.classList.remove('active');
		var activeGallery_option = document.querySelector('.gallery-option.active');
		if(activeGallery_option != null)
			activeGallery_option.classList.remove('active');

		frame.style.backgroundImage = 'url(' + default_src + ')';
		
	});
}