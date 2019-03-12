<?php

/* SupportBundle:Default:monitoreo.html.twig */
class __TwigTemplate_a3e3a474cec00625700f18be6569d3297a21a98689c9e86c0881c542cd26dfe7 extends Twig_Template
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
        <link rel=\"stylesheet\" href=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/styles/jqx.base.css\" type=\"text/css\" />
        <script type=\"text/javascript\" src=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/scripts/jquery-1.10.2.min.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxcore.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxdatetimeinput.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxcalendar.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxtooltip.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/globalization/globalize.js\"></script></head>
        <style>
            .noticias{
                margin-top:40px;
                list-style: none;
            }
            .noticia{
                display: inline-table;
                width: 270px;
                padding: 5px;
                font-family: arial;
                font-size:12px;
                list-style: none;
            }
            .title{
                padding: 5px;
                background:linear-gradient(#AAAAAA, #DDDDDD, #AAAAAA);
                color:black;
                border-radius: 0px 0px 10px 10px; 
                border-bottom-color: #0088cc;
                border-bottom-width: 5px;
                border-bottom-style: solid;
                font-weight: bold;
            }
            a{
                color:black;
                text-decoration: none;
            }
            a:hover{
                text-decoration: underline;
            }
        </style>   
    <body>
        <div id='content'>
            <script type=\"text/javascript\">
                \$(document).ready(function() {
                    // Create a jqxDateTimeInput
                    val = '";
        // line 47
        echo $this->env->getExtension('routing')->getPath("monitoreo_get");
        echo "';
                        var parametros = {
                            'fecha': \"\",
                        };
                        \$.ajax({
                            data: parametros,
                            url: val,
                            type: 'post',
                            beforeSend: function() {

                            },
                            success: function(response) {
                                //alert(response);
                                //noticias.innerHTML=response;
                                \$(\"#noticias\").html(response);
                            }
                        });
                    \$(\"#jqxWidget\").jqxDateTimeInput({width: '250px', height: '25px'});
                    \$('#jqxWidget').on('valuechanged', function(event) {
                        var date = event.args.date;
                        val = '";
        // line 67
        echo $this->env->getExtension('routing')->getPath("monitoreo_get");
        echo "';
                        var parametros = {
                            'fecha': date,
                        };
                        \$.ajax({
                            data: parametros,
                            url: val,
                            type: 'post',
                            beforeSend: function() {

                            },
                            success: function(response) {
                                //alert(response);
                                //noticias.innerHTML=response;
                                \$(\"#noticias\").html(response);
                            }
                        });
                    });
                });
            </script>
            Fecha:<div id='jqxWidget' style=\"margin-left:50px;position:fixed;\"></div>fjh
            <div id=\"noticias\">
            </div>    
        </div>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "SupportBundle:Default:monitoreo.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  111 => 67,  88 => 47,  48 => 10,  44 => 9,  40 => 8,  36 => 7,  32 => 6,  28 => 5,  24 => 4,  19 => 1,);
    }
}
