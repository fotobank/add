<?php

/* /kontakty/kontakty.twig */
class __TwigTemplate_20830ea7a85756204df91467286382566822c11caa2a31f082c67eafd33ba5dd extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.twig", "/kontakty/kontakty.twig", 1);
        $this->blocks = array(
            'content_header' => array($this, 'block_content_header'),
            'top' => array($this, 'block_top'),
            'l_colonka' => array($this, 'block_l_colonka'),
            'c_colonka' => array($this, 'block_c_colonka'),
            'r_colonka' => array($this, 'block_r_colonka'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content_header($context, array $blocks = array())
    {
        // line 4
        echo "\t    ";
        $this->displayParentBlock("content_header", $context, $blocks);
        echo "
    ";
    }

    // line 7
    public function block_top($context, array $blocks = array())
    {
        // line 8
        echo "    <div class=\"center\"><div class=\"centered\">
\t\t<div class=\"drop-shadow lifted\" >
\t\t\t<h2 ><span style=\"color: #00146e;\" > Раздел КОНТАКТЫ</span ></h2 >
\t\t</div >
\t</div ></div >
\t<div class=\"clear\" ></div >
";
    }

    // line 16
    public function block_l_colonka($context, array $blocks = array())
    {
        // line 17
        echo "\t ";
        $this->displayParentBlock("l_colonka", $context, $blocks);
        echo "
 ";
    }

    // line 20
    public function block_c_colonka($context, array $blocks = array())
    {
        // line 21
        echo "
<div class=\"block lifted\">
\t<h2>Форма обратной связи</h2>
\t<div class=\"post\">
\t\t<h1>
\t\t\t<a title=\"Ссылка на запись Немного о нас\" rel=\"bookmark\" href=\"javascript:void(0)\" onclick=\"\$('#oNas').toggle(200);\">Раздел контакты</a>
\t\t</h1>

\t\t<div class=\"center\">
\t\t\t<div class=\"centered\">
\t\t\t\t<div class=\"tagged\" style=\"width: 550px;\">
\t\t\t\t\t<ul>
\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t<b>
\t\t\t\t\t\t\t\tПоля не отмеченные * можно не заполнять. Эта информация понадобится
\t\t\t\t\t\t\t\tтолько при заказе фотографий и её можно будет ввести потом.
\t\t\t\t\t\t\t\tВаши данные сохраняются конфиденциально и нигде не афишируются.

\t\t\t\t\t\t\t</b>
\t\t\t\t\t\t</li>
\t\t\t\t\t</ul>
\t\t\t\t</div>
\t\t\t\t<div class=\"clear\"></div>

\t\t\t</div>
\t\t</div>
\t\t<div class=\"clear\"></div>

\t\t\t   <!--[if IE]>
\t\t\t   <script type='text/javascript'>
\t\t\t\t   \$(document).ready(function () {

\t\t\t\t\t   \$(\"#form_wrap\").css({
\t\t\t\t\t\t   height: '900px',
\t\t\t\t\t\t   top: '-150px' });

\t\t\t\t\t   \$(\".label\").css({
\t\t\t\t\t\t   background: '#f1ece3',
\t\t\t\t\t\t   color: 'red' });

\t\t\t\t\t   \$(\".inp_f_kont\").css({
\t\t\t\t\t\t   background: '#e8e3da' });

\t\t\t\t\t   \$('form').css({
\t\t\t\t\t\t   height: '680px'
\t\t\t\t\t   }, function () {

\t\t\t\t\t\t   \$(' #form_wrap input[type=submit] ').css({'z-index': '1', 'opacity': '1'})
\t\t\t\t\t   })
\t\t\t\t   })
\t\t\t   </script ><![endif]-->

\t   <link rel=\"stylesheet\" type=\"text/css\"  href=\"/css/kontakty.css\" media=\"all\"/>

\t   ";
        // line 76
        echo "\t   ";
        if ((isset($context["kontakt_Msg"]) || array_key_exists("kontakt_Msg", $context))) {
            // line 77
            echo "\t    <div class=\"center\"><div class=\"centered\">
\t\t\t   <div class=\"drop-shadow lifted\">
\t\t\t\t   <div style=\"font-size: 22px;\">";
            // line 79
            echo (isset($context["kontakt_Msg"]) || array_key_exists("kontakt_Msg", $context) ? $context["kontakt_Msg"] : (function () { throw new Twig_Error_Runtime('Variable "kontakt_Msg" does not exist.', 79, $this->source); })());
            echo "</div>
\t\t\t   </div>
\t\t</div></div>
\t   <div class=\"clear\"></div>
\t   ";
        }
        // line 84
        echo "\t   ";
        // line 85
        echo "
