<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link rel="stylesheet" href="style.css" type="text/css" />




<!--

	Does not support jQuery old versions

-->

<script type="text/javascript" src="jquery.1.6.1.js"></script>
<script type="text/javascript" src="jquery.multi_field_extender.js"></script>
<script type="text/javascript" src="idata.js"></script>
<script type="text/javascript" src="validation.js"></script>

<title>Validation</title>

<style type="text/css">



strong{ display:block}

span.validate-line-error {
  color:#FFBABA;
  
  
}


span.validate-line-success {
  color:#DFF2BF;
 
  
}

span.validate-line-loading {
  color:#E6E6E6;
 
  
}




.confirm_tooltip {
	display: inline;
	position: relative;
}
.tooltip  {
	background-color: #333333;
	color: #fff;
	display: block;
	height: 40px;
	left: -72px;
	padding: 5px !important; 
	position: absolute;
	top: -65px;
	width: 100px;
	text-align:center  !important;
	z-index:9999;
	font-family:Verdana, Arial, Helvetica, sans-serif !important;
	line-height: 12px  !important;
	font-size:12px !important;
	font-weight:normal !important;
	font-style:normal !important;
	border:2px solid #666666;
	border-radius:10px;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	-khtml-border-radius:10px;
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	filter:alpha(opacity=90);
	-moz-opacity:0.9;
	-khtml-opacity: 0.9;
	opacity: 0.9;
	cursor:default;
}


















