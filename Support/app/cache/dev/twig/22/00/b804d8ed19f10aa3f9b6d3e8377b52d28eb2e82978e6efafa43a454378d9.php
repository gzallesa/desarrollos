<?php

/* ClienteBundle:Default:flip.html.twig */
class __TwigTemplate_2200b804d8ed19f10aa3f9b6d3e8377b52d28eb2e82978e6efafa43a454378d9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\" />
    <title>Booklet - jQuery Plugin</title>
    <!--[if lt IE 9]><script src=\"https://html5shiv.googlecode.com/svn/trunk/html5.js\"></script><![endif]-->
    <link href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("booklet"), "html", null, true);
        echo "/jquery.booklet.latest.css\" type=\"text/css\" rel=\"stylesheet\" media=\"screen, projection, tv\" />
    <style type=\"text/css\">
        body {background:#ccc; font:normal 12px/1.2 arial, verdana, sans-serif;margin: 0px;padding: 0px;}
    </style>
</head>
<body>
\t<section>
\t    <div id=\"mybook\">
                ";
        // line 15
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["news"]) ? $context["news"] : $this->getContext($context, "news")));
        foreach ($context['_seq'] as $context["_key"] => $context["new"]) {
            // line 16
            echo "                    <div title=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["new"]) ? $context["new"] : $this->getContext($context, "new")), "titulo"), "html", null, true);
            echo "\">
                        <img style=\"width:120px\" src=\"";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["new"]) ? $context["new"] : $this->getContext($context, "new")), "imagen"), "html", null, true);
            echo "\"/>
                        <a  target=\"_blank\" style=\"color:black; text-decoration: none\" href=\"";
            // line 18
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["new"]) ? $context["new"] : $this->getContext($context, "new")), "url"), "html", null, true);
            echo "\"><h5>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["new"]) ? $context["new"] : $this->getContext($context, "new")), "titulo"), "html", null, true);
            echo "</h5></a>
                    </div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['new'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        echo "    
\t    </div>
\t</section>
\t<footer></footer>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js\"></script>
\t<script> window.jQuery || document.write('<script src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("booklet"), "html", null, true);
        echo "/jquery-2.1.0.min.js\"><\\/script>') </script>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js\"></script>
\t<script> window.jQuery.ui || document.write('<script src=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("booklet"), "html", null, true);
        echo "/jquery-ui-1.10.4.min.js\"><\\/script>') </script>
    <script src=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("booklet"), "html", null, true);
        echo "/jquery.easing.1.3.js\"></script>
    <script src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("booklet"), "html", null, true);
        echo "/jquery.booklet.latest.js\"></script>
\t<script>
\t    \$(function () {\t\t
\t        \$(\"#mybook\").booklet({
                    width:  280,
        \t    height: 250
                });
\t    });
    </script>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "ClienteBundle:Default:flip.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 29,  78 => 28,  74 => 27,  69 => 25,  62 => 20,  51 => 18,  47 => 17,  42 => 16,  38 => 15,  27 => 7,  19 => 1,);
    }
}