\t\t\t   <table style=\"position: relative; margin: 0 auto;\" >
\t\t\t\t   <tr >
\t\t\t\t\t   <td >
\t\t\t\t\t\t   <div id=\"wrap\" >
\t\t\t\t\t\t\t   <div id='form_wrap' >
\t\t\t\t\t\t\t\t   <table width=\"100%\" >
\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t   <td width=\"750\" >
\t\t\t\t\t\t\t\t\t\t\t   <form id=\"form_ob\" action=\"/kontakty.php\" method=\"post\" name=\"send_form\" >
\t\t\t\t\t\t\t\t\t\t\t\t   <h3 style=\"color:#000;\" >Пишите нам:</h3 >
\t\t\t\t\t\t\t\t\t\t\t\t   <table style=\"font-weight:bold\" >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >Ваше имя*:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR\" ><input rel=\"tooltip\" data-placement=\"top\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   data-original-title=\"Имя или ник на сайте. Длина от 3 до 16 символов.\" class=\"inp_f_kont\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   type=\"text\" name=\"uname\" style=\"margin-bottom: 5px; margin-left: 0; width: 200px;\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   id=\"td_name\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   maxlength=\"20\" value=\"";
        // line 103
        echo (isset($context["uname"]) || array_key_exists("uname", $context) ? $context["uname"] : (function () { throw new Twig_Error_Runtime('Variable "uname" does not exist.', 103, $this->source); })());
        echo "\" autofocus /></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td ><span id=\"valid_form_name\" class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t              style=\"margin-left: 10px;\" >";
        // line 105
        echo (isset($context["e1"]) || array_key_exists("e1", $context) ? $context["e1"] : (function () { throw new Twig_Error_Runtime('Variable "e1" does not exist.', 105, $this->source); })());
        echo "</span ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >Телефон*:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR\" ><input rel=\"tooltip\" data-placement=\"right\" data-original-title=\"Не меньше 6 цифр.\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"inp_f_kont\" type=\"text\" name=\"uphone\"  id=\"td_phone\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-bottom: 4px; margin-left: 0; width: 200px;\" maxlength=\"20\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   value=\"";
        // line 112
        echo (isset($context["uphone"]) || array_key_exists("uphone", $context) ? $context["uphone"] : (function () { throw new Twig_Error_Runtime('Variable "uphone" does not exist.', 112, $this->source); })());
        echo "\" onkeyup=\"parseField(this.name)\" /></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td ><span id=\"valid_form_phone\" class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t              style=\" margin-left: 10px;\" >";
        // line 114
        echo (isset($context["e4"]) || array_key_exists("e4", $context) ? $context["e4"] : (function () { throw new Twig_Error_Runtime('Variable "e4" does not exist.', 114, $this->source); })());
        echo "</span ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >Skype:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR\" ><input rel=\"tooltip\" data-placement=\"right\" data-original-title=\"Для быстрой связи.\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"inp_f_kont\" type=\"text\" name=\"skype\" id=\"td_skype\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-bottom: 5px; margin-left: 0; width: 200px;\" maxlength=\"20\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   value=\"";
        // line 121
        echo (isset($context["skype"]) || array_key_exists("skype", $context) ? $context["skype"] : (function () { throw new Twig_Error_Runtime('Variable "skype" does not exist.', 121, $this->source); })());
        echo "\" /></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td ><span id=\"valid_form_skype\" class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t              style=\" margin-left: 10px;\" ></span ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >Ваш E-mail*:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR\" ><input rel=\"tooltip\" data-placement=\"bottom\" id=\"td_email\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   data-original-title=\"Указывайте реально существующий почтовый ящик. На него Вам прийдет ответ.\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"inp_f_kont\" type=\"text\" name=\"umail\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-bottom: 15px; margin-left: 0; width: 200px;\" maxlength=\"50\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   value=\"";
        // line 131
        echo (isset($context["umail"]) || array_key_exists("umail", $context) ? $context["umail"] : (function () { throw new Twig_Error_Runtime('Variable "umail" does not exist.', 131, $this->source); })());
        echo "\" /></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td style=\"padding-bottom: 17px;\" ><span id=\"valid_form_email\" class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-top: 7px; margin-left: 10px;\" >";
        // line 133
        echo (isset($context["e3"]) || array_key_exists("e3", $context) ? $context["e3"] : (function () { throw new Twig_Error_Runtime('Variable "e3" does not exist.', 133, $this->source); })());
        echo "</span ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t   </table >

