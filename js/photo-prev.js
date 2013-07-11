$(document).ready(function () {
    $(function () {
        $('.top_pos').each(function (i) {
            $(this).delay((i) * 500).fadeTo(300, 1);

        });

    });
});


function preview(idPhoto, imgWidth, imgHeight) {
    $('#photo_preview').fadeTo('fast', 0.01, function () {
      $('<img src="/photo_preview.php?id=" + idPhoto/>');
        $('#photo_preview').load('/photo_preview.php?id=' + idPhoto, function () {
            $('#photo_preview_bg').height($(document).height()).toggleClass('hidden').fadeTo('fast', 0.7, function () {
                $('#photo_preview').alignCenter().toggleClass('hidden').fadeTo('fast', 1).click(function(){
                       $('#photo_preview').css('box-shadow','');
                });
            });
        });
    });
    return false;
}





function previewTop(idPhoto, imgWidth, imgHeight) {
    $('#photo_preview').fadeTo('fast', 0.01, function () {
       $('<img src="/photo_preview.php?id=" + idPhoto/>');
        $('#photo_preview').load('photo_top_preview.php?id=' + idPhoto, function () {
           $('#photo_preview_bg').height($(document).height()).toggleClass('hidden').fadeTo('fast', 0.7, function () {
           //   $("img[src='dir.php?num=5618']").closest("#photo_preview").css('box-shadow', '0 0 0 2px #000,0 0 2px 6px #fa0, 0 0 0 11px #fd0, 0 0 0 13px #000');
              $("#photo_preview").css('box-shadow', '0 0 0 2px #000,0 0 2px 6px #fa0, 0 0 0 11px #fd0, 0 0 0 13px #000');
                $('#photo_preview').alignCenter().toggleClass('hidden').fadeTo('fast', 1).click(function(){
                      $('#photo_preview').css('box-shadow','');
                  });
                });
            });
        });
    return false;
}


//additional properties for jQuery object
/*
$(document).ready(function () {
    //align element in the middle of the screen
    $.fn.alignCenter = function () {
        //get margin left
        var marginLeft = -$(this).width() / 2 + 'px';
        //get margin top
        var marginTop = '';
        if ($(this).height() < 100)
        {
            marginTop = - 300 + 'px';
        } else {
            marginTop = -$(this).height() / 2 + 'px';
        }

        //return updated element
        return $(this).css({'margin-left': marginLeft, 'margin-top': marginTop});
    };
});
*/

$(document).ready(function () {
    //align element in the middle of the screen
    $.fn.alignCenter = function ( imgWidth, imgHeight) {


            // удаляем атрибуты width и height
            $(this).removeAttr("width")
                .removeAttr("height")
                .css({ width: "", height: "" });

        var fotoW = $(this).width();
        var fotoH = ($(this).height() > 150)?$(this).height():(($(this).width() > 500)?$(this).width()*0.82:$(this).width()/0.6);

        var marginLeft = -fotoW / 2 + 'px';
        var marginTop  = -fotoH / 2 + 'px';
        // для тех браузеров, которые подгрузку с кеша не считают загрузкой, пишем следующий код
        $(this).each(function() {
            var src = $(this).attr('src');
            $(this).attr('src', '');
            $(this).attr('src', src);
        });

//        alert ("высота экрана h= "+ getScreenHeight()+"фото w="+$(this).width()+"фото h="+$(this).height()+'  '+"fotoH= "+fotoH);

        //return updated element
        return $(this).css({'margin-left': marginLeft, 'margin-top': marginTop});

    };
});


function hidePreview() {
    $('#photo_preview').toggleClass('hidden').fadeOut('normal', function () {
        $('#photo_preview_bg').toggleClass('hidden').removeAttr('style').hide().click(function(){
           $('#photo_preview').css('box-shadow','');
    });
  });
    return false;
}

humane.forceNew = (true);
humane.clickToClose = (true);
humane.timeout = (2500);


function basketAdd(idPhoto) {
    $.post('add_basket.php', {'id': idPhoto}, function (data) {
        $(this).outDebug(data,"add_basket.php","basketAdd");
        var ans = JSON.parse(data);
        if (ans.status == 'ERR') {
            humane.error(ans.msg);
        }
        else {
       //     humane.success(["Файл добавлен в корзину"]);
            dhtmlx.message({
                text: ans.msg,
                expire:15000,
                type:"addfoto" // 'customCss' - css класс
            });
        }
    });
}


