var GALLERY = {
  container: '#gallery',
  url: 'getImages',
  delay: 5000,
  
  load: function() {
    var _gallery = this;
    $.ajax({ 
      type:"get", 
      url: this.url, 
      beforeSend: function() {
        $(_gallery.container)
          .find('img')
          .fadeOut('slow', function() {
            $(this).remove();
          });
      },
      success: function(data){ 
        var images = data.split('|');
        $.each(images, function() {  
          _gallery.display(this);
        });
      },
      complete: function() {
        setTimeout(function() {
          _gallery.load();
        }, _gallery.delay);
      }
    });
  },
  display: function(image_url) {
    $('<img></img>')
      .attr('src', '../../images/' + image_url + "?" + new Date().getTime()) //��� ����� ��� ��, ��, ����, �������� �������� � �� ���������� load
      .hide()
      .load(function() { 
        //$(this).fadeIn(); ��� ����
        $(this).delay(600).fadeIn(); //���� �����
      })
      .appendTo('#gallery');
  }
}

$(document).ready(function(){
  GALLERY.load();
});
