<?php

/* footer.twig */
class __TwigTemplate_b3f8e6660a42bd628ded4515e835fb6eece0e349c0edce775146110d040883fb extends Twig_Template
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
        echo "
";
        // line 4
        echo "    <div id=\"footer\">

    <div id=\"foot_JavaScript1\" style=\"position:absolute;left:550px;top:-13px;width:800px;height:25px;z-index:10;\">
        <div style=\"color:#000;font-size:10px;font-family:Verdana,serif;font-weight:normal;font-style:normal;text-decoration:none\" id=\"copyrightnotice\">
        </div>
        <script type=\"text/javascript\">
            var now = new Date();
            var startYear = \"2012\";
            var text = \"&copy; \";
            if (startYear != '') {
                text = text + startYear + \"-\";
            }
            text = text + now.getFullYear() + \", www.aleks.od.ua | Все права защищены. При цитировании документа ссылка на сайт обязательна.\";
            var copyrightnotice = document.getElementById('copyrightnotice');
            copyrightnotice.innerHTML = text;
        </script>
    </div>
    <div style=\"padding-top: 13px; padding-left: 42%;\">
        <hfooter> Creative ls &copy; 2013</hfooter>
    </div>

   ";
        // line 25
        if (((isset($context["SERVER_NAME"]) || array_key_exists("SERVER_NAME", $context)) && ((isset($context["SERVER_NAME"]) || array_key_exists("SERVER_NAME", $context) ? $context["SERVER_NAME"] : (function () { throw new Twig_Error_Runtime('Variable "SERVER_NAME" does not exist.', 25, $this->source); })()) == "aleks.od.ua"))) {
            // line 26
            echo "        <script type=\"text/javascript\">
            var _paq = _paq || [];
            _paq.push([\"trackPageView\"]);
            _paq.push([\"enableLinkTracking\"]);

            (function() {
                var u=((\"https:\" == document.location.protocol) ? \"https\" : \"http\") + \"://fotosait.no-ip.org/piwik/\";
                _paq.push([\"setTrackerUrl\", u+\"piwik.php\"]);
                _paq.push([\"setSiteId\", \"1\"]);
                var d=document, g=d.createElement(\"script\"), s=d.getElementsByTagName(\"script\")[0]; g.type=\"text/javascript\";
                g.defer=true; g.async=true; g.src=u+\"piwik.js\"; s.parentNode.insertBefore(g,s);
            })();
        </script>
   ";
        }
        // line 40
        echo "
\t     ";
        // line 42
        echo "\t    ";
        if ((isset($context["include_Js_footer"]) || array_key_exists("include_Js_footer", $context))) {
            // line 43
            echo "    <a id=\"dynamic_to_top\" href=\"#\" style=\"display: inline;\">
        <span> </span>
    </a>
\t    <script type='text/javascript'>
\t\t    /* <![CDATA[ */
\t\t    var mv_dynamic_to_top = {\"text\": \"0\", \"version\": \"0\", \"min\": \"200\", \"speed\": \"1000\", \"easing\": \"easeInOutExpo\", \"margin\": \"20\"};
\t\t    /* ]]> */
\t    </script>
\t    <script src=\"";
            // line 51
            echo $this->extensions['Extension']->merge_files("/cache/footer.min.js", "js", (isset($context["include_Js_footer"]) || array_key_exists("include_Js_footer", $context) ? $context["include_Js_footer"] : (function () { throw new Twig_Error_Runtime('Variable "include_Js_footer" does not exist.', 51, $this->source); })()), "", (isset($context["include_Js_footer"]) || array_key_exists("include_Js_footer", $context) ? $context["include_Js_footer"] : (function () { throw new Twig_Error_Runtime('Variable "include_Js_footer" does not exist.', 51, $this->source); })()));
            echo "\"></script>
\t    ";
        }
        // line 53
        echo "    </div>

";
    }

    public function getTemplateName()
    {
        return "footer.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 53,  83 => 51,  73 => 43,  70 => 42,  67 => 40,  51 => 26,  49 => 25,  26 => 4,  23 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#{% extends \"content.twig\" %}#}

{#{% block footer %}#}
    <div id=\"footer\">

    <div id=\"foot_JavaScript1\" style=\"position:absolute;left:550px;top:-13px;width:800px;height:25px;z-index:10;\">
        <div style=\"color:#000;font-size:10px;font-family:Verdana,serif;font-weight:normal;font-style:normal;text-decoration:none\" id=\"copyrightnotice\">
        </div>
        <script type=\"text/javascript\">
            var now = new Date();
            var startYear = \"2012\";
            var text = \"&copy; \";
            if (startYear != '') {
                text = text + startYear + \"-\";
            }
            text = text + now.getFullYear() + \", www.aleks.od.ua | Все права защищены. При цитировании документа ссылка на сайт обязательна.\";
            var copyrightnotice = document.getElementById('copyrightnotice');
            copyrightnotice.innerHTML = text;
        </script>
    </div>
    <div style=\"padding-top: 13px; padding-left: 42%;\">
        <hfooter> Creative ls &copy; 2013</hfooter>
    </div>

   {% if SERVER_NAME is defined and SERVER_NAME == 'aleks.od.ua' %}
        <script type=\"text/javascript\">
            var _paq = _paq || [];
            _paq.push([\"trackPageView\"]);
            _paq.push([\"enableLinkTracking\"]);

            (function() {
                var u=((\"https:\" == document.location.protocol) ? \"https\" : \"http\") + \"://fotosait.no-ip.org/piwik/\";
                _paq.push([\"setTrackerUrl\", u+\"piwik.php\"]);
                _paq.push([\"setSiteId\", \"1\"]);
                var d=document, g=d.createElement(\"script\"), s=d.getElementsByTagName(\"script\")[0]; g.type=\"text/javascript\";
                g.defer=true; g.async=true; g.src=u+\"piwik.js\"; s.parentNode.insertBefore(g,s);
            })();
        </script>
   {% endif %}

\t     {#кнопка наверх#}
\t    {% if include_Js_footer is defined %}
    <a id=\"dynamic_to_top\" href=\"#\" style=\"display: inline;\">
        <span> </span>
    </a>
\t    <script type='text/javascript'>
\t\t    /* <![CDATA[ */
\t\t    var mv_dynamic_to_top = {\"text\": \"0\", \"version\": \"0\", \"min\": \"200\", \"speed\": \"1000\", \"easing\": \"easeInOutExpo\", \"margin\": \"20\"};
\t\t    /* ]]> */
\t    </script>
\t    <script src=\"{{ merge_files('/cache/footer.min.js', 'js', include_Js_footer, '', include_Js_footer) }}\"></script>
\t    {% endif %}
    </div>

{#{% endblock %}#}", "footer.twig", "O:\\domains\\add.pr\\templates\\footer.twig");
    }
}
