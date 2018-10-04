<?php

/* /fotobanck_adw/fotobanck_adw.twig */
class __TwigTemplate_2a095dbb0d2f485655f21f245ec6adc00686a178690a04ab0ce8ce7da5c9e11b extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'doctype' => array($this, 'block_doctype'),
            'head' => array($this, 'block_head'),
            'golova_menu' => array($this, 'block_golova_menu'),
            'showDebug' => array($this, 'block_showDebug'),
            'content_header' => array($this, 'block_content_header'),
            'bottom' => array($this, 'block_bottom'),
            'content' => array($this, 'block_content'),
            'end_content' => array($this, 'block_end_content'),
            'footer' => array($this, 'block_footer'),
            'html' => array($this, 'block_html'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('doctype', $context, $blocks);
        // line 5
        echo "
<head>
";
        // line 7
        $this->displayBlock('head', $context, $blocks);
        // line 10
        echo "</head>

\t<body>
\t\t<div id=\"maket\">
\t\t\t<div id=\"photo_preview_bg\" class=\"hidden\" onClick=\"hidePreview();\"></div>
\t\t\t<div id=\"photo_preview\" class=\"hidden\"></div>

\t\t\t<!--Голова начало-->
\t\t\t";
        // line 18
        $this->displayBlock('golova_menu', $context, $blocks);
        // line 22
        echo "\t\t\t<!--Голова конец-->


\t\t\t<!-- ввод пароля -->
\t\t\t<div class=\"modal-scrolable\"
\t\t\t     style=\"z-index: 150;\">
\t\t\t\t<div id=\"static\"
\t\t\t\t     class=\"modal hide fade in animated fadeInDown\"
\t\t\t\t     data-keyboard=\"false\"
\t\t\t\t     data-backdrop=\"static\"
\t\t\t\t     tabindex=\"-1\"
\t\t\t\t     aria-hidden=\"false\">
\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t\t<h3 style=\"color: #444444\">Ввод пароля:</h3>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"modal-body\">

\t\t\t\t\t\t<div style=\"ttext_white\">
\t\t\t\t\t\t\tНа данный альбом установлен пароль. Если у Вас нет пароля для входа или он утерян , пожалуйста свяжитесь с администратором сайта
\t\t\t\t\t\t\tчерез email в разделе <a href=\"/kontakty.php\"><span class=\"ttext_blue\">\"Контакты\"</span>.</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<br/>
\t\t\t\t\t\t<form action=\"/fotobanck_adw.php\"
\t\t\t\t\t\t      id=\"parol\"
\t\t\t\t\t\t      method=\"post\">
\t\t\t\t\t\t\t<label for=\"inputError\"
\t\t\t\t\t\t\t       class=\"ttext_red\"
\t\t\t\t\t\t\t       style=\"float: left; margin-right: 10px;\">Пароль: </label> <input id=\"inputError\" type=\"text\" name=\"album_pass\" value=\"\" maxlength=\"20\"/>
\t\t\t\t\t\t\t<input class=\"btn-small btn-primary\" type=\"submit\" value=\"ввод\"/>
\t\t\t\t\t\t</form>
\t\t\t\t\t\t<div id=\"err_parol\"></div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"modal-footer\">
\t\t\t\t\t\t<p id=\"err-modal\" style=\"float: left;\"></p>
\t\t\t\t\t\t<button type=\"button\" data-dismiss=\"modal\" class=\"btn\"
\t\t\t\t\t\t        onClick=\"window.document.location.href='/fotobanck_adw.php?back_to_albums'\">
\t\t\t\t\t\t\tЯ не знаю
\t\t\t\t\t\t</button>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>


\t\t\t<script type=\"text/javascript\">
\t\t\t\t\t\$(document).ready(function(){
\t\t\t\t\t\t    \$('#parol').submit(function(){
\t\t\t\t\t\t\t        var value=\$('#inputError').val();
\t\t\t\t\t\t\t        if (value=='')
\t\t\t\t\t\t\t\t        {
\t\t\t\t\t\t\t\t\t        \$('#err_parol').empty().append('Заполните поле или отмените действие');
\t\t\t\t\t\t\t\t            return false;
\t\t\t\t\t\t\t\t        }
\t\t\t\t\t\t\t    })
\t\t\t\t\t\t});
\t\t\t\t\t</script>


\t\t\t<!-- ошибка -->
\t\t\t<div id=\"error_inf\"
\t\t\t     class=\"modal hide fade\"
\t\t\t     tabindex=\"-1\"
\t\t\t     data-replace=\"true\">
\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t<button type=\"button\"
\t\t\t\t\t        class=\"close\"
\t\t\t\t\t        data-dismiss=\"modal\"
\t\t\t\t\t        aria-hidden=\"true\">x
\t\t\t\t\t</button>
\t\t\t\t\t<h3 style=\"color:red\">Неправильный пароль.</h3>
\t\t\t\t</div>
\t\t\t\t<div class=\"modal-body\">
\t\t\t\t\t<div>
\t\t\t\t\t\t<a href=\"/kontakty.php\"><span class=\"ttext_blue\">Забыли пароль?</span></a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

";
        // line 99
        if (((isset($context["ret"]) || array_key_exists("ret", $context)) && (twig_length_filter($this->env, (isset($context["ret"]) || array_key_exists("ret", $context) ? $context["ret"] : (function () { throw new Twig_Error_Runtime('Variable "ret" does not exist.', 99, $this->source); })())) > 0))) {
            // line 100
            echo "\t\t\t<div id=\"zapret\"
\t\t\t     class=\"modal hide fade\"
\t\t\t     tabindex=\"-1\"
\t\t\t     data-replace=\"true\"
\t\t\t     style=\" margin-top: -180px;\">
\t\t\t\t<div class=\"err_msg\">
\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t\t<h3 style=\"color:#fd0001\">Доступ к альбому \"";
            // line 107
            echo (isset($context["album_name"]) || array_key_exists("album_name", $context) ? $context["album_name"] : (function () { throw new Twig_Error_Runtime('Variable "album_name" does not exist.', 107, $this->source); })());
            echo "\" заблокирован!</h3>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t<div style=\"color:black\">Вы использовали 5 попыток ввода пароля.В целях защиты,<br> Ваш IP ";
            // line 110
            echo (isset($context["ip"]) || array_key_exists("ip", $context) ? $context["ip"] : (function () { throw new Twig_Error_Runtime('Variable "ip" does not exist.', 110, $this->source); })());
            echo " заблокирован на 30 минут.</div>
\t\t\t\t\t\t<br>
\t\t\t\t\t\t<h2>Осталось <span id='timer' long='";
            // line 112
            echo ((twig_get_attribute($this->env, $this->source, ($context["ret"] ?? null), "min", array(), "any", true, true)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["ret"] ?? null), "min", array()), 30)) : (30));
            echo ":";
            echo ((twig_get_attribute($this->env, $this->source, ($context["ret"] ?? null), "sec", array(), "any", true, true)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["ret"] ?? null), "sec", array()), 0)) : (0));
            echo "'>";
            echo ((twig_get_attribute($this->env, $this->source, ($context["ret"] ?? null), "min", array(), "any", true, true)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["ret"] ?? null), "min", array()), 30)) : (30));
            echo ":";
            echo ((twig_get_attribute($this->env, $this->source, ($context["ret"] ?? null), "sec", array(), "any", true, true)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["ret"] ?? null), "sec", array()), 0)) : (0));
            echo "