\t\t\t\t\t\t\t\t\t\t\t\t   <table class=\"tb_m_form\" >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL2\" >Текст сообщения:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR2\" ><textarea style=\"margin-top: -5px; margin-bottom: 10px; width: 350px; \"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Краткость - сестра таланта! :)\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   name=\"utext\" >";
        // line 142
        echo (isset($context["utext"]) || array_key_exists("utext", $context) ? $context["utext"] : (function () { throw new Twig_Error_Runtime('Variable "utext" does not exist.', 142, $this->source); })());
        echo "</textarea ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <span class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-top: -13px; margin-left: 180px; position:absolute\" >";
        // line 144
        echo (isset($context["e2"]) || array_key_exists("e2", $context) ? $context["e2"] : (function () { throw new Twig_Error_Runtime('Variable "e2" does not exist.', 144, $this->source); })());
        echo "</span >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >
\t\t\t\t\t\t\t\t\t\t<div style=\"position: absolute; margin-top: 1px; margin-left: 200px;\" >";
        // line 148
        echo $this->extensions['Extension']->captcha("kontakti.cfg.php", 1);
        echo "</div >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   </td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR2\" >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <input rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Защита от спама.\" class=\"inp_f_kont\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   type=\"text\" name=\"umath\" value=\"\" style=\"margin-left: -8px; width: 100px;\" /> <span
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"position: relative; padding-top: 2px; bottom: 40px;\" >";
        // line 154
        echo (isset($context["e5"]) || array_key_exists("e5", $context) ? $context["e5"] : (function () { throw new Twig_Error_Runtime('Variable "e5" does not exist.', 154, $this->source); })());
        echo "</span > <input
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   type=\"hidden\" name=\"go\" value=\"5\" /><br > <input class=\"inp_f_kont\" type=\"submit\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   name=\"submit\" value=\"Готово. Отправить!\" data-original-title=\"\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-top: 3px; margin-left: -8px; width: 300px;\" > <br >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   ";
        // line 158
        echo (isset($context["dataDB"]) || array_key_exists("dataDB", $context) ? $context["dataDB"] : (function () { throw new Twig_Error_Runtime('Variable "dataDB" does not exist.', 158, $this->source); })());
        echo "
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   </td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t   </table >
\t\t\t\t\t\t\t\t\t\t\t   </form >
\t\t\t\t\t\t\t\t\t\t   </td >
\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t   </table >
\t\t\t\t\t\t\t   </div >
\t\t\t\t\t\t   </div >
\t\t\t\t\t   </td >
\t\t\t\t   </tr >
\t\t\t   </table >

