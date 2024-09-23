<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* thank_you.html.twig */
class __TwigTemplate_4c73b8bf918682075d2c94e299754d7d extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'styles' => [$this, 'block_styles'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 2
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html.twig", "thank_you.html.twig", 2);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Thank You for Your Order
";
        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_styles(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 8
        yield "\t<style type=\"text/css\">
\t\t.email-container {
\t\t\tbackground-color: #f7f7f7;
\t\t\tpadding: 40px;
\t\t\tborder-radius: 8px;
\t\t\tfont-family: Arial, sans-serif;
\t\t}

\t\t.logo {
\t\t\tfont-weight: 800;
\t\t\tfont-size: 16px;
\t\t\tcolor: #FF9A8B;
\t\t}

\t\t.header {
\t\t\tmargin-top: 30px;
\t\t\ttext-align: left;
\t\t}

\t\t.card {
\t\t\tbackground-color: #ffffff;
\t\t\tbox-shadow: rgba(17, 12, 46, 0.12) 0 40px 70px 0;
\t\t\tpadding: 50px 32px;
\t\t\tmargin: auto;
\t\t}

\t\t.content {
\t\t\tpadding: 0;
\t\t}

\t\th1 {
\t\t\tfont-size: 22px;
\t\t\tfont-weight: bold;
\t\t\tcolor: #2b2d2d;
\t\t\tmargin-bottom: 20px;
\t\t}

\t\tp {
\t\t\tfont-size: 16px;
\t\t\tcolor: #555;
\t\t\tline-height: 1.6;
\t\t}

\t\t.button {
\t\t\tdisplay: inline-block;
\t\t\tmargin-top: 20px;
\t\t\tpadding: 12px 25px;
\t\t\tbackground-color: #FF9A8B;
\t\t\tbackground-image: linear-gradient(90deg, #FFA76F 0%, #FF99AC 100%);
\t\t\tbox-shadow: rgba(99, 99, 99, 0.2) 0 2px 8px 0;
\t\t\tcolor: white;
\t\t\ttext-decoration: none;
\t\t\tfont-weight: bold;
\t\t\tfont-size: 16px;
\t\t\tborder-radius: 6px;
\t\t}

\t\t.foot {
\t\t\tborder-top: 1px solid #dddddd;
\t\t\tcolor: #131313;
\t\t\tmargin-top: 40px;
\t\t}

\t\t.foot h6 {
\t\t\tfont-size: 14px;
\t\t\tmargin-bottom: 10px;
\t\t\tline-height: 1.2;
\t\t}

\t\t.foot p {
\t\t\tfont-size: 14px;
\t\t\tline-height: 0;
\t\t\tmargin-bottom: 30px;
\t\t}

\t\ta.footlink {
\t\t\tdisplay: flex;
\t\t\tgap: 6px;
\t\t\talign-items: center;
\t\t\tfont-size: 14px;
\t\t\tfont-weight: 600;
\t\t\tcolor: inherit;
\t\t\ttext-decoration: none;
\t\t\tcolor: #FF99AC;
\t\t\tfill: #FF99AC;
\t\t}
\t</style>
";
        yield from [];
    }

    // line 97
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 98
        yield "
\t<div class=\"card\">
\t\t<span class=\"logo\">Hacked Shopz</span>
\t\t<div class=\"header\">
\t\t\t<h1>🎉 Thank You for Your Order</h1>
\t\t</div>
\t\t<div class=\"content\">

\t\t\t<p>Hi
\t\t\t\t";
        // line 107
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["name"] ?? null));
        yield ",</p>
\t\t\t<p>Thank you for your order! Your order number is
\t\t\t\t<strong>";
        // line 109
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["orderNumber"] ?? null));
        yield "</strong>.</p>
\t\t\t<p>We appreciate your business and hope you enjoy your new product. Should you have any questions or need further\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t      assistance, feel free to reach out to us anytime.</p>
\t\t\t<a href=\"";
        // line 111
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["buttonUrl"] ?? null), "html", null, true);
        yield "\" class=\"button\">";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["buttonText"] ?? null));
        yield "</a>
\t\t</div>
\t\t<div class=\"foot\">
\t\t\t<h6>Pann Kaansadich</h6>
\t\t\t<p>Information Support at PannKs</p>
\t\t\t<a href=\"https://pannks.me/store\" class=\"footlink\">
\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" id=\"Bold\" viewbox=\"0 0 24 24\" width=\"14\" height=\"14\"><path d=\"M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm8.941,11H17.463a18.368,18.368,0,0,0-2.289-7.411A9.013,9.013,0,0,1,20.941,11ZM9.685,14h4.63A16.946,16.946,0,0,1,12,19.9,16.938,16.938,0,0,1,9.685,14Zm-.132-3A16.246,16.246,0,0,1,12,4.1,16.241,16.241,0,0,1,14.447,11ZM8.826,3.589A18.368,18.368,0,0,0,6.537,11H3.059A9.013,9.013,0,0,1,8.826,3.589ZM3.232,14H6.641a18.906,18.906,0,0,0,2.185,6.411A9.021,9.021,0,0,1,3.232,14Zm11.942,6.411A18.884,18.884,0,0,0,17.359,14h3.409A9.021,9.021,0,0,1,15.174,20.411Z\"/></svg>
\t\t\t\tpannks.me</a>
\t\t</div>
\t</div>


