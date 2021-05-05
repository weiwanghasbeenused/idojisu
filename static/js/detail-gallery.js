var isViewingGallery = false;

function gallery_init(elements=false, images=false, list_parent = false, gallery_container = false){
	elements = elements || document.getElementsByClassName('gallery-option');
	images = images || document.getElementsByClassName('gallery-image');
	list_parent = list_parent || document.getElementById('season-detail-sticky-container');
	gallery_container = gallery_container || document.getElementById('season-detail-container');
	if(!elements || !images || !list_parent || !gallery_container)
		return false;
	
			
				
	var sGallery_toggle = document.getElementById('gallery-toggle');
	[].forEach.call(elements, function(el, i){
		el.addEventListener('click', function(){
			window.scrollTo(0, 0);
			close_gallery(false, sSeason_detail_sticky_container, sSeason_detail_container);
			if(!this.classList.contains('active'))
			{
				gallery_container.setAttribute('viewing', 'gallery');
				var activeAccessory_item = document.querySelector('.accessory-item.active');
				if(activeAccessory_item != null)
					activeAccessory_item.classList.remove('active');
				var activeSibling = this.parentNode.querySelector('.gallery-option.active');
				if(activeSibling != null)
					activeSibling.classList.remove('active');
				var viewing = document.querySelector('#gallery-frame .viewing');
				if(viewing != null)
					viewing.classList.remove('viewing');
				images[i].classList.add('viewing');
			}
			this.classList.toggle('active');

			if(sGallery_toggle != undefined)
				sGallery_toggle.classList.remove('active');
			
		});
	});
	if(isMobileLayout && sGallery_toggle != undefined)
	{
		sGallery_toggle.addEventListener('click', function(){
			var viewingList = list_parent.getAttribute('viewing-list');
			if(viewingList == 'gallery')
			{
				list_parent.setAttribute('viewing-list', 'none');
				body.classList.remove('fadeout');
			}
			else
			{
				var activeListToggle = document.querySelector('.list-toggle.active');
				if(activeListToggle != null)
					activeListToggle.classList.remove('active');
				list_parent.setAttribute('viewing-list', 'gallery');
				body.classList.add('fadeout');
			}
			this.classList.toggle('active');
		});
	}
}
function items_init(elements=false, frames=false, list_parent = false, gallery_container=false)
{
	elements = elements || document.getElementsByClassName('accessory-item');
	frames = frames || document.getElementsByClassName('image-frame');
	list_parent = list_parent || document.getElementById('season-detail-sticky-container');
	gallery_container = gallery_container || document.getElementById('season-detail-container');
	if(!elements || !frames || !list_parent || !gallery_container)
		return false;
	var sItems_toggle = document.getElementById('items-toggle');
	[].forEach.call(elements, function(el, i){
		el.addEventListener('click', function(){
			window.scrollTo(0, 0);
			close_gallery(false, sSeason_detail_sticky_container, sSeason_detail_container);
			if(!this.classList.contains('active'))
			{
				gallery_container.setAttribute('viewing', 'items');
				var activeGallery_option = document.querySelector('.gallery-option.active');
				if(activeGallery_option != null)
					activeGallery_option.classList.remove('active');
				
				var activeSibling = this.parentNode.querySelector('.accessory-item.active');
				if(activeSibling != null)
					activeSibling.classList.remove('active');
				var viewing = document.querySelector('#gallery-frame .viewing');
				if(viewing != null)
					viewing.classList.remove('viewing');
				frames[i].classList.add('viewing');
			}
			this.classList.toggle('active');

			if(isMobileLayout && sItems_toggle != null)
				sItems_toggle.classList.remove('active');
		});
		
	});

	if(isMobileLayout && sItems_toggle != undefined)
	{
		sItems_toggle.addEventListener('click', function(){
			var viewingList = list_parent.getAttribute('viewing-list');
			if(viewingList == 'items')
			{
				list_parent.setAttribute('viewing-list', 'none');
				body.classList.remove('fadeout');
			}
			else
			{
				var activeListToggle = document.querySelector('.list-toggle.active');
				if(activeListToggle != null)
					activeListToggle.classList.remove('active');
				list_parent.setAttribute('viewing-list', 'items');
				body.classList.add('fadeout');
			}
			this.classList.toggle('active');
		});
	}
}
function close_gallery(side = false, list_parent = false, gallery_container=false)
{
	list_parent = list_parent || document.getElementById('season-detail-sticky-container');
	var viewing = document.querySelector('#gallery-frame .viewing');
	if(viewing != null)
		viewing.classList.remove('viewing');
	gallery_container.setAttribute('viewing', 'default');
	if(isMobileLayout)
	{
		list_parent.setAttribute('viewing-list', 'none');
		body.classList.remove('fadeout');
	}
	return false;
}
function toggle_init(toggle = false, frame = false, list_parent = false, gallery_container=false){
	toggle = toggle || document.getElementById('gallery-default-toggle');
	frame = frame || document.getElementById('gallery-frame');
	list_parent = list_parent || document.getElementById('season-detail-sticky-container');
	gallery_container = gallery_container || document.getElementById('season-detail-container');
	var sItems_toggle = document.getElementById('items-toggle');
	var sGallery_toggle = document.getElementById('gallery-toggle');
	if(!toggle || !frame)
		return false;
	toggle.addEventListener('click', function(){
		gallery_container.setAttribute('viewing', 'default');
		var viewing = document.querySelector('#gallery-frame .viewing');
		if(viewing != null)
			viewing.classList.remove('viewing');
		if(isMobileLayout)
		{
			list_parent.setAttribute('viewing-list', 'none');
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
	});
}