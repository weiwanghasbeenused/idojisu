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

var body = document.body;

var wW = window.innerWidth;
var wH = window.innerHeight;

var critical_w_menu = 768;
isWebLayout = false;
if(wW < critical_w_menu)
	isWebLayout = true;