";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "thank_you.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  192 => 111,  187 => 109,  182 => 107,  171 => 98,  164 => 97,  72 => 8,  65 => 7,  53 => 4,  42 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# src/templates/emails/v1/thank_you.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}Thank You for Your Order
{% endblock %}

{% block styles %}
\t<style type=\"text/css\">
\t\t.email-container {
\t\t\tbackground-color: #f7f7f7;
\t\t\tpadding: 40px;
\t\t\tborder-radius: 8px;
\t\t\tfont-family: Arial, sans-serif;
\t\t}

\t\t.logo {
\t\t\tfont-weight: 800;
\t\t\tfont-size: 16px;
\t\t\tcolor: #FF9A8B;
\t\t}

\t\t.header {
\t\t\tmargin-top: 30px;
\t\t\ttext-align: left;
\t\t}

\t\t.card {
\t\t\tbackground-color: #ffffff;
\t\t\tbox-shadow: rgba(17, 12, 46, 0.12) 0 40px 70px 0;
\t\t\tpadding: 50px 32px;
\t\t\tmargin: auto;
\t\t}

\t\t.content {
\t\t\tpadding: 0;
\t\t}

\t\th1 {
\t\t\tfont-size: 22px;
\t\t\tfont-weight: bold;
\t\t\tcolor: #2b2d2d;
\t\t\tmargin-bottom: 20px;
\t\t}

\t\tp {
\t\t\tfont-size: 16px;
\t\t\tcolor: #555;
\t\t\tline-height: 1.6;
\t\t}

\t\t.button {
\t\t\tdisplay: inline-block;
\t\t\tmargin-top: 20px;
\t\t\tpadding: 12px 25px;
\t\t\tbackground-color: #FF9A8B;
\t\t\tbackground-image: linear-gradient(90deg, #FFA76F 0%, #FF99AC 100%);
\t\t\tbox-shadow: rgba(99, 99, 99, 0.2) 0 2px 8px 0;
\t\t\tcolor: white;
\t\t\ttext-decoration: none;
\t\t\tfont-weight: bold;
\t\t\tfont-size: 16px;
\t\t\tborder-radius: 6px;
\t\t}

\t\t.foot {
\t\t\tborder-top: 1px solid #dddddd;
\t\t\tcolor: #131313;
\t\t\tmargin-top: 40px;
\t\t}

\t\t.foot h6 {
\t\t\tfont-size: 14px;
\t\t\tmargin-bottom: 10px;
\t\t\tline-height: 1.2;
\t\t}

\t\t.foot p {
\t\t\tfont-size: 14px;
\t\t\tline-height: 0;
\t\t\tmargin-bottom: 30px;
\t\t}

\t\ta.footlink {
\t\t\tdisplay: flex;
\t\t\tgap: 6px;
\t\t\talign-items: center;
\t\t\tfont-size: 14px;
\t\t\tfont-weight: 600;
\t\t\tcolor: inherit;
\t\t\ttext-decoration: none;
\t\t\tcolor: #FF99AC;
\t\t\tfill: #FF99AC;
\t\t}
\t</style>
{% endblock %}

{% block content %}

\t<div class=\"card\">
\t\t<span class=\"logo\">Hacked Shopz</span>
\t\t<div class=\"header\">
\t\t\t<h1>🎉 Thank You for Your Order</h1>
\t\t</div>
\t\t<div class=\"content\">

\t\t\t<p>Hi
\t\t\t\t{{ name|e }},</p>
\t\t\t<p>Thank you for your order! Your order number is
\t\t\t\t<strong>{{ orderNumber|e }}</strong>.</p>
\t\t\t<p>We appreciate your business and hope you enjoy your new product. Should you have any questions or need further\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t      assistance, feel free to reach out to us anytime.</p>
\t\t\t<a href=\"{{ buttonUrl }}\" class=\"button\">{{ buttonText|e }}</a>
\t\t</div>
\t\t<div class=\"foot\">
\t\t\t<h6>Pann Kaansadich</h6>
\t\t\t<p>Information Support at PannKs</p>
\t\t\t<a href=\"https://pannks.me/store\" class=\"footlink\">
\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" id=\"Bold\" viewbox=\"0 0 24 24\" width=\"14\" height=\"14\"><path d=\"M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm8.941,11H17.463a18.368,18.368,0,0,0-2.289-7.411A9.013,9.013,0,0,1,20.941,11ZM9.685,14h4.63A16.946,16.946,0,0,1,12,19.9,16.938,16.938,0,0,1,9.685,14Zm-.132-3A16.246,16.246,0,0,1,12,4.1,16.241,16.241,0,0,1,14.447,11ZM8.826,3.589A18.368,18.368,0,0,0,6.537,11H3.059A9.013,9.013,0,0,1,8.826,3.589ZM3.232,14H6.641a18.906,18.906,0,0,0,2.185,6.411A9.021,9.021,0,0,1,3.232,14Zm11.942,6.411A18.884,18.884,0,0,0,17.359,14h3.409A9.021,9.021,0,0,1,15.174,20.411Z\"/></svg>
\t\t\t\tpannks.me</a>
\t\t</div>
\t</div>


{% endblock %}
", "thank_you.html.twig", "/var/www/html/src/templates/emails/thank_you.html.twig");
    }
}
