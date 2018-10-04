<?php

/* main_menu.twig */
class __TwigTemplate_51163b8f3e6bedbe4f6efa1bb604b68748cf63c630627f6c1be1e2ddbc7e285e extends Twig_Template
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
        echo "\t\t";
        if (((isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 1, $this->source); })()) == "/index.php")) {
            // line 2
            echo "
\t<a class='gl_act'   href='";
            // line 3
            echo (isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 3, $this->source); })());
            echo "' >Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>\";

        ";
        } elseif ((        // line 10
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 10, $this->source); })()) == "/fotobanck_adw.php?unchenge_cat")) {
            // line 11
            echo "
\t<a class='bt_gl'    href='/index.php'>Главная</a>
    <a class='fb_act'   href='";
            // line 13
            echo (isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 13, $this->source); })());
            echo "' >Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>\";

        ";
        } elseif ((((((((((((((        // line 19
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 19, $this->source); })()) == "/uslugi.php") || (        // line 20
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 20, $this->source); })()) == "/f_svadbi.php")) || (        // line 21
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 21, $this->source); })()) == "/f_deti.php")) || (        // line 22
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 22, $this->source); })()) == "/f_bankety.php")) || (        // line 23
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 23, $this->source); })()) == "/f_photoboock.php")) || (        // line 24
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 24, $this->source); })()) == "/f_vipusk.php")) || (        // line 25
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 25, $this->source); })()) == "/f_raznoe.php")) || (        // line 27
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 27, $this->source); })()) == "/v_svadby.php")) || (        // line 28
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 28, $this->source); })()) == "/v_deti.php")) || (        // line 29
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 29, $this->source); })()) == "/v_vipusk.php")) || (        // line 30
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 30, $this->source); })()) == "/v_sl_show.php")) || (        // line 31
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 31, $this->source); })()) == "/v_bankety.php")) || (        // line 32
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 32, $this->source); })()) == "/v_raznoe.php"))) {
            // line 34
            echo "
\t<a class='bt_gl'    href='/index.php'>Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
    <a class='usl_act'  href='";
            // line 37
            echo (isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 37, $this->source); })());
            echo "' >Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>\";

        ";
        } elseif ((        // line 42
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 42, $this->source); })()) == "/ceny.php")) {
            // line 43
            echo "
\t<a class='bt_gl'    href='/index.php'>Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
    <a class='cn_act'   href='";
            // line 47
            echo (isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 47, $this->source); })());
            echo "' >Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>\";

        ";
        } elseif ((        // line 51
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 51, $this->source); })()) == "/kontakty.php")) {
            // line 52
            echo "
\t<a class='bt_gl'     href='/index.php'>Главная</a>
\t<a class='bt_fb'     href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'    href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'   href='/ceny.php'>Цены</a>
    <a class='konty_act' href='";
            // line 57
            echo (isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 57, $this->source); })());
            echo "' >Контакты</a>
\t<a class='bt_gb'     href='/gb/'>Гостевая</a>

        ";
        } elseif ((        // line 60
(isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 60, $this->source); })()) == "/gb/index.php")) {
            // line 61
            echo "
\t<a class='bt_gl'    href='/index.php'>Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
    <a class='gb_act'   href='";
            // line 67
            echo (isset($context["razdel"]) || array_key_exists("razdel", $context) ? $context["razdel"] : (function () { throw new Twig_Error_Runtime('Variable "razdel" does not exist.', 67, $this->source); })());
            echo "' >Гостевая</a>

        ";
        } else {
            // line 70
            echo "
\t<a class='bt_gl'    href='/index.php'>Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>

        ";
        }
    }

    public function getTemplateName()
    {
        return "main_menu.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 70,  121 => 67,  113 => 61,  111 => 60,  105 => 57,  98 => 52,  96 => 51,  89 => 47,  83 => 43,  81 => 42,  73 => 37,  68 => 34,  66 => 32,  65 => 31,  64 => 30,  63 => 29,  62 => 28,  61 => 27,  60 => 25,  59 => 24,  58 => 23,  57 => 22,  56 => 21,  55 => 20,  54 => 19,  45 => 13,  41 => 11,  39 => 10,  29 => 3,  26 => 2,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("\t\t{% if razdel  == '/index.php' %}

\t<a class='gl_act'   href='{{ razdel }}' >Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>\";

        {% elseif razdel == '/fotobanck_adw.php?unchenge_cat' %}

\t<a class='bt_gl'    href='/index.php'>Главная</a>
    <a class='fb_act'   href='{{ razdel }}' >Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>\";

        {% elseif razdel == '/uslugi.php'
        or razdel == '/f_svadbi.php'
        or razdel == '/f_deti.php'
        or razdel == '/f_bankety.php'
        or razdel == '/f_photoboock.php'
        or razdel == '/f_vipusk.php'
        or razdel == '/f_raznoe.php'

        or razdel == '/v_svadby.php'
        or razdel == '/v_deti.php'
        or razdel == '/v_vipusk.php'
        or razdel == '/v_sl_show.php'
        or razdel == '/v_bankety.php'
        or razdel == '/v_raznoe.php'
        %}

\t<a class='bt_gl'    href='/index.php'>Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
    <a class='usl_act'  href='{{ razdel }}' >Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>\";

        {% elseif razdel == '/ceny.php' %}

\t<a class='bt_gl'    href='/index.php'>Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
    <a class='cn_act'   href='{{ razdel }}' >Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>\";

        {% elseif razdel == '/kontakty.php' %}

\t<a class='bt_gl'     href='/index.php'>Главная</a>
\t<a class='bt_fb'     href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'    href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'   href='/ceny.php'>Цены</a>
    <a class='konty_act' href='{{ razdel }}' >Контакты</a>
\t<a class='bt_gb'     href='/gb/'>Гостевая</a>

        {% elseif razdel == '/gb/index.php' %}

\t<a class='bt_gl'    href='/index.php'>Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
    <a class='gb_act'   href='{{ razdel }}' >Гостевая</a>

        {% else %}

\t<a class='bt_gl'    href='/index.php'>Главная</a>
\t<a class='bt_fb'    href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
\t<a class='bt_usl'   href='/uslugi.php'>Услуги</a>
\t<a class='bt_ceny'  href='/ceny.php'>Цены</a>
\t<a class='bt_konty' href='/kontakty.php'>Контакты</a>
\t<a class='bt_gb'    href='/gb/'>Гостевая</a>

        {% endif %}", "main_menu.twig", "O:\\domains\\add.pr\\templates\\main_menu.twig");
    }
}
