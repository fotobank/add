/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 16.09.13
 * Time: 11:14
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function() {

    function okMsg(pole, valid) {
        pole.css({'border' : '1px solid #569b44'});
        if (valid.hasClass('label-important')) {
            valid.removeClass('label-important').addClass('label-success');
        }
        valid.text('Верно');
    }

    function errMsg(pole, valid, txt) {
        pole.css({'border' : '1px solid #ff0000'});
        if (valid.hasClass('label-success')) {
            valid.removeClass('label-success').addClass('label-important');
        }
        valid.text(txt);

    }

    $('#td_name').blur(function() {
        var valid = $('#valid_form_name');
        var pole = $(this);
        if($(this).val() != '') {
            var pattern = /[?a-zA-Zа-яА-Я0-9_-]{3,16}$/;
            if(pattern.test($(this).val())){
                okMsg(pole, valid);
            } else {
                errMsg(pole, valid, 'Не верно');
            }
        } else {
            errMsg(pole, valid, 'Заполните поле');
        }
    });

    $('#td_email').blur(function() {
        var valid = $('#valid_form_email');
        var pole = $(this);
        if($(this).val() != '') {
            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
            if(pattern.test($(this).val())){
                okMsg(pole, valid);
            } else {
                errMsg(pole, valid, 'Не верно');
            }
        } else {
            errMsg(pole, valid, 'Заполните поле');
        }
    });


    $('#td_name_us').blur(function() {
        var valid = $('#valid_form_name_us');
        var pole = $(this);
        if($(this).val() != '') {
            var pattern = /[?a-zA-Zа-яА-Я0-9_-]{2,30}$/;
            if(pattern.test($(this).val())){
                okMsg(pole, valid);
            } else {
                errMsg(pole, valid, 'Не верно');
            }
        } else {
            errMsg(pole, valid, 'Заполните поле');
        }
    });


    $('#td_phone').blur(function() {
        var valid = $('#valid_form_phone');
        var pole = $(this);
        if($(this).val() != '') {
            var pattern = /[%a-z_@.,^=:;а-я\"*&$#№!?<>\~`|[{}\]]/i;
            if($(this).val().length > 6 && $(this).val().length < 20 && !pattern.test($(this).val())){
                okMsg(pole, valid);
            } else {
                errMsg(pole, valid, 'Не верно');
            }
        } else {
            errMsg(pole, valid, 'Заполните поле');
        }
    });


    $('#td_city').blur(function() {
        var valid = $('#valid_form_city');
        var pole = $(this);
        if($(this).val() != '') {
            var pattern = /[?a-zA-Zа-яА-Я0-9_-]{2,20}$/;
            if(pattern.test($(this).val())){
                okMsg(pole, valid);
            } else {
                errMsg(pole, valid, 'Не верно');
            }
        } else {
            errMsg(pole, valid, 'Заполните поле');
        }
    });

    $('#td_skype').blur(function() {
        var valid = $('#valid_form_skype');
        var pole = $(this);
        if(pole.val() != '') {
            if(pole.val().length >= 0 && pole.val().length < 20){
                okMsg(pole, valid);
            } else {
                errMsg(pole, valid, 'Не верно');
            }
        } else {
            errMsg(pole, valid, 'Заполните поле');
        }
    });


    /*$(function () {
        $('#td_phone').bind("change keyup input click", function () {
            if (this.value.match(/[^0-9\(\)\-\+]/g)) {
                this.value = this.value.replace(/[^0-9\(\)\-\+]/g, '');
            }
        })
    })*/


});


function parseField(id) {
    var obj = '[name="' + id + '"]';
    var str = new String(jQuery(obj).val());
    if (str.match(/[^0-9-_]+/gi)) {

        jQuery(obj).css({'border-color': '#980000', 'background-color': '#EDCECE'});
        jQuery(obj).val(str.replace(/[^0-9-_]+/gi, ''));

        setTimeout(function () {
            jQuery(obj).css({'border-color': '#85BFF2', 'background-color': '#FFFFFF'});
        }, 1000)
    }
}