\t\t\t\t\t\t\t</span> минут";
            // line 113
            echo (isset($context["okonc"]) || array_key_exists("okonc", $context) ? $context["okonc"] : (function () { throw new Twig_Error_Runtime('Variable "okonc" does not exist.', 113, $this->source); })());
            echo "</h2>
\t\t\t\t\t\t<script type='text/javascript'>
\t\t\t\t\t\t\t\$(function () {
\t\t\t\t\t\t\t\tsetInterval(function () {
\t\t\t\t\t\t\t\t\tfunction iTime(x) {
\t\t\t\t\t\t\t\t\t\treturn (x / 100).toFixed(2).substr(2)
\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\tvar o = document.getElementById('timer'),
\t\t\t\t\t\t\t\t\t\t\tw = 60,
\t\t\t\t\t\t\t\t\t\t\ty = o.innerHTML.split(':'),
\t\t\t\t\t\t\t\t\t\t\tv = y [0] * w + (y [1] - 1),
\t\t\t\t\t\t\t\t\t\t\ts = v % w,
\t\t\t\t\t\t\t\t\t\t\tm = (v - s) / w;
\t\t\t\t\t\t\t\t\tif (s < 0) {
\t\t\t\t\t\t\t\t\t\tv = o.getAttribute('long').split(':');
\t\t\t\t\t\t\t\t\t\tm = v [0];
\t\t\t\t\t\t\t\t\t\ts = v [1];
\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\to.innerHTML = [iTime(m), iTime(s)].join(':');
\t\t\t\t\t\t\t\t}, 1000);
\t\t\t\t\t\t\t});
\t\t\t\t\t\t</script>
\t\t\t\t\t\t<br> <br> <a href=\"/kontakty.php\">
\t\t\t\t\t\t\t<span class=\"ttext_blue\">Восстановление пароля</span></a>
\t\t\t\t\t\t<a style=\"float:right\"
\t\t\t\t\t\t   class=\"btn btn-danger\"
\t\t\t\t\t\t   data-dismiss=\"fotobanck_adw.php\"
\t\t\t\t\t\t   href=\"/fotobanck_adw.php?back_to_albums\">Закрыть</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
";
        }
        // line 145
        echo "

\t\t\t\t";
        // line 148
        echo "\t\t\t\t";
        if (((twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 148, $this->source); })()), "showRealtime", array(), "method") == true) && (twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 148, $this->source); })()), "isError", array()) > 0))) {
            // line 149
            echo "\t\t\t\t\t";
            $this->displayBlock('showDebug', $context, $blocks);
            // line 161
            echo "\t\t\t\t";
        }
        // line 162
        echo "

\t\t\t\t";
        // line 164
        $this->displayBlock('content_header', $context, $blocks);
        // line 169
        echo "
\t\t";
        // line 171
        echo "


\t\t";
        // line 175
        echo "
