<?php

/* ::base.html.twig */
class __TwigTemplate_36ae987630ecc6be61a1a8a5bfe38c8ebaaf674d40713d9d9cc4b867f7f997d1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'link' => array($this, 'block_link'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
        <link href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/css/font-awesome.min.css\" rel=\"stylesheet\"/>
        ";
        // line 8
        $this->displayBlock('link', $context, $blocks);
        // line 9
        echo "        <script src=\"http://code.jquery.com/jquery-1.9.1.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/js/jquery-2.0.3.min.js\"></script>
        <!--script type=\"text/javascript\" src=\"knockout-3.0.0.js\"></script-->
        <!--script type=\"text/javascript\" src=\"angular.min.js\"></script-->
        <script type=\"text/javascript\" src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/js/globalize.min.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/js/dx.chartjs.js\"></script>
        ";
        // line 15
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 16
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/12.png\" />
    </head>
    <body>
        ";
        // line 19
        $this->displayBlock('body', $context, $blocks);
        // line 20
        echo "    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Soporte";
    }

    // line 8
    public function block_link($context, array $blocks = array())
    {
    }

    // line 15
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 19
    public function block_body($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 19,  85 => 15,  80 => 8,  74 => 5,  68 => 20,  66 => 19,  59 => 16,  57 => 15,  53 => 14,  43 => 10,  40 => 9,  38 => 8,  34 => 7,  23 => 1,  49 => 13,  45 => 7,  42 => 6,  39 => 5,  32 => 3,  29 => 5,);
    }
}
