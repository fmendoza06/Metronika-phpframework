var ez_NN4 = document.layers?1:0
var ez_IE4 = document.getElementById?0:1
var ez_NS6 = (!ez_IE4 && !(navigator.appVersion.indexOf("MSIE")>-1))?1:0
var ez_OPR = (navigator.userAgent.indexOf("Opera")!=-1)
var ez_isMac = (navigator.appVersion.indexOf("Mac") != -1)

if(ez_NN4) {
	document.write("<SCR" + "IPT  SRC='" + ez_codePath + "ezmenuns.js' TYPE='text/javascript'><\/SCR" + "IPT>");
} else {
	document.write("<SCR" + "IPT  SRC='" + ez_codePath + "ezmenuie.js' TYPE='text/javascript'><\/SCR" + "IPT>");
}