";
        // line 176
        if ((isset($context["current_album"]) || array_key_exists("current_album", $context) ? $context["current_album"] : (function () { throw new Twig_Error_Runtime('Variable "current_album" does not exist.', 176, $this->source); })())) {
            // line 177
            echo "
\t\t\t";
            // line 178
            echo (isset($context["parol"]) || array_key_exists("parol", $context) ? $context["parol"] : (function () { throw new Twig_Error_Runtime('Variable "parol" does not exist.', 178, $this->source); })());
            echo "

\t\t\t";
            // line 180
            if ((isset($context["may_view"]) || array_key_exists("may_view", $context) ? $context["may_view"] : (function () { throw new Twig_Error_Runtime('Variable "may_view" does not exist.', 180, $this->source); })())) {
                // line 181
                echo "
\t\t\t";
                // line 182
                echo (isset($context["akkordeon"]) || array_key_exists("akkordeon", $context) ? $context["akkordeon"] : (function () { throw new Twig_Error_Runtime('Variable "akkordeon" does not exist.', 182, $this->source); })());
                echo "

\t\t\t\t<script language=JavaScript type=\"text/javascript\">
\t\t\t\t\t\$(function () {
\t\t\t\t\t\t\$('.modern').click(function () {
\t\t\t\t\t\t\tonJS('/js_test.php');
\t\t\t\t\t\t\treturn false;
\t\t\t\t\t\t});
\t\t\t\t\t});
\t\t\t\t\t\$(function () {
\t\t\t\t\t\t\$('.profile_bitton , .profile_bitton2').click(function () {
\t\t\t\t\t\t\t\$('.profile').slideToggle();
\t\t\t\t\t\t\treturn false;
\t\t\t\t\t\t});
\t\t\t\t\t});
\t\t\t\t</script>

\t\t\t\t<!-- кнопки назад -->
\t\t\t\t<div class=\"page\">
\t\t\t\t\t";
                // line 202
                echo "\t\t\t\t\t<a class=\"next\" href=\"/fotobanck_adw.php?unchenge_cat\">« категории </a>
\t\t\t\t\t<a class=\"next\" href=\"/fotobanck_adw.php?back_to_albums\">« ";
                // line 203
                echo (isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 203, $this->source); })());
                echo "</a>
\t\t\t\t\t<a class=\"next\">« ";
                // line 204
                echo (isset($context["album_name"]) || array_key_exists("album_name", $context) ? $context["album_name"] : (function () { throw new Twig_Error_Runtime('Variable "album_name" does not exist.', 204, $this->source); })());
                echo "</a>
\t\t\t\t</div>

\t\t\t\t<!-- Название альбома  -->
\t\t\t\t<div class=\"cont-list\"
\t\t\t\t     style=\"margin: 40px 10px 30px 0;\">
\t\t\t\t\t<div class=\"drop-shadow lifted\">
\t\t\t\t\t\t<h2><span style=\"color: #00146e;\">Фотографии альбома \"";
                // line 211
                echo (isset($context["album_name"]) || array_key_exists("album_name", $context) ? $context["album_name"] : (function () { throw new Twig_Error_Runtime('Variable "album_name" does not exist.', 211, $this->source); })());
                echo "\"</span>
\t\t\t\t\t\t</h2>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div style=\"clear: both;\"></div>

\t\t\t\t<!--/**\tвыводим фотографию - заголовок альбома*/ -->
\t\t\t\t<div id=\"alb_opis\"
\t\t\t\t     class=\"span3\">
\t\t\t\t\t<div class=\"alb_logo\">
\t\t\t\t\t\t<div id=\"fb_alb_fotoP\">
\t\t\t\t\t\t\t<img src=\"/album_id.php?num=";
                // line 222
                echo (isset($context["album_img"]) || array_key_exists("album_img", $context) ? $context["album_img"] : (function () { throw new Twig_Error_Runtime('Variable "album_img" does not exist.', 222, $this->source); })());
                echo "\"
\t\t\t\t\t\t\t     width=\"130px\"
\t\t\t\t\t\t\t     height=\"124px\"
\t\t\t\t\t\t\t     alt=\"-\"/>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t";
                // line 228
                echo (isset($context["descr"]) || array_key_exists("descr", $context) ? $context["descr"] : (function () { throw new Twig_Error_Runtime('Variable "descr" does not exist.', 228, $this->source); })());
                echo "
\t\t\t\t</div>