\t   <script type=\"text/javascript\" src=\"/js/valdator_kontakty.js\"></script>
\t</div ></div >
   ";
    }

    // line 176
    public function block_r_colonka($context, array $blocks = array())
    {
        // line 177
        echo "\t ";
        $this->displayParentBlock("r_colonka", $context, $blocks);
        echo "
 ";
    }

    public function getTemplateName()
    {
        return "/kontakty/kontakty.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  277 => 177,  274 => 176,  253 => 158,  246 => 154,  237 => 148,  230 => 144,  225 => 142,  213 => 133,  208 => 131,  195 => 121,  185 => 114,  180 => 112,  170 => 105,  165 => 103,  145 => 85,  143 => 84,  135 => 79,  131 => 77,  128 => 76,  72 => 21,  69 => 20,  62 => 17,  59 => 16,  49 => 8,  46 => 7,  39 => 4,  36 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"base.twig\" %}

    {% block content_header %}
\t    {{ parent() }}
    {% endblock %}

{% block top %}
    <div class=\"center\"><div class=\"centered\">
\t\t<div class=\"drop-shadow lifted\" >
\t\t\t<h2 ><span style=\"color: #00146e;\" > Раздел КОНТАКТЫ</span ></h2 >
\t\t</div >
\t</div ></div >
\t<div class=\"clear\" ></div >
{% endblock top %}

 {% block l_colonka %}
\t {{ parent() }}
 {% endblock %}

   {% block c_colonka %}

<div class=\"block lifted\">
\t<h2>Форма обратной связи</h2>
\t<div class=\"post\">
\t\t<h1>
\t\t\t<a title=\"Ссылка на запись Немного о нас\" rel=\"bookmark\" href=\"javascript:void(0)\" onclick=\"\$('#oNas').toggle(200);\">Раздел контакты</a>
\t\t</h1>

\t\t<div class=\"center\">
\t\t\t<div class=\"centered\">
\t\t\t\t<div class=\"tagged\" style=\"width: 550px;\">
\t\t\t\t\t<ul>
\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t<b>
\t\t\t\t\t\t\t\tПоля не отмеченные * можно не заполнять. Эта информация понадобится
\t\t\t\t\t\t\t\tтолько при заказе фотографий и её можно будет ввести потом.
\t\t\t\t\t\t\t\tВаши данные сохраняются конфиденциально и нигде не афишируются.

\t\t\t\t\t\t\t</b>
\t\t\t\t\t\t</li>
\t\t\t\t\t</ul>
\t\t\t\t</div>
\t\t\t\t<div class=\"clear\"></div>

\t\t\t</div>
\t\t</div>
\t\t<div class=\"clear\"></div>

\t\t\t   <!--[if IE]>
\t\t\t   <script type='text/javascript'>
\t\t\t\t   \$(document).ready(function () {

\t\t\t\t\t   \$(\"#form_wrap\").css({
\t\t\t\t\t\t   height: '900px',
\t\t\t\t\t\t   top: '-150px' });

\t\t\t\t\t   \$(\".label\").css({
\t\t\t\t\t\t   background: '#f1ece3',
\t\t\t\t\t\t   color: 'red' });

\t\t\t\t\t   \$(\".inp_f_kont\").css({
\t\t\t\t\t\t   background: '#e8e3da' });

\t\t\t\t\t   \$('form').css({
\t\t\t\t\t\t   height: '680px'
\t\t\t\t\t   }, function () {

\t\t\t\t\t\t   \$(' #form_wrap input[type=submit] ').css({'z-index': '1', 'opacity': '1'})
\t\t\t\t\t   })
\t\t\t\t   })
\t\t\t   </script ><![endif]-->

\t   <link rel=\"stylesheet\" type=\"text/css\"  href=\"/css/kontakty.css\" media=\"all\"/>

