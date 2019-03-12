<?php

/* ClienteBundle:Default:newsticket.html.twig */
class __TwigTemplate_db1e9bc21b571b3df28581d7208eef584bc1aaad64bcf6f893303883bea054a2 extends Twig_Template
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
        echo "<html>

<head>
    <!--<link href=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/styles/ticker-style.css\" rel=\"stylesheet\" type=\"text/css\" />-->
    <!--<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js\"></script>-->
    <!--<script src=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/includes/jquery.ticker.js\" type=\"text/javascript\"></script>-->
    <!--<script src=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/includes/site.js\" type=\"text/javascript\"></script>-->
    <link href='//fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js\"></script>
    <script src=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/includes/newsTicker.js\" type=\"text/javascript\"></script>
    <!--<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">-->
</head>

<body style=\"width: 100%;\">
    <!--
        <ul id=\"js-news\" class=\"js-hidden\">
            ";
        // line 17
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["eventos"]) ? $context["eventos"] : $this->getContext($context, "eventos")));
        foreach ($context['_seq'] as $context["_key"] => $context["evento"]) {
            // line 18
            echo "                <li class=\"\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["evento"]) ? $context["evento"] : $this->getContext($context, "evento")), "evento"), "html", null, true);
            echo "</li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['evento'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "   
       </ul>
    -->

    <script>
        \$(function() {
            \$('#newsList').newsTicker();
        });
    </script>

    <style>
        #newsList {
            width: 100%;
        }
        .newsCss {
            background-color: #607D8B;
            color: white;
            font-family: 'Roboto Slab', sans-serif;
            font-size: 0.9em;
            margin: 0;
            padding: 15px;
            text-align: center;
        }
    </style>
    <div id=\"newsData\" class=\"row newsCss\"></div>
    <ul id=\"newsList\">
        ";
        // line 45
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["eventos"]) ? $context["eventos"] : $this->getContext($context, "eventos")));
        foreach ($context['_seq'] as $context["_key"] => $context["evento"]) {
            // line 46
            echo "            <li class=\"news-itemm\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["evento"]) ? $context["evento"] : $this->getContext($context, "evento")), "evento"), "html", null, true);
            echo "</li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['evento'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 48
        echo "    </ul>
</body>

</html>";
    }

    public function getTemplateName()
    {
        return "ClienteBundle:Default:newsticket.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  103 => 48,  94 => 46,  90 => 45,  62 => 19,  53 => 18,  49 => 17,  39 => 10,  33 => 7,  29 => 6,  24 => 4,  19 => 1,);
    }
}
