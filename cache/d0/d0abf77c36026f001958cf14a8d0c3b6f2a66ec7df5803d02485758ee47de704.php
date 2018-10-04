<?php

/* head.twig */
class __TwigTemplate_9f73ae020e7ff335ffcc20c6acb50f65cdefbb98714a6ae78f7b64a4bd039a7c extends Twig_Template
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
        echo "\t<meta name=\"description\" content=\"";
        echo (isset($context["description"]) || array_key_exists("description", $context) ? $context["description"] : (function () { throw new Twig_Error_Runtime('Variable "description" does not exist.', 1, $this->source); })());
        echo "\"/>
\t<meta name=\"keywords\" content=\"";
        // line 2
        echo (isset($context["keywords"]) || array_key_exists("keywords", $context) ? $context["keywords"] : (function () { throw new Twig_Error_Runtime('Variable "keywords" does not exist.', 2, $this->source); })());
        echo "\"/>
\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\"/>
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=9\"/>
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=0.85\"/>
\t<title>";
        // line 6
        echo (isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new Twig_Error_Runtime('Variable "title" does not exist.', 6, $this->source); })());
        echo "</title>

\t<link rel=\"shortcut icon\" type=\"image/vnd.microsoft.icon\" href=\"/favicon.ico\"/>
\t<link rel=\"shortcut icon\" href=\"/img/ico_nmain.gif\"/>
\t";
        // line 10
        if ((isset($context["include_CSS"]) || array_key_exists("include_CSS", $context))) {
            // line 11
            echo "\t<link rel=\"stylesheet\" href=\"";
            echo $this->extensions['Extension']->merge_files("/cache/head.min.css", "css", (isset($context["include_CSS"]) || array_key_exists("include_CSS", $context) ? $context["include_CSS"] : (function () { throw new Twig_Error_Runtime('Variable "include_CSS" does not exist.', 11, $this->source); })()), "", (isset($context["include_CSS"]) || array_key_exists("include_CSS", $context) ? $context["include_CSS"] : (function () { throw new Twig_Error_Runtime('Variable "include_CSS" does not exist.', 11, $this->source); })()));
            echo "\"/>
\t";
        }
        // line 13
        echo "\t";
        // line 17
        echo "\t";
        if (((isset($context["include_Js"]) || array_key_exists("include_Js", $context)) && (isset($context["prioritize_Js"]) || array_key_exists("prioritize_Js", $context)))) {
            // line 18
            echo "\t<script type=\"text/JavaScript\" src=\"";
            echo $this->extensions['Extension']->merge_files("/cache/head.min.js", "js", (isset($context["include_Js"]) || array_key_exists("include_Js", $context) ? $context["include_Js"] : (function () { throw new Twig_Error_Runtime('Variable "include_Js" does not exist.', 18, $this->source); })()), "", (isset($context["prioritize_Js"]) || array_key_exists("prioritize_Js", $context) ? $context["prioritize_Js"] : (function () { throw new Twig_Error_Runtime('Variable "prioritize_Js" does not exist.', 18, $this->source); })()));
            echo "\"></script>
\t";
        }
        // line 20
        echo "\t";
        if ((isset($context["odebug"]) || array_key_exists("odebug", $context))) {
            // line 21
            echo "\t";
            echo twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 21, $this->source); })()), "setCss", array(0 => (isset($context["odebugCSS"]) || array_key_exists("odebugCSS", $context) ? $context["odebugCSS"] : (function () { throw new Twig_Error_Runtime('Variable "odebugCSS" does not exist.', 21, $this->source); })())), "method");
            echo "
\t";
            // line 22
            echo twig_get_attribute($this->env, $this->source, (isset($context["odebug"]) || array_key_exists("odebug", $context) ? $context["odebug"] : (function () { throw new Twig_Error_Runtime('Variable "odebug" does not exist.', 22, $this->source); })()), "setCssLog", array(0 => (isset($context["odebugCSSLOG"]) || array_key_exists("odebugCSSLOG", $context) ? $context["odebugCSSLOG"] : (function () { throw new Twig_Error_Runtime('Variable "odebugCSSLOG" does not exist.', 22, $this->source); })())), "method");
            echo "
\t";
        }
        // line 24
        echo "\t<link rel=\"stylesheet\" href=\"/css/main.css\" type=\"text/css\">

\t<!--[if lt IE 9]>
\t<script type='text/javascript'>
\t\tdocument.createElement('header');
\t\tdocument.createElement('nav');
\t\tdocument.createElement('section');
\t\tdocument.createElement('article');
\t\tdocument.createElement('aside');
\t\tdocument.createElement('footer');
\t\tdocument.createElement('figure');
\t\tdocument.createElement('figcaption');
\t\tdocument.createElement('span');
\t</script>     <![endif]-->

\t";
        // line 40
        echo "\t<script type=\"text/JavaScript\">
\t\twindow.onerror = null;
\t</script>";
    }

    public function getTemplateName()
    {
        return "head.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 40,  74 => 24,  69 => 22,  64 => 21,  61 => 20,  55 => 18,  52 => 17,  50 => 13,  44 => 11,  42 => 10,  35 => 6,  28 => 2,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("\t<meta name=\"description\" content=\"{{ description }}\"/>
\t<meta name=\"keywords\" content=\"{{ keywords }}\"/>
\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\"/>
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=9\"/>
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=0.85\"/>
\t<title>{{ title }}</title>

\t<link rel=\"shortcut icon\" type=\"image/vnd.microsoft.icon\" href=\"/favicon.ico\"/>
\t<link rel=\"shortcut icon\" href=\"/img/ico_nmain.gif\"/>
\t{% if include_CSS is defined %}
\t<link rel=\"stylesheet\" href=\"{{ merge_files('/cache/head.min.css', 'css',  include_CSS , '',  include_CSS ) }}\"/>
\t{% endif %}
\t{#<link rel=\"stylesheet\" href=\"/js/visLightBox/data/vlboxCustom.css\"/>
\t<link rel=\"stylesheet\" href=\"/js/visLightBox/data/visuallightbox.css\"/>
\t<link rel=\"stylesheet\" href=\"/js/prettyPhoto/css/prettyPhoto.css\"/>
\t<link rel=\"stylesheet\" href=\"/js/badger/badger.css\"/>#}
\t{% if include_Js is defined and prioritize_Js is defined %}
\t<script type=\"text/JavaScript\" src=\"{{ merge_files('/cache/head.min.js', 'js',  include_Js , '',  prioritize_Js ) }}\"></script>
\t{% endif %}
\t{% if odebug is defined %}
\t{{ odebug.setCss(odebugCSS) }}
\t{{ odebug.setCssLog(odebugCSSLOG) }}
\t{% endif %}
\t<link rel=\"stylesheet\" href=\"/css/main.css\" type=\"text/css\">

\t<!--[if lt IE 9]>
\t<script type='text/javascript'>
\t\tdocument.createElement('header');
\t\tdocument.createElement('nav');
\t\tdocument.createElement('section');
\t\tdocument.createElement('article');
\t\tdocument.createElement('aside');
\t\tdocument.createElement('footer');
\t\tdocument.createElement('figure');
\t\tdocument.createElement('figcaption');
\t\tdocument.createElement('span');
\t</script>     <![endif]-->

\t{#подавить все сообщения об ошибках JavaScript#}
\t<script type=\"text/JavaScript\">
\t\twindow.onerror = null;
\t</script>", "head.twig", "O:\\domains\\add.pr\\templates\\head.twig");
    }
}
