<?php

/* base.twig */
class __TwigTemplate_d6eda0c0bfdf8552ef283183d10fbf05d54060014650792904b7ef3c976fc74e extends Twig_Template
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
        // line 1
        ob_start();
        // line 2
        echo "\t";
        $this->displayBlock('doctype', $context, $blocks);
        // line 6
        echo "

\t<head>
\t\t";
        // line 9
        $this->displayBlock('head', $context, $blocks);
        // line 12
        echo "\t</head>


\t";
        // line 15
        $this->displayBlock('body', $context, $blocks);
        // line 124
        echo "

\t";
        // line 126
        $this->displayBlock('html', $context, $blocks);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 2
    public function block_doctype($context, array $blocks = array())
    {
        // line 3
        echo "\t\t<!DOCTYPE html>
\t\t<html xmlns=\"http://www.w3.org/1999/xhtml\">
\t";
    }

    // line 9
    public function block_head($context, array $blocks = array())
    {
        // line 10
        echo "\t\t\t";
        $this->loadTemplate("head.twig", "base.twig", 10)->display($context);
        // line 11
        echo "\t\t";
    }

    // line 15
    public function block_body($context, array $blocks = array())
    {
        // line 16
        echo "\t\t<body>

\t\t";
        // line 18
        $this->displayBlock('maket', $context, $blocks);
        // line 101
        echo "

\t\t";
        // line 103
        $this->displayBlock('end_content', $context, $blocks);
        // line 106
        echo "


\t\t";
        // line 109
        $this->displayBlock('footer', $context, $blocks);
        // line 112
        echo "

\t\t";
        // line 115
        echo "\t\t<script type='text/javascript' >
\t\t\t\$('img').error(function () {
\t\t\t\t//\t\t\$(this).parent().css('visibility', 'hidden');
\t\t\t\t\$(this).attr('src', '/img/bg_out.png');
\t\t\t});
\t\t</script >

\t\t</body>
\t";
    }

    // line 18
    public function block_maket($context, array $blocks = array())
    {
        // line 19
        echo "\t\t\t<div id=\"maket\">

\t\t\t\t<div id=\"photo_preview_bg\"
\t\t\t\t     class=\"hidden\"
\t\t\t\t     onClick=\"hidePreview();\"></div>
\t\t\t\t<div id=\"photo_preview\"
\t\t\t\t     class=\"hidden\"></div>


\t\t\t\t<!--Голова начало-->
\t\t\t\t";
        // line 29
        $this->displayBlock('golova_menu', $context, $blocks);
        // line 32
        echo "\t\t\t\t<!--Голова конец-->


\t\t\t\t";
        // line 35
        $this->displayBlock('content', $context, $blocks);
        // line 96
        echo "
\t\t\t\t<div class=\"clear\"></div>

\t\t\t</div>
\t\t";
    }

    // line 29
    public function block_golova_menu($context, array $blocks = array())
    {
        // line 30
        echo "\t\t\t\t\t";
        $this->loadTemplate("golova_menu.twig", "base.twig", 30)->display($context);
        // line 31
        echo "\t\t\t\t";
    }

    // line 35
    public function block_content($context, array $blocks = array())
    {
        // line 36
        echo "\t\t\t\t\t<div id=\"main\">

\t\t\t\t\t\t";
        // line 39
        echo "\t\t\t\t\t\t";
        if ((isset($context["odebug"]) || array_key_exists("odebug", $context))) {
            // line 40
            echo "\t\t\t\t\t\t";
            if (((twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 40, $this->source); })()), "showRealtime", array(), "method") == true) && (twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 40, $this->source); })()), "isError", array()) > 0))) {
                // line 41
                echo "\t\t\t\t\t\t\t";
                $this->displayBlock('showDebug', $context, $blocks);
                // line 53
                echo "\t\t\t\t\t\t";
            }
            // line 54
            echo "\t\t\t\t\t\t";
        }
        // line 55
        echo "


\t\t\t\t\t\t";
        // line 58
        $this->displayBlock('content_header', $context, $blocks);
        // line 61
        echo "\t\t\t\t\t\t<div class=\"clear\"></div>


\t\t\t\t\t\t";
        // line 64
        $this->displayBlock('top', $context, $blocks);
        // line 66
        echo "
\t\t\t\t\t\t<div class=\"l_colonka\">
\t\t\t\t\t\t\t&#160
\t\t\t\t\t\t\t";
        // line 69
        $this->displayBlock('l_colonka', $context, $blocks);
        // line 72
        echo "\t\t\t\t\t\t</div>


