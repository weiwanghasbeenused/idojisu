function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function expireCookie(name) {
	if (getCookie(name) != "")
	{
		document.cookie = name+"=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
		return true;
	} 
	else
		return false;
}

function getCookie(name) {
	var cname = name + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i < ca.length; i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ')
			c = c.substring(1);
		if (c.indexOf(cname) != -1) 
			return c.substring(cname.length,c.length);
	}
	return "";
}

function checkCookie(name) {
	if (getCookie(name) != "")
		return true;
	else
		return false;
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

function SHS_B(e, sc, eAmt, start) {
    e.scrollLeft = (eAmt * sc) + start;
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
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
function preloadImage(img_arr, callback=false, idx_to_callback=false, idx=0)
{
    var img = new Image();
    if(!idx_to_callback)
    	idx_to_callback = img_arr.length-1;
    img.onload = function(){
    	console.log('loaded');
    	if(idx < img_arr.length-1)
    		preloadImage(img_arr, callback, idx_to_callback, idx+1);
    	if(idx == idx_to_callback)
    		callback();
    };
    img.src = img_arr[idx];
}
function removeLoading(){
	body.classList.remove('loading');
}

var body = document.body;

var wW = window.innerWidth;
var wH = window.innerHeight;

var critical_w_menu = 768;
isMobileLayout = false;
if(wW < critical_w_menu)
	isMobileLayout = true;