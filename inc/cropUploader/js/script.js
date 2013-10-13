// конвертация изображения
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
}

// проверка выбранной области для обрезки
function checkForm() {
    if (parseInt($('#w').val())) return true;
 //    $('.error').html('Пожалуйста, выберите область подрезки, а затем нажмите Загрузить').show();
 //   return false;
}

// обновление информации обрезки ( обработчик событий onChange и onSelect)
function updateInfo1(e) {
    $('#x1').val(e.x);
    $('#y1').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);
    $('#w').val(e.w);
    $('#h').val(e.h);
}

function updateInfo(c) {
    if(parseInt(c.w) > 0) {
        // Show image preview
        var imageObj = $("#preview")[0];
        var canvas = $("#thumb")[0];
        var context = canvas.getContext("2d");
        context.drawImage(imageObj, c.x*5, c.y*5, c.w*22, c.h*22, 0, 0, canvas.width*5, canvas.height*5);
    }
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);
}

// очистка информации обрезки ( обработчик событий onRelease)
function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
}

function fileSelectHandler() {

    // получение выбранного файла
    var oFile = $('#image_file')[0].files[0];

    // скрыть все ошибки
    $('.error').hide();

    // проверка изображения ( доступны jpg, и png)
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (! rFilter.test(oFile.type)) {
        $('.error').html('Пожалуйста выберите разрешенный тип файла (допускаются jpg и png)').show();
        return;
    }

//    $(".jcrop-holder").empty();

    // проверка размера файла
    if (oFile.size > 15000 * 1024) {  // > 15Mb
        $('.error').html('Вы выбрали слишком большой файл, пожалуйста выбетите файл меньшего размера').show();
        return;
    }

    // предварительный просмотр элемента
    var oImage = document.getElementById('preview');

    // подготовка HTML5 FileReader
    var oReader = new FileReader();
        oReader.onload = function(e) {

        // e.target.result содержит DataURL, который мы можем использовать в качестве источника изображения
        oImage.src = e.target.result;
        oImage.onload = function () { // обработчик событий onload

            // отображение второго шага
            $('.step2').fadeIn(500);

            // вывод на экран информации об изображении
            var sResultFileSize = bytesToSize(oFile.size);
            $('#filesize').val(sResultFileSize);
            $('#filetype').val(oFile.type);
            $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);

            // Создание переменных, для использования API Jcrop 
            var jcrop_api, boundx, boundy;

            // удалите Jcrop, если он уже использовался
            if (typeof jcrop_api != 'undefined')
                jcrop_api.destroy();

            // инициализация Jcrop
            $('#preview').Jcrop({
                minSize: [32, 32], // минимальный размер обрезки
                aspectRatio : 1, // сохранение форматного соотношения 1:1
                bgFade: true, // использовать эффект исчезновения
                bgOpacity: .3, // непрозрачность
                onChange: updateInfo,
                onSelect: updateInfo,
                onRelease: clearInfo
            }, function(){

                // используйте API Jcrop, чтобы получить реальный размер изображения
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];

                // сохранение переменных API Jcrop в jcrop_api 
                jcrop_api = this;
            });
        };
    };

    oReader.readAsDataURL(oFile);
}