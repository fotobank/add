<?php

/* content_header.twig */
class __TwigTemplate_35ff9f61d2c49fce897347d4a5da7148c0ad4b0ecb3fceac2c55f1e4e269a4cb extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'content_header' => array($this, 'block_content_header'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $this->displayBlock('content_header', $context, $blocks);
    }

    public function block_content_header($context, array $blocks = array())
    {
        // line 3
        echo "<div class=\"header\">

    <div id=\"wb_Shape2\" style=\"position:relative; margin:20px auto 0;width:1050px;height:235px;z-index:1;\">
        <img src=\"/img/gradient.png\" id=\"Shape2\" alt=\"\" style=\"width:1050px;height:235px;\">
    </div>
    <div id=\"wb_Image16\" style=\"position:relative;margin:-50px auto 0;width:1000px;height:96px;z-index:0;\">
        <img id=\"Image16\" style=\"width:1000px;height:96px;\" alt=\"\" src=\"/img/shadow_horizontal_18.png\">
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "content_header.twig";
    }

    public function getDebugInfo()
    {
        return array (  30 => 3,  24 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#{% extends \"base.twig\" %}#}
{% block content_header %}
<div class=\"header\">

    <div id=\"wb_Shape2\" style=\"position:relative; margin:20px auto 0;width:1050px;height:235px;z-index:1;\">
        <img src=\"/img/gradient.png\" id=\"Shape2\" alt=\"\" style=\"width:1050px;height:235px;\">
    </div>
    <div id=\"wb_Image16\" style=\"position:relative;margin:-50px auto 0;width:1000px;height:96px;z-index:0;\">
        <img id=\"Image16\" style=\"width:1000px;height:96px;\" alt=\"\" src=\"/img/shadow_horizontal_18.png\">
    </div>
</div>
{% endblock %}", "content_header.twig", "O:\\domains\\add.pr\\templates\\content_header.twig");
    }
}
