function setWCNB(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	document.getElementById('wcnb-cookie-info').remove();
}


function getWCNB(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function checkWCNB() {
	var wcnb_cookie = getWCNB("wcnb_cookie");
	if (wcnb_cookie != "") {
		document.getElementById('wcnb-cookie-info').remove();
	}
}
checkWCNB();