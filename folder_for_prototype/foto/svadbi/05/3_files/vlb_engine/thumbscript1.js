jQuery(document).ready(function(){
var a=jQuery;
a("#vlightbox1 .vlightbox1").mouseenter(function(){
var b=a("div.vlb_zoom",this);
if(!b.length){
b=a('<div class="vlb_zoom" style="position:absolute">').hide().appendTo(this);
a("img:first",b).detach()
}
b.fadeIn("fast")
}).mouseleave(function(){
a("div",this).fadeOut("fast")
})
});