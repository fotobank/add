<?php

/* golova_menu.twig */
class __TwigTemplate_2c744547c03894c75785b0f60c8ac3837804b1bb69fe2925dd0c2774caffc07e extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div id=\"head\">
\t<table class=\"tb_head\">
\t\t<tr>
\t\t\t<td>
\t\t\t\t<div class=\"td_head_logo\">
\t\t\t\t\t<a class=\"logo\"
\t\t\t\t\t   href=\"/index.php\"></a>

\t\t\t\t\t<div id=\"zagol\">
\t\t\t\t\t\t<h1>
\t\t\t\t\t\t<span class=\"letter1\">���������������� <br>
\t\t\t\t\t\t<span style=\"
\t\t\t\t\t\tpadding-top: 10px;
\t\t\t\t\t\tpadding-bottom: 10px;
\t\t\t\t\t\tline-height: 1.3em;
\t\t\t\t\t\tletter-spacing: 0;
\t\t\t\t\t\t\"> ���� � �����������</span><br>
\t\t\t\t          � ������</span>
\t\t\t\t\t\t</h1>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</td>
\t\t\t<td class=\"td_form_ent\">
\t\t\t\t<div id=\"form_ent\">
\t\t\t\t\t";
        // line 25
        if ((isset($context["logged"]) || array_key_exists("logged", $context) ? $context["logged"] : (function () { throw new Twig_Error_Runtime('Variable "logged" does not exist.', 25, $this->source); })())) {
            // line 26
            echo "\t\t\t\t\t\t<div style=\"text-align: center;\">
\t\t\t\t\t      <span style=\"color:#bb5\"><span style=\"font-size: 14px\">������������,</span><br> <span
\t\t\t\t\t\t\t\t      style=\"font-weight: bold;\">";
            // line 28
            echo (isset($context["us_name"]) || array_key_exists("us_name", $context) ? $context["us_name"] : (function () { throw new Twig_Error_Runtime('Variable "us_name" does not exist.', 28, $this->source); })());
            echo "</span><br/>
\t\t\t\t\t\t  <span style=\"font-size: 12px;\"> ��� ������: </span>
\t\t\t\t\t\t  <span id=\"balans\"
\t\t\t\t\t\t        style=\"font-weight: bold;\">";
            // line 31
            echo (isset($context["user_balans"]) || array_key_exists("user_balans", $context) ? $context["user_balans"] : (function () { throw new Twig_Error_Runtime('Variable "user_balans" does not exist.', 31, $this->source); })());
            echo "</span> ��.<br/></span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div style=\"margin-top: 8px;\">
\t\t\t\t\t\t\t<a class=\"korzina\"
\t\t\t\t\t\t\t   style=\"position: absolute; top: 62px; width: 52px;\"
\t\t\t\t\t\t\t   href=\"/basket.php\">�������</a> <a
\t\t\t\t\t\t\t\t\tclass=\"vihod\"
\t\t\t\t\t\t\t\t\tstyle=\"position: absolute; top: 62px; left: 80px;\"
\t\t\t\t\t\t\t\t\thref=\"/enter.php?logout=1\">�����</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div style=\"margin-top: 8px;\">
\t\t\t\t\t\t\t<a class=\"scet\"
\t\t\t\t\t\t\t   style=\"position: absolute; width: 30px; top: 88px;\"
\t\t\t\t\t\t\t   data-target=\"#\"
\t\t\t\t\t\t\t   data-toggle=\"order\"
\t\t\t\t\t\t\t   href=\"/security.php?acc=";
            // line 46
            echo (isset($context["accVer"]) || array_key_exists("accVer", $context) ? $context["accVer"] : (function () { throw new Twig_Error_Runtime('Variable "accVer" does not exist.', 46, $this->source); })());
            echo "\">����</a> <a class=\"user\"
\t\t\t\t\t\t\t                                                     href=\"/security.php?user=";
            // line 47
            echo (isset($context["userVer"]) || array_key_exists("userVer", $context) ? $context["userVer"] : (function () { throw new Twig_Error_Runtime('Variable "userVer" does not exist.', 47, $this->source); })());
            echo "\"
\t\t\t\t\t\t\t                                                     style=\"position: absolute; width: 88px; left: 48px; top: 88px;\">������������</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t";
        } else {
            // line 51
            echo "\t\t\t\t\t\t<span>����� �����:</span><br>
\t\t\t\t\t\t<form id=\"form_login\"
\t\t\t\t\t\t      action=\"/enter.php\"
\t\t\t\t\t\t      method=\"post\">
\t\t\t\t\t\t\t<table>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td> �����:</td>
\t\t\t\t\t\t\t\t\t<td><label><input class=\"inp_fent\"
\t\t\t\t\t\t\t\t\t                  name=\"login\"> </label></td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td> ������:</td>
\t\t\t\t\t\t\t\t\t<td><label> <input class=\"inp_fent\"
\t\t\t\t\t\t\t\t\t                   type=\"password\"
\t\t\t\t\t\t\t\t\t                   name=\"password\"> </label></td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr></tr>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td>
\t\t\t\t\t\t\t\t\t\t<input data-placement=\"left\"
\t\t\t\t\t\t\t\t\t\t       rel=\"tooltip\"
\t\t\t\t\t\t\t\t\t\t       class=\"vhod\"
\t\t\t\t\t\t\t\t\t\t       name=\"submit\"
\t\t\t\t\t\t\t\t\t\t       type=\"submit\"
\t\t\t\t\t\t\t\t\t\t       value=\"����\"
\t\t\t\t\t\t\t\t\t\t       title=\"����� ����������!\"
\t\t\t\t\t\t\t\t\t\t       data-original-title=\"����� ����������!\">
\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t<td>
\t\t\t\t\t\t\t\t\t\t<a href=\"/registr.php\"
\t\t\t\t\t\t\t\t\t\t   class=\"registracia\"
\t\t\t\t\t\t\t\t\t\t   data-placement=\"right\"
\t\t\t\t\t\t\t\t\t\t   data-original-title=\"�� ��� �� ������������������? ���������������\">�����������</a>
\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t</table>
\t\t\t\t\t\t\t<a href=\"/reminder.php\"
\t\t\t\t\t\t\t   style=\"color: #fff; text-decoration: none;\"
\t\t\t\t\t\t\t   data-target=\"#\"
\t\t\t\t\t\t\t   data-toggle=\"modal\"
\t\t\t\t\t\t\t   data-placement=\"right\"
\t\t\t\t\t\t\t   data-original-title=\"�������������� ������\">������ ������?</a>
\t\t\t\t\t\t</form>
\t\t\t\t\t";
        }
        // line 95
        echo "\t\t\t\t</div>
