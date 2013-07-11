$(function(){
    $(' #modern .modern ')
        .mouseenter(function(){
            var b=$("div.vlb_zoom",this);
            if(!b.length){b=$('<div class="vlb_zoom" style="position:absolute">').hide().appendTo(this);
                $("img:first",b).detach()}b.fadeIn("fast")}).mouseleave(function(){
            $("div",this).fadeOut("fast")
        })
});