\t\t\t\t\t\t<div class=\"c_colonka\">
\t\t\t\t\t\t\t&#160
\t\t\t\t\t\t\t";
        // line 77
        $this->displayBlock('c_colonka', $context, $blocks);
        // line 80
        echo "\t\t\t\t\t\t</div>


\t\t\t\t\t\t<div class=\"r_colonka\">
\t\t\t\t\t\t\t&#160
\t\t\t\t\t\t\t";
        // line 85
        $this->displayBlock('r_colonka', $context, $blocks);
        // line 88
        echo "\t\t\t\t\t\t</div>

\t\t\t\t\t\t";
        // line 90
        $this->displayBlock('bottom', $context, $blocks);
        // line 93
        echo "
\t\t\t\t\t</div>
\t\t\t\t";
    }

    // line 41
    public function block_showDebug($context, array $blocks = array())
    {
        // line 42
        echo "\t\t\t\t\t\t\t\t<div class=\"center\">
\t\t\t\t\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t\t\t\t\t";
        // line 44
        echo twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 44, $this->source); })()), "showAll", array(), "method");
        echo "
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"center\">
\t\t\t\t\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t\t\t\t\t";
        // line 50
        echo "\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t";
    }

    // line 58
    public function block_content_header($context, array $blocks = array())
    {
        // line 59
        echo "\t\t\t\t\t\t\t";
        $this->loadTemplate("content_header.twig", "base.twig", 59)->display($context);
        // line 60
        echo "\t\t\t\t\t\t";
    }

    // line 64
    public function block_top($context, array $blocks = array())
    {
        // line 65
        echo "\t\t\t\t\t\t";
    }

    // line 69
    public function block_l_colonka($context, array $blocks = array())
    {
        // line 70
        echo "\t\t\t\t\t\t\t\t";
        $this->loadTemplate("l_colonka.twig", "base.twig", 70)->display($context);
        // line 71
        echo "\t\t\t\t\t\t\t";
    }

    // line 77
    public function block_c_colonka($context, array $blocks = array())
    {
        // line 78
        echo "\t\t\t\t\t\t\t\t";
        $this->loadTemplate("c_colonka.twig", "base.twig", 78)->display($context);
        // line 79
        echo "\t\t\t\t\t\t\t";
    }

    // line 85
    public function block_r_colonka($context, array $blocks = array())
    {
        // line 86
        echo "\t\t\t\t\t\t\t\t";
        $this->loadTemplate("r_colonka.twig", "base.twig", 86)->display($context);
        // line 87
        echo "\t\t\t\t\t\t\t";
    }

    // line 90
    public function block_bottom($context, array $blocks = array())
    {
        // line 91
        echo "
\t\t\t\t\t\t";
    }

    // line 103
    public function block_end_content($context, array $blocks = array())
    {
        // line 104
        echo "\t\t\t<div class=\"end_content\"></div>
\t\t";
    }

    // line 109
    public function block_footer($context, array $blocks = array())
    {
        // line 110
        echo "\t\t\t";
        $this->loadTemplate("footer.twig", "base.twig", 110)->display($context);
        // line 111
        echo "\t\t";
    }

    // line 126
    public function block_html($context, array $blocks = array())
    {
        // line 127
        echo "\t\t</html>
\t";
    }

    public function getTemplateName()
    {
        return "base.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  336 => 127,  333 => 126,  329 => 111,  326 => 110,  323 => 109,  318 => 104,  315 => 103,  310 => 91,  307 => 90,  303 => 87,  300 => 86,  297 => 85,  293 => 79,  290 => 78,  287 => 77,  283 => 71,  280 => 70,  277 => 69,  273 => 65,  270 => 64,  266 => 60,  263 => 59,  260 => 58,  254 => 50,  246 => 44,  242 => 42,  239 => 41,  233 => 93,  231 => 90,  227 => 88,  225 => 85,  218 => 80,  216 => 77,  209 => 72,  207 => 69,  202 => 66,  200 => 64,  195 => 61,  193 => 58,  188 => 55,  185 => 54,  182 => 53,  179 => 41,  176 => 40,  173 => 39,  169 => 36,  166 => 35,  162 => 31,  159 => 30,  156 => 29,  148 => 96,  146 => 35,  141 => 32,  139 => 29,  127 => 19,  124 => 18,  112 => 115,  108 => 112,  106 => 109,  101 => 106,  99 => 103,  95 => 101,  93 => 18,  89 => 16,  86 => 15,  82 => 11,  79 => 10,  76 => 9,  70 => 3,  67 => 2,  62 => 126,  58 => 124,  56 => 15,  51 => 12,  49 => 9,  44 => 6,  41 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% spaceless %}
\t{% block doctype %}
\t\t<!DOCTYPE html>
\t\t<html xmlns=\"http://www.w3.org/1999/xhtml\">
\t{% endblock doctype %}


\t<head>
\t\t{% block head %}
\t\t\t{% include 'head.twig' %}
\t\t{% endblock head %}
\t</head>


\t{% block body %}
\t\t<body>

\t\t{% block maket %}
\t\t\t<div id=\"maket\">

\t\t\t\t<div id=\"photo_preview_bg\"
\t\t\t\t     class=\"hidden\"
\t\t\t\t     onClick=\"hidePreview();\"></div>
\t\t\t\t<div id=\"photo_preview\"
\t\t\t\t     class=\"hidden\"></div>


\t\t\t\t<!--Голова начало-->
\t\t\t\t{% block golova_menu %}
\t\t\t\t\t{% include 'golova_menu.twig' %}
\t\t\t\t{% endblock golova_menu %}
\t\t\t\t<!--Голова конец-->


\t\t\t\t{% block content %}
\t\t\t\t\t<div id=\"main\">

\t\t\t\t\t\t{#вывод ошибок#}
\t\t\t\t\t\t{% if odebug is defined %}
\t\t\t\t\t\t{% if odebug.showRealtime() == true and odebug.isError > 0 %}
\t\t\t\t\t\t\t{% block showDebug %}
\t\t\t\t\t\t\t\t<div class=\"center\">
\t\t\t\t\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t\t\t\t\t{{ odebug.showAll() }}
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"center\">
\t\t\t\t\t\t\t\t\t<div class=\"centered\">
\t\t\t\t\t\t\t\t\t\t{#{{ odebug.showLog() }}#}
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t{% endblock showDebug %}
\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t{% endif %}



\t\t\t\t\t\t{% block content_header %}
\t\t\t\t\t\t\t{% include 'content_header.twig' %}
\t\t\t\t\t\t{% endblock content_header %}
\t\t\t\t\t\t<div class=\"clear\"></div>


\t\t\t\t\t\t{% block top %}
\t\t\t\t\t\t{% endblock top %}

\t\t\t\t\t\t<div class=\"l_colonka\">
\t\t\t\t\t\t\t&#160
\t\t\t\t\t\t\t{% block l_colonka %}
\t\t\t\t\t\t\t\t{% include 'l_colonka.twig' %}
\t\t\t\t\t\t\t{% endblock l_colonka %}
\t\t\t\t\t\t</div>


\t\t\t\t\t\t<div class=\"c_colonka\">
\t\t\t\t\t\t\t&#160
\t\t\t\t\t\t\t{% block c_colonka %}
\t\t\t\t\t\t\t\t{% include 'c_colonka.twig' %}
\t\t\t\t\t\t\t{% endblock c_colonka %}
\t\t\t\t\t\t</div>


\t\t\t\t\t\t<div class=\"r_colonka\">
\t\t\t\t\t\t\t&#160
\t\t\t\t\t\t\t{% block r_colonka %}
\t\t\t\t\t\t\t\t{% include 'r_colonka.twig' %}
\t\t\t\t\t\t\t{% endblock r_colonka %}
\t\t\t\t\t\t</div>

\t\t\t\t\t\t{% block bottom %}

\t\t\t\t\t\t{% endblock bottom %}

\t\t\t\t\t</div>
\t\t\t\t{% endblock content %}

\t\t\t\t<div class=\"clear\"></div>

\t\t\t</div>
\t\t{% endblock maket %}


\t\t{% block end_content %}
\t\t\t<div class=\"end_content\"></div>
\t\t{% endblock end_content %}



\t\t{% block footer %}
\t\t\t{% include 'footer.twig' %}
\t\t{% endblock footer %}


\t\t{#замена удаленных картинок#}
\t\t<script type='text/javascript' >
\t\t\t\$('img').error(function () {
\t\t\t\t//\t\t\$(this).parent().css('visibility', 'hidden');
\t\t\t\t\$(this).attr('src', '/img/bg_out.png');
\t\t\t});
\t\t</script >

\t\t</body>
\t{% endblock body %}


\t{% block html %}
\t\t</html>
\t{% endblock html %}
{% endspaceless %}", "base.twig", "O:\\domains\\add.pr\\templates\\base.twig");
    }
}
