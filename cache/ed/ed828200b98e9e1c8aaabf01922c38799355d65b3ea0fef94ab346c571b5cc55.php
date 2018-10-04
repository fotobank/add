<?php

/* /fotobanck_adw/fotobanck_adw_kategorii.twig */
class __TwigTemplate_694b9e3bdecdc823632d9aca764a18968ac53b67ad937ae797c132d5b4af100d extends Twig_Template
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
        // line 2
        echo "<br >
<div class=\"cont-list\" style=\"margin: -10px 10px 60px 40%;\" >
\t<div class=\"drop-shadow lifted\" >
\t\t<h2 ><span style=\"color: #00146e;\" >Выбор категорий:</span ></h2 >
\t</div >
</div >
<div class=\"clear\" ></div >
<table >
\t<tr >
\t\t<td >
\t\t</td >
\t</tr >
\t<tr >
\t\t<td >
\t\t\t<div id=\"cont_fb\" >
\t\t\t</div >
\t\t</td >
\t</tr >
</table >

<div style=\"width:240px; float: left;\">
\t<div class=\"block lifted silver\" >
\t\t<h2 class=\"silver\">Категории</h2>
\t\t\t";
        // line 25
        if (((isset($context["buttons"]) || array_key_exists("buttons", $context)) && (twig_length_filter($this->env, (isset($context["buttons"]) || array_key_exists("buttons", $context) ? $context["buttons"] : (function () { throw new Twig_Error_Runtime('Variable "buttons" does not exist.', 25, $this->source); })())) > 0))) {
            // line 26
            echo "\t\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["buttons"]) || array_key_exists("buttons", $context) ? $context["buttons"] : (function () { throw new Twig_Error_Runtime('Variable "buttons" does not exist.', 26, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["button"]) {
                // line 27
                echo "\t\t\t\t\t";
                // line 28
                echo "\t\t\t\t\t<a class=\"button small gray\" href=\"/fotobanck_adw.php?chenge_cat=";
                echo twig_get_attribute($this->env, $this->source, $context["button"], "id", array());
                echo "\" >";
                echo twig_get_attribute($this->env, $this->source, $context["button"], "nm", array());
                echo "</a ><br>
\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['button'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 30
            echo "\t\t\t";
        } else {
            // line 31
            echo "\t\t\t<p>Разделы не найдены</p>
\t\t\t";
        }
        // line 33
        echo "\t</div>
</div>

<div class=\"clear\"></div>

<div class=\"center\">
\t<div class=\"centered\">
<div class=\"block lifted centered\" style=\"width: 1100px; float: right; margin-top: 40px; text-align: left; \">
\t<h2>Фотобанк</h2>
\t<div class=\"post\">
\t\t<h1>
\t\t\t<a title=\"Ссылка на запись Немного о нас\" rel=\"bookmark\" href=\"javascript:void(0)\" >О фотобанке</a>
\t\t</h1>
\t</div>
\t<div class=\"post\">
\t\t
\t</div>
</div>
\t</div>


</div>
<div class=\"clear\"></div>";
    }

    public function getTemplateName()
    {
        return "/fotobanck_adw/fotobanck_adw_kategorii.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 33,  71 => 31,  68 => 30,  57 => 28,  55 => 27,  50 => 26,  48 => 25,  23 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#/** кнопки разделов */#}
<br >
<div class=\"cont-list\" style=\"margin: -10px 10px 60px 40%;\" >
\t<div class=\"drop-shadow lifted\" >
\t\t<h2 ><span style=\"color: #00146e;\" >Выбор категорий:</span ></h2 >
\t</div >
</div >
<div class=\"clear\" ></div >
<table >
\t<tr >
\t\t<td >
\t\t</td >
\t</tr >
\t<tr >
\t\t<td >
\t\t\t<div id=\"cont_fb\" >
\t\t\t</div >
\t\t</td >
\t</tr >
</table >

<div style=\"width:240px; float: left;\">
\t<div class=\"block lifted silver\" >
\t\t<h2 class=\"silver\">Категории</h2>
\t\t\t{% if buttons is defined and buttons|length > 0 %}
\t\t\t\t{% for button in buttons %}
\t\t\t\t\t{#{{ dump_t(button) }}#}
\t\t\t\t\t<a class=\"button small gray\" href=\"/fotobanck_adw.php?chenge_cat={{- button.id -}}\" >{{- button.nm -}}</a ><br>
\t\t\t\t{% endfor %}
\t\t\t{% else %}
\t\t\t<p>Разделы не найдены</p>
\t\t\t{% endif %}
\t</div>
</div>

<div class=\"clear\"></div>

<div class=\"center\">
\t<div class=\"centered\">
<div class=\"block lifted centered\" style=\"width: 1100px; float: right; margin-top: 40px; text-align: left; \">
\t<h2>Фотобанк</h2>
\t<div class=\"post\">
\t\t<h1>
\t\t\t<a title=\"Ссылка на запись Немного о нас\" rel=\"bookmark\" href=\"javascript:void(0)\" >О фотобанке</a>
\t\t</h1>
\t</div>
\t<div class=\"post\">
\t\t
\t</div>
</div>
\t</div>


</div>
<div class=\"clear\"></div>", "/fotobanck_adw/fotobanck_adw_kategorii.twig", "O:\\domains\\add.pr\\templates\\fotobanck_adw\\fotobanck_adw_kategorii.twig");
    }
}
