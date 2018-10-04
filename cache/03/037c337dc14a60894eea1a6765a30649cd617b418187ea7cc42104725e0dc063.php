<?php

/* /index/index.twig */
class __TwigTemplate_7334bf5ad9fccd04f5400d9c937ee1032b62a4f8f81a1dc604eed6fafd63005f extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.twig", "/index/index.twig", 1);
        $this->blocks = array(
            'content_header' => array($this, 'block_content_header'),
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

    // line 4
    public function block_content_header($context, array $blocks = array())
    {
        // line 5
        echo "\t    ";
        $this->displayParentBlock("content_header", $context, $blocks);
        echo "
    ";
    }

    // line 9
    public function block_l_colonka($context, array $blocks = array())
    {
        // line 10
        echo "\t    ";
        $this->displayParentBlock("l_colonka", $context, $blocks);
        echo "
    ";
    }

    // line 14
    public function block_c_colonka($context, array $blocks = array())
    {
        // line 15
        echo "\t    ";
        $this->displayParentBlock("c_colonka", $context, $blocks);
        echo "
    ";
    }

    // line 19
    public function block_r_colonka($context, array $blocks = array())
    {
        // line 20
        echo "\t    ";
        $this->displayParentBlock("r_colonka", $context, $blocks);
        echo "
    ";
    }

    public function getTemplateName()
    {
        return "/index/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 20,  65 => 19,  58 => 15,  55 => 14,  48 => 10,  45 => 9,  38 => 5,  35 => 4,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"base.twig\" %}


    {% block content_header %}
\t    {{ parent() }}
    {% endblock %}


    {% block l_colonka %}
\t    {{ parent() }}
    {% endblock %}


    {% block c_colonka %}
\t    {{ parent() }}
    {% endblock %}


    {% block r_colonka %}
\t    {{ parent() }}
    {% endblock %}
", "/index/index.twig", "O:\\domains\\add.pr\\templates\\index\\index.twig");
    }
}