\t   {#<NOSCRIPT >#}
\t   {% if kontakt_Msg is defined %}
\t    <div class=\"center\"><div class=\"centered\">
\t\t\t   <div class=\"drop-shadow lifted\">
\t\t\t\t   <div style=\"font-size: 22px;\">{{ kontakt_Msg }}</div>
\t\t\t   </div>
\t\t</div></div>
\t   <div class=\"clear\"></div>
\t   {% endif %}
\t   {#</NOSCRIPT >#}

\t\t\t   <table style=\"position: relative; margin: 0 auto;\" >
\t\t\t\t   <tr >
\t\t\t\t\t   <td >
\t\t\t\t\t\t   <div id=\"wrap\" >
\t\t\t\t\t\t\t   <div id='form_wrap' >
\t\t\t\t\t\t\t\t   <table width=\"100%\" >
\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t   <td width=\"750\" >
\t\t\t\t\t\t\t\t\t\t\t   <form id=\"form_ob\" action=\"/kontakty.php\" method=\"post\" name=\"send_form\" >
\t\t\t\t\t\t\t\t\t\t\t\t   <h3 style=\"color:#000;\" >Пишите нам:</h3 >
\t\t\t\t\t\t\t\t\t\t\t\t   <table style=\"font-weight:bold\" >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >Ваше имя*:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR\" ><input rel=\"tooltip\" data-placement=\"top\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   data-original-title=\"Имя или ник на сайте. Длина от 3 до 16 символов.\" class=\"inp_f_kont\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   type=\"text\" name=\"uname\" style=\"margin-bottom: 5px; margin-left: 0; width: 200px;\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   id=\"td_name\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   maxlength=\"20\" value=\"{{ uname }}\" autofocus /></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td ><span id=\"valid_form_name\" class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t              style=\"margin-left: 10px;\" >{{ e1 }}</span ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >Телефон*:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR\" ><input rel=\"tooltip\" data-placement=\"right\" data-original-title=\"Не меньше 6 цифр.\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"inp_f_kont\" type=\"text\" name=\"uphone\"  id=\"td_phone\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-bottom: 4px; margin-left: 0; width: 200px;\" maxlength=\"20\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   value=\"{{ uphone }}\" onkeyup=\"parseField(this.name)\" /></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td ><span id=\"valid_form_phone\" class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t              style=\" margin-left: 10px;\" >{{ e4 }}</span ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >Skype:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR\" ><input rel=\"tooltip\" data-placement=\"right\" data-original-title=\"Для быстрой связи.\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"inp_f_kont\" type=\"text\" name=\"skype\" id=\"td_skype\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-bottom: 5px; margin-left: 0; width: 200px;\" maxlength=\"20\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   value=\"{{ skype }}\" /></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td ><span id=\"valid_form_skype\" class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t              style=\" margin-left: 10px;\" ></span ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >Ваш E-mail*:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR\" ><input rel=\"tooltip\" data-placement=\"bottom\" id=\"td_email\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   data-original-title=\"Указывайте реально существующий почтовый ящик. На него Вам прийдет ответ.\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"inp_f_kont\" type=\"text\" name=\"umail\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-bottom: 15px; margin-left: 0; width: 200px;\" maxlength=\"50\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   value=\"{{ umail }}\" /></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td style=\"padding-bottom: 17px;\" ><span id=\"valid_form_email\" class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-top: 7px; margin-left: 10px;\" >{{ e3 }}</span ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t   </table >

\t\t\t\t\t\t\t\t\t\t\t\t   <table class=\"tb_m_form\" >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL2\" >Текст сообщения:</td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR2\" ><textarea style=\"margin-top: -5px; margin-bottom: 10px; width: 350px; \"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Краткость - сестра таланта! :)\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   name=\"utext\" >{{ utext }}</textarea ></td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <span class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-top: -13px; margin-left: 180px; position:absolute\" >{{ e2 }}</span >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t   <tr >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formL\" style=\"width: 100px;\" >
\t\t\t\t\t\t\t\t\t\t<div style=\"position: absolute; margin-top: 1px; margin-left: 200px;\" >{{ captcha('kontakti.cfg.php', 1) }}</div >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   </td >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <td class=\"td_formR2\" >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   <input rel=\"tooltip\" data-placement=\"top\" data-original-title=\"Защита от спама.\" class=\"inp_f_kont\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   type=\"text\" name=\"umath\" value=\"\" style=\"margin-left: -8px; width: 100px;\" /> <span
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   class=\"label label-important\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"position: relative; padding-top: 2px; bottom: 40px;\" >{{ e5 }}</span > <input
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   type=\"hidden\" name=\"go\" value=\"5\" /><br > <input class=\"inp_f_kont\" type=\"submit\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   name=\"submit\" value=\"Готово. Отправить!\" data-original-title=\"\"
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   style=\"margin-top: 3px; margin-left: -8px; width: 300px;\" > <br >
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   {{ dataDB|raw }}
\t\t\t\t\t\t\t\t\t\t\t\t\t\t   </td >
\t\t\t\t\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t\t\t\t\t   </table >
\t\t\t\t\t\t\t\t\t\t\t   </form >
\t\t\t\t\t\t\t\t\t\t   </td >
\t\t\t\t\t\t\t\t\t   </tr >
\t\t\t\t\t\t\t\t   </table >
\t\t\t\t\t\t\t   </div >
\t\t\t\t\t\t   </div >
\t\t\t\t\t   </td >
\t\t\t\t   </tr >
\t\t\t   </table >

\t   <script type=\"text/javascript\" src=\"/js/valdator_kontakty.js\"></script>
\t</div ></div >
   {% endblock c_colonka %}

 {% block r_colonka %}
\t {{ parent() }}
 {% endblock %}
", "/kontakty/kontakty.twig", "O:\\domains\\add.pr\\templates\\kontakty\\kontakty.twig");
    }
}
