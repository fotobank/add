<?php

/* /uslugi/uslugi.twig */
class __TwigTemplate_25ba4ba22ed4c00ef70fb81f07f17f06675b4f2e66f09dcb32e17c4b3247fc8d extends Twig_Template
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
            'body' => array($this, 'block_body'),
            'maket' => array($this, 'block_maket'),
            'golova_menu' => array($this, 'block_golova_menu'),
            'content' => array($this, 'block_content'),
            'showDebug' => array($this, 'block_showDebug'),
            'content_header' => array($this, 'block_content_header'),
            'top' => array($this, 'block_top'),
            'l_colonka' => array($this, 'block_l_colonka'),
            'c_colonka' => array($this, 'block_c_colonka'),
            'r_colonka' => array($this, 'block_r_colonka'),
            'bottom' => array($this, 'block_bottom'),
            'end_content' => array($this, 'block_end_content'),
            'footer' => array($this, 'block_footer'),
            'html' => array($this, 'block_html'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo "
  ";
        // line 3
        ob_start();
        // line 4
        echo "\t  ";
        $this->displayBlock('doctype', $context, $blocks);
        // line 8
        echo "

\t  <head>
\t\t  ";
        // line 11
        $this->displayBlock('head', $context, $blocks);
        // line 14
        echo "\t  </head>


\t  ";
        // line 17
        $this->displayBlock('body', $context, $blocks);
        // line 179
        echo "

";
        // line 181
        $this->displayBlock('html', $context, $blocks);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 4
    public function block_doctype($context, array $blocks = array())
    {
        // line 5
        echo "\t\t  <!DOCTYPE html>
\t\t  <html xmlns=\"http://www.w3.org/1999/xhtml\">
\t  ";
    }

    // line 11
    public function block_head($context, array $blocks = array())
    {
        // line 12
        echo "\t\t\t  ";
        $this->loadTemplate("head.twig", "/uslugi/uslugi.twig", 12)->display($context);
        // line 13
        echo "\t\t  ";
    }

    // line 17
    public function block_body($context, array $blocks = array())
    {
        // line 18
        echo "\t\t  <body>
\t\t  ";
        // line 19
        $this->displayBlock('maket', $context, $blocks);
        // line 165
        echo "

\t";
        // line 167
        $this->displayBlock('end_content', $context, $blocks);
        // line 170
        echo "

\t";
        // line 172
        $this->displayBlock('footer', $context, $blocks);
        // line 175
        echo "

</body>
";
    }

    // line 19
    public function block_maket($context, array $blocks = array())
    {
        // line 20
        echo "\t\t\t  <div id=\"maket\">
\t\t\t\t  <div id=\"photo_preview_bg\" class=\"hidden\" onClick=\"hidePreview();\"></div>
\t\t\t\t  <div id=\"photo_preview\" class=\"hidden\"></div>


\t\t\t\t  <!--Голова начало-->
\t\t\t\t  ";
        // line 26
        $this->displayBlock('golova_menu', $context, $blocks);
        // line 29
        echo "\t\t\t\t  <!--Голова конец-->


\t\t\t\t  ";
        // line 32
        $this->displayBlock('content', $context, $blocks);
        // line 162
        echo "<div class=\"clear\"></div>
</div>
";
    }

    // line 26
    public function block_golova_menu($context, array $blocks = array())
    {
        // line 27
        echo "\t\t\t\t\t  ";
        $this->loadTemplate("golova_menu.twig", "/uslugi/uslugi.twig", 27)->display($context);
        // line 28
        echo "\t\t\t\t  ";
    }

    // line 32
    public function block_content($context, array $blocks = array())
    {
        // line 33
        echo "\t<div id=\"main\">

\t\t";
        // line 36
        echo "\t\t";
        if (((twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 36, $this->source); })()), "showRealtime", array(), "method") == true) && (twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 36, $this->source); })()), "isError", array()) > 0))) {
            // line 37
            echo "\t\t\t";
            $this->displayBlock('showDebug', $context, $blocks);
            // line 49
            echo "\t\t";
        }
        // line 50
        echo "
\t\t";
        // line 51
        $this->displayBlock('content_header', $context, $blocks);
        // line 54
        echo "\t\t<div class=\"clear\"></div>


\t\t";
        // line 57
        $this->displayBlock('top', $context, $blocks);
        // line 65
        echo "


\t\t<div class=\"l_colonka\">
\t\t\t&#160
\t\t\t";
        // line 70
        $this->displayBlock('l_colonka', $context, $blocks);
        // line 73
        echo "\t\t</div>
