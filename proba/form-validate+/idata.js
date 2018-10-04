/*!
 * iData v1.0
 * jQuery Onfly DOM Data Fatcher
 * http://www.richmediabd.com/
 *
 * Copyright 2011, Emran Ahmed
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * 
 * Example: 

HTML:
<input type="text" id="tag"  class="tag data[url:index.php]  validation[required]" />




CODE:

1. $.idata('.tag','data','url',{	
			'using' : 'class', 			
			'seperator' : ',',
			'assigner':':'			
			});
			
2. $.idata('.tag','data','url');

3. $.idata('.tag','data',0);

4. $.idata('.tag','data');

5. USING each



$('.tag').each(function(){
	
	
alert($.idata(this,'data'));
alert($.idata(this,'data',0));	
alert($.idata(this,'data','url'));

	
});



*/

;(function($) {
	
	

	
	$.idata = function(container,prefix,index,options)
	{
		
		
			var settings = $.extend({	
			'using' : 'class', 		// class attribute	
			'seperator' : ',',
			'assigner':':'			
			}, options);
		
		
		var get = function(){
			
			
				var $find = $(container).find('['+settings.using+'*='+prefix+']').attr(settings.using);
				
				if( typeof($find)=='undefined' )
				{
					var $find = $(container).attr(settings.using);
				}
				
				
				
				/**
				Pattern of getting data source
				*/
				var pattern=new RegExp(prefix+"\\[.*?\\]","i");
				
				var html = pattern.exec($find);
				

				/**
				Pattern of getting original data source
				*/
					 
				var rulesRegExp =       /\[(.+)\]/;
				var getRules = rulesRegExp.exec(html);
				
				
	
				
				/**
				
				NULL data return false
				
				*/
				if(getRules==null)
				{
				return false;	
				}
				
				
				
				/**
				
				No index defined return original data source
				
				*/
				
				if( $.trim(index)=='' )
				{
				
				return getRules[1];
					
				}
				
				
				
				
				
				var str = getRules[1];			
			
				
				var res = str.split(settings.seperator);	
				
					
					
				if( !isNaN(index) )
				{
					return res[index];
				}
				
				
				
				
				
				var items=[];
				
				for(var j=0; j<res.length; j++)
				{	
					var k = res[j].split(settings.assigner);	
					
					var key = $.trim(k[0]);
					var value = $.trim(k[1]);
					
					items[key]=value;
				}
				
				
				return items[index];
				
			
			}
			
		
		return get();
		
	}
	
	
})(jQuery);