function goVote(balans,voteprice, idPhoto) {
    if (voteprice != 0)
    {
    dhtmlx.confirm({
        type: "confirm",
        text: "Цена одного голоса " + voteprice + " гр.<br> Проголосовать?",
        callback: function (index) {
            if (index == true) {

                $.ajax({
                    type: "POST",
                    header: ('Content-Type: application/json; charset=utf-8;'),
                    url: '/go_vote.php',
                    data:  {'id': idPhoto},

                    error:function(XHR) {
                        $(this).outDebug(" Ошибка: "+XHR.status+ "  " + XHR.statusText,"/go_vote.php","goVote");
                    },
                    statusCode: {
                        404: function() {
                            $(this).outDebug("Страница не найдена","/go_vote.php","goVote");
                        }
                    },

                    success: function (data) {
                        $(this).outDebug(data,"/go_vote.php","goVote");
                        var ans = JSON.parse(data);
                        if (ans.status == 'ERR') {
                            humane.timeout = (8000);
                            humane.error(ans.msg);
                        }
                        else {
                            $(this).outDebug(data,"/go_vote.php","goVote");
                            dhtmlx.message({ text: "Ваш голос добавлен", expire: 10000, type: "addgolos" });
                            var newBalans = (balans - voteprice).toFixed(2);
                            $('#balans').empty().append(newBalans);
                            preview(idPhoto);
                        }
                    }
                });
               /* $.post('/go_vote.php', {'id': idPhoto}, function (data) {
                })*/
            }
        }
    });
    }
    else
    {
        $.post('/go_vote.php', {'id': idPhoto}, function (data) {
            $(this).outDebug(data,"/go_vote.php","goVote");
            var ans = JSON.parse(data);
            if (ans.status == 'ERR') {
                humane.timeout = (8000);
                humane.error(ans.msg);
            }
            else {
                humane.success("Ваш голос успешно добавлен!");
                preview(idPhoto);
            }
        })
    }
}






/** delayed image load by Black#FFFFFF **/


/*loadWait            = 30000;
loadCheck           = 300;
preloadObjects      = ".ramka img";
notImagesLoaded     = [];
excludeImages       = false;*/

function getScreenHeight(){

    var myHeight = 0;
    if( typeof( window.innerHeight ) == "number" ) {
    //Non-IE
    myHeight = window.innerHeight;
    } else if( document.documentElement &&
( document.documentElement.clientHeight
|| document.documentElement.clientHeight )){
    //IE 6+ in "standards compliant mode"
    myHeight = document.documentElement.clientHeight;
    } else if( document.body &&
( document.body.clientHeight || document.body.clientHeight ) ) {
    //IE 4 compatible
    myHeight = document.body.clientHeight;
    }

return  myHeight;

}

/*
function preloadOther(){
    var l       = notImagesLoaded.length;
    var currentExists       = false;

    for(var i = 0; i < l; i ++){
    var item          = notImagesLoaded[i];
    if(item){
    loadImage(item);
    currentExists = true;
    }
}
*/



/*if(!currentExists){
    notImagesLoaded = [];
    jQuery(window).unbind("scroll",preloadOther);
    }

}*/



function imagesPreloader(){

    jQuery(preloadObjects).each(function(){
        var item        =  this;
        if(item.nodeName.toLowerCase() == "img" && ( typeof excludeImages == "undefined"  || excludeImages == false || (item.className.indexOf(excludeImages) == -1) ) ){

            item.longDesc   = item.src;

            item.src        = "#";

            item.alt        = "";

            var preloaderElt= jQuery("<figure ></figure >");
            jQuery(preloaderElt).css({"display":"block"});
            preloaderElt.className      = "preloader "+item.className;

            jQuery(item).before(preloaderElt);
            loadImage(item);

}
});

// jQuery(window).bind("scroll",preloadOther);

}

function loadImage(item){
    var pos      = jQuery(item).position();
    var ItemOffsetTop  = typeof pos == "object" && typeof pos.top != "undefined" ? pos.top : 0;
    var documentScrollTop    = jQuery(window).scrollTop();
    var scrHeight= getScreenHeight();

    if(ItemOffsetTop <= (documentScrollTop + scrHeight) && typeof item.storePeriod == "undefined"){

    item.src = item.longDesc;

    item.onerror         = function(){
    this.width       = 0;
    this.height      = 0;
    };

item.onabort         = function(){
    this.width       = 0;
    this.height      = 0;
    };


item.wait= 0;
item.storePeriod     = setInterval(function(){


    item.wait    += loadCheck;
    if(item.width && item.height && item.complete){


    clearInterval(item.storePeriod);
    item.storePeriod      = false;
    jQuery(item.previousSibling).remove();
    jQuery(item).css("visibility","visible");
    if(typeof item.loadedCount != "undefined"
    && notImagesLoaded[item.loadedCount]){
    notImagesLoaded[item.loadedCount] = false;
    }

} else if(item.wait > loadWait){

    clearInterval(item.storePeriod);
    item.storePeriod      = false;
    if(typeof item.loadedCount != "undefined"
    && notImagesLoaded[item.loadedCount]){
    notImagesLoaded[item.loadedCount]  = false;
    }

jQuery(item).css({"display":"none","visibility":"hidden"});
jQuery(item.previousSibling).remove();

}

},loadCheck);

} else {
    if(typeof item.loadedCount == "undefined"){
        item.loadedCount = notImagesLoaded.length;
        notImagesLoaded[item.loadedCount]  = item;
    }
}

}