\t\t\t";
                // line 231
                if ((isset($context["JS"]) || array_key_exists("JS", $context) ? $context["JS"] : (function () { throw new Twig_Error_Runtime('Variable "JS" does not exist.', 231, $this->source); })())) {
                    // line 232
                    echo "\t\t\t\t";
                    if (((isset($context["event"]) || array_key_exists("event", $context) ? $context["event"] : (function () { throw new Twig_Error_Runtime('Variable "event" does not exist.', 232, $this->source); })()) == "on")) {
                        // line 233
                        echo "\t\t\t\t\t";
                        // line 234
                        echo "\t\t\t\t\t";
                        echo (isset($context["top5"]) || array_key_exists("top5", $context) ? $context["top5"] : (function () { throw new Twig_Error_Runtime('Variable "top5" does not exist.', 234, $this->source); })());
                        echo "
\t\t\t\t\t";
                        // line 236
                        echo "\t\t\t\t\t";
                        echo (isset($context["renderTop"]) || array_key_exists("renderTop", $context) ? $context["renderTop"] : (function () { throw new Twig_Error_Runtime('Variable "renderTop" does not exist.', 236, $this->source); })());
                        echo "
\t\t\t\t\t";
                        // line 238
                        echo "\t\t\t\t\t<div id=\"modern\">
\t\t\t\t\t\t<hr class='style-one' style='margin-top: 10px; margin-bottom: -20px;'/> <div style= 'clear: both;'>
\t\t\t\t\t\t\t";
                        // line 240
                        echo (isset($context["fotoPageModern"]) || array_key_exists("fotoPageModern", $context) ? $context["fotoPageModern"] : (function () { throw new Twig_Error_Runtime('Variable "fotoPageModern" does not exist.', 240, $this->source); })());
                        echo "
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<script type=\"text/javascript\">
\t\t\t\t\t\t\$(function () {
\t\t\t\t\t\t\t\$(\"img.lazy\").lazyload({
\t\t\t\t\t\t\t\tthreshold: 200,
\t\t\t\t\t\t\t\teffect: \"fadeIn\"
\t\t\t\t\t\t\t});
\t\t\t\t\t\t});
\t\t\t\t\t</script>

\t\t\t\t\t<hr class=\"style-one\" style=\"clear: both; margin-bottom: -20px; margin-top: 0\"/>
\t\t\t\t\t";
                        // line 253
                        echo (isset($context["renderBottom"]) || array_key_exists("renderBottom", $context) ? $context["renderBottom"] : (function () { throw new Twig_Error_Runtime('Variable "renderBottom" does not exist.', 253, $this->source); })());
                        echo "
\t\t\t\t";
                    } else {
                        // line 255
                        echo "
\t\t\t\t\t";
                        // line 256
                        $this->loadTemplate("/fotobanck_adw/_podpiska.twig", "/fotobanck_adw/fotobanck_adw.twig", 256)->display($context);
                        // line 257
                        echo "
\t\t\t\t";
                    }
                    // line 259
                    echo "\t\t\t";
                } else {
                    // line 260
                    echo "\t\t\t<br><br>
\t\t\t<hfooter style=\"font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;\"
\t\t\t\t\t>В Вашем браузере не работает JavaScript!
\t\t\t</hfooter>
\t\t\t<script type='text/javascript'>
\t\t\t\t\$(function(){
\t\t\t\t\twindow.document.location.href = '";
                    // line 266
                    echo (isset($context["REQUEST_URI"]) || array_key_exists("REQUEST_URI", $context) ? $context["REQUEST_URI"] : (function () { throw new Twig_Error_Runtime('Variable "REQUEST_URI" does not exist.', 266, $this->source); })());
                    echo "';
\t\t\t\t}
\t\t\t</script>
\t\t\t<NOSCRIPT>
\t\t\t\t<br><br>
\t\t\t\t<hfooter style=\"font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;\"
\t\t\t\t\t\t>Из - за отключенной JavaScript показ фотографий невозможен!
\t\t\t\t         ( <a href=\"http://www.enable-javascript.com/ru/\">Как включить JavaScript?</a>)
\t\t\t\t</hfooter>
\t\t\t</NOSCRIPT>

\t\t\t";
                }
                // line 278
                echo "\t\t\t";
            } else {
                // line 279
                echo "\t\t\t\t<div class=\"center\" style=\"margin-top: 30px;\">
\t\t\t\t\t<hfooter style=\"font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;\">
\t\t\t\t\t\tАльбом заблокирован паролем
\t\t\t\t\t</hfooter>
\t\t\t\t</div>
\t\t\t\t<div class=\"center\" style=\"margin-top: 30px;\">
\t\t\t\t\t<NOSCRIPT>
\t\t\t\t\t\t<hfooter style=\"font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;\">
\t\t\t\t\t\t\tПри отключенной JavaScript функционал сайта заблокирован! ( <a href=\"http://www.enable-javascript.com/ru/\">Как включить JavaScript?</a> )
\t\t\t\t\t\t</hfooter>
\t\t\t\t\t</NOSCRIPT>
\t\t\t\t</div>
\t\t\t";
            }
            // line 292
            echo "
\t\t";
        } else {
            // line 294
            echo "
\t\t\t";
            // line 295
            if ((isset($context["current_cat"]) || array_key_exists("current_cat", $context) ? $context["current_cat"] : (function () { throw new Twig_Error_Runtime('Variable "current_cat" does not exist.', 295, $this->source); })())) {
                // line 296
                echo "\t\t\t";
                // line 297
                echo "\t\t\t";
                $this->loadTemplate("/fotobanck_adw/fotobanck_adw_razdel.twig", "/fotobanck_adw/fotobanck_adw.twig", 297)->display($context);
                // line 298
                echo "\t";
            } else {
                // line 299
                echo "\t\t";
                // line 300
                echo "\t\t";
                $this->loadTemplate("/fotobanck_adw/fotobanck_adw_kategorii.twig", "/fotobanck_adw/fotobanck_adw.twig", 300)->display($context);
                // line 301
                echo "
\t";
            }
        }
        // line 304
        echo "


\t\t\t";
        // line 307
        $this->displayBlock('bottom', $context, $blocks);
        // line 310
        echo "
\t\t\t";
        // line 311
        $this->displayBlock('content', $context, $blocks);
        // line 314
        echo "\t\t\t<div class=\"clear\"></div>


\t\t</div>


\t\t";
        // line 320
        $this->displayBlock('end_content', $context, $blocks);
        // line 323
        echo "


\t\t";
        // line 326
        $this->displayBlock('footer', $context, $blocks);
        // line 329
        echo "

\t</body>
";
        // line 332
        $this->displayBlock('html', $context, $blocks);
    }

    // line 1
    public function block_doctype($context, array $blocks = array())
    {
        // line 2
        echo "\t<!DOCTYPE html>
<html xmlns=\"http://www.w3.org/1999/xhtml\">
";
    }

    // line 7
    public function block_head($context, array $blocks = array())
    {
        // line 8
        echo "\t";
        $this->loadTemplate("head.twig", "/fotobanck_adw/fotobanck_adw.twig", 8)->display($context);
    }

    // line 18
    public function block_golova_menu($context, array $blocks = array())
    {
        // line 19
        echo "\t\t\t\t";
        $this->loadTemplate("golova_menu.twig", "/fotobanck_adw/fotobanck_adw.twig", 19)->display($context);
        // line 20
        echo "\t\t\t\t<div style=\"margin-top: 10px;\">\t</div>
\t\t\t";
    }

    // line 149
    public function block_showDebug($context, array $blocks = array())
    {
        // line 150
        echo "\t\t\t\t\t\t<div class=\"center\">
\t\t\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t\t\t";
        // line 152
        echo twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 152, $this->source); })()), "showAll", array(), "method");
        echo "
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"center\">
\t\t\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t\t\t";
        // line 158
        echo "\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t";
    }

    // line 164
    public function block_content_header($context, array $blocks = array())
    {
        // line 165
        echo "
\t\t\t\t\t";
        // line 166
        $this->loadTemplate("content_header.twig", "/fotobanck_adw/fotobanck_adw.twig", 166)->display($context);
        // line 167
        echo "
\t\t\t\t";
    }

    // line 307
    public function block_bottom($context, array $blocks = array())
    {
        // line 308
        echo "
\t\t\t";
    }

    // line 311
    public function block_content($context, array $blocks = array())
    {
        // line 312
        echo "\t\t\t\t<script src=\"";
        echo $this->extensions['Extension']->merge_files("/cache/fotobank.min.js", "js", (isset($context["include_Js_banck"]) || array_key_exists("include_Js_banck", $context) ? $context["include_Js_banck"] : (function () { throw new Twig_Error_Runtime('Variable "include_Js_banck" does not exist.', 312, $this->source); })()), "", (isset($context["include_Js_banck"]) || array_key_exists("include_Js_banck", $context) ? $context["include_Js_banck"] : (function () { throw new Twig_Error_Runtime('Variable "include_Js_banck" does not exist.', 312, $this->source); })()));
        echo "\" ></script >
\t\t\t";
    }

    // line 320
    public function block_end_content($context, array $blocks = array())
    {
        // line 321
        echo "\t\t\t<div class=\"end_content\" ></div >
\t\t";
    }

    // line 326
    public function block_footer($context, array $blocks = array())
    {
        // line 327
        echo "\t\t\t";
        $this->loadTemplate("footer.twig", "/fotobanck_adw/fotobanck_adw.twig", 327)->display($context);
        // line 328
        echo "\t\t";
    }

    // line 332
    public function block_html($context, array $blocks = array())
    {
        // line 333
        echo "</html>
";
    }

    public function getTemplateName()
    {
        return "/fotobanck_adw/fotobanck_adw.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  573 => 333,  570 => 332,  566 => 328,  563 => 327,  560 => 326,  555 => 321,  552 => 320,  545 => 312,  542 => 311,  537 => 308,  534 => 307,  529 => 167,  527 => 166,  524 => 165,  521 => 164,  515 => 158,  507 => 152,  503 => 150,  500 => 149,  495 => 20,  492 => 19,  489 => 18,  484 => 8,  481 => 7,  475 => 2,  472 => 1,  468 => 332,  463 => 329,  461 => 326,  456 => 323,  454 => 320,  446 => 314,  444 => 311,  441 => 310,  439 => 307,  434 => 304,  429 => 301,  426 => 300,  424 => 299,  421 => 298,  418 => 297,  416 => 296,  414 => 295,  411 => 294,  407 => 292,  392 => 279,  389 => 278,  374 => 266,  366 => 260,  363 => 259,  359 => 257,  357 => 256,  354 => 255,  349 => 253,  333 => 240,  329 => 238,  324 => 236,  319 => 234,  317 => 233,  314 => 232,  312 => 231,  306 => 228,  297 => 222,  283 => 211,  273 => 204,  269 => 203,  266 => 202,  244 => 182,  241 => 181,  239 => 180,  234 => 178,  231 => 177,  229 => 176,  226 => 175,  221 => 171,  218 => 169,  216 => 164,  212 => 162,  209 => 161,  206 => 149,  203 => 148,  199 => 145,  164 => 113,  154 => 112,  149 => 110,  143 => 107,  134 => 100,  132 => 99,  53 => 22,  51 => 18,  41 => 10,  39 => 7,  35 => 5,  33 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% block doctype %}
\t<!DOCTYPE html>
<html xmlns=\"http://www.w3.org/1999/xhtml\">
{% endblock doctype %}

<head>
{% block head %}
\t{% include 'head.twig' %}
{% endblock head %}
</head>

\t<body>
\t\t<div id=\"maket\">
\t\t\t<div id=\"photo_preview_bg\" class=\"hidden\" onClick=\"hidePreview();\"></div>
\t\t\t<div id=\"photo_preview\" class=\"hidden\"></div>

\t\t\t<!--Голова начало-->
\t\t\t{% block golova_menu %}
\t\t\t\t{% include 'golova_menu.twig' %}
\t\t\t\t<div style=\"margin-top: 10px;\">\t</div>
\t\t\t{% endblock golova_menu %}
\t\t\t<!--Голова конец-->


\t\t\t<!-- ввод пароля -->
\t\t\t<div class=\"modal-scrolable\"
\t\t\t     style=\"z-index: 150;\">
\t\t\t\t<div id=\"static\"
\t\t\t\t     class=\"modal hide fade in animated fadeInDown\"
\t\t\t\t     data-keyboard=\"false\"
\t\t\t\t     data-backdrop=\"static\"
\t\t\t\t     tabindex=\"-1\"
\t\t\t\t     aria-hidden=\"false\">
\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t\t<h3 style=\"color: #444444\">Ввод пароля:</h3>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"modal-body\">

\t\t\t\t\t\t<div style=\"ttext_white\">
\t\t\t\t\t\t\tНа данный альбом установлен пароль. Если у Вас нет пароля для входа или он утерян , пожалуйста свяжитесь с администратором сайта
\t\t\t\t\t\t\tчерез email в разделе <a href=\"/kontakty.php\"><span class=\"ttext_blue\">\"Контакты\"</span>.</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<br/>
\t\t\t\t\t\t<form action=\"/fotobanck_adw.php\"
\t\t\t\t\t\t      id=\"parol\"
\t\t\t\t\t\t      method=\"post\">
\t\t\t\t\t\t\t<label for=\"inputError\"
\t\t\t\t\t\t\t       class=\"ttext_red\"
\t\t\t\t\t\t\t       style=\"float: left; margin-right: 10px;\">Пароль: </label> <input id=\"inputError\" type=\"text\" name=\"album_pass\" value=\"\" maxlength=\"20\"/>
\t\t\t\t\t\t\t<input class=\"btn-small btn-primary\" type=\"submit\" value=\"ввод\"/>
\t\t\t\t\t\t</form>
\t\t\t\t\t\t<div id=\"err_parol\"></div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"modal-footer\">
\t\t\t\t\t\t<p id=\"err-modal\" style=\"float: left;\"></p>
\t\t\t\t\t\t<button type=\"button\" data-dismiss=\"modal\" class=\"btn\"
\t\t\t\t\t\t        onClick=\"window.document.location.href='/fotobanck_adw.php?back_to_albums'\">
\t\t\t\t\t\t\tЯ не знаю
\t\t\t\t\t\t</button>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>


\t\t\t<script type=\"text/javascript\">
\t\t\t\t\t\$(document).ready(function(){
\t\t\t\t\t\t    \$('#parol').submit(function(){
\t\t\t\t\t\t\t        var value=\$('#inputError').val();
\t\t\t\t\t\t\t        if (value=='')
\t\t\t\t\t\t\t\t        {
\t\t\t\t\t\t\t\t\t        \$('#err_parol').empty().append('Заполните поле или отмените действие');
\t\t\t\t\t\t\t\t            return false;
\t\t\t\t\t\t\t\t        }
\t\t\t\t\t\t\t    })
\t\t\t\t\t\t});
\t\t\t\t\t</script>


\t\t\t<!-- ошибка -->
\t\t\t<div id=\"error_inf\"
\t\t\t     class=\"modal hide fade\"
\t\t\t     tabindex=\"-1\"
\t\t\t     data-replace=\"true\">
\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t<button type=\"button\"
\t\t\t\t\t        class=\"close\"
\t\t\t\t\t        data-dismiss=\"modal\"
\t\t\t\t\t        aria-hidden=\"true\">x
\t\t\t\t\t</button>
\t\t\t\t\t<h3 style=\"color:red\">Неправильный пароль.</h3>
\t\t\t\t</div>
\t\t\t\t<div class=\"modal-body\">
\t\t\t\t\t<div>
\t\t\t\t\t\t<a href=\"/kontakty.php\"><span class=\"ttext_blue\">Забыли пароль?</span></a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

{% if ret is defined and ret|length > 0 %}
\t\t\t<div id=\"zapret\"
\t\t\t     class=\"modal hide fade\"
\t\t\t     tabindex=\"-1\"
\t\t\t     data-replace=\"true\"
\t\t\t     style=\" margin-top: -180px;\">
\t\t\t\t<div class=\"err_msg\">
\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t\t\t<h3 style=\"color:#fd0001\">Доступ к альбому \"{{ album_name }}\" заблокирован!</h3>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t<div style=\"color:black\">Вы использовали 5 попыток ввода пароля.В целях защиты,<br> Ваш IP {{ ip }} заблокирован на 30 минут.</div>
\t\t\t\t\t\t<br>
\t\t\t\t\t\t<h2>Осталось <span id='timer' long='{{ ret.min|default(30) }}:{{ ret.sec|default(0) }}'>{{ ret.min|default(30) }}:{{ ret.sec|default(0) }}
\t\t\t\t\t\t\t</span> минут{{ okonc }}</h2>
\t\t\t\t\t\t<script type='text/javascript'>
\t\t\t\t\t\t\t\$(function () {
\t\t\t\t\t\t\t\tsetInterval(function () {
\t\t\t\t\t\t\t\t\tfunction iTime(x) {
\t\t\t\t\t\t\t\t\t\treturn (x / 100).toFixed(2).substr(2)
\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\tvar o = document.getElementById('timer'),
\t\t\t\t\t\t\t\t\t\t\tw = 60,
\t\t\t\t\t\t\t\t\t\t\ty = o.innerHTML.split(':'),
\t\t\t\t\t\t\t\t\t\t\tv = y [0] * w + (y [1] - 1),
\t\t\t\t\t\t\t\t\t\t\ts = v % w,
\t\t\t\t\t\t\t\t\t\t\tm = (v - s) / w;
\t\t\t\t\t\t\t\t\tif (s < 0) {
\t\t\t\t\t\t\t\t\t\tv = o.getAttribute('long').split(':');
\t\t\t\t\t\t\t\t\t\tm = v [0];
\t\t\t\t\t\t\t\t\t\ts = v [1];
\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\to.innerHTML = [iTime(m), iTime(s)].join(':');
\t\t\t\t\t\t\t\t}, 1000);
\t\t\t\t\t\t\t});
\t\t\t\t\t\t</script>
\t\t\t\t\t\t<br> <br> <a href=\"/kontakty.php\">
\t\t\t\t\t\t\t<span class=\"ttext_blue\">Восстановление пароля</span></a>
\t\t\t\t\t\t<a style=\"float:right\"
\t\t\t\t\t\t   class=\"btn btn-danger\"
\t\t\t\t\t\t   data-dismiss=\"fotobanck_adw.php\"
\t\t\t\t\t\t   href=\"/fotobanck_adw.php?back_to_albums\">Закрыть</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
{% endif %}


\t\t\t\t{#вывод ошибок#}
\t\t\t\t{% if odebug.showRealtime() == true and odebug.isError > 0 %}
\t\t\t\t\t{% block showDebug %}
\t\t\t\t\t\t<div class=\"center\">
\t\t\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t\t\t{{ odebug.showAll() }}
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"center\">
\t\t\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t\t\t{#{{ odebug.showLog() }}#}
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t{% endblock showDebug %}
\t\t\t\t{% endif %}


\t\t\t\t{% block content_header %}

\t\t\t\t\t{% include 'content_header.twig' %}

\t\t\t\t{% endblock content_header %}

\t\t{#<div id=\"main\">#}



\t\t{#</div>#}

{% if current_album %}

\t\t\t{{ parol }}

\t\t\t{% if may_view %}

\t\t\t{{ akkordeon }}

\t\t\t\t<script language=JavaScript type=\"text/javascript\">
\t\t\t\t\t\$(function () {
\t\t\t\t\t\t\$('.modern').click(function () {
\t\t\t\t\t\t\tonJS('/js_test.php');
\t\t\t\t\t\t\treturn false;
\t\t\t\t\t\t});
\t\t\t\t\t});
\t\t\t\t\t\$(function () {
\t\t\t\t\t\t\$('.profile_bitton , .profile_bitton2').click(function () {
\t\t\t\t\t\t\t\$('.profile').slideToggle();
\t\t\t\t\t\t\treturn false;
\t\t\t\t\t\t});
\t\t\t\t\t});
\t\t\t\t</script>

\t\t\t\t<!-- кнопки назад -->
\t\t\t\t<div class=\"page\">
\t\t\t\t\t{#<a class=\"next\" href=\"/fotobanck_adw.php?back_to_albums\">« назад</a> #}
\t\t\t\t\t<a class=\"next\" href=\"/fotobanck_adw.php?unchenge_cat\">« категории </a>
\t\t\t\t\t<a class=\"next\" href=\"/fotobanck_adw.php?back_to_albums\">« {{ razdel }}</a>
\t\t\t\t\t<a class=\"next\">« {{ album_name }}</a>
\t\t\t\t</div>

\t\t\t\t<!-- Название альбома  -->
\t\t\t\t<div class=\"cont-list\"
\t\t\t\t     style=\"margin: 40px 10px 30px 0;\">
\t\t\t\t\t<div class=\"drop-shadow lifted\">
\t\t\t\t\t\t<h2><span style=\"color: #00146e;\">Фотографии альбома \"{{ album_name }}\"</span>
\t\t\t\t\t\t</h2>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div style=\"clear: both;\"></div>

\t\t\t\t<!--/**\tвыводим фотографию - заголовок альбома*/ -->
\t\t\t\t<div id=\"alb_opis\"
\t\t\t\t     class=\"span3\">
\t\t\t\t\t<div class=\"alb_logo\">
\t\t\t\t\t\t<div id=\"fb_alb_fotoP\">
\t\t\t\t\t\t\t<img src=\"/album_id.php?num={{ album_img }}\"
\t\t\t\t\t\t\t     width=\"130px\"
\t\t\t\t\t\t\t     height=\"124px\"
\t\t\t\t\t\t\t     alt=\"-\"/>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t{{ descr }}
\t\t\t\t</div>

\t\t\t{% if JS %}
\t\t\t\t{% if event == 'on' %}
\t\t\t\t\t{# Вывод фото в шапку альбома #}
\t\t\t\t\t{{ top5 }}
\t\t\t\t\t{# верхний пагитнатор#}
\t\t\t\t\t{{ renderTop }}
\t\t\t\t\t{# Вывод фото в альбом #}
\t\t\t\t\t<div id=\"modern\">
\t\t\t\t\t\t<hr class='style-one' style='margin-top: 10px; margin-bottom: -20px;'/> <div style= 'clear: both;'>
\t\t\t\t\t\t\t{{ fotoPageModern }}
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<script type=\"text/javascript\">
\t\t\t\t\t\t\$(function () {
\t\t\t\t\t\t\t\$(\"img.lazy\").lazyload({
\t\t\t\t\t\t\t\tthreshold: 200,
\t\t\t\t\t\t\t\teffect: \"fadeIn\"
\t\t\t\t\t\t\t});
\t\t\t\t\t\t});
\t\t\t\t\t</script>

\t\t\t\t\t<hr class=\"style-one\" style=\"clear: both; margin-bottom: -20px; margin-top: 0\"/>
\t\t\t\t\t{{ renderBottom }}
\t\t\t\t{% else %}

\t\t\t\t\t{% include '/fotobanck_adw/_podpiska.twig' %}

\t\t\t\t{% endif %}
\t\t\t{% else %}
\t\t\t<br><br>
\t\t\t<hfooter style=\"font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;\"
\t\t\t\t\t>В Вашем браузере не работает JavaScript!
\t\t\t</hfooter>
\t\t\t<script type='text/javascript'>
\t\t\t\t\$(function(){
\t\t\t\t\twindow.document.location.href = '{{ REQUEST_URI }}';
\t\t\t\t}
\t\t\t</script>
\t\t\t<NOSCRIPT>
\t\t\t\t<br><br>
\t\t\t\t<hfooter style=\"font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;\"
\t\t\t\t\t\t>Из - за отключенной JavaScript показ фотографий невозможен!
\t\t\t\t         ( <a href=\"http://www.enable-javascript.com/ru/\">Как включить JavaScript?</a>)
\t\t\t\t</hfooter>
\t\t\t</NOSCRIPT>

\t\t\t{% endif %}
\t\t\t{% else %}
\t\t\t\t<div class=\"center\" style=\"margin-top: 30px;\">
\t\t\t\t\t<hfooter style=\"font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;\">
\t\t\t\t\t\tАльбом заблокирован паролем
\t\t\t\t\t</hfooter>
\t\t\t\t</div>
\t\t\t\t<div class=\"center\" style=\"margin-top: 30px;\">
\t\t\t\t\t<NOSCRIPT>
\t\t\t\t\t\t<hfooter style=\"font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;\">
\t\t\t\t\t\t\tПри отключенной JavaScript функционал сайта заблокирован! ( <a href=\"http://www.enable-javascript.com/ru/\">Как включить JavaScript?</a> )
\t\t\t\t\t\t</hfooter>
\t\t\t\t\t</NOSCRIPT>
\t\t\t\t</div>
\t\t\t{% endif %}

\t\t{% else %}

\t\t\t{% if current_cat %}
\t\t\t{#/**  Печать альбомов*/#}
\t\t\t{% include '/fotobanck_adw/fotobanck_adw_razdel.twig' %}
\t{% else %}
\t\t{#/**  кнопки разделов (категорий) */#}
\t\t{% include '/fotobanck_adw/fotobanck_adw_kategorii.twig' %}

\t{% endif %}
{% endif %}



\t\t\t{% block bottom %}

\t\t\t{% endblock bottom %}

\t\t\t{% block content %}
\t\t\t\t<script src=\"{{ merge_files('/cache/fotobank.min.js', 'js', include_Js_banck, '',  include_Js_banck) }}\" ></script >
\t\t\t{% endblock content %}
\t\t\t<div class=\"clear\"></div>


\t\t</div>


\t\t{% block end_content %}
\t\t\t<div class=\"end_content\" ></div >
\t\t{% endblock end_content %}



\t\t{% block footer %}
\t\t\t{% include 'footer.twig' %}
\t\t{% endblock footer %}


\t</body>
{% block html %}
</html>
{% endblock html %}", "/fotobanck_adw/fotobanck_adw.twig", "O:\\domains\\add.pr\\templates\\fotobanck_adw\\fotobanck_adw.twig");
    }
}