label{
	display:block; width:auto}
	li{ display:block; list-style:none; background:#CCC; padding:10px; width:400px}
	li input, li textarea, li option, li select{ padding:5px; border:#666 1px solid; font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif; }
</style>

</head>

<body>


<h1>Totally onfly form validator</h1>

<h2>Params:</h2>






<strong>type:required/optional</strong>

<strong>accept:gif,jpg,png,jpeg    [  for input[type=file]  ]</strong>

<strong>ajax:name,url,method,success,error,loading,response</strong>

<strong>max:3</strong>

<strong>min:2</strong>


<strong>maxword:3</strong>

<strong>minword:2</strong>


<strong>msg:contents...</strong>

<strong>custommsg:messages in order to function</strong>

<strong>like:#id</strong>

<strong>notlike:#id</strong>

<strong>not:same text</strong>

<strong>in:web,cms ( must contained words web or cms )</strong>


<strong>notin:web,cms  ( must not contained words web or cms )</strong>



<strong>date:d-m-Y / dS F, Y ( like php date format character )</strong>

<strong>custom: email / letter / number / url / telephone / nospecialchar / phone / alnum / username / mobile / digit</strong>



<strong>hiddenvalid:yes</strong>

<strong>disablevalid:yes</strong>

<strong>readonlyvalid:yes</strong>

<strong>position: leftbottom, rightbottom, centerbottom, lefttop, righttop, centertop</strong>

<strong>arrow: show / hide</strong>

<strong>display: line / bubble</strong>
<!--text, select, multiple select, radio, checkbox, file, textarea
-->
<br />

<strong>Example: </strong>

<pre>
&lt;label for="ajax">Ajax : &lt;/label>

&lt;input  
  class="<strong>validate[
  
  type:required;  // means this field is required 
  
  response:success;    // means when we get "success" it will show success message
  
  custom:email;   // means custom validation 
  
  ajax:name,test.php,post,success msg,error msg,loading msg;  // means ajax setup 
  
  msg:This field is required;  // means error message
  
  position:leftbottom;  // means bubble message display position
  
  custommsg:Your email address is not valid;   // means custom error message after validation
  
  display:line  // means inline error message displayed not bubble.
  ]</strong>" 
  
  id="ajax" type="text"  />

</pre>



<strong>Javascript </strong>
<pre>



$('form').validate({
            
			'isreturn':false,
			'scroll':true,			
			'position':"righttop",	// leftbottom, rightbottom, centerbottom, lefttop, righttop, centertop			
			'validateusing':'class',  /*   default is class, 
            
            if you wish to use custom attribute you should use <em  style="color:#03F">data-&lt;name>="value"</em> 
            ex: &lt;input <em  style="color:#03F">data-validator="validate[type:.....]"</em> */
            
			'prefix':'validate',  //  prefix    &lt;input class="large <em style="color:#03F">validate</em>[type:.....]"
			'seperator':';',
			'arraw':true,			 // true /  false
			'wrap':'em',		//  wrap when bubble message off then message will wrapped by em means &lt;em> you can use span, level  etc
			'bubble':true    //  true /  false
			
        });

</pre>






<form action="rrr">

<ul >




<li class="clone"><label for="ajax">Ajax ( ajax example ): </label><input  class="validate[type:required;response:success; custom:email; ajax:name,test.php,post,success msg,error msg,loading msg; msg:This field is required; position:leftbottom;custommsg:Your email address is not valid; display:line]" id="ajax" type="text"  /></li>






<li><label for="date">Date ( date example ): </label><input   class="validate[type:required; date:dS F, Y; msg:This date field is required; display:line]" id="date" type="text" value="<?php echo date('dS F, Y') ?>" /></li>


<li><label for="date">Mobile : </label><input   class="validate[type:required; custom:mobile; msg:This date field is required; ]" id="m" type="text" value="" /></li>









<li><label for="pass">Password : </label><input  class="validate[type:required; min:3; not:123,abc; msg:This field is required]" id="pass" type="password" /></li>


<li><label for="repass">re Password : </label><input  class="validate[type:required; like:#pass; msg:This field is required; custommsg:Sorry! didnot match]" id="repass" type="password" /></li>


<li><label for="in">In : </label><input  class="validate[type:required; in:web,cms; msg:This field is required]" id="in" type="text" /></li>



<li><label for="notin">notIn : </label><input  class="validate[type:required; notin:web,cms; msg:This field is required]" id="notin" type="text" /></li>










<li ><label for="email">Email: </label><input  class="tag validate[type:required; custom:email; custommsg:Invalid email address; msg:This field is required;]"  id="email" type="text" /></li>


<li><label for="letter">Only letter: </label><input  class="tag validate[type:required; custom:letter;  custommsg:Only letter allowed; msg:This field is required]" id="letter" type="text" /></li>



<li><label for="letter">User Name: </label><input  class="tag validate[type:required; custom:username;  custommsg:User Name; msg:This field is required]" id="letter" type="text" /></li>





<li><label for="number">Only number: </label><input  class="tag validate[type:required; custom:number;  custommsg:Only number allowed; msg:This field is required]" id="number" type="text" /></li>


<li><label for="number">Digit: </label><input  class="tag validate[type:required; custom:digit;  custommsg:Digit; msg:This field is required]" id="number" type="text" /></li>






<li><label for="url">data url: </label><input  class="tag validate[type:required; custom:url;  custommsg:Invalid url; msg:This field is required]" id="url" type="text" /></li>

<li><label for="address">Address: </label>
<textarea id="address" class="tag validate[type:required; maxword:3;  msg:This field is required; custommsg:Maximum 3  word(s) allowed]"></textarea>
</li>

<li><label for="file">File: </label><input id="file"  class="tag validate[type:required; accept:gif,png,jpg; custommsg:Only accept %s extensions; msg:This field is required]" type="file" /></li>






<li><label for="selectone">Select-one: </label>
<select id="selectone" name="m"  class="validate[type:required; msg:This field is required]">
<option value="">Select</option>
<option value="1">One</option>
<option value="2">Two</option>

</select>
</li>


<li><label for="selectall">Select-multiple: </label>
<select multiple="multiple" id="selectall" name="nn[]"   class="validate[type:required; min:2; msg:This field is required;]">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
</select>
</li>



<li>
<label><input type="checkbox" id="c1" 	name="abc[]" value="1"   class="validate[type:required; max:2]" /> One </label>
<label><input type="checkbox"  id="c2"  name="abc[]" value="2"   class="validate[type:required; max:2] " /> 2 </label>
<label><input type="checkbox"  id="c3"  name="abc[]" value="3"   class="validate[type:required; max:2] " /> 3 </label>
<label><input type="checkbox"  id="c4" name="abc[]" value="4"   class="validate[type:required; max:2]" /> 4 </label>
<label><input type="checkbox" id="c5"  name="abc[]" value="5"   class="validate[type:required; max:2] " /> 5 </label>
</li>






<li>
<label><input type="checkbox" id="a" 	name="abcd[]" value="1"   class="validate[type:required; min:2]" /> One </label>
<label><input type="checkbox"  id="b"  name="abcd[]" value="2"   class="validate[type:required; min:2]" /> 2 </label>
<label><input type="checkbox"  id="c"  name="abcd[]" value="3"   class="validate[type:required; min:2]" /> 3 </label>
<label><input type="checkbox"  id="d" name="abcd[]" value="4"   class="validate[type:required; min:2]" /> 4 </label>
<label><input type="checkbox" id="e"  name="abcd[]" value="5"   class="validate[type:required; min:2]" /> 5 </label>
</li>


<li>
<label><input type="checkbox" id="lll"  name="abcde[]" value="5"   class="validate[type:required]" /> Privacy </label>
</li>



<li>
<label><input type="radio" id="r1" 	name="abcl[]" class="validate[type:required]" value="1" /> One </label>
<label><input type="radio"  id="r2" name="abcl[]" class="validate[type:required]" value="2" /> 2 </label>
<label><input type="radio"  id="r3" name="abcl[]" class="validate[type:required]" value="3" /> 3 </label>
<label><input type="radio" id="r4"  name="abcl[]" class="validate[type:required]" value="4" /> 4 </label>
<label><input type="radio" id="r5"  name="abcl[]" class="validate[type:required]" value="5" /> 5 </label>
</li>

<li>
<input type="submit"   /> &nbsp;
<input type="reset"   /> 
</li>


</ul>



</form>








<script type="text/javascript">



$('.clone').MultiField();





/*$('form').each(function(){
	
	
	
	
	$('div.validationmessagecontainer').live('click', function(){
		
		
		$(this).fadeOut().remove();
		
		
		});
	
	
	
	$.createerrormessage = function(selector){
		
		
		$validatetype = $.idata(selector,'validate','type',{'seperator' : ';' });
		$message =$.idata(selector,'validate','msg',{'seperator' : ';' });
		$message =  (typeof($message)=='undefined')?' required ':$message;
		
		
		$position = $(selector).position();
		$height = $(selector).outerHeight()+7;
		
		$width = $(selector).width()-40;
		//$value = $.trim( $(selector).val() );
		
		
		
		
		
		$('<div class="validationmessagecontainer"><div class="validate-bubble-error">'+$message+'<div class="validate-bubble-arrow-border-leftbottom"></div><div class="validate-bubble-arrow-leftbottom"></div></div></div>').appendTo(document.body).css('left',$position.left+$width).css('top',$position.top-$height).fadeIn() ;
		
		
		
		
		
	}
	
	
	
	
	
	$.checktype = function(selector)
	{
	
	
	$switch =  $(selector).prop('type');
	//$value =  $(selector).val('type');
	
	  switch($switch)
	  {
		case 'text':
		
		$.createerrormessage(selector);
		
		
		
		break;
		
		
		case 'textarea':
		
		$.createerrormessage(selector);
		
		
		
		break;
		
		  
		  
	  }
		
	
		//alert( $(selector).prop('type') );
		
	}
	
	
	
	
	
	
	
	
	
	
	$(this).find('[class*=validate]').live('blur',function(){
		
	
		
		$.checktype(this);
		
		
		
		
		
			
		//alert(	$(document.body).append('<div class="validationmessagecontainer"><div class="validate-bubble-error">'+$message+'<div class="validate-bubble-arrow-border-leftbottom"></div><div class="validate-bubble-arrow-leftbottom"></div></div></div>').attr('class') );
		
		
	
		

		//alert( $(this).attr('class'));
		
		
		
		
		
		
		
		});
		
		
		
		$(this).submit(function(){
			
			$(this).find('[class*=validate]').each(function(){
				
				
				$.checktype(this);
				
				
				
				//alert($(this).attr('class'));
				
				});
			
			
			return false;
			});
	
	
	
	
	
	});*/

</script>




<div class="validationmessage" style="display:none">




<div class="validationmessagecontainer">
<div class="validate-bubble-error">
  Buongiorno!
  <div class="validate-bubble-arrow-border-leftbottom"></div>
  <div class="validate-bubble-arrow-leftbottom"></div>
</div>

</div>

<br />

<div rel="">
<div class="validate-bubble-success">
  Success!
  <div class="validate-bubble-arrow-border-leftbottom"></div>
  <div class="validate-bubble-arrow-leftbottom"></div>
</div>

</div>

<br />

<div rel="">
<div class="validate-bubble-loading">
  Success!
  <div class="validate-bubble-arrow-border-leftbottom"></div>
  <div class="validate-bubble-arrow-leftbottom"></div>
</div>

</div>

<br />

<div rel="">
<div class="validate-bubble-error">
  Success!
  <div class="validate-bubble-arrow-border-rightbottom"></div>
  <div class="validate-bubble-arrow-rightbottom"></div>
</div>

</div>

<br />
<div rel="">
<div class="validate-bubble-error">
  Success!
  <div class="validate-bubble-arrow-border-lefttop"></div>
  <div class="validate-bubble-arrow-lefttop"></div>
</div>

</div>
<br />

<div rel="">
<div class="validate-bubble-error">
  Success!
  <div class="validate-bubble-arrow-border-righttop"></div>
  <div class="validate-bubble-arrow-righttop"></div>
</div>

</div>

<br />


<div rel="">
<div class="validate-bubble-error">
  Success!
  <div class="validate-bubble-arrow-border-centertop"></div>
  <div class="validate-bubble-arrow-centertop"></div>
</div>

</div>
<br />

<div rel="">
<div class="validate-bubble-success">
  Success!
  <div class="validate-bubble-arrow-border-centerbottom"></div>
  <div class="validate-bubble-arrow-centerbottom"></div>
</div>

</div>

<br />

<div rel="">
<div class="validate-bubble-success">
  Success!
  <div class="validate-bubble-arrow-border-none"></div>
  <div class="validate-bubble-arrow-none"></div>
</div>

</div>
</div>


<script type="text/javascript">

$('form').validate();





$('form').each(function(){//
	
	
	/*$(this).submit(function(){
		
	alert( $(this).validate({isreturn:true}) );
	
		
		
	
		
		});*/
	
	
	
	
	
});





</script>
</body>
</html>