\t\t";
        // line 75
        echo "
\t\t<div class=\"c_colonka\">
\t\t\t&#160
\t\t\t";
        // line 78
        $this->displayBlock('c_colonka', $context, $blocks);
        // line 91
        echo "\t\t</div>



<div class=\"r_colonka\">
\t&#160
\t";
        // line 97
        $this->displayBlock('r_colonka', $context, $blocks);
        // line 100
        echo "</div>


\t<div class=\"clear\"></div>
 ";
        // line 104
        $this->displayBlock('bottom', $context, $blocks);
        // line 158
        echo "

</div>
";
    }

    // line 37
    public function block_showDebug($context, array $blocks = array())
    {
        // line 38
        echo "\t\t\t\t<div class=\"center\">
\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t";
        // line 40
        echo twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 40, $this->source); })()), "showAll", array(), "method");
        echo "
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"center\">
\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t";
        // line 46
        echo "\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t";
    }

    // line 51
    public function block_content_header($context, array $blocks = array())
    {
        // line 52
        echo "\t\t\t";
        $this->loadTemplate("content_header.twig", "/uslugi/uslugi.twig", 52)->display($context);
        // line 53
        echo "\t\t";
    }

    // line 57
    public function block_top($context, array $blocks = array())
    {
        // line 58
        echo "\t\t\t";
        // line 64
        echo "\t\t";
    }

    // line 70
    public function block_l_colonka($context, array $blocks = array())
    {
        // line 71
        echo "\t\t\t\t";
        $this->loadTemplate("rubriki.twig", "/uslugi/uslugi.twig", 71)->display($context);
        // line 72
        echo "\t\t\t";
    }

    // line 78
    public function block_c_colonka($context, array $blocks = array())
    {
        // line 79
        echo "\t\t\t\t<!-- вывод описания-->
\t\t\t\t<div class=\"block lifted\">
\t\t\t\t\t<h2>Альбомы</h2>
\t\t\t\t\t<div class=\"post\">
\t\t\t\t\t\t<h1>
\t\t\t\t\t\t\t<a title=\"Ссылка на запись Немного о нас\" rel=\"bookmark\" href=\"javascript:void(0)\" >Школа и выпускники</a>
\t\t\t\t\t\t</h1>
\t\t\t\t\t</div>
\t\t\t\t\t";
        // line 87
        echo (isset($context["dataDB_top"]) || array_key_exists("dataDB_top", $context) ? $context["dataDB_top"] : (function () { throw new Twig_Error_Runtime('Variable "dataDB_top" does not exist.', 87, $this->source); })());
        echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"clear\"></div>
\t\t\t";
    }

    // line 97
    public function block_r_colonka($context, array $blocks = array())
    {
        // line 98
        echo "\t\t";
        // line 99
        echo "\t";
    }

    // line 104
    public function block_bottom($context, array $blocks = array())
    {
        // line 105
        echo "\t <div class=\"block lifted\">
\t\t <h2>Альбомы</h2>
\t\t <div class=\"post\">
\t\t\t <h1>
\t\t\t\t <a title=\"Ссылка на запись Немного о нас\" rel=\"bookmark\" href=\"javascript:void(0)\" >Школа и выпускники</a>
\t\t\t </h1>
\t\t </div>
\t <div class=\"clear\"></div>
\t <table width=\"100%\" border=\"0\" >
\t\t <tr >
\t\t\t <td >
\t\t\t\t <table class=\"tb_usl_foto\" border=\"0\" >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_ph\" >&nbsp;</td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\" usl_svad\" href=\"/f_svadbi.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_deti\" href=\"/f_deti.php\" ></a ></td >
\t\t\t\t\t </tr >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_bankety\" href=\"/f_bankety.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_phknigi\" href=\"/f_photoboock.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_vipusk\" href=\"/f_vipusk.php\" ></a ></td >
\t\t\t\t\t </tr >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_raznoe\" href=\"/f_raznoe.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" >&nbsp;</td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" >&nbsp;</td >
\t\t\t\t\t </tr >
\t\t\t\t </table >
\t\t\t </td >
\t\t\t <td >
\t\t\t\t <table class=\"tb_usl_video\" border=\"0\" >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_vd\" ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_svad\" href=\"/v_svadby.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_deti\" href=\"/v_deti.php\" ></a ></td >
\t\t\t\t\t </tr >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_vipusk\" href=\"/v_vipusk.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"sl_show\" href=\"/v_sl_show.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_bankety\" href=\"/v_bankety.php\" ></a ></td >
\t\t\t\t\t </tr >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_raznoe\" href=\"/v_raznoe.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" >&nbsp;</td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" >&nbsp;</td >
\t\t\t\t\t </tr >
\t\t\t\t </table >
\t\t\t </td >
\t\t </tr >
\t </table >
\t ";
        // line 155
        echo (isset($context["dataDB_bottom"]) || array_key_exists("dataDB_bottom", $context) ? $context["dataDB_bottom"] : (function () { throw new Twig_Error_Runtime('Variable "dataDB_bottom" does not exist.', 155, $this->source); })());
        echo "
\t </div>
 ";
    }

    // line 167
    public function block_end_content($context, array $blocks = array())
    {
        // line 168
        echo "\t\t<div class=\"end_content\"></div>
\t";
    }

    // line 172
    public function block_footer($context, array $blocks = array())
    {
        // line 173
        echo "\t\t";
        $this->loadTemplate("footer.twig", "/uslugi/uslugi.twig", 173)->display($context);
        // line 174
        echo "\t";
    }

    // line 181
    public function block_html($context, array $blocks = array())
    {
        // line 182
        echo "\t</html>
";
    }

    public function getTemplateName()
    {
        return "/uslugi/uslugi.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  387 => 182,  384 => 181,  380 => 174,  377 => 173,  374 => 172,  369 => 168,  366 => 167,  359 => 155,  307 => 105,  304 => 104,  300 => 99,  298 => 98,  295 => 97,  287 => 87,  277 => 79,  274 => 78,  270 => 72,  267 => 71,  264 => 70,  260 => 64,  258 => 58,  255 => 57,  251 => 53,  248 => 52,  245 => 51,  239 => 46,  231 => 40,  227 => 38,  224 => 37,  217 => 158,  215 => 104,  209 => 100,  207 => 97,  199 => 91,  197 => 78,  192 => 75,  189 => 73,  187 => 70,  180 => 65,  178 => 57,  173 => 54,  171 => 51,  168 => 50,  165 => 49,  162 => 37,  159 => 36,  155 => 33,  152 => 32,  148 => 28,  145 => 27,  142 => 26,  136 => 162,  134 => 32,  129 => 29,  127 => 26,  119 => 20,  116 => 19,  109 => 175,  107 => 172,  103 => 170,  101 => 167,  97 => 165,  95 => 19,  92 => 18,  89 => 17,  85 => 13,  82 => 12,  79 => 11,  73 => 5,  70 => 4,  65 => 181,  61 => 179,  59 => 17,  54 => 14,  52 => 11,  47 => 8,  44 => 4,  42 => 3,  39 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#{% extends \"base.twig\" %}#}

  {% spaceless %}
\t  {% block doctype %}
\t\t  <!DOCTYPE html>
\t\t  <html xmlns=\"http://www.w3.org/1999/xhtml\">
\t  {% endblock doctype %}


\t  <head>
\t\t  {% block head %}
\t\t\t  {% include 'head.twig' %}
\t\t  {% endblock head %}
\t  </head>


\t  {% block body %}
\t\t  <body>
\t\t  {% block maket %}
\t\t\t  <div id=\"maket\">
\t\t\t\t  <div id=\"photo_preview_bg\" class=\"hidden\" onClick=\"hidePreview();\"></div>
\t\t\t\t  <div id=\"photo_preview\" class=\"hidden\"></div>


\t\t\t\t  <!--Голова начало-->
\t\t\t\t  {% block golova_menu %}
\t\t\t\t\t  {% include 'golova_menu.twig' %}
\t\t\t\t  {% endblock golova_menu %}
\t\t\t\t  <!--Голова конец-->


\t\t\t\t  {% block content %}
\t<div id=\"main\">

\t\t{#вывод ошибок#}
\t\t{% if odebug.showRealtime() == true and odebug.isError > 0 %}
\t\t\t{% block showDebug %}
\t\t\t\t<div class=\"center\">
\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t{{ odebug.showAll() }}
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"center\">
\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t{#{{ odebug.showLog() }}#}
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t{% endblock showDebug %}
\t\t{% endif %}

\t\t{% block content_header %}
\t\t\t{% include 'content_header.twig' %}
\t\t{% endblock content_header %}
\t\t<div class=\"clear\"></div>


\t\t{% block top %}
\t\t\t{#<div class=\"cont-list\" style=\"margin: -10px 10px 80px 40%;\" >
\t\t\t\t<div class=\"drop-shadow lifted\" >
\t\t\t\t\t<h2 ><span style=\"color: #00146e;\" > Раздел УСЛУГИ</span ></h2 >
\t\t\t\t</div >
\t\t\t</div >
\t\t\t<div class=\"clear\" ></div >#}
\t\t{% endblock top %}



\t\t<div class=\"l_colonka\">
\t\t\t&#160
\t\t\t{% block l_colonka %}
\t\t\t\t{% include 'rubriki.twig' %}
\t\t\t{% endblock l_colonka %}
\t\t</div>
\t\t{#{% include 'rubriki.twig' %}#}

\t\t<div class=\"c_colonka\">
\t\t\t&#160
\t\t\t{% block c_colonka %}
\t\t\t\t<!-- вывод описания-->
\t\t\t\t<div class=\"block lifted\">
\t\t\t\t\t<h2>Альбомы</h2>
\t\t\t\t\t<div class=\"post\">
\t\t\t\t\t\t<h1>
\t\t\t\t\t\t\t<a title=\"Ссылка на запись Немного о нас\" rel=\"bookmark\" href=\"javascript:void(0)\" >Школа и выпускники</a>
\t\t\t\t\t\t</h1>
\t\t\t\t\t</div>
\t\t\t\t\t{{ dataDB_top|raw }}
\t\t\t\t</div>
\t\t\t\t<div class=\"clear\"></div>
\t\t\t{% endblock c_colonka %}
\t\t</div>



<div class=\"r_colonka\">
\t&#160
\t{% block r_colonka %}
\t\t{#{% include 'r_colonka.twig' %}#}
\t{% endblock r_colonka %}
</div>


\t<div class=\"clear\"></div>
 {% block bottom %}
\t <div class=\"block lifted\">
\t\t <h2>Альбомы</h2>
\t\t <div class=\"post\">
\t\t\t <h1>
\t\t\t\t <a title=\"Ссылка на запись Немного о нас\" rel=\"bookmark\" href=\"javascript:void(0)\" >Школа и выпускники</a>
\t\t\t </h1>
\t\t </div>
\t <div class=\"clear\"></div>
\t <table width=\"100%\" border=\"0\" >
\t\t <tr >
\t\t\t <td >
\t\t\t\t <table class=\"tb_usl_foto\" border=\"0\" >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_ph\" >&nbsp;</td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\" usl_svad\" href=\"/f_svadbi.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_deti\" href=\"/f_deti.php\" ></a ></td >
\t\t\t\t\t </tr >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_bankety\" href=\"/f_bankety.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_phknigi\" href=\"/f_photoboock.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_vipusk\" href=\"/f_vipusk.php\" ></a ></td >
\t\t\t\t\t </tr >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" ><a class=\"usl_raznoe\" href=\"/f_raznoe.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" >&nbsp;</td >
\t\t\t\t\t\t <td class=\"td_usl_ph_sp\" >&nbsp;</td >
\t\t\t\t\t </tr >
\t\t\t\t </table >
\t\t\t </td >
\t\t\t <td >
\t\t\t\t <table class=\"tb_usl_video\" border=\"0\" >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_vd\" ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_svad\" href=\"/v_svadby.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_deti\" href=\"/v_deti.php\" ></a ></td >
\t\t\t\t\t </tr >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_vipusk\" href=\"/v_vipusk.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"sl_show\" href=\"/v_sl_show.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_bankety\" href=\"/v_bankety.php\" ></a ></td >
\t\t\t\t\t </tr >
\t\t\t\t\t <tr >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" ><a class=\"usl_v_raznoe\" href=\"/v_raznoe.php\" ></a ></td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" >&nbsp;</td >
\t\t\t\t\t\t <td class=\"td_usl_vd_sp\" >&nbsp;</td >
\t\t\t\t\t </tr >
\t\t\t\t </table >
\t\t\t </td >
\t\t </tr >
\t </table >
\t {{ dataDB_bottom|raw }}
\t </div>
 {% endblock bottom %}


</div>
{% endblock content %}
<div class=\"clear\"></div>
</div>
{% endblock maket %}


\t{% block end_content %}
\t\t<div class=\"end_content\"></div>
\t{% endblock end_content %}


\t{% block footer %}
\t\t{% include 'footer.twig' %}
\t{% endblock footer %}


</body>
{% endblock body %}


{% block html %}
\t</html>
{% endblock html %}
{% endspaceless %}", "/uslugi/uslugi.twig", "O:\\domains\\add.pr\\templates\\uslugi\\uslugi.twig");
    }
}
