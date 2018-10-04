/*
  Implemented by Sandro Alves Peres
  sandrinhodobanjo@yahoo.com.br
*/

$f = {
  
  BY_ID: 1,
  BY_VALUE: 2,
  MASK_CEP: "#####-###",
  MASK_CPF: "###.###.###-##",
  MASK_CNPJ: "##.###.###/####-##",
  MASK_DATE: "##/##/####",
  MASK_TIME: "##:##:##",  
  MASK_SHORT_TIME: "##:##",  
  MASK_FONE: "(##)####-####",
  FORMAT_BR: 1,
  FORMAT_SQL: 2,
  TIME_FULL: 1,  
  TIME_SHORT: 2,
   
  
  $: function( str_id ){
	 if( document.getElementById ){
        return document.getElementById( str_id );
	 }
	 
	 if( !document.getElementById && document.all ){
		return document.all[ str_id ];
	 }
  },
  
  
  $$_str: "",     // used in $f.cbboxSearch
  $$_timeout: 0,  // used in $f.cbboxSearch

  cbboxSearch: function( sel, e ){ // put [ onkeypress="$f.cbboxSearch(this, event); return false;" ] of the select
    var i=0, c=true;
	var key = (window.event ? e.keyCode : e.which);
	
    $f.$$_str = $f.$$_str + String.fromCharCode(key);
    $f.$$_str = $f.$$_str.toLowerCase();
	
    while(c){
      var textOpt = sel.options[i].text.toLowerCase();
      var strOpt = textOpt.substr(0, ($f.$$_str.length));
		
      if(strOpt == $f.$$_str){
        sel.options[i].selected = true;
        c = false;
      }
      if(i >= (sel.options.length - 1)){
        c = false;
      }
      i++;
    }
	
    clearTimeout($f.$$_timeout);
	$f.$$_timeout = setTimeout("clearTimeout($f.$$_timeout); $f.$$_str='';", 2000);
  },
  
  
  $$_background: null, // used in $f.paint
  $$_foreground: null, // used in $f.paint
  $$_fontWeight: null, // used in $f.paint
  $$_fontStyle: null,  // used in $f.paint  
    
  paint: function( obj, colorBack, colorFore, fontWeight, fontStyle){
	$f.$$_background = null;
	$f.$$_foreground = null;
	$f.$$_fontWeight = null;  
	$f.$$_fontStyle  = null;	
	  
    if(typeof(colorFore) != "undefined"){
	  $f.$$_foreground = obj.style.color;
	  obj.style.color = colorFore;  
    }
	
    if(typeof(fontWeight) != "undefined"){
	  $f.$$_fontWeight = obj.style.fontWeight;
	  obj.style.fontWeight = fontWeight;  
    }		
	
    if(typeof(fontStyle) != "undefined"){
	  $f.$$_fontStyle = obj.style.fontStyle;
	  obj.style.fontStyle = fontStyle;  
    }	
   
    $f.$$_background = obj.style.backgroundColor;
    obj.style.backgroundColor = colorBack;	
  },


  unpaint: function( obj ){
	if($f.$$_background != null){
      obj.style.backgroundColor = $f.$$_background;
	}
  
    if($f.$$_foreground != null){
      obj.style.color = $f.$$_foreground;
    }
	
    if($f.$$_fontWeight != null){
      obj.style.fontWeight = $f.$$_fontWeight;
    }			
	
    if($f.$$_fontStyle != null){
      obj.style.fontStyle = $f.$$_fontStyle;
    }	
  
	$f.$$_background = null;
	$f.$$_foreground = null;
	$f.$$_fontWeight = null;
	$f.$$_fontStyle  = null;	
  },  
  
  
  utf8_encode: function( s ) {
	var c, d = "";
	for (var i = 0; i < s.length; i++) {
	  c = s.charCodeAt(i);
	  if (c <= 0x7f) {
		d += s.charAt(i);
	  } else if (c >= 0x80 && c <= 0x7ff) {
		d += String.fromCharCode(((c >> 6) & 0x1f) | 0xc0);
		d += String.fromCharCode((c & 0x3f) | 0x80);
	  } else {
		d += String.fromCharCode((c >> 12) | 0xe0);
		d += String.fromCharCode(((c >> 6) & 0x3f) | 0x80);
		d += String.fromCharCode((c & 0x3f) | 0x80);
	  }
	}
	return d;
  }, 
  
  
  utf8_decode: function( s ) {
	var c, d = "", flag = 0, tmp;
	for (var i = 0; i < s.length; i++) {
	  c = s.charCodeAt(i);
	  if (flag == 0) {
		if ((c & 0xe0) == 0xe0) {
		  flag = 2;
		  tmp = (c & 0x0f) << 12;
		} else if ((c & 0xc0) == 0xc0) {
		  flag = 1;
		  tmp = (c & 0x1f) << 6;
		} else if ((c & 0x80) == 0) {
		  d += s.charAt(i);
		} else {
		  flag = 0;
		}
	  } else if (flag == 1) {
		flag = 0;
		d += String.fromCharCode(tmp | (c & 0x3f));
	  } else if (flag == 2) {
		flag = 3;
		tmp |= (c & 0x3f) << 6;
	  } else if (flag == 3) {
		flag = 0;
		d += String.fromCharCode(tmp | (c & 0x3f));
	  } else {
		flag = 0;
	  }
	}
	return d;
  },  


  getAjax: function(){
    if( window.XMLHttpRequest ) return new XMLHttpRequest();

    if( window.ActiveXObject ){
	   var msxmls = ['Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'Msxml2.XMLHTTP.3.0', 'Msxml2.XMLHTTP', 'Microsoft.XMLHTTP'];
	   for(var i=0; i < msxmls.length; i++){
		  try{
			 return new ActiveXObject( msxmls[i] );
		  }
		  catch(e){}
	   }		  
    }
	
    return null;
  },
 
 
  getCookie: function( check_name ){
	var a_all_cookies  = document.cookie.split(';');
	var a_temp_cookie  = '';
	var cookie_name    = '';
	var cookie_value   = '';
	var b_cookie_found = false; // set boolean t/f default f
	
	for(var i=0; i < a_all_cookies.length; i++){
	  // now we'll split apart each name=value pair
	  a_temp_cookie = a_all_cookies[i].split('=');
	  
	  // and trim left/right whitespace while we're at it
	  cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');
  
	  // if the extracted name matches passed check_name
	  if( cookie_name == check_name ){
		  b_cookie_found = true;
		  // we need to handle case where cookie has no value but exists (no = sign, that is):
		  if( a_temp_cookie.length > 1 ){
			 cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
		  }
		  // note that in cases where cookie is initialized but no value, null is returned
		  return cookie_value;
		  break;
	  }
	  
	  a_temp_cookie = null;
	  cookie_name = '';
	}
	
	if( !b_cookie_found ){
	   return null;
	}
  },


  setCookie: function( name, value, expires, path, domain, secure ){ // only the first 2 parameters are required. Expires is for hours
	var today = new Date();
	today.setTime(today.getTime());

	if( expires ){
	  expires = expires * 1000 * 60 * 60;
	}

    var cookie = '';
	var expires_date = new Date(today.getTime() + (expires));

    cookie  = name + "=" + escape(value);
	cookie += (expires ? ";expires=" + expires_date.toGMTString() : "");
    cookie += (path ? ";path=" + path : "");
    cookie += (domain ? ";domain=" + domain : ""); 
    cookie += (secure ? ";secure" : "");	

	document.cookie = cookie;	
  },


  deleteCookie: function( name, path, domain ){
	var cookie = '';
	
	if( $f.getCookie(name) ){
	  cookie  = name + "=" + (path ? ";path=" + path : "");
	  cookie += (domain ? ";domain=" + domain : "");
	  cookie += ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
	  document.cookie = cookie;
	}
  },  
 
 
  preventDefault: function( ev ){
	if( typeof(ev.preventDefault) != "undefined" ){
	  ev.preventDefault();
	}	
  },
    
  
  isAcceptedFormat: function( __name, __allowEmpty, __formats ){ // for input files, separate by comma the formats or "*" for all
    if(typeof(__formats) == "undefined") var __formats = "*";  // default
	__formats = __formats.toLowerCase();
	
	var __accepted = true;
	var __files = document.getElementsByName(__name);
	for(var i=0; i < __files.length; i++){
	  if(__allowEmpty && $f.empty(__files.item(i).value, 2)){
		continue;  
	  }
	  else{
		if(! __allowEmpty && $f.empty(__files.item(i).value, 2)){
		  __accepted = false;
		  break;
		}
		else{
		  var __pieces = (new String(__files.item(i).value)).split(".");
		  
		  if(__pieces.length >= 2){
			if(__formats == "*") continue;
			  
			var __arrFormats = __formats.replace(/\s+/gi, "").split(",");
			if($f.inArray((new String(__pieces[__pieces.length-1])).toLowerCase(), __arrFormats)){
			  continue;	
			}
			else{
			  __accepted = false;
			  break;
			}
		  }
		  else{
			__accepted = false; 
			break;
		  }
		}
	  }
	}
	
	return __accepted;
  },
  

  isLeapYear: function( __year ){
    if((__year % 4) == 0 && ((__year % 100) != 0 || (__year % 400) == 0)){
	  return true;
	}
	else{
	  return false;	
	}
  },
  
  
  getViewportHeight: function(){
	if( window.innerHeight != window.undefined )
	return window.innerHeight;
	
	if( document.compatMode == 'CSS1Compat' )
	return document.documentElement.clientHeight;
	
	if( document.body )
	return document.body.clientHeight; 

	return window.undefined; 
  },


  getViewportWidth: function(){
	if( window.innerWidth != window.undefined )
	return window.innerWidth; 
	
	if( document.compatMode == 'CSS1Compat' )
	return document.documentElement.clientWidth; 
	
	if( document.body )
	return document.body.clientWidth; 
  },


  getScrollTop: function() {
	if( self.pageYOffset ){// all except Explorer
	   return self.pageYOffset;
	}
	else if( document.documentElement && document.documentElement.scrollTop ){ // Explorer 6 Strict
	   return document.documentElement.scrollTop;
	}
	else if( document.body ){ // all other Explorers
	   return document.body.scrollTop;
	}
  },


  getScrollLeft: function() {
	if( self.pageXOffset ){ // all except Explorer
	   return self.pageXOffset;
	}
	else if( document.documentElement && document.documentElement.scrollLeft ){ // Explorer 6 Strict
	   return document.documentElement.scrollLeft;
	}
	else if( document.body ){ // all other Explorers
	   return document.body.scrollLeft;
	}
  },
  
  
  datediff: function( _date1, _date2 ){ // format dd/mm/yyyy
    var date1 = new String(_date1);
	var date2 = new String(_date2);
	return ($f.todays(date1) - $f.todays(date2));
  },
  
  
  todays: function(_date){ // format dd/mm/yyyy
	var days  = 0, days29 = 0;  
	var _date = (new String(_date)).split("/");
	var daysMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	
	_date[0] = parseInt(_date[0], 10);
	_date[1] = parseInt(_date[1], 10);
	_date[2] = parseInt(_date[2], 10);
	
	for(var i=1; i < _date[2]; i++){
      if($f.isLeapYear(i)){
	    days29++;
      }	  	
	}
    
	if($f.isLeapYear(_date[2])){
	  if(_date[1] > 2 || (_date[1]==2 && _date[0]==29)){
		daysMonth[1] = 29;
	  }
	}
	
	for(var i=0; i <= (_date[1] - 2); i++){
	  days += daysMonth[i];
	}
	
	days += ((_date[2] * 365) + _date[0] + days29);
	return days;
  }, 
  
  
  timediff: function( _time1, _time2 ){
    var _time1 = new String(_time1);
	var _time2 = new String(_time2);
	return ($f.tosecs(_time1) - $f.tosecs(_time2));
  }, 
  

  tosecs: function( _time ){
	if($f.isTime(_time, 2)){
	  var arrTime = (new String(_time)).split(":");
	  arrTime[0] = parseInt(arrTime[0], 10);
	  arrTime[1] = parseInt(arrTime[1], 10);
	  arrTime[2] = parseInt(arrTime[2], 10);
	  
	  var seconds = (arrTime[0] * Math.pow(60, 2));
	  seconds += ((arrTime[1] * 60) + arrTime[2]);
	  
	  return seconds;
	}
	else{
	  return 0;	
	}
  },
  
  
  lockKeys: function( ev ){ // put code of keys after event or use a string with the keys to lock (return lockKeys(event, 13, 9) || return lockKeys(event, "a[]{}@+", 13)
    var key = (window.event ? ev.keyCode : ev.which);
 
    for(var i=1; i < arguments.length; i++){
	  if(typeof(arguments[i]) == "number"){
		if(key == arguments[i]){
		  return false;
		}
	  }
	  else if(typeof(arguments[i]) == "string"){
		for(var j=0; j < arguments[i].length; j++){
		  if(key == arguments[i].charCodeAt(j)){
			return false;
		  }
		}
	  }
	}
	
	return true;
  },
  
  
  allowOnlyEmailKeys: function( ev ){ // onkeypress="return allowOnlyEmailKeys( event );"
    var val = $f.getEvent(ev).target.value;
  
    if( val.indexOf("@") > -1 && $f.getEvent(ev).charCode == 64 ){
	  return false;	
	}
	
	return $f.lockKeys(ev, '[]{}%#$^~´`?!|\\/=+,*¨;:()&§ºª°¢¹²³£¬<>', 32, 34, 39);
  },
  
  
  htmlentities: function( _text ){
    var char, entity="";
    var _text = new String(_text);
  
    for(var i=0; i < _text.length; i++){
	  char = _text.charCodeAt(i);
	  if((char > 47 && char < 58) || (char > 62 && char < 127)){            
	    entity += _text.charAt(i);
	  }
	  else{
	    entity += "&#" + _text.charCodeAt(i) + ";";
	  }
    }
    return entity;
  },
  
  
  addFavorite: function( url, title ){
    if( window.sidebar ){
  	  window.sidebar.addPanel(title, url, "");
	}
    else if( window.opera && window.print ){
      var o = document.createElement("a");
      o.setAttribute("rel", "sidebar");
      o.setAttribute("href", url);
      o.setAttribute("title", title);
      o.click();
    }
    else if( document.all ){
	  window.external.AddFavorite(url, title);
	}
  },  
  
  
  removeNode: function( id_obj ){
    var pNode = $f.$(id_obj).parentNode;
	var cNode = $f.$(id_obj);
    pNode.removeChild(cNode);
  },
  
  
  randomCode: function( _size ){ // max 12
    var s = (Math.abs(_size) > 12 ? 12 : Math.abs(_size));
	var base = new Array();
	base[0] = ((new Date()).getMilliseconds() * (new Date()).getSeconds());
	base[1] = (base[0] * 2);
	base[2] = Math.round(base[1] / 3);
	var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var _code = (new String(base.join(""))).split("");
	var strCode = "";
	
	for(var i in _code){
	  if((i + parseInt(_code[i], 10)) > 25){
		var pos = Math.floor(_code[i] / 2.5);
		strCode += (pos * 2) + chars.charAt(pos);  
	  }
	  else{
		strCode += Math.ceil(parseInt(_code[i], 10) * 1.5) + chars.charAt(parseInt(_code[i], 10));
	  }
	}
	
	strCode = strCode.toUpperCase();
	
	if((new Date()).getSeconds() % 2 == 0){
	  strCode = strCode.substr(0, s); 	
	}
	else{
	  strCode = strCode.slice(-s);	
	}
	
	return strCode;	
  },
  
  
  daysOfMonth: function(month, year){
    if(month < 8 && (month % 2) == 1 || month > 7 && (month % 2) == 0){
	  return 31;
    }
    if(month != 2){
	  return 30; 
    }
    if($f.isLeapYear(year)){
	  return 29;
    }
    return 28;
  }, 


  adddate: function( __identifier, days, __option ){
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }
  
    var arrdate = __identifier.split("/");
    var Month   = parseInt(arrdate[1], 10);
    var Year    = parseInt(arrdate[2], 10);
  
    if(days >= 0){
      var AddedDay = parseInt(arrdate[0], 10);
	  AddedDay += days;
	  
      while(AddedDay > $f.daysOfMonth(Month, Year)){
	    AddedDay -= $f.daysOfMonth(Month, Year);
	    Month++; 
	    if(Month > 12){
	      Month = 1;
	      Year++;
	    }
      }
    }
    else{
	  var AddedDay = parseInt(arrdate[0], 10);
      for(var i=0; i < (days * -1); i++){
	    if(AddedDay > 1){
	      AddedDay--;
	    }
	    else{
	      if(Month > 1){
		    Month--;
		  }
		  else{
		    Month=12;
		    Year--;
		  }
		  AddedDay = $f.daysOfMonth(Month, Year);
	    }
	  }							
    }
  
    AddedDay = $f.lpad(AddedDay, 2);
    Month    = $f.lpad(Month, 2);
    Year     = $f.lpad(Year, 4);
  
    return AddedDay.concat("/", Month, "/", Year);
  },


  insertAtCursor: function( idField, myValue ){
    var myField = $f.$(idField);
    if( document.selection ){ //IE
      myField.focus();
      var sel  = document.selection.createRange();
      sel.text = myValue;
    } // Mozila, NetScape
    else if( myField.selectionStart || myField.selectionStart == "0" ){
      var startPos  = myField.selectionStart;
      var endPos    = myField.selectionEnd;
      myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
    }
    else{
      myField.value += myValue;
    }
  },


  isIE: function(){
	var userAgent = navigator.userAgent.toString();  
	  
    if(document.all && userAgent.match(/MSIE.([0-9\.]*)/i)){
      return true;
    }
    else{
      return false;
    }
  },

  
  isOpera: function(){
    var nav = navigator.appName.toString();
	var userAgent = navigator.userAgent.toString();  	
	 
    if(nav.match(/^Opera$/i) && userAgent.match(/Opera.([0-9\.]*)/i)){
      return true;
    }
    else{
      return false;
    }	  
  },
  
  
  isSafari: function(){
	var userAgent = navigator.userAgent.toString(); 	  
	  
    if(userAgent.match(/(applewebkit|safari)\/([\d\.]*)/i) && !$f.isIE() && !$f.isOpera()){
	  return true;	
	}
	else{
	  return false;	
	}
  },

  
  isMozillaLine: function(){
	var userAgent = navigator.userAgent.toString(); 	  
	  
    if(userAgent.match(/Mozilla|Firefox|Gecko/gi)){
	  return true;	
	}
	else{
	  return false;	
	} 	  
  },


  isDownCapsLock: function( ev ){
    var e = ev || window.event;
    var _keyCode  = e.keyCode ? e.keyCode : e.which;
    var _keyShift = e.shiftKey ? e.shiftKey : ((_keyCode == 16) ? true : false);

    if(((_keyCode >= 65 && _keyCode <= 90) && !_keyShift) || ((_keyCode >= 97 && _keyCode <= 122) && _keyShift)){
      return true;
    }
    else{
      return false;
    }
  },


  inArray: function( objValue, array ){
    __return=false;
  
    for(var i in array){
      if(array[i] == objValue){
	     __return = true;
		 break;
	  }
    } 
	
    return __return;
  },
  
  
  inMatrix: function( objValue, matrix ){ // bidimensional
    __return=false;
  
    for(var i in matrix){
	  for(var j in matrix[i]){
		if(matrix[i][j] == objValue){
		   __return = true;
		   break;	
		}
	  }
    } 
	
    return __return;	  
  },


  addEvent: function( idobj, ev, func, useCapture ){
    if(window.addEventListener){
      $f.$(idobj).addEventListener(ev, func, useCapture); // Mozilla, Chrome
    }
    else if(window.attachEvent){
      $f.$(idobj).attachEvent("on" + ev, func); // IE
    }  
  },
  
  
  removeEvent: function( idobj, ev, func, useCapture ){
    if(window.addEventListener){
      $f.$(idobj).removeEventListener(ev, func, useCapture); // Mozilla, Chrome 
    }
    else if(window.attachEvent){
      $f.$(idobj).detachEvent("on" + ev, func); // IE
    }  
  },  


  addWindowEvent: function( ev, func, useCapture ){
    if(window.addEventListener){
      window.addEventListener(ev, func, useCapture); // Mozilla, Chrome
    }
    else if(window.attachEvent){
      window.attachEvent("on" + ev, func); // IE
    }
  },
  
  
  removeWindowEvent: function( ev, func, useCapture ){
    if(window.addEventListener){
      window.removeEventListener(ev, func, useCapture); // Mozilla, Chrome
    }
    else if(window.attachEvent){
      window.detachEvent("on" + ev, func); // IE
    }
  },  


  fckGetText: function( id ){ // gets the text from FCKEditor
    var theEditor = FCKeditorAPI.GetInstance(id);
    var _text     = theEditor.GetXHTML();
    return _text;
  },


  fckSetText: function( id, _text, clean ){
    var theEditor = FCKeditorAPI.GetInstance(id);
    theEditor.SetData(_text, clean);
  },
  
  
  fckFocus: function( id ){
    var theEditor = FCKeditorAPI.GetInstance(id);
    theEditor.Focus();
  }, 
  

  fckIsEmpty: function( id ){
    if($f.stripSpace($f.trim($f.stripTags($f.fckGetText(id), 2), 2), 2) == ""){
	  return true;	
	}
	else{
	  return false;	
	}
  },


  stripTags: function( __identifier, __option ){ // gi=global search
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }
  
    __identifier = __identifier.replace(/^\s*/, "");
    __identifier = __identifier.replace(/\s*$/, "");  
    __identifier = __identifier.replace(/<[^>]*>/gi, "");
    return __identifier;
  },


  stripSpace: function( __identifier, __option ){
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }

    __identifier = __identifier.replace(/&nbsp;/gi, "");
    return __identifier;
  },


  lpad: function( __value, __size, __fillWith ){
	if(typeof(__fillWith) == "undefined"){ __fillWith = "0"; }
	
	if(__fillWith.length == 0 || __fillWith.length > 1){
	  throw new Error("Value of filling must have length 1.");	
	}
	
	__value = new String(__value);
	
    if(__value.length >= __size){
	  return __value;
    }	
	
	for(var i=0; i <= __size; i++){
      __value = __fillWith + __value;	
	}

    return __value.slice(-__size); // copy back when it is negative
  },
  
  
  rpad: function( __value, __size, __fillWith ){
	if(typeof(__fillWith) == "undefined"){ __fillWith = "0"; }
	
	if(__fillWith.length == 0 || __fillWith.length > 1){
	  throw new Error("Value of filling must have length 1.");	
	}
	
    var v = new String(__value);
	
	if(v.length < __size){
	  var diff = __size - v.length;
	  for(var i=0; i < diff; i++){
	    v += __fillWith;
	  }
	  return v;
	}
	else{
	  return v;	
	}    
  },  
  
  
  div: function( n1, n2 ){ // operator div
	return (n2 > n1 ? 0 : (n1 == n2 ? 1 : Math.floor(n1 / n2)));
  },
   
  
  formatFloat: function( __float, __dec, __thousandSep, __decPoint ){
	if(isNaN(__float)){
	  return 0;	
	}
	
	if(typeof(__dec) == "undefined"){ __dec = 2; }	
	if(typeof(__thousandSep) == "undefined"){ __thousandSep = "."; }
	if(typeof(__decPoint) == "undefined"){ __decPoint = ","; }	
	
    var strNum     = new String(__float);
	var isNegative = (strNum.charAt(0) == "-" ? true : false);
	var strDec     = "";
	
	if(isNegative){
	  strNum = strNum.replace(/^[-]+/i, "");
	}

	if(strNum.indexOf(".") == -1){
	  strDec = $f.lpad(strDec, __dec, "0");
	  strNum = strNum.concat(".", strDec);
	}
	
	var arrV = [];
	arrV     = strNum.split(".");
    arrV[1]  = $f.rpad(arrV[1], __dec, "0");
	
	var arrNum  = [];	
	var sizeNum = arrV[0].length;
	
	arrNum = arrV[0].split("");	
	arrNum.reverse();
	arrV[0] = arrNum.join("");
    
	var arrN = new Array();
	
    for(var i=0; i < sizeNum; i += 3){
	  arrNum = [];
	  arrNum = (arrV[0].substr(i,3)).split("");
	  arrNum.reverse();
	  arrN.push(arrNum.join(""));
	}
	
	arrN.reverse();
	var number = (isNegative ? "-" : "") + arrN.join(__thousandSep) + __decPoint + arrV[1];
	
	return number;	
  },


  formatDate: function( __identifier, __option, formatTo ){
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }
	
	if(typeof(formatTo) == "undefined"){
	  formatTo = $f.FORMAT_SQL;	
	}
	
	var arrTime = [];
	if(formatTo == $f.FORMAT_SQL){
      arrTime = __identifier.split("/");
      arrTime.reverse();
	  return arrTime.join("-");
	}
	else{
      arrTime = __identifier.split("-");
      arrTime.reverse();
	  return arrTime.join("/");		
	}    
  },


  isDate: function( __identifier, __option ){
   if(typeof(__option) == "undefined"){
     var __identifier = new String($f.$(__identifier).value);
   }
   else if(__option == $f.BY_VALUE){
     var __identifier = new String(__identifier); 
   }  
   else{ // catches by id
     var __identifier = new String($f.$(__identifier).value);
   }	
	
   var arrDate = new Array();
   arrDate = __identifier.split("/");
   var __return = false;
   var DaysMonth = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
   
   if(! /^\d{2}\/\d{2}\/\d{4}$/.test(__identifier)){
	 return false;
   }
 
   var Day   = parseInt(arrDate[0], 10);
   var Month = parseInt(arrDate[1], 10);
   var Year  = parseInt(arrDate[2], 10);		 
	 
   if($f.isLeapYear(Year)){
     DaysMonth[1] = 29; // February in leap year
   }
	   
   if(Year > 0){
     if(Month > 0 && Month <= 12){
       if(Day > 0 && Day <= DaysMonth[(Month-1)]){
         __return = true;
       }
       else{
         __return = false;  
       }
     }
     else{
       __return = false;
     }
   }
   else{
     __return = false;
   }	 
 
   return __return;  
  },


  isCurrentDate: function( __identifier, __option, _strDateServer ){ // date must be true -> validating through the IsDate() | strDateServer = dd/mm/yyyy
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }

    var arrDate = new Array();
    arrDate = __identifier.split("/");
    var __return = false;
    var Day   = parseInt(arrDate[0], 10);
    var Month = parseInt(arrDate[1], 10);
    var Year  = parseInt(arrDate[2], 10); 

    var SysDate = new Date();
	if(typeof(_strDateServer) != "undefined"){
	  var arrDateServer=(new String(_strDateServer)).split("/");
	  SysDate.setDate(parseInt(arrDateServer[0], 10));
	  SysDate.setMonth(parseInt(arrDateServer[1], 10)-1);
	  SysDate.setYear(parseInt(arrDateServer[2], 10));	  
	}

    var SysYear  = parseInt(SysDate.getFullYear(), 10);
    var SysMonth = parseInt(SysDate.getMonth()+1, 10);
    var SysDay   = parseInt(SysDate.getDate(), 10);
 
    if(Year > SysYear){
      __return = true;
    }
    else if(Year == SysYear){
      if(Month > SysMonth){
        __return = true;
      }
      else if(Month == SysMonth){
        if(Day >= SysDay){
	      __return = true; 
	    }
	    else{
	      __return = false;
	    }
      }
      else{
        __return = false;
      }
    }
    else{
      __return = false;
    }
 
    return __return;
  },


  isTime: function(__identifier, __option, __format){
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }
	
	var format = (typeof(__format) != "undefined" ? __format : $f.TIME_FULL);
	
	switch(format){
	  case 1:
	    if(! /^\d{2}:\d{2}:\d{2}$/.test(__identifier)){
	      return false;
		}
	  break;
	  
	  case 2:
	    if(! /^\d{2}:\d{2}$/.test(__identifier)){
		  return false;
		}
	  break;
	  
	  default:
	    throw new Error("Time Format is not defined!!!");
	  break;		
	}
	
    var arrTime  = new Array();
    var __return = false;		
    arrTime      = __identifier.split(":");

    var __hours   = parseInt(arrTime[0], 10);	
    var __minutes = parseInt(arrTime[1], 10);
	
	if(format == $f.TIME_FULL){	
      var __seconds = parseInt(arrTime[2], 10);	
	}
		
    if(__hours >= 0 && __hours <= 23){
      if(__minutes >= 0 && __minutes <= 59){
		  
		if(format == $f.TIME_SHORT){
		  return true;	
		}
		  
        if(__seconds >= 0 && __seconds <= 59){
          return true; 
        }
        else{
          return false;	  
        }
		
      }
      else{
        return false; 
      }
    }
    else{
      return false; 
    }
  },


  noNumbers: function(ev){ // use on onkeypress [ return noNumbers() ]
    var key = (window.event ? ev.keyCode : ev.which);
 
    if(key > 47 && key < 58){
      return false;
    }
    else{   
      return true;
    }
  },


  isFone: function( __identifier, __option ){
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }	

    if(/^\(\d{2}\)\d{4}-\d{4}$/.exec(__identifier)){
      return true;
    }
    else{
      return false;
    }
  },


  isCEP: function( __identifier, __option ){
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }	
 
    if(/^\d{5}-\d{3}$/.test(__identifier)){
      return true;
    }
    else{
      return false;
    }
  },


  setFormat: function( mask, object ){ // put on OnKeyPress = "$f.setFormat('##/##/####', this)"
    object.maxLength = (new String(mask)).length;  
    var __len  = object.value.length;
    var __text = mask.substring(__len);

    if (__text.substring(0,1) != "#"){
	  object.value += __text.substring(0,1);
    }
  },
  

  getPos: function(object){
    var currLeft = 0;
	var currTop  = 0;
	var objLeft  = object;
	var objTop   = object;
  
    if( objLeft.offsetParent ){
      while( objLeft.offsetParent ){
        currLeft += objLeft.offsetLeft;
        objLeft = objLeft.offsetParent;
      }
    }
  
    if( objTop.offsetParent ){
      while( objTop.offsetParent ){
        currTop += objTop.offsetTop;
        objTop = objTop.offsetParent;
      }
    } 
	
    return {x:currLeft, y:currTop};
  },
  
  
  getXY: function(ev){ // mouse position
	var ev = (ev ? ev : window.event);  
	   
	if($f.isIE() || $f.isSafari()){
	  var x = ev.clientX + document.body.scrollLeft;
	  var y = ev.clientY + document.body.scrollTop;
	}
	else{
	  var x = ev.pageX;
	  var y = ev.pageY;
	}
	 
    return {x:x, y:y};
  },  


  moveList: function(id_fbox, id_tbox){ 
    var arrFbox   = new Array();
	var arrTbox   = new Array();
	var arrLookup = new Array();
    var fbox      = $f.$(id_fbox); // list from
    var tbox      = $f.$(id_tbox); // list to

    for(var i=0; i < tbox.options.length; i++){ 
      arrLookup[tbox.options[i].text]=tbox.options[i].value; 
      arrTbox[i]=tbox.options[i].text; 
    }
  
    var fLength=0;
	var tLength=arrTbox.length;
    for(var i=0; i < fbox.options.length; i++){ 
      arrLookup[fbox.options[i].text]=fbox.options[i].value; 
      if(fbox.options[i].selected && fbox.options[i].value != ""){ 
        arrTbox[tLength]=fbox.options[i].text; 
        tLength++; 
      } 
      else{ 
        arrFbox[fLength]=fbox.options[i].text; 
        fLength++; 
      } 
    } 

    arrFbox.sort(); 
    arrTbox.sort(); 
    fbox.length=0; 
    tbox.length=0;
  
    for(var c=0; c < arrFbox.length; c++){ 
      var no=new Option(); 
      no.value=arrLookup[arrFbox[c]]; 
      no.text=arrFbox[c]; 
      fbox[c]=no; 
    } 
  
    for(var c=0; c < arrTbox.length; c++){ 
      var no=new Option(); 
      no.value=arrLookup[arrTbox[c]]; 
      no.text=arrTbox[c]; 
      no.selected="selected";
      tbox[c]=no; 
    } 
  },


  empty: function( __identifier, __option ){
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }
    
	if($f.trim(__identifier, 2)==""){
	  return true;	
	}
	else{
	  return false;	
	}
  },
  

  emptySelect: function(id){
    var _Length=$f.$(id).length;
    var __return=true;
  
    for(var i=0; i < _Length; i++){
      if($f.$(id).options[i].selected){
	    __return=false;
	    break;
	  }
    }
  
    return __return;
  },


  cleanSelect: function(id){
    var _Length=$f.$(id).length;
  
    for(var i=0; i < _Length; i++){
      $f.$(id).options[i].selected = false;
    }  
  },
  
  
  fullSelect: function(id){
    var _Length=$f.$(id).length;
  
    for(var i=0; i < _Length; i++){
      $f.$(id).options[i].selected = true;
    }  
  },  


  trim: function( __identifier, __option ){
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }   
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }
  
    return __identifier.replace(/^\s*/, "").replace(/\s*$/, "");
  },


  isEmail: function( __identifier, __option ){
    var expEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,3})+$/; // regular expression for email
	
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }
  
	if(__identifier.lastIndexOf(".") == (__identifier.length-1)){
	  return false;
	}
	
    var arrEmail = __identifier.split(".");
	try{
	  if((new String(arrEmail[arrEmail.length-1])).length >= 4){
		return false;  
	  }
	}
	catch(e){}  
    finally{
      return expEmail.exec(__identifier);
	}
  },


  isNumber: function( __identifier, __option ){
    var expression=/^\d{1,}$/;	
	
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }
  
    return expression.exec(__identifier);
  },


  isFloat: function( __identifier, __option ){
    var expression=/^(\d+)(\.?)(\d*)$/;
	
    if(typeof(__option) == "undefined"){
      var __identifier = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var __identifier = new String(__identifier); 
    }  
    else{ // catches by id
      var __identifier = new String($f.$(__identifier).value);
    }
  
    return expression.test(__identifier);
  },


  isCPF: function( __identifier, __option ){
    __return = true;
  
    if(typeof(__option) == "undefined"){
      var CPF = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      var CPF = new String(__identifier);
    }  
    else{ // catches by id
      var CPF = new String($f.$(__identifier).value);
    }  
  
    if(! /^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(CPF)){
	  return false;	
	}
	
    CPF = CPF.replace(/[\.-]+/gi, "");
	
    if(/^0{11}|1{11}|2{11}|3{11}|4{11}|5{11}|6{11}|7{11}|8{11}|9{11}$/.test(CPF)){
      return false;
    }
	
	try{
	  var DIGITO = new Array(10);
	  var DV_INFORMADO = CPF.substr(9, 2);

	  for(var i=0; i <= 8; i++){
		DIGITO[i] = CPF.substr(i, 1);
	  }

	  var POSICAO = 10;
	  var SOMA = 0;

	  for(var i=0; i <= 8; i++){
		SOMA = (SOMA + DIGITO[i] * POSICAO);
		POSICAO = (POSICAO - 1);
	  }

	  DIGITO[9] = (SOMA % 11);

	  if(DIGITO[9] < 2){
		DIGITO[9] = 0;
	  }
	  else{
		DIGITO[9] = (11 - DIGITO[9]);
	  }

	  POSICAO = 11;
	  SOMA = 0;

	  for(var i=0; i <= 9; i++){
		SOMA = (SOMA + DIGITO[i] * POSICAO);
		POSICAO = (POSICAO - 1);
	  }

	  DIGITO[10] = (SOMA % 11);

	  if(DIGITO[10] < 2){
		DIGITO[10] = 0;
	  }
	  else{
		DIGITO[10] = (11 - DIGITO[10]);
	  }

	  var DV = (DIGITO[9] * 10 + DIGITO[10]);

	  if(DV != DV_INFORMADO){
		__return = false;
	  }
	}
	catch(e){
	  __return = false;
	}
  
    return __return;
  },


  isCNPJ: function( __identifier, __option ){
    if(typeof(__option) == "undefined"){
      CNPJ = new String($f.$(__identifier).value);
    }
    else if(__option == $f.BY_VALUE){
      CNPJ = new String(__identifier); 
    }  
    else{ // catches through the id
      CNPJ = new String($f.$(__identifier).value);
    }	
	
    __return = true;
  
    if(! /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/.test(CNPJ)){
      return false;
    }

    CNPJ = CNPJ.replace(/\D/gi, "");
  
    var a = [];
    var b = new Number();
    var c = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    for(var i=0; i < 12; i++){
      a[i] = CNPJ.charAt(i);
      b   += (a[i] * c[i+1]);
    }
  
    if((x=b % 11) < 2){
      a[12] = 0;
    }
    else{
	  a[12] = (11-x);
    }
  
    b = 0;
    for(var y=0; y < 13; y++){
      b += (a[y] * c[y]); 
    }

    if((x=b % 11) < 2){
	  a[13] = 0;
    }
    else{
	  a[13] = (11-x);
    }
  
    if((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
      __return = false;
    }
               
    return __return;
  },
   

  getEvent: function( ev ){
    var ev = (ev ? ev: (window.event ? window.event : null));
  
    if( ev ){
      originalEvent = ev;
      type    = ev.type;
      screenX = ev.screenX;
      screenY = ev.screenY;
      target  = (ev.target ? ev.target : ev.srcElement); // IE: srcElement
      
      if( ev.modifiers ){ // N4: modifiers
        altKey   = ev.modifiers & Event.ALT_MASK;
        ctrlKey  = ev.modifiers & Event.CONTROL_MASK;
        shiftKey = ev.modifiers & Event.SHIFT_MASK;
        metaKey  = ev.modifiers & Event.META_MASK;
      }
      else{
        altKey   = ev.altKey;
        ctrlKey  = ev.ctrlKey;
        shiftKey = ev.shiftKey;
        metaKey  = ev.metaKey;
      }

      // N4: which // N6+: charCode
      charCode = (!isNaN(ev.charCode) ? ev.charCode : (!isNaN(ev.keyCode) ? ev.keyCode : ev.which));
      keyCode  = (!isNaN(ev.keyCode) ? ev.keyCode : ev.which);
      button   = (!isNaN(ev.button) ? ev.button : (!isNaN(ev.which) ? ev.which-1 : null));
      debug    = ("c:"+ev.charCode+" k:"+ev.keyCode+" b:"+ev.button+" w:"+ev.which);
    }
	
	return {
	  target: target,
	  type: type,
	  screenX: screenX,
	  screenY: screenY,
      altKey: altKey,
      ctrlKey: ctrlKey,
      shiftKey: shiftKey,
      metaKey: metaKey,
      charCode: charCode,
      keyCode: keyCode,
      button: button
	}
  }  
  
} /* end class */


if( !window.open ){ // Implementation to supply the BUG of IE8
  $f.addWindowEvent("load", function(){ 
	var ANCHOR_WINDOW_OPEN = document.createElement("a");
	ANCHOR_WINDOW_OPEN.setAttribute("id", "ANCHOR_WINDOW_OPEN");
	ANCHOR_WINDOW_OPEN.setAttribute("href", "#");
	ANCHOR_WINDOW_OPEN.setAttribute("target", "_blank");
	ANCHOR_WINDOW_OPEN.innerHTML = "ANCHOR_WINDOW_OPEN";
	ANCHOR_WINDOW_OPEN.style.cssText = "display:none; visibility:hidden";
	document.body.appendChild( ANCHOR_WINDOW_OPEN );
  }, false);
	
  window.open = function( url ){
	try{
	  $f.$("ANCHOR_WINDOW_OPEN").setAttribute("href", url);
	  $f.$("ANCHOR_WINDOW_OPEN").click();
	}
	catch(e){}
  
	return {
	  focus: function(){},
	  close: function(){}, 
	  alert: function( msg ){ alert(msg); },
	  confirm: function( msg ){ return confirm(msg); }
	}
  }
}