\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td></td>
\t\t\t<td></td>
\t\t</tr>
\t</table>

\t";
        // line 104
        $this->loadTemplate("flash.twig", "golova_menu.twig", 104)->display($context);
        // line 105
        echo "
\t<div id=\"main_menu\">

\t\t";
        // line 108
        $this->loadTemplate("main_menu.twig", "golova_menu.twig", 108)->display($context);
        // line 109
        echo "
\t\t<object width=\"90\"
\t\t        height=\"90\"
\t\t        style=\"position: absolute; margin-left: 135px; margin-top: 26px; width: 70px; height: 80px; z-index:10;\"
\t\t        type=\"application/x-shockwave-flash\"
\t\t        data=\"/img/calendarb.swf\">
\t\t\t<param name=\"movie\"
\t\t\t       value=\"img/calendar2b.swf\"/>
\t\t\t<param name=\"wmode\"
\t\t\t       value=\"transparent\"/>
\t\t</object>

\t</div>

</div>

<!--[if lt IE 7]><p class=\"chromeframe\">�� ����������� ���������� �������. ��� ��������� ���� ������������ ������� ����� ���������� �������� �������. <a
\t\thref=\"http://browsehappy.com/\">�������� ���� ������� ������</a>��� <a href=\"http://www.google.com/chromeframe/?redirect=true\">���������� ���������� Google
                                                                                                                                      Chrome Frame</a>���
                                        ��������� ����� �����.</p><![endif]-->

<NOSCRIPT>
\t<br><br>
\t<hfooter style=\"
       margin-left: 90px;
        font-size: 20px;
         font-weight: 400;
          font-style: inherit;
           color: #df0000;
            text-shadow: 1px 1px 0 #d1a2a2;
            \">��������! ��� ����������� ������ �����, �������� � �������� ��������� JavaScript! (<a href=\"http://www.enable-javascript.com/ru/\">��� ��������
\t                                                                                                                                            JavaScript?</a>)
\t</hfooter>
</NOSCRIPT>


