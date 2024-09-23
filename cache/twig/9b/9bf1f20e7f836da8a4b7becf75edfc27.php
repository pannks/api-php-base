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

/* base.html.twig */
class __TwigTemplate_2e4e27af1973148395760611be4fa4d1 extends Template
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

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'styles' => [$this, 'block_styles'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 2
        yield "<!DOCTYPE html>
<html>
\t<head>
\t\t<title>
\t\t\t";
        // line 6
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        // line 8
        yield "\t\t</title>
\t\t<style>

\t\t\t/* Base styles for the email */
\t\t\tbody {
\t\t\t\tfont-family: Arial, sans-serif;
\t\t\t\tfont-size: 14px;
\t\t\t\tcolor: #333333;
\t\t\t\tbackground-color: #FFF6F8;
\t\t\t\tmargin: 0;
\t\t\t\tpadding: 0;
\t\t\t}

\t\t\t.email-container {
\t\t\t\twidth: 100%;
\t\t\t\tmax-width: 500px;
\t\t\t\tmargin: auto;
\t\t\t\tpadding: 50px 0 20px;
\t\t\t}
\t\t\tp {
\t\t\t\tline-height: 1.5;
\t\t\t}
\t\t\t.signature {
\t\t\t\tmargin-top: 20px;
\t\t\t}
\t\t\t.footer {
\t\t\t\tfont-size: 12px;
\t\t\t\tcolor: #666666;
\t\t\t\ttext-align: center;
\t\t\t\tmargin-top: 30px;
\t\t\t\tpadding: 10px;
\t\t\t}
\t\t\t";
        // line 40
        yield from $this->unwrap()->yieldBlock('styles', $context, $blocks);
        // line 41
        yield "\t\t</style>
\t</head>
\t<body>
\t\t<div class=\"email-container\">

\t\t\t";
        // line 46
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 49
        yield "
\t\t\t<div class=\"footer\">
\t\t\t\t&copy;
\t\t\t\t";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "
\t\t\t\tPannKs. All rights reserved.
\t\t\t</div>
\t\t</div>
\t</body>
</html>
";
        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Email Title
\t\t\t";
        yield from [];
    }

    // line 40
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_styles(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 46
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 47
        yield "\t\t\t\t<!-- Default content -->
\t\t\t";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.html.twig";
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
        return array (  144 => 47,  137 => 46,  127 => 40,  115 => 6,  103 => 52,  98 => 49,  96 => 46,  89 => 41,  87 => 40,  53 => 8,  51 => 6,  45 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# src/templates/emails/v1/base.html.twig #}
<!DOCTYPE html>
<html>
\t<head>
\t\t<title>
\t\t\t{% block title %}Email Title
\t\t\t{% endblock %}
\t\t</title>
\t\t<style>

\t\t\t/* Base styles for the email */
\t\t\tbody {
\t\t\t\tfont-family: Arial, sans-serif;
\t\t\t\tfont-size: 14px;
\t\t\t\tcolor: #333333;
\t\t\t\tbackground-color: #FFF6F8;
\t\t\t\tmargin: 0;
\t\t\t\tpadding: 0;
\t\t\t}

\t\t\t.email-container {
\t\t\t\twidth: 100%;
\t\t\t\tmax-width: 500px;
\t\t\t\tmargin: auto;
\t\t\t\tpadding: 50px 0 20px;
\t\t\t}
\t\t\tp {
\t\t\t\tline-height: 1.5;
\t\t\t}
\t\t\t.signature {
\t\t\t\tmargin-top: 20px;
\t\t\t}
\t\t\t.footer {
\t\t\t\tfont-size: 12px;
\t\t\t\tcolor: #666666;
\t\t\t\ttext-align: center;
\t\t\t\tmargin-top: 30px;
\t\t\t\tpadding: 10px;
\t\t\t}
\t\t\t{% block styles %}{% endblock %}
\t\t</style>
\t</head>
\t<body>
\t\t<div class=\"email-container\">

\t\t\t{% block content %}
\t\t\t\t<!-- Default content -->
\t\t\t{% endblock %}

\t\t\t<div class=\"footer\">
\t\t\t\t&copy;
\t\t\t\t{{ \"now\"|date(\"Y\") }}
\t\t\t\tPannKs. All rights reserved.
\t\t\t</div>
\t\t</div>
\t</body>
</html>
", "base.html.twig", "/var/www/html/src/templates/emails/base.html.twig");
    }
}
