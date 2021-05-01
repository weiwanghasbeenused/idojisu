var isViewingGallery = false;


function gallery_init(elements=false, image=false, toggle=false, frame=false){
	elements = elements || document.getElementsByClassName('gallery-option');
	image = image || document.getElementById('gallery-image');
	toggle = toggle || document.getElementById('gallery-default-toggle');
	frame = frame || document.getElementById('gallery-frame');
	if(!elements || !image || !toggle || !frame)
		return false;

	var default_url = image.getAttribute('img-url');
	[].forEach.call(elements, function(el, i){
		el.addEventListener('click', function(){
			if(el.classList.contains('active'))
			{
				frame.classList.remove('viewing-gallery');
				el.classList.remove('active');
				image.src = default_url;
			}
			else
			{
				frame.classList.add('viewing-gallery');
				var activeSibling = el.parentNode.querySelector('.active');
				if(activeSibling != null)
					activeSibling.classList.remove('active');
				el.classList.add('active');
				image.src = el.getAttribute('img-url');
			}
			
		});
	});

	toggle.addEventListener('click', function(){
		frame.classList.remove('viewing-gallery');
		var activeThumbnail = elements[0].parentNode.querySelector('.active');
		activeThumbnail.classList.remove('active');
		image.src = default_url;
	});
}