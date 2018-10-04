<?php

/* /uslugi/f_svadbi/f_svadbi.twig */
class __TwigTemplate_cb90079f3a8b545809a6c49283ecf3f8c90556d3787cb61af31753775ec337a6 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("uslugi/uslugi.twig", "/uslugi/f_svadbi/f_svadbi.twig", 1);
        $this->blocks = array(
            'content_header' => array($this, 'block_content_header'),
            'top' => array($this, 'block_top'),
            'l_colonka' => array($this, 'block_l_colonka'),
            'c_colonka' => array($this, 'block_c_colonka'),
            'r_colonka' => array($this, 'block_r_colonka'),
            'bottom' => array($this, 'block_bottom'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "uslugi/uslugi.twig";
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
\t    <script type=\"text/JavaScript\" src=\"";
        // line 5
        echo $this->extensions['Extension']->merge_files("/cache/f_svadbi.min.js", "js", (isset($context["include_Js_f_svadbi"]) || array_key_exists("include_Js_f_svadbi", $context) ? $context["include_Js_f_svadbi"] : (function () { throw new Twig_Error_Runtime('Variable "include_Js_f_svadbi" does not exist.', 5, $this->source); })()), "", (isset($context["include_Js_f_svadbi"]) || array_key_exists("include_Js_f_svadbi", $context) ? $context["include_Js_f_svadbi"] : (function () { throw new Twig_Error_Runtime('Variable "include_Js_f_svadbi" does not exist.', 5, $this->source); })()));
        echo "\"></script>
    ";
    }

    // line 8
    public function block_top($context, array $blocks = array())
    {
        // line 9
        echo "\t<div id=\"cont_fb\">
\t\t<div class=\"cont-list\" style=\"margin: 0 10px 20px 43%;\">
\t\t\t<div class=\"drop-shadow lifted\">
\t\t\t\t<h2><span style=\"color: #00146e;\">Свадьбы</span></h2>
\t\t\t</div>
\t\t</div>
\t\t<a class=\"small button full blue\" href=\"/uslugi.php\"><span>Назад к категориям</span></a>
\t</div>
\t<div style=\"clear: both;\"></div>
\t<!-- вывод описания-->
\t";
        // line 19
        echo (isset($context["txt"]) || array_key_exists("txt", $context) ? $context["txt"] : (function () { throw new Twig_Error_Runtime('Variable "txt" does not exist.', 19, $this->source); })());
        echo "
\t";
        // line 21
        echo "\t";
        echo twig_get_attribute($this->env, $this->source, (isset($context["autoPrev"]) || array_key_exists("autoPrev", $context) ? $context["autoPrev"] : (function () { throw new Twig_Error_Runtime('Variable "autoPrev" does not exist.', 21, $this->source); })()), "printAlbum", array(0 => "/reklama/photo/svadbi/", 1 => 250, 2 => true), "method");
        echo "

\t";
        // line 24
        echo "\t";
        echo twig_get_attribute($this->env, $this->source, (isset($context["autoPrev"]) || array_key_exists("autoPrev", $context) ? $context["autoPrev"] : (function () { throw new Twig_Error_Runtime('Variable "autoPrev" does not exist.', 24, $this->source); })()), "printStart", array());
        echo "
\t<div id='thumb' style=\"min-height: 600px; margin-top: 50px;\"></div>

";
    }

    // line 32
    public function block_l_colonka($context, array $blocks = array())
    {
        // line 33
        echo "\t ";
        // line 34
        echo " ";
    }

    // line 38
    public function block_c_colonka($context, array $blocks = array())
    {
        // line 39
        echo "
\t\t    ";
        // line 41
        echo "\t\t    ";
        // line 42
        echo "
   ";
    }

    // line 48
    public function block_r_colonka($context, array $blocks = array())
    {
    }

    // line 52
    public function block_bottom($context, array $blocks = array())
    {
        // line 53
        echo " ";
    }

    public function getTemplateName()
    {
        return "/uslugi/f_svadbi/f_svadbi.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  115 => 53,  112 => 52,  107 => 48,  102 => 42,  100 => 41,  97 => 39,  94 => 38,  90 => 34,  88 => 33,  85 => 32,  76 => 24,  70 => 21,  66 => 19,  54 => 9,  51 => 8,  45 => 5,  40 => 4,  37 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"uslugi/uslugi.twig\" %}

    {% block content_header %}
\t    {{ parent() }}
\t    <script type=\"text/JavaScript\" src=\"{{ merge_files( '/cache/f_svadbi.min.js', 'js',  include_Js_f_svadbi , '',  include_Js_f_svadbi ) }}\"></script>
    {% endblock %}

{% block top %}
\t<div id=\"cont_fb\">
\t\t<div class=\"cont-list\" style=\"margin: 0 10px 20px 43%;\">
\t\t\t<div class=\"drop-shadow lifted\">
\t\t\t\t<h2><span style=\"color: #00146e;\">Свадьбы</span></h2>
\t\t\t</div>
\t\t</div>
\t\t<a class=\"small button full blue\" href=\"/uslugi.php\"><span>Назад к категориям</span></a>
\t</div>
\t<div style=\"clear: both;\"></div>
\t<!-- вывод описания-->
\t{{ txt }}
\t{#вывод альбомов#}
\t{{ autoPrev.printAlbum('/reklama/photo/svadbi/', 250, true) }}

\t{#вывод фотографий из первого альбома при загрузке#}
\t{{ autoPrev.printStart }}
\t<div id='thumb' style=\"min-height: 600px; margin-top: 50px;\"></div>

{% endblock top %}




 {% block l_colonka %}
\t {#{{ parent() }}#}
 {% endblock %}



   {% block c_colonka %}

\t\t    {#{{ dump(txt) }}#}
\t\t    {#{{ dump_r(txt) }}#}

   {% endblock c_colonka %}




{% block r_colonka %}
{% endblock r_colonka %}


 {% block bottom %}
 {% endblock bottom %}", "/uslugi/f_svadbi/f_svadbi.twig", "O:\\domains\\add.pr\\templates\\uslugi\\f_svadbi\\f_svadbi.twig");
    }
}
