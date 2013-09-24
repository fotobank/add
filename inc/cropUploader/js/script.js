// ����������� �����������
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
}

// �������� ��������� ������� ��� �������
function checkForm() {
    if (parseInt($('#w').val())) return true;
 //    $('.error').html('����������, �������� ������� ��������, � ����� ������� ���������').show();
 //   return false;
}

// ���������� ���������� ������� ( ���������� ������� onChange � onSelect)
function updateInfo(e) {
    $('#x1').val(e.x);
    $('#y1').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);
    $('#w').val(e.w);
    $('#h').val(e.h);
}

// ������� ���������� ������� ( ���������� ������� onRelease)
function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
}

function fileSelectHandler() {

    // ��������� ���������� �����
    var oFile = $('#image_file')[0].files[0];

    // ������ ��� ������
    $('.error').hide();

    // �������� ����������� ( �������� jpg, � png)
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (! rFilter.test(oFile.type)) {
        $('.error').html('���������� �������� ����������� ��� ����� (����������� jpg � png)').show();
        return;
    }

    // �������� ������� �����
    if (oFile.size > 15000 * 1024) {
        $('.error').html('�� ������� ������� ������� ����, ���������� �������� ���� �������� �������').show();
        return;
    }

    // ��������������� �������� ��������
    var oImage = document.getElementById('preview');

    // ���������� HTML5 FileReader
    var oReader = new FileReader();
        oReader.onload = function(e) {

        // e.target.result �������� DataURL, ������� �� ����� ������������ � �������� ��������� �����������
        oImage.src = e.target.result;
        oImage.onload = function () { // ���������� ������� onload

            // ����������� ������� ����
            $('.step2').fadeIn(500);

            // ����� �� ����� ���������� �� �����������
            var sResultFileSize = bytesToSize(oFile.size);
            $('#filesize').val(sResultFileSize);
            $('#filetype').val(oFile.type);
            $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);

            // �������� ����������, ��� ������������� API Jcrop 
            var jcrop_api, boundx, boundy;

            // ������� Jcrop, ���� �� ��� �������������
            if (typeof jcrop_api != 'undefined')
                jcrop_api.destroy();

            // ������������� Jcrop
            $('#preview').Jcrop({
                minSize: [32, 32], // ����������� ������ �������
                aspectRatio : 1, // ���������� ���������� ����������� 1:1
                bgFade: true, // ������������ ������ ������������
                bgOpacity: .3, // ��������������
                onChange: updateInfo,
                onSelect: updateInfo,
                onRelease: clearInfo
            }, function(){

                // ����������� API Jcrop, ����� �������� �������� ������ �����������
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];

                // ���������� ���������� API Jcrop � jcrop_api 
                jcrop_api = this;
            });
        };
    };

    oReader.readAsDataURL(oFile);
}