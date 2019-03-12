<?php

/* ClienteBundle:Default:slider.html.twig */
class __TwigTemplate_49534dc22d7f26d07f8e5298ab497e96245df47b5b726d9546933ea781530343 extends Twig_Template
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
<!-- Camera is a Pixedelic free jQuery slideshow | Manuel Masia (designer and developer) --> 
<html> 
    <head> 
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" > 
        <title>Camera | a free jQuery slideshow by Pixedelic</title> 
        <meta name=\"description\" content=\"Camera a free jQuery slideshow with many effects, transitions, adaptive layout, easy to customize, using canvas and mobile ready\"> 
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <!--///////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //\t\tStyles
        //
        ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
        <link rel='stylesheet' id='camera-css'  href='";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/slider2/css/camera.css' type='text/css' media='all'> 
        <style>
            body {
                margin: 0;
                padding: 0;
            }
            a {
                color: #09f;
                float: right;
            }
            a:hover {
                text-decoration: none;
            }
            #back_to_camera {
                clear: both;
                display: block;
                height: 80px;
                line-height: 40px;
                padding: 20px;
            }
            .fluid_container {
                margin: 0 auto;
                max-width: 1000px;
                width: 90%;
            }
        </style>

        <!--///////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //\t\tScripts
        //
        ///////////////////////////////////////////////////////////////////////////////////////////////////--> 

        <script type='text/javascript' src='";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/slider2/scripts/jquery.min.js'></script>
        <script type='text/javascript' src='";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/slider2/scripts/jquery.mobile.customized.min.js'></script>
        <script type='text/javascript' src='";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/slider2/scripts/jquery.easing.1.3.js'></script> 
        <script type='text/javascript' src='";
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/slider2/scripts/camera.min.js'></script> 

        <script>
            jQuery(function() {

                jQuery('#camera_wrap_1').camera({
                    height: '270px',
                    loader: 'bar',
                    pagination: false,
                    thumbnails: false
                });
            });
            function ir(url)
            {
                parent.document.location=url;
            }
        </script>

    </head>
    <body>
        <div class=\"camera_wrap camera_azure_skin\" id=\"camera_wrap_1\">
            ";
        // line 71
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["news"]) ? $context["news"] : $this->getContext($context, "news")));
        foreach ($context['_seq'] as $context["_key"] => $context["new"]) {
            // line 72
            echo "            <div data-thumb=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["new"]) ? $context["new"] : $this->getContext($context, "new")), "imagen"), "html", null, true);
            echo "\" data-src=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["new"]) ? $context["new"] : $this->getContext($context, "new")), "imagen"), "html", null, true);
            echo "\">
                <div class=\"camera_caption fadeFromBottom\">
                        ";
            // line 74
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["new"]) ? $context["new"] : $this->getContext($context, "new")), "titulo"), "html", null, true);
            echo " <em><a href=\"javascript:ir('";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["new"]) ? $context["new"] : $this->getContext($context, "new")), "url"), "html", null, true);
            echo "');\">Leer mas</a></em>
                </div>
            </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['new'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 78
        echo "        </div><!-- #camera_wrap_1 -->

        <div style=\"clear:both; display:block; height:100px\"></div>
    </body> 
</html>";
    }

    public function getTemplateName()
    {
        return "ClienteBundle:Default:slider.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  130 => 78,  118 => 74,  110 => 72,  106 => 71,  82 => 50,  78 => 49,  74 => 48,  70 => 47,  34 => 14,  19 => 1,);
    }
}