";
        // line 146
        if ((isset($context["printMsg"]) || array_key_exists("printMsg", $context))) {
            // line 147
            echo twig_get_attribute($this->env, $this->source, (isset($context["printMsg"]) || array_key_exists("printMsg", $context) ? $context["printMsg"] : (function () { throw new Twig_Error_Runtime('Variable "printMsg" does not exist.', 147, $this->source); })()), "noJs", array());
            echo " ";
            echo twig_get_attribute($this->env, $this->source, (isset($context["printMsg"]) || array_key_exists("printMsg", $context) ? $context["printMsg"] : (function () { throw new Twig_Error_Runtime('Variable "printMsg" does not exist.', 147, $this->source); })()), "withJs", array());
            echo "
";
        }
        // line 149
        echo "
";
        // line 162
        echo "
";
        // line 164
        echo "
";
    }

    public function getTemplateName()
    {
        return "golova_menu.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  209 => 164,  206 => 162,  203 => 149,  196 => 147,  194 => 146,  156 => 109,  154 => 108,  149 => 105,  147 => 104,  136 => 95,  90 => 51,  83 => 47,  79 => 46,  61 => 31,  55 => 28,  51 => 26,  49 => 25,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div id=\"head\">
\t<table class=\"tb_head\">
\t\t<tr>
\t\t\t<td>
\t\t\t\t<div class=\"td_head_logo\">
\t\t\t\t\t<a class=\"logo\"
\t\t\t\t\t   href=\"/index.php\"></a>

\t\t\t\t\t<div id=\"zagol\">
\t\t\t\t\t\t<h1>
\t\t\t\t\t\t<span class=\"letter1\">���������������� <br>
\t\t\t\t\t\t<span style=\"
\t\t\t\t\t\tpadding-top: 10px;
\t\t\t\t\t\tpadding-bottom: 10px;
\t\t\t\t\t\tline-height: 1.3em;
\t\t\t\t\t\tletter-spacing: 0;
\t\t\t\t\t\t\"> ���� � �����������</span><br>
\t\t\t\t          � ������</span>
\t\t\t\t\t\t</h1>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</td>
\t\t\t<td class=\"td_form_ent\">
\t\t\t\t<div id=\"form_ent\">
\t\t\t\t\t{% if logged %}
\t\t\t\t\t\t<div style=\"text-align: center;\">
\t\t\t\t\t      <span style=\"color:#bb5\"><span style=\"font-size: 14px\">������������,</span><br> <span
\t\t\t\t\t\t\t\t      style=\"font-weight: bold;\">{{ us_name }}</span><br/>
\t\t\t\t\t\t  <span style=\"font-size: 12px;\"> ��� ������: </span>
\t\t\t\t\t\t  <span id=\"balans\"
\t\t\t\t\t\t        style=\"font-weight: bold;\">{{ user_balans }}</span> ��.<br/></span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div style=\"margin-top: 8px;\">
\t\t\t\t\t\t\t<a class=\"korzina\"
\t\t\t\t\t\t\t   style=\"position: absolute; top: 62px; width: 52px;\"
\t\t\t\t\t\t\t   href=\"/basket.php\">�������</a> <a
\t\t\t\t\t\t\t\t\tclass=\"vihod\"
\t\t\t\t\t\t\t\t\tstyle=\"position: absolute; top: 62px; left: 80px;\"
\t\t\t\t\t\t\t\t\thref=\"/enter.php?logout=1\">�����</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div style=\"margin-top: 8px;\">
\t\t\t\t\t\t\t<a class=\"scet\"
\t\t\t\t\t\t\t   style=\"position: absolute; width: 30px; top: 88px;\"
\t\t\t\t\t\t\t   data-target=\"#\"
\t\t\t\t\t\t\t   data-toggle=\"order\"
\t\t\t\t\t\t\t   href=\"/security.php?acc={{ accVer }}\">����</a> <a class=\"user\"
\t\t\t\t\t\t\t                                                     href=\"/security.php?user={{ userVer }}\"
\t\t\t\t\t\t\t                                                     style=\"position: absolute; width: 88px; left: 48px; top: 88px;\">������������</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t{% else %}
\t\t\t\t\t\t<span>����� �����:</span><br>
\t\t\t\t\t\t<form id=\"form_login\"
\t\t\t\t\t\t      action=\"/enter.php\"
\t\t\t\t\t\t      method=\"post\">
\t\t\t\t\t\t\t<table>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td> �����:</td>
\t\t\t\t\t\t\t\t\t<td><label><input class=\"inp_fent\"
\t\t\t\t\t\t\t\t\t                  name=\"login\"> </label></td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td> ������:</td>
\t\t\t\t\t\t\t\t\t<td><label> <input class=\"inp_fent\"
\t\t\t\t\t\t\t\t\t                   type=\"password\"
\t\t\t\t\t\t\t\t\t                   name=\"password\"> </label></td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr></tr>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td>
\t\t\t\t\t\t\t\t\t\t<input data-placement=\"left\"
\t\t\t\t\t\t\t\t\t\t       rel=\"tooltip\"
\t\t\t\t\t\t\t\t\t\t       class=\"vhod\"
\t\t\t\t\t\t\t\t\t\t       name=\"submit\"
\t\t\t\t\t\t\t\t\t\t       type=\"submit\"
\t\t\t\t\t\t\t\t\t\t       value=\"����\"
\t\t\t\t\t\t\t\t\t\t       title=\"����� ����������!\"
\t\t\t\t\t\t\t\t\t\t       data-original-title=\"����� ����������!\">
\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t<td>
\t\t\t\t\t\t\t\t\t\t<a href=\"/registr.php\"
\t\t\t\t\t\t\t\t\t\t   class=\"registracia\"
\t\t\t\t\t\t\t\t\t\t   data-placement=\"right\"
\t\t\t\t\t\t\t\t\t\t   data-original-title=\"�� ��� �� ������������������? ���������������\">�����������</a>
\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t</table>
\t\t\t\t\t\t\t<a href=\"/reminder.php\"
\t\t\t\t\t\t\t   style=\"color: #fff; text-decoration: none;\"
\t\t\t\t\t\t\t   data-target=\"#\"
\t\t\t\t\t\t\t   data-toggle=\"modal\"
\t\t\t\t\t\t\t   data-placement=\"right\"
\t\t\t\t\t\t\t   data-original-title=\"�������������� ������\">������ ������?</a>
\t\t\t\t\t\t</form>
\t\t\t\t\t{% endif %}
\t\t\t\t</div>
\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td></td>
\t\t\t<td></td>
\t\t</tr>
\t</table>

\t{% include 'flash.twig' %}

\t<div id=\"main_menu\">

\t\t{% include 'main_menu.twig' %}

\t\t<object width=\"90\"
\t\t        height=\"90\"
\t\t        style=\"position: absolute; margin-left: 135px; margin-top: 26px; width: 70px; height: 80px; z-index:10;\"
\t\t        type=\"application/x-shockwave-flash\"
\t\t        data=\"/img/calendarb.swf\">
\t\t\t<param name=\"movie\"
\t\t\t       value=\"img/calendar2b.swf\"/>
\t\t\t<param name=\"wmode\"
\t\t\t       value=\"transparent\"/>
\t\t</object>

\t</div>

</div>

<!--[if lt IE 7]><p class=\"chromeframe\">�� ����������� ���������� �������. ��� ��������� ���� ������������ ������� ����� ���������� �������� �������. <a
\t\thref=\"http://browsehappy.com/\">�������� ���� ������� ������</a>��� <a href=\"http://www.google.com/chromeframe/?redirect=true\">���������� ���������� Google
                                                                                                                                      Chrome Frame</a>���
                                        ��������� ����� �����.</p><![endif]-->

<NOSCRIPT>
\t<br><br>
\t<hfooter style=\"
       margin-left: 90px;
        font-size: 20px;
         font-weight: 400;
          font-style: inherit;
           color: #df0000;
            text-shadow: 1px 1px 0 #d1a2a2;
            \">��������! ��� ����������� ������ �����, �������� � �������� ��������� JavaScript! (<a href=\"http://www.enable-javascript.com/ru/\">��� ��������
\t                                                                                                                                            JavaScript?</a>)
\t</hfooter>
</NOSCRIPT>


{#��������� �� ������� � ok#}
{% if printMsg is defined %}
{{ printMsg.noJs }} {{ printMsg.withJs }}
{% endif %}

{#
<form>
\t...
\t<input type=\"button\" class=\"js\" style=\"display:none\" value=\"������, ���������� � JS\"
\t\t\tonClick=\"javascript:addtocart()\">
\t<input type=\"submit\" class=\"noscript\" value=\"������, ���������� ��� JS\">
</form>

<script>
\t\$('.noscript').hide();
\t\$('.js').show();
</script>#}

{#<a href=\"/cart/add/123\" onclick=\"javascript:addToCart(123); return false;\" target=\"_blank\">ytutyutyutyutyutyu</a>#}

{#����#}
{#{{ dump('') }}#}
{#{{ dump(accVer) }}#}
{#{{ dump(userVer) }}#}", "golova_menu.twig", "O:\\domains\\add.pr\\templates\\golova_menu.twig");
    }
}
