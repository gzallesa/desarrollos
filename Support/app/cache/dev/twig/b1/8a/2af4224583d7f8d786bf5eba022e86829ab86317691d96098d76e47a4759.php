<?php

/* ClienteBundle:Default:notfound.html.twig */
class __TwigTemplate_b18a2af4224583d7f8d786bf5eba022e86829ab86317691d96098d76e47a4759 extends Twig_Template
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
        <style>
            body{
                background-color: #F4AC00;
            }
            .image{
                background-image: url(";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/images/404.jpg);
                width:550px;
                height:550px;
                position:absolute;
            }
            .image .ip{
                position:absolute;
                top:95px;
                left:200px;
                font-size:18px;
                color:red;
                
            }
            .image .titulo{
                position:absolute;
                top:150px;
                left:120px;
                font-size:15px;
                
            }
  .users {
            margin-left: 30px;
        }
      .users>li>img {
            position: absolute; 
            left: 2px;
            top: -4px;
            border: 3px solid #000;
            border-radius: 50%;
            width: 64px;
        }
        .users>li {
            position: relative;
            
            list-style: none;
            padding: 3px 0 3px 75px
        }     </style>    
    </head>   
    <body>
    <div class=\"image\">
        <div class=\"ip\">
            ";
        // line 49
        echo twig_escape_filter($this->env, (isset($context["ip"]) ? $context["ip"] : $this->getContext($context, "ip")), "html", null, true);
        echo "
        </div>
        <div class=\"titulo\">
            <b>Encargados de la Unidad de Recursos Humanos (INT. 215)</b>

\t    <!--
            <ul class=\"users\">
                <li style=\"\">
                    <img alt=\"Paola Carrasco\" src=\"http://siemi.oopp.gob.bo/doccargados/rrhh/4812791/FOTOS/27_06_2014_15_56_40.jpg\">
                    <b>Paola Carrasco Vasquez</b><br>
                    <cite>Tecnico RRHH</cite><br>
                    <b>Int:&nbsp;</b>215 - <b>Correo:&nbsp;</b>pcarrasco@oopp.gob.bo
                </li>
            </ul>
            
            <ul class=\"users\">
                <li>
                    <img alt=\"Gerardo Luna\" src=\"http://siemi.oopp.gob.bo/doccargados/rrhh/6090005/FOTOS/05_03_2015_10_04_00.jpg\">
                    <b>GERARDO LUNA ARGUATA</b><br>
                    <cite>Encargado de Sistemas 1</cite><br>
                    <b>Int:&nbsp;</b>608 - <b>Correo:&nbsp;</b>gluna@oopp.gob.bo
                </li>
            </ul>
            <ul class=\"users\">
            \t<li>
               \t    <img alt=\"Wilfredo Alarcon\" src=\"http://siemi.oopp.gob.bo/doccargados/rrhh/4897441/FOTOS/16_12_2015_18_24_09.jpg\">
                    <b>WILFREDO ALARCON CONDORI</b><br>
                    <cite>Responsable de Redes y Servicios</cite><br>
                    <b>Int:&nbsp;</b>627 - <b>Correo:&nbsp;</b>walancon@oopp.gob.bo
            \t</li>
            </ul>
\t    -->
        </div>
    </div>
</body>    
</html>    
";
    }

    public function getTemplateName()
    {
        return "ClienteBundle:Default:notfound.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  72 => 49,  28 => 8,  19 => 1,);
    }
}
