/*!
 * jQuery Based Inline form validation
 * http://www.richmediabd.com/
 *
 * Copyright 2011, Emran Ahmed (emran.bd.08@gmail.com)
 * Licensed under the GNU General Public License (GPL).
 *
 * NOTE:   Do Not works under jquery version 1.6.*
 *
 * Extends: idata.js
 *
 * Example:
 
 
 $('form').validate({
            
			'isreturn':false,
			'scroll':true,			
			'position':"righttop",	// leftbottom, rightbottom, centerbottom, lefttop, righttop, centertop			
			'validateusing':'class',
			'prefix':'validate',
			'seperator':';',
			'arraw':true,			
			'wrap':'em',		
			'bubble':true 
			
        });


 */

;(function ($) {
	
	$.fn.extend({
		
		
		"validate" : function(options){	
		var settings  = {
            
			'isreturn':false,
			'scroll':true,			
			'position':"righttop",	// leftbottom, rightbottom, centerbottom, lefttop, righttop, centertop			
			'validateusing':'class',
			'prefix':'validate',
			'seperator':';',
			'arraw':true,
			'wrap':'em',
			'bubble':true 
			
        };
					
			
					
					
					
					
				var setting = $.extend(settings,options);
				
				
				
				var returnValidation;
				
				
				
				this.each(function(){
				// start
					
				
					
					
				$.selector = this;
					
		
				$.isvalidate = false;
		
				
		
		$('div.validationmessagecontainer').live('click', function(){
		
		
		var $thisID = '#'+$(this).prop('rel');
		
		//$($thisID).focus();
		
		$(this).fadeOut().remove();
		
		
		});
		
		
		
		/**
		
		Remove Message
		
		
		*/
		
		$.removemsg = function(selector){
			
			
		
			
		if( typeof(selector)==='undefined' )
		{		
		$('div.validationmessagecontainer').fadeOut().remove();	
		return;
		}
			
		$(selector).next(setting.wrap).remove();	
			
		  var $thisID = $(selector).prop('id');
		  
		
		 $('div.validationmessagecontainer[rel='+$thisID+']').fadeOut().remove();
			
			
			
			};
		
		////////////////////////////////////////////////////////////////////////////
		
		
		/**
		
		Create message box
		
		*/
		
		 $.createmessage = function(selector, msgtype ,msg, usearrow){
		
		
		if( typeof(usearrow)==='undefined' )
		{		
		usearrow = true;			
		} 
		
		
		
		var new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		var msgdisplay = $.idata(selector,setting.prefix,'display',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		var arrowdisplay = $.idata(selector,setting.prefix,'arrow',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		if( arrowdisplay=='show' )
		{		
		usearrow = true;			
		} else if( arrowdisplay=='hide' ) {		
		usearrow = false;			
		} 
		
		
		
		
		//alert($new_position);
		
		//alert( new_position );
		
		//var $validatetype = $.idata(selector,setting.prefix,'type',{'seperator' : ';' });
		//var $message =$.idata(selector,setting.prefix,'msg',{'seperator' : ';' });
		var $message =  (typeof(msg)==='undefined')?' * Required ':msg;
		
		
		
		
		
		var $msgtype = $.trim(msgtype);
		
		
		
		if(setting.bubble==false)
		{ 
		  msgdisplay='line';
		}
		
		
		if( msgdisplay=='line')
		{
			
		//alert( "Line Valid" );	
		
		
		
		
		
		$(selector).next(setting.wrap).remove();
		
		
		$linehtml = "<"+setting.wrap+' class="'+$msgtype+'">';
		$linehtml +=$message;
		$linehtml += '</'+setting.wrap+'>';
		$(selector).after($linehtml);
		return;
		}
		
		
		
		
		//var $height = $(selector).height()+11;
		
		
		
		var $id = $(selector).prop('id');
		
		var $hasarrow = setting.arraw;
		
		
		
		
		//var $arrowclass = setting.position;
		
		var $arrowclass = new_position;
		
		if(  typeof($arrowclass)==='undefined' )
		{
			$arrowclass = setting.position;
			
		}
		
		
		
		
		var $position = $(selector).position();
		
		var $offset = $(selector).offset();
		
		
		var $height = $(selector).height();		
		var $width = $(selector).width();
		
		
		if( $(selector).prop('type')=='textarea' )
		{
			
			$height = 18;
		}
		
		
		if( $(selector).prop('type')=='select-one' )
		{
			
			$height = 18;
		}
		
		
		if( $(selector).prop('type')=='select-multiple' )
		{
			
			$height = 18;
		}
		
		
		
		
		
		if(  $(selector).prop('type')=='checkbox' || $(selector).prop('type')=='radio' )
		{
			  
		  $name = $(selector).prop('name');	
		  
		  
		  
		  
		  $fcheckbox =  $($.selector).find("input[name='"+$name+"']:first").prop('id');
			  
			  
			  
			  
			  
		$checkbox =  $($.selector).find("input[name='"+$name+"']:checked");
			  
			  
			  if($checkbox.size()<1)
			  {
				  
				 $id = $fcheckbox;
				 
				 //alert($fcheckbox);
			  }
			
			$height = 18;
		}
		
		
		
		
		switch($arrowclass)
		{
		//// leftbottom, rightbottom, centerbottom, lefttop, righttop, centertop
		case 'righttop':
		
		
		var $left = $offset.left+$width-40;
		var $top = $offset.top-$height-12;
		
		$cssclass = 'leftbottom';
		
		break;
		
		
		case 'lefttop':
		
		var $left = $offset.left-40;
		var $top = $offset.top-$height-11;
		$cssclass = 'rightbottom';
		break;
		
		
		case 'centertop':
		
		var $left = $offset.left-35;
		var $top = $offset.top-$height-11;
		$cssclass = 'centerbottom';
		break;
		
		
		
		case 'leftbottom':
		
		var $left = $offset.left;
		var $top = $offset.top+$height+15;
		$cssclass = 'lefttop';
		break;
		
		
		case 'rightbottom':
		var $top = $offset.top+$height+15;
		var $left = $offset.left-40;
		
		$cssclass = 'righttop';
		break;
		
		
		
		
		
		case 'centerbottom':
		
		var $left = $offset.left-11;
		var $top = $offset.top+$height+15;
		$cssclass = 'centertop';
		break;
		
		
		
		
		
			
		}
		
		
		//alert($.hiddenleft)
		
		
		if($.hiddenleft && $.hiddentop)
		{
		$cssclass = 'centerbottom';	
		
		$left = $.hiddenleft;
		$top = $.hiddentop;
		usearrow = false;
		}
		
		
		
		
		
		var $iscreated = $('div.validationmessagecontainer[rel='+$id+']').hasClass('validationmessagecontainer');
		
			if( !$iscreated )
			{
				
				
				if($msgtype=='loading'){
					
					$fadeIn=0;
					
					} else {
					
						$fadeIn='slow';
						
					}
				
				
			
				if($hasarrow && usearrow)
				{
				
				
				$('<div class="validationmessagecontainer" rel="'+$id+'"><div class="validate-bubble-'+$msgtype+'">'+$message+'<div class="validate-bubble-arrow-border-'+$cssclass+'"></div><div class="validate-bubble-arrow-'+$cssclass+'"></div></div></div>').appendTo(document.body).css('left',$left).css('top',$top).fadeIn($fadeIn) ;	
					
				} else {
					
					$('<div class="validationmessagecontainer" rel="'+$id+'"><div class="validate-bubble-'+$msgtype+'">'+$message+'</div></div>').appendTo(document.body).css('left',$left).css('top',$top).fadeIn($fadeIn) ;
					
					
				}
			
			
			
			//alert( $top );
			
			$h =  $('div.validationmessagecontainer[rel='+$id+']').outerHeight();
			
			//// leftbottom, rightbottom, centerbottom, lefttop, righttop, centertop
			
			//alert($h);
			
			
			
			
			if( $h>26 )
			{
				
			
			$css =  $('div.validationmessagecontainer[rel='+$id+']').position().top;
			
			//alert( 'barasa' );
			
			if($('#'+$id).prop('type')=='textarea' || $('#'+$id).prop('type')=='select-multiple')
			{
				
				
				$h = 20;
			} else {
				
				$h = $h-26;
				
				
				}
			
			
			
			
			
			if($arrowclass=='righttop' || $arrowclass=='centertop' || $arrowclass=='lefttop')
			{
				
				
			  $('div.validationmessagecontainer[rel='+$id+']').animate({		  
			  top: '-='+$h
			  }, 'slow');
				
			} 
			
				
			}
			
			
			
			}
		
		
		
		};
		
		
		
		
		
		
		
		
		/**
		
		Checking custom validation
		
		*/
		
		
		
		
		
		
		$.check_custom = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'custom',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			
			var $value =  $.trim($(selector).val());
			
			
			var $message =  (typeof($custommsg)==='undefined')?'* Invalid '+$fn+' ':$custommsg;
			
			
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			
			
			switch($fn){
				
				case 'email':
				
				  var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
				  $validate = pattern.test($value); 
				  
				  if($validate){
					  
					  $.isvalidate = true;	
					  
					  }
				  else{				
				 		
				  $.createmessage(selector,'error',$message);
				  	 $.isvalidate = false;	
				  }
				
				
				break;
				
				
				
				case 'letter':
				
				  var pattern = /^[a-zA-Z\ \']+$/;  
				  $validate = pattern.test($value); 
				  
				  if($validate){$.isvalidate = true;	}
				  else{				
				  $.isvalidate = false;			
				  $.createmessage(selector,'error',$message);	
				  }
				
				
				break;
				
				
				case 'alpha':
				
				  var pattern = /^[a-zA-Z]+$/;  
				  $validate = pattern.test($value); 
				  
				  if($validate){$.isvalidate = true;	}
				  else{				
				  $.isvalidate = false;			
				  $.createmessage(selector,'error',$message);	
				  }
				
				
				break;
				
				
				
				case 'number':
				
				  var pattern = /^[0-9]+$/;  
				  $validate = pattern.test($value); 
				  
				  if($validate){$.isvalidate = true;	}
				  else{				
				  $.isvalidate = false;			
				  $.createmessage(selector,'error',$message);	
				  }
				
				
				break;
				
				
				
				case 'url':
				
				  var pattern = /^(ftp|http|https):\/\/[a-zA-Z0-9-\.]+\.[a-zA-Z0-9-]{2,4}\/?(.+)?$/;  
				  $validate = pattern.test($value); 
				  
				  if($validate){$.isvalidate = true;	}
				  else{				
				  $.isvalidate = false;			
				  $.createmessage(selector,'error',$message);	
				  }
				
				
				break;
				
				
				case 'telephone':
				
				  var pattern = /^[0-9\-\(\)\ ]+$/;  
				  $validate = pattern.test($value); 
				  
				  if($validate){$.isvalidate = true;	}
				  else{				
				  $.isvalidate = false;			
				  $.createmessage(selector,'error',$message);	
				  }
				
				
				break;
				
				
				
				
				
				case 'digit':
				
				  var pattern = /^-{0,1}\d*\.{0,1}\d+$/;  
				  
				  
				  
				  $validate = pattern.test($value); 
				  
				  if($validate){$.isvalidate = true;	}
				  else{				
				  $.isvalidate = false;			
				  $.createmessage(selector,'error',$message);	
				  }
				
				
				break;
				
				
				
				
				
				case 'mobile':
				case 'phone':
				
				 // var pattern = /^\+{0,1}\d{5,15}\s*$/;  
				  
				   var pattern = /^[\+{0,1}0-9{5,16}\ ]+$/; 
				  
				  
				  $validate = pattern.test($value); 
				  
				  if($validate){$.isvalidate = true;	}
				  else{				
				  $.isvalidate = false;			
				  $.createmessage(selector,'error',$message);	
				  }
				
				
				break;
		
				
				
				
				
				
				case 'nospecialchar':
				case 'alnum':
				  var pattern = /^[0-9a-zA-Z]+$/;  
				  $validate = pattern.test($value); 
				  
				  if($validate){$.isvalidate = true;	}
				  else{				
				  $.isvalidate = false;			
				  $.createmessage(selector,'error',$message);	
				  }
				
				
				break;
				
				
				
				
				
				case 'username':
				
				  var pattern = /^[0-9a-zA-Z\-\_]+$/;  
				  $validate = pattern.test($value); 
				  
				  if($validate){$.isvalidate = true;	}
				  else{				
				  $.isvalidate = false;			
				  $.createmessage(selector,'error',$message);	
				  }
				
				
				break;
				
				
				
				
				
				
				}
			
			
			
			
			
			
			
			
		};
		
		
		
		
		
		
		
		
		
		
		
		
		/**
		
		Checking :file access
		
		*/
		
		
		
		$.check_access = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'accept',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			
			var $value =  $.trim($(selector).val());
			
			
			var $message =  (typeof($custommsg)==='undefined')?'* Only '+$fn+' extensions allowed. ':$custommsg;
			
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			
			
			var files = $fn.split(',');
			
			var pieces = $value.split('.');
			var ext=pieces[pieces.length-1];
			var getexts = ext.toLowerCase();
			
			
			
			
			$match =  $.inArray(getexts,files);
			
			
			if( $match=='-1' )
			{
				
				 $.isvalidate = false;	
				 
				 
				 $message = $message.replace("%s", $fn);
				 		
				$.createmessage(selector,'error',$message);	
				
			} else {
				
				$.isvalidate = true;	
				
				}
			
			
			
			
			
			
			
		};
		
		
		
		
		/**
		
		Ajax validation
		
		*/
		
		
		$.check_ajax = function(selector, $responseText)
		{
			
			
			//alert($.isvalidate);
			
			
			
			if(!$.isvalidate)
			{
			 return;	
				
			}
			


			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'ajax',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			
			
			var $value =  $.trim($(selector).val());
			
			
			var $thisID = $(selector).prop('id');
			
			
			var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			//var $message =  (typeof($custommsg)==='undefined')?' * Only '+$fn+' extensions allowed. ':$custommsg;
			
			
			var $params = $fn.split(',');
			
			
			
			var $name = $.trim($params[0]);
			var $url = $.trim($params[1]);
			var $method = $.trim($params[2]).toUpperCase();
			var $success = $.trim($params[3]);
			var $error = $.trim($params[4]);
			var $loading = $.trim($params[5]);
			
			//alert($method);
			
			
			
			$.isvalidate = false;	
				 
				 
	
		
		$.removemsg(selector);			
		$.createmessage(selector,'loading',$loading);
		 
		

		
		$.ajax({
			url: $url,
			type: $method,
			data: $name+'='+$value,	
			cache: false,			
			global: false,
			async: false,
			
			
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				
				
			$.removemsg(selector);	
					
			$.createmessage(selector,'error',XMLHttpRequest.status+'  '+errorThrown);
			$.isvalidate  = false;
				
			},
			
			
			

			success: function(msg){
				
				
				var $resp = $.trim(msg);
				
				
				if($resp==$responseText)
				{
					
				$.isvalidate  = true;
				//$.ajaxvalidate=true;	
				$.removemsg(selector);					
				$.createmessage(selector,'success',$success);
				
					
					
					//alert($isValid)
									
				} else {
				$.isvalidate  = false;
				//$.ajaxvalidate=false;	
				$.removemsg(selector);					
				$.createmessage(selector,'error',$error);
				//alert($.isvalidate)
					
				}
				
				
				
				
				}
				
			}); 
		
		 
			
			
		
		
		
				
				//alert($.isvalidate )
				
		
			
			
		};
		
		
		
		
		
		
		/**
		
		checking maximum value
		
		*/
		
		
		
		$.check_max = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'max',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			
			var $value =  $.trim($(selector).val());
			
			
			var $message =  (typeof($custommsg)==='undefined')?'* Maximum '+$fn+' character allowed. ':$custommsg;
			
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			
			if( $value.length>$fn )
			{
				
			$.isvalidate = false;	
			$.createmessage(selector,'error',$message);	
				
			} else {
				
				$.isvalidate = true;	
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		
		
		
		
		
		
		
		
		
		
		/**
		
		date validation
		
		*/
		
		$.check_date = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'date',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			var $value =  $.trim($(selector).val());
			
			var $like = $fn;
			
		/*$patt = /[^a-z0-9]/gi;
		
		
		$unc =  $value.match($patt);
		
		
		$unc = $.unique($unc);
		$unc = $.unique($unc);
		
		var s;
		for($i=0; $i<$unc.length; $i++)
		{
		
		$search = new RegExp($unc[$i],'g');
		
		//alert( $unc[$i] );
		
		// $fn = $fn.replace($search, '\\'+$unc[$i]+'\\');
		
		}
		
		
	//	$value = 
			
		//alert( $fn );*/
		
		
		
		
		
		var formats={
		
		'd':'(\\d{2})',
		'D' :'(\\w{3})',		
		'j': '(\\d{1,2})',
		
		'l': '(\\w{3,10})',
		'S': '(\\w{2})',
		'F': '(\\w{3,10})',
		
		'm': '(\\d{2})',
		
		'M': '(\\w{3})',
		'n': '(\\d{1,2})',
		
		'Y': '(\\d{4})',
		
		'y': '(\\d{2})',
		
		'a': '(\\w{2})',
		'A': '(\\w{2})',
		'h': '(\\d{2})',
		
		'i': '(\\d{2})',
		's': '(\\d{2})',
		'e': '(\\w{3,6})',
		
		//'O': '[0-9+]{5,7}'
		}; // literal array
		
		
		
		
		
		
		for (var key in formats) {
			
		$search = new RegExp(key,"g");
		
		//alert($search)
		
		$fn = $fn.replace($search, formats[key]);
		
		//alert($fn);

		
		}
		
		//       "/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/"
		// /^[0-9]{2}\-\[0-9]{2}\-\[0-9]{4}$/
		
		var regexp = new RegExp("^"+$fn+"$");
		
		
		
		
		var $isMatch = regexp.test($value);

			
		var $message =  (typeof($custommsg)==='undefined')?' Invalid date format. <br>Valid format:'+$like+' ':$custommsg;
			
			
			
			
			
			
			if( $isMatch  )
			{
				
			
			$.isvalidate = true;	
				
				
			} else {
				
			
			$.createmessage(selector,'error',$message);	
			$.isvalidate = false;		
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		/**
		
		
		check like
		
		
		*/
		
		
		$.check_like = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'like',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			var $value =  $(selector).val();
			
		
			
			
			var $checkval = $($fn).val();
			
			var $message =  (typeof($custommsg)==='undefined')?' Didn\'t match . ':$custommsg;
			
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			
			if( $checkval===$value  )
			{
				
			
			$.isvalidate = true;	
				
				
			} else {
				
			
			$.createmessage(selector,'error',$message);	
			$.isvalidate = false;		
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		/**
		
		
		ckeck not like
		
		*/
		
		$.check_notlike = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'notlike',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			
			var $value =  $(selector).val();
			
		
			
			
			var $checkval = $($fn).val();
			
			var $message =  (typeof($custommsg)==='undefined')?' Matched, try another . ':$custommsg;
			
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			
			if( $checkval===$value  )
			{
				
			
			
			
			$.createmessage(selector,'error',$message);	
			$.isvalidate = false;		
				
				
			} else {
				
			$.isvalidate = true;
				
				
			}
			
			
			
			
			
			
			
		};
		
		
		/**
		
		check not
		
		*/
		
		$.check_not = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'not',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			var $value =  $.trim($(selector).val());
			
			
			
			
			var $texts = $fn.split(',');
			
			
			$has = $.inArray($value, $texts) ;
						
			var $message =  (typeof($custommsg)==='undefined')?' Cann\'t type '+$fn+' ':$custommsg;
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			/*
			*/
			
			
			if( $has=='-1'  )
			{
				
			
			
			$.isvalidate = true;
					
				
				
			} else {
				
			
			$.createmessage(selector,'error',$message);	
			$.isvalidate = false;
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		/**
		
		check in
		
		*/
		
		
		$.check_in = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'in',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			var $value =  $.trim($(selector).val());
			
			
			var $container = $fn.split(',');
			
			
			$container = $.unique($container);
			
			
			//alert($fn);
			var $hasItem = false;
			
			var $content = $value.split(/\s+/);
			
			for($i=0; $i<$container.length; $i++)
			{
			
			var $val = $container[$i];
			
			
			
			$has = $.inArray($val, $content);
			
			
			
			if( $has=='-1' )
			{				
				$hasItem = false;	
				
			} else {
				
				$hasItem = true;	
				break;
			}
				
			}
			
			
			
			//document.write(str.match(patt1));
			
			
			
			
			
			
			//$has = $.inArray($value, $texts) ;
						
			var $message =  (typeof($custommsg)==='undefined')?' * Field value may contained '+$fn+' ':$custommsg;
			
			
			
			/*
			*/
			
			
			if( $hasItem  )
			{
				
			
			
			$.isvalidate = true;
					
				
				
			} else {
				
			
			$.createmessage(selector,'error',$message);	
			$.isvalidate = false;
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		/**
		
		check not in
		
		**/
		
		$.check_notin = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'notin',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			var $value =  $.trim($(selector).val());
			
			
			var $container = $fn.split(',');
			
			
			$container = $.unique($container);
			
			
			//alert($fn);
			var $hasItem = false;
			
			var $content = $value.split(/\s+/);
			
			for($i=0; $i<$container.length; $i++)
			{
			
			var $val = $container[$i];
			
			
			
			$has = $.inArray($val, $content);
			
			
			
			if( $has=='-1' )
			{				
				
				
				$hasItem = true;	
				//break;
				
			} else {
				
				$hasItem = false;
			}
				
			}
			
			
			
			//document.write(str.match(patt1));
			
			
			
			
			
			
			//$has = $.inArray($value, $texts) ;
						
			var $message =  (typeof($custommsg)==='undefined')?' * Field value may not contained '+$fn+' ':$custommsg;
			
			
			
			/*
			*/
			
			
			if( $hasItem  )
			{
				
			
			
			$.isvalidate = true;
					
				
				
			} else {
				
			
			$.createmessage(selector,'error',$message);	
			$.isvalidate = false;
				
			}
			
			
			
			
			
			
			
		};
		
		
		/**
		
		check min
		
		*/
		
		
		$.check_min = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'min',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			var $value =  $.trim($(selector).val());
			
			
			var $message =  (typeof($custommsg)==='undefined')?'* Minimum '+$fn+' character allowed. ':$custommsg;
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			//alert($fn);
			
			
			
			if( $value.length<$fn )
			{
				
			$.isvalidate = false;	
			$.createmessage(selector,'error',$message);	
				
			} else {
				
				$.isvalidate = true;	
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		
		/**
		
		check max select
		
		*/
		
		$.check_max_select = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'max',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			//var $value =  $.trim($(selector).val());
			
			
			var $message =  (typeof($custommsg)==='undefined')?'* Maximum '+$fn+' option allowed. ':$custommsg;
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			
			var $value = $(selector).find('option:selected');
			
			
			
			if( $value.length>$fn )
			{
				
			$.isvalidate = false;	
			$.createmessage(selector,'error',$message);	
				
			} else {
				
				$.isvalidate = true;	
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		/**
		
		
		check min select
		
		**/
		
		$.check_min_select = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'min',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			//var $value =  $.trim($(selector).val());
			
			
			var $message =  (typeof($custommsg)==='undefined')?'* Should have minimum '+$fn+' option. ':$custommsg;
			
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			
			var $value = $(selector).find('option:selected');
			
			
			
			if( $value.length<$fn )
			{
				
			$.isvalidate = false;	
			$.createmessage(selector,'error',$message);	
				
			} else {
				
				$.isvalidate = true;	
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		/**
		
		
		check max word
		
		*/
		
		$.check_maxword = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'maxword',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			var $value =  $.trim($(selector).val());
			
			
			var $message =  (typeof($custommsg)==='undefined')?'* Maximum '+$fn+' word(s) allowed. ':$custommsg;
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			var $length = $value.split(/\s+/).length
			
			
			//alert($fn);
			
			if( $length>$fn )
			{
				
			$.isvalidate = false;	
			$.createmessage(selector,'error',$message);	
				
			} else {
				
				$.isvalidate = true;	
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		/**
		
		
		check min word
		
		
		*/
		
		$.check_minword = function(selector)
		{
			
			var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			var $fn =$.idata(selector,setting.prefix,'minword',{'seperator' : setting.seperator,'using':setting.validateusing });
			
			if( typeof($fn)==='undefined' )
			{
			return;	
			}
			
			
			var $value =  $.trim($(selector).val());
			
			
			var $message =  (typeof($custommsg)==='undefined')?'* Minimum '+$fn+' word(s) allowed. ':$custommsg;
			
			
			
			//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			
			
			$length = $value.split(/\s+/).length
			
			
			//alert($fn);
			
			if( $length<$fn )
			{
				
			$.isvalidate = false;	
			$.createmessage(selector,'error',$message);	
				
			} else {
				
				$.isvalidate = true;	
				
			}
			
			
			
			
			
			
			
		};
		
		
		/**
		
		
		max check box
		
		*/
		
		$.check_maxcheckbox = function(selector)
		{
			
		var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
		var $fn =$.idata(selector,setting.prefix,'max',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
		if( typeof($fn)==='undefined' )
			{
			return;	
			}
		
		
		
		
		var $message =  (typeof($custommsg)==='undefined')?'* Maximum '+$fn+' option(s) allowed. ':$custommsg;
		
		//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
				
				
				
			
			
			$name = $(selector).prop('name');
			
			var $group =  $($.selector).find("input[name='"+$name+"']:checked");
			
			var $id =  $($.selector).find("input[name='"+$name+"']:first");
			//alert( $fn );
			
			
			//alert($group.size());
			
			if( $group.size()>$fn )
			{
				
			$.isvalidate = false;	
			$.createmessage($id,'error',$message,false);	
				
			} else {
				
				$.isvalidate = true;	
				
			}
			
			
			
			
			
			
			
		};
		
		/**
		
		
		
		min checkbox
		
		
		
		*/
		
		$.check_mincheckbox = function(selector)
		{
			
		var $custommsg =$.idata(selector,setting.prefix,'custommsg',{'seperator' : setting.seperator,'using':setting.validateusing });
			
		var $fn =$.idata(selector,setting.prefix,'min',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
		if( typeof($fn)==='undefined' )
			{
			return;	
			}
		
		
		
		
		
		var $message =  (typeof($custommsg)==='undefined')?'* Should have minimum '+$fn+' option(s). ':$custommsg;
		//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
			
			
			$name = $(selector).prop('name');
			
			var $group =  $($.selector).find("input[name='"+$name+"']:checked");
			
			var $id =  $($.selector).find("input[name='"+$name+"']:first");
			//alert( $fn );
			
			
			//alert($group.size());
			
			if( $group.size()<$fn )
			{
				
			$.isvalidate = false;	
			$.createmessage($id,'error',$message,false);	
				
			} else {
				
				$.isvalidate = true;	
				
			}
			
			
			
			
			
			
			
		};
		
		
		
		
		
		
		$.hiddenleft=false;
		$.hiddentop=false;
		
		
		$.validit = function(selector)
		{
		
		
		var $switch =  $(selector).prop('type');
		var $value =  $.trim($(selector).val());
		
		
		var $valtype = $.trim($.idata(selector,setting.prefix,'type',{'seperator' : setting.seperator,'using':setting.validateusing }));
		
		
		
		//alert($valtype)
		
		if($valtype=='optional' && $value=='')
		{
			return;
		}
		
		
		
		var $message =$.idata(selector,setting.prefix,'msg',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		//var $new_position =$.idata(selector,setting.prefix,'position',{'seperator' : setting.seperator,'using':setting.validateusing });
		
		
		
		
		
		//alert( $new_position );
		
		
		
		
		var $custom =$.trim($.idata(selector,setting.prefix,'custom',{'seperator' : setting.seperator,'using':setting.validateusing }));
		
		//alert( $switch );
		//
		
		
		if( typeof($custom)==='undefined' )
			{
			return;	
			}
			
			
			
			
			
			
		
		
		
		var $disablevalidation =$.trim($.idata(selector,setting.prefix,'disablevalid',{'seperator' : setting.seperator,'using':setting.validateusing }));
		
		
		var $invisiblevalidation =$.trim($.idata(selector,setting.prefix,'hiddenvalid',{'seperator' : setting.seperator,'using':setting.validateusing }));
		
		
		var $readonlyvalidation =$.trim($.idata(selector,setting.prefix,'readonlyvalid',{'seperator' : setting.seperator,'using':setting.validateusing }));
		
		
		var $responseText =$.trim($.idata(selector,setting.prefix,'response',{'seperator' : setting.seperator,'using':setting.validateusing }));
		
		
		
		var $isDisabled = $(selector).is(':disabled');
		var $isHidden = $(selector).is(':hidden');
		var $isReadonly = $(selector).prop('readonly');
		
		
		if( $disablevalidation=='yes' ||  $invisiblevalidation=='yes' || $readonlyvalidation=='yes')
		{
			
			
			if($invisiblevalidation=='yes' && $isHidden)
			{
				
				
				
				$(selector).show();
				 $.hiddenleft =  $(selector).parents('form').offset().left;
				
				
				if( !$(selector).is(':hidden') )
				{
				$.hiddentop =  $(selector).offset().top;	
				} else {
					
				$.hiddentop =  $(selector).parents('form').offset().top-26;
				
				}
				
				 
				 
				 $(selector).hide();
				 
				 
				 
				//  $.hiddenleft =  $(selector).prevUntil(':not(:hidden)').position().left;
				
				// $.hiddentop =  $(selector).prevUntil(':not(:hidden)').position().top;
				
				//alert($(selector).parents('form').position().left);
				
			}
			
			
		} else if( $isDisabled || $isHidden || $isReadonly ) {
			
			return;
			
		} else {
			
			
			$.hiddenleft = false;
			$.hiddentop = false;
			
			}
		
		
		/////////////////////////
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/////////////////////////////////////
		
		switch($switch)
		{
		case 'text':
		case 'textarea':
		case 'password':
		
		if($value==''){	
				
			$.createmessage(selector,'error',$message);
			$.isvalidate = false;	
			
		} else {
		
		$.isvalidate = true;	
		//alert($custom);
		
		$.check_custom(selector);
		$.check_max(selector);
		$.check_min(selector);
		$.check_maxword(selector);
		$.check_minword(selector);		
		$.check_like(selector);
		$.check_notlike(selector);
		$.check_not(selector);
		$.check_in(selector);
		$.check_notin(selector);
		$.check_date(selector);
		$.check_ajax(selector, $responseText);
	
		
		
		}
		
		break;
		
		
		
		
		
		
		
		case 'select-one':
		
		
		if($value==''){	
				
			$.createmessage(selector,'error',$message);
			$.isvalidate = false;	
			
		} else {
		
		$.isvalidate = true;	
		//alert($custom);
		
		/*$.check_custom(selector);
		$.check_max(selector);
		$.check_maxword(selector);
		$.check_minword(selector);*/
		
		}
		
		break;
		
		
		
		case 'select-multiple':
		
		
		if($value==''){	
				
			$.createmessage(selector,'error',$message);
			$.isvalidate = false;	
			
		} else {
		
		$.isvalidate = true;
		
		$.check_max_select(selector);
		$.check_min_select(selector);
		//alert($custom);
		
		/*$.check_custom(selector);
		$.check_max(selector);
		$.check_maxword(selector);
		$.check_minword(selector);*/
		
		}
		
		break;
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		case 'file':
				
		if($value==''){	
				
			$.createmessage(selector,'error',$message);
			$.isvalidate = false;	
			
		} else {

		
		$.isvalidate = true;	
		//alert($custom);
		
		$.check_access(selector);
		
		
		
		}
		
		break;
		
		
		
		
		
		/**   PADNDING */
		
		case 'checkbox':
				
				
			if(!$message)
			{
			$message = 'Please check option(s)';	
			}
				
			$name = $(selector).prop('name');	
			
			
			
			var $group =  $($.selector).find("input[name='"+$name+"']:checked");
			
			
			//alert( $group.first().val() );
			
			if($group.size()<1)
			{
			$.createmessage(selector,'error',$message);
			$.isvalidate = false;
			} else {
				
				$.isvalidate = true;
				
				$.check_maxcheckbox(selector);
				$.check_mincheckbox(selector);
			}
			
			//alert( group.prop('name') );
			
		
		
		
		
		
		break;
		
		
		
		
		
		
		
		
		
		
		
		case 'radio':
				
				
			if(!$message)
			{
			$message = 'Please check option(s)';	
			}
				
			$name = $(selector).prop('name');	
			
			
			
			var $group =  $($.selector).find("input[name='"+$name+"']:checked");
			
			
			//alert( $group.first().val() );
			
			if($group.size()<1)
			{
			$.createmessage(selector,'error',$message);
			$.isvalidate = false;
			} else {
				
				$.isvalidate = true;
				
				
			}
			
			//alert( group.prop('name') );
			
		
		
		
		
		
		break;
		
		
		
		
		
		
		
		
		
		
		
		}
		
		
		//alert( $(selector).prop('type') );
		
		};
		
		
		
		
		
		
		
		
		

		
		$(this).find('input[type="reset"]').live('click',function(){
			
			
			
			$.removemsg();
			
			
		//	alert('reset');
			
			
			
			});
		
		
		
		
		
		$(this).find('[class*='+setting.prefix+']').live('blur',function(){
		
		
		
		
		
		
		
		
		$prop = $(this).prop('type');
	
		
		
		if( $prop=='checkbox' || $prop=='radio' )
		{} else {
		
		$.removemsg(this);
		
		$.validit(this);
		
		}
		
		
		
		});
		
		
		
		
		
		
		$(this).find('[class*='+setting.prefix+']').live('click',function(){
		
		
		
		
		
		
		
		
		
		
		
		$prop = $(this).prop('type');
		
		if( $prop=='checkbox' || $prop=='radio' )
		{
			
			
			
		$name = $(this).prop('name');	
			
		var $group =  $($.selector).find("input[name='"+$name+"']:first");
			
		$.removemsg($group);
		
		$.validit(this);
			
			} else {
		
		
		
		}
		
		
		
		});
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		var ret;
		
		
		
		$(this).submit(function(){
		
		
		var $firstitem = true;
		
		ret = false;
		
		$(this).find('[class*='+setting.prefix+']').each(function(){

		
		
		$prop = $(this).prop('type');
		
		if( $prop=='checkbox' || $prop=='radio' )
		{
			
			
			
		$name = $(this).prop('name');	
			
		var $group =  $($.selector).find("input[name='"+$name+"']:first");
			
		//$.removemsg($group);
		
		$.validit(this);
			
			} else {
		
		
		
		
		
		
		
		$.validit(this);
		
			}
		
		//alert($.isvalidate);
		
		
		if($firstitem){
			
			
		if( !$.isvalidate )
		{
		
		ret = false;	
			
		} else { ret = true; }
			
			
		
		if( !$.isvalidate && setting.scroll)
		{
			
		var destination = $(this).offset().top-30;
		
		//alert( destination );
		
		$("html:not(:animated), body:not(:animated)").animate({ scrollTop: destination}, 'slow');
			
		}
		
		}
		
		
		
		
		
		if( $firstitem && !$.isvalidate  )
		{
			$firstitem = false;	
		}
		
		
		//alert($(this).prop('class'));
		
		});
		
		
		
		
	
				
		//returnValidation = $ret;
					
				
		
				
		
		return ret;
		});
		
					
				// end	
				
				
				
				
				
				
				
				
				});
				
				
				
				
					
					
					if( setting.isreturn )
					{
						
						
						
						return $.isvalidate;
						
						//return returnValidation;
						
						
						}  else {
						
						
						
						return this;
						
						
						
						//return returnValidation;
						
						}
						
					
					
				
			}
		
	});
	
	
})(jQuery);