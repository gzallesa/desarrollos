<?php

/* ClienteBundle:Default:calendar.html.twig */
class __TwigTemplate_5187c8ff3f44c8d62c0cfe5a94a8996d2a0c0ed20b1f1660376da732c40e4ca0 extends Twig_Template
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
<html>
    <head>
        <meta charset=\"utf-8\" />
        <!-- <meta name=\"viewport\" content=\"width=device-width\" /> -->
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, user-scalable=no\" />        
        <title></title>
        <link rel=\"shortcut icon\" href=\"images/favicon.ico\" />
        <link rel=\"stylesheet\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/paragridma.css\">
        <link rel=\"stylesheet\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/eventCalendar.css\">
        <!-- <link rel=\"stylesheet\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/eventCalendar_theme_responsive.css\"> -->
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js\" type=\"text/javascript\"></script>
        <script src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/js/jquery.eventCalendar.js\" type=\"text/javascript\"></script>
        <style>
            .cumplefoto{
                width: 70px;
                border-radius: 5px;
                margin: auto;
                border-style: solid;
                border-width:5px;
                border-color: #cccccc;
                box-shadow: 2px 2px 2px #000000;
            }
        </style>    
    </head>
    <body id=\"responsiveDemo\">
        <div class=\"container\">
        <div id=\"eventCalendarDefault\"></div>
        <script>
            \$(document).ready(function() {
                \$(\"#eventCalendarDefault\").eventCalendar({
                    eventsjson: '";
        // line 32
        echo $this->env->getExtension('routing')->getPath("cliente_events");
        echo "',
                    monthNames: [\"Enero\", \"Febrero\", \"Marzo\", \"Abril\", \"Mayo\", \"Junio\",
                        \"Julio\", \"Agosto\", \"Septiembre\", \"Octubre\", \"Noviembre\", \"Diciembre\"],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles',
                        'Jueves', 'Viernes', 'Sabado'],
                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    txt_noEvents: \"No hay eventos para este periodo\",
                    txt_SpecificEvents_prev: \"\",
                    txt_SpecificEvents_after: \"eventos:\",
                    txt_next: \"siguiente\",
                    txt_prev: \"anterior\",
                    txt_NextEvents: \"Próximos eventos:\",
                    txt_GoToEventUrl: \"Ir al evento\",
                    eventsScrollable: true
                });
            });
        </script>
        </div>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "ClienteBundle:Default:calendar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 32,  42 => 13,  37 => 11,  33 => 10,  29 => 9,  19 => 1,);
    }
}
