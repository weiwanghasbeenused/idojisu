

function SHS_B(e, sc, eAmt, start) {
    e.scrollLeft = (eAmt * sc) + start;
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function preloadImage(img_arr, callback=false, idx_to_callback=false, idx=0)
{
    var img = new Image();
    if(!idx_to_callback)
    	idx_to_callback = img_arr.length-1;
    img.onload = function(){
    	if(idx < img_arr.length-1)
    		preloadImage(img_arr, callback, idx_to_callback, idx+1);
    	if(callback && idx == idx_to_callback)
    		callback();
    };
    img.src = img_arr[idx];
}

var body = document.body;

var wW = window.innerWidth;
var wH = window.innerHeight;

var critical_w_menu = 768;
isMobileLayout = false;
if(wW < critical_w_menu)
	isMobileLayout = true;