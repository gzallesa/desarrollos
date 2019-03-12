<?php

/* ClienteBundle:Default:index.html.twig */
class __TwigTemplate_0819e7937efb1d219a56d42ba7998731dca7f45b85cad1d038322358902c4e65 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::cliente.html.twig");

        $this->blocks = array(
            'scripts' => array($this, 'block_scripts'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::cliente.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_scripts($context, array $blocks = array())
    {
        // line 3
        echo "    <meta http-equiv=\"refresh\" content=\"600\"/>
    <link rel='stylesheet' href='";
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/style.css' type='text/css' media='all'/>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/default.css\"/>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/bookblock.css\"/>
    <!-- custom demo style -->
    <script src=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/js/modernizr.custom.js\"></script>

    <script type=\"text/javascript\" src=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/scripts/jquery.snow.min.1.0.js\"></script>
    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js\"></script>
    <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bootstrap"), "html", null, true);
        echo "/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bootstrap"), "html", null, true);
        echo "/css/bootstrap-theme.min.css\">
    <script>
        \$(document).ready(function () {
            //\$.fn.snow();
        });
        function cerrarr() {
            backgroundx.style.display = \"none\";
        }
        function mostrarr() {
            ifrm.src = \"";
        // line 22
        echo $this->env->getExtension('routing')->getPath("cliente_grilla");
        echo "\";
            backgroundx.style.display = \"block\";
        }
    </script>
";
    }

    // line 27
    public function block_body($context, array $blocks = array())
    {
        // line 28
        echo "
    -->

    <!-- ===== CARGAR MP3 DE FONDO ===== -->
    <!--
    <div>
        <audio autoplay loop>
            <source src=\"https://www.oopp.gob.bo/Viva-Cochabamba-Mayllapipis.mp3\">
        </audio>
    </div>
    -->
    <!-- ===== FIN CARGAR MP3 DE FONDO ===== -->


    <!-- ===== INICIO POPUP ===== -->

    <!-- Modal -->
    ";
        // line 45
        if ((twig_length_filter($this->env, (isset($context["popup_intranet"]) ? $context["popup_intranet"] : $this->getContext($context, "popup_intranet"))) > 0)) {
            // line 46
            echo "        <div class=\"modal fade\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\"
             aria-hidden=\"true\">
            <div class=\"modal-dialog modal-lg\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">&times;</span>
                        </button>
                        <h4 class=\"modal-title\" id=\"myModalLabel\">COMUNICADOS</h4>
                    </div>
                    <div class=\"modal-body\">
                        <div class=\"comunicado\">


                            <!--
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">El Che</h4>
                                <center>
                                    <video src=\"https://intranet.oopp.gob.bo/videos/Video_El-Che2_20171004.mp4\" controls autostart=\"false\" width=\"100%\" >El Che</video>
                                </center>
                            </div>
                            -->
                            <!--
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">DÍA DE \"TODOS LOS SANTOS\"</h4>
                                <center>
                                    <video src=\"https://intranet.oopp.gob.bo/videos/Todo-Santos-2017_11_01.mp4\" controls autoplay width=\"100%\" >DÍA DE \"TODOS LOS SANTOS\"</video>
                                </center>
                            </div>
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">Corredor Bioceánico</h4>
                                <center>
                                    <video src=\"https://intranet.oopp.gob.bo/videos/Tren-Bioceanico_Convenio-EMI_20171019.mp4\" controls autostart=\"false\" width=\"100%\" >Corredor Bioceánico</video>
                                </center>
                            </div>
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">Corredor Bioceánico</h4>
                                <center>
                                    <video src=\"https://intranet.oopp.gob.bo/videos/CFBI_20171106.mp4\" controls
                                           autostart=\"false\" width=\"100%\">Corredor Bioceánico
                                    </video>
                                </center>
                            </div>
                            -->

                            <!--
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">Corredor Ferroviario Bioceánico de Integración </h4>
                                <center>
                                    <video src=\"https://intranet.oopp.gob.bo/videos/CFBI_20171121.mp4\" controls
                                           autostart=\"false\" width=\"100%\">Corredor Bioceánico
                                    </video>
                                </center>
                            </div>
                            -->

                            <!--
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">NAVIDAD 2017</h4>
                                <center>
                                    <video src=\"https://intranet.oopp.gob.bo/videos/Navidad_20171220.mp4\" controls
                                           autostart=\"false\" width=\"100%\">Corredor Bioceánico
                                    </video>
                                </center>
                            </div>
                            -->

                            <!--
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">FAMILIA MOPSV</h4>
                                <center>
                                    <video src=\"https://intranet.oopp.gob.bo/videos/Somos-MOPSV_2017_12_29.mp4\" controls
                                           autostart=\"false\" width=\"100%\">Familia MOPSV
                                    </video>
                                </center>
                            </div>
                            -->

                            <!--
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">LA BOLIVIA QUE SOÑAMOS</h4>
                                <center>
                                    <video src=\"https://intranet.oopp.gob.bo/videos/La-Bolivia-que-sonamos_20180123.mp4\" controls
                                           autostart=\"false\" width=\"100%\">LA BOLIVIA QUE SOÑAMOS
                                    </video>
                                </center>
                            </div>
                            -->
                            <!--
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">TRABAJEMOS JUNTOS POR BOLIVIA</h4>
                                <center>
                                    <video src=\"https://intranet.oopp.gob.bo/videos/Trabajemos-juntos_20180209.mp4\" controls
                                           autostart=\"false\" width=\"100%\">TRABAJEMOS JUNTOS POR BOLIVIA
                                    </video>
                                </center>
                            </div>
                            -->

                            <!--
                            <div style=\"margin: 10px 0;\">
                                <h4 class=\"modal-title\">INVITACIÓN - AUDIENCIA INICIAL DE RENDICIÓN PÚBLICA DE CUENTAS</h4>
                                <center>
                                    <video width=\"100%\" height=\"auto\" controls=\"\" autoplay=\"\" name=\"media\" autostart=\"false\">
                                        <source src=\"https://intranet.oopp.gob.bo/videos/Invitacion-Audiencia-Inicial-de-Rendicion-Publica-de-Cuentas_20180622.mp4\" type=\"video/mp4\">
                                    </video>
                                </center>
                            </div>
                            -->

                            ";
            // line 156
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["popup_intranet"]) ? $context["popup_intranet"] : $this->getContext($context, "popup_intranet")));
            foreach ($context['_seq'] as $context["_key"] => $context["popup"]) {
                // line 157
                echo "                                <div style=\"margin: 10px 0\">
                                    <h4 class=\"modal-title\">";
                // line 158
                echo $this->getAttribute((isset($context["popup"]) ? $context["popup"] : $this->getContext($context, "popup")), "Titulo");
                echo "</h4>
                                    <center><img width=\"100%\" src=\"";
                // line 159
                echo $this->getAttribute((isset($context["popup"]) ? $context["popup"] : $this->getContext($context, "popup")), "image_url");
                echo "\" alt=\"\"></center>
                                </div>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['popup'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 162
            echo "                        </div>
                    </div>
                    <!--
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" class=\"btn btn-primary\">Save changes</button>
                    </div>
                    -->
                </div>
            </div>
        </div>
    ";
        }
        // line 174
        echo "
    <style>
        .comunicado {
            height: auto;
            width: 100%;
        }
    </style>

    <script>
        window.onload = function () {
            \$('#myModal').modal('show');
        };
    </script>

    <!-- ===== FIN POPUP ===== -->


    <div id=\"backgroundx\" class=\"backgroundx\">
        <div style=\"color:white;float:right;margin-right: 10px; \">
            <i class=\"fa fa-times-circle-o fa-2x\"></i> <a style=\"color:white;\" href=\"javascript:cerrarr();\">Cerrar</a>
        </div>
        <div id=\"contenedrx\" class=\"contenedrx\">
            <h3 style=\"color:white;\">ULTIMOS REGLAMENTOS</h3>

        </div>
    </div>
    <div class=\"alert2\" id=\"alert2\">
        <div style=\"font-size:15px;color: white;text-align: center;height: 50px\">
            <img style=\"float:left;height:45px;width:45px;border-radius:50%;\"
                 src=\"https://siemi.oopp.gob.bo/doccargados/rrhh/";
        // line 203
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "ci"), "html", null, true);
        echo "/FOTOS/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "foto"), "html", null, true);
        echo "\">
            <div style=\"float:left;font-size:9px;\">
                ";
        // line 205
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "name"), "html", null, true);
        echo "<br>
                <cite>";
        // line 206
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "cargo"), "html", null, true);
        echo "</cite>
            </div>
        </div>
        <ul>
            ";
        // line 210
        $context["c"] = "";
        // line 211
        echo "            ";
        $context["ids"] = "";
        // line 212
        echo "            ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["problemas"]) ? $context["problemas"] : $this->getContext($context, "problemas")));
        foreach ($context['_seq'] as $context["_key"] => $context["problema"]) {
            // line 213
            echo "                ";
            $context["c"] = 0;
            // line 214
            echo "                ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["solicitudes"]) ? $context["solicitudes"] : $this->getContext($context, "solicitudes")));
            foreach ($context['_seq'] as $context["_key"] => $context["solicitud"]) {
                // line 215
                echo "                    ";
                if (($this->getAttribute((isset($context["solicitud"]) ? $context["solicitud"] : $this->getContext($context, "solicitud")), "idp") == $this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "idp"))) {
                    // line 216
                    echo "                        ";
                    $context["c"] = $this->getAttribute((isset($context["solicitud"]) ? $context["solicitud"] : $this->getContext($context, "solicitud")), "n");
                    // line 217
                    echo "                        ";
                    $context["ids"] = $this->getAttribute((isset($context["solicitud"]) ? $context["solicitud"] : $this->getContext($context, "solicitud")), "id");
                    // line 218
                    echo "                    ";
                }
                // line 219
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['solicitud'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 220
            echo "                ";
            if (((isset($context["c"]) ? $context["c"] : $this->getContext($context, "c")) > 0)) {
                // line 221
                echo "                    <li>
                        <div class=\"element\">
                            <div class=\"indicador\">";
                // line 223
                echo twig_escape_filter($this->env, (isset($context["c"]) ? $context["c"] : $this->getContext($context, "c")), "html", null, true);
                echo "</div>
                            <div class=\"botones\">
                                ";
                // line 225
                if (($this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "fun") != null)) {
                    // line 226
                    echo "                                    <div class=\"foto2\">
                                        <img style=\"height:45px;width:45px;border-radius:50%;\"
                                             src='https://siemi.oopp.gob.bo/doccargados/rrhh/";
                    // line 228
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "fun"), "ci"), "html", null, true);
                    echo "/FOTOS/";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "fun"), "foto"), "html", null, true);
                    echo "'>

                                    </div>
                                ";
                } else {
                    // line 232
                    echo "                                    <div class=\"foto2\">


                                    </div>
                                ";
                }
                // line 237
                echo "                                <div title=\"Solicitar soporte nuevamente\"
                                     onclick=\"enviar(";
                // line 238
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "idp"), "html", null, true);
                echo ",
                                             '";
                // line 239
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "fun"), "name"), "html", null, true);
                echo "',
                                             '";
                // line 240
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "fun"), "email"), "html", null, true);
                echo "',
                                             '";
                // line 241
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "name"), "html", null, true);
                echo "',
                                             '";
                // line 242
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "nombre"), "html", null, true);
                echo "'
                                             );\"
                                     class=\"sol\"><i class=\"fa fa-user-md fa-2x\"></i></div>
                                <div title=\"Finalizar solicitud\" onclick=\"finaliza(";
                // line 245
                echo twig_escape_filter($this->env, (isset($context["ids"]) ? $context["ids"] : $this->getContext($context, "ids")), "html", null, true);
                echo ");\" class=\"cer\"><i
                                            class=\"fa fa-thumbs-o-up fa-2x\"></i></div>
                            </div>
                            <div class=\"icono\">
                                <i class=\"fa ";
                // line 249
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "icon"), "html", null, true);
                echo " fa-2x\"></i>
                            </div>
                            <div class=\"tituloxx\">";
                // line 251
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "nombre"), "html", null, true);
                echo "</div>
                        </div>
                    </li>
                ";
            } else {
                // line 255
                echo "                    <li>
                        <div class=\"element\">

                            <div class=\"botones\">
                                ";
                // line 259
                if (($this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "fun") != null)) {
                    // line 260
                    echo "                                    <div class=\"foto2\">
                                        <div style=\"font-size:9px;\">INT:";
                    // line 261
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "fun"), "interno"), "html", null, true);
                    echo "</div>
                                    </div>
                                ";
                } else {
                    // line 264
                    echo "                                    <div class=\"foto2\">
                                    </div>
                                ";
                }
                // line 267
                echo "                                <div title=\"Solicitar soporte\"
                                     onclick=\"enviar(";
                // line 268
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "idp"), "html", null, true);
                echo ",
                                             '";
                // line 269
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "fun"), "name"), "html", null, true);
                echo "',
                                             '";
                // line 270
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "fun"), "email"), "html", null, true);
                echo "',
                                             '";
                // line 271
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "name"), "html", null, true);
                echo "',
                                             '";
                // line 272
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "nombre"), "html", null, true);
                echo "'
                                             );\" class=\"sol\">
                                    <i class=\"fa fa-user-md fa-2x\"></i>
                                </div>
                            </div>
                            <div class=\"icono\">
                                <i class=\"fa ";
                // line 278
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "icon"), "html", null, true);
                echo " fa-2x\"></i>
                            </div>
                            <div class=\"tituloxx\">";
                // line 280
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["problema"]) ? $context["problema"] : $this->getContext($context, "problema")), "nombre"), "html", null, true);
                echo "</div>
                        </div>
                    </li>
                ";
            }
            // line 284
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['problema'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 285
        echo "        </ul>
        <div class=\"soporte\">
            <span style=\"float:left;\">SOPORTE TÉCNICO:  </span><br>
            <span style=\"float:left;\">INTERNO: </span><br>
            <span style=\"float:left;\">CELULAR: </span><br>
        </div>
    </div>
    <div id=\"panel\">
    </div> <!-- /login -->
    <!-- The tab on top -->
    <div class=\"tab\">
        <ul class=\"login\">
            <li class=\"left\">&nbsp;</li>
            <li>Bienvenido!</li>
            <li class=\"sep\">|</li>
            <li id=\"toggle1\">
                <a id=\"open1\" style=\"display: block;\" class=\"open1\"
                   href=\"javascript:slideDown('";
        // line 302
        echo $this->env->getExtension('routing')->getPath("cliente_lista_usuarios");
        echo "');\">Funcionarios</a>
            </li>
            <li class=\"right\">&nbsp;</li>
        </ul>
    </div> <!-- / top -->
    <div class=\"header\">
        <div class=\"logo\"></div>
        <div style='position: absolute;width: 100%;top:40px;'>
            <div style='margin:auto;width: 1000px;height:100px;'>
                <img style=\"width:100px;float: left;\" src=\"";
        // line 311
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/images/escudo.png\"/>
                <img style=\"width: 15%; height: auto; float: right; margin-top: 20px;\" src=\"";
        // line 312
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/images/logo.png\"/>
            </div>
            <div style='position:absolute;right:5px;top:80px;font-size:12px;'>
                <a style='color:white;' href=\"";
        // line 315
        echo $this->env->getExtension('routing')->getPath("support_support_login");
        echo "\">
                    <i class=\"fa fa-user fa-2x\"></i> Entrar
                </a>
            </div>
        </div>
    </div>
    <div class=\"contenedor\">
        <div class=\"center_box\">
            <div class=\"leftbuttons\">
                <a href=\"";
        // line 324
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("uploads"), "html", null, true);
        echo "/LISTA-DE-PRECIOS-CAFETERIA_20180327.pdf\" title=\"ver\" target=\"_blank\"><i
                            class=\"fa fa-coffee fa-1x\"></i> Cafeteria</a>
            </div>
            <div class=\"leftbuttons2\">
                <i class=\"fa fa-video-camera fa-1x\"></i>
                ";
        // line 329
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["videos"]) ? $context["videos"] : $this->getContext($context, "videos")));
        foreach ($context['_seq'] as $context["_key"] => $context["video"]) {
            // line 330
            echo "                    <div>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["video"]) ? $context["video"] : $this->getContext($context, "video")), "titulo"), "html", null, true);
            echo "</div>
                    ";
            // line 331
            echo $this->getAttribute((isset($context["video"]) ? $context["video"] : $this->getContext($context, "video")), "embebido");
            echo "
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['video'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 333
        echo "            </div>
            <div style=\"text-align:center;\">
                <iframe scrolling=\"no\" style=\"border:none;overflow:hidden;width:100%;height:270px;margin: auto;\"
                        src=\"";
        // line 336
        echo $this->env->getExtension('routing')->getPath("cliente_slider");
        echo "\"></iframe>
            </div>
            <div class=\"contenedorx\">
                <ul class=\"lista\">
                    ";
        // line 340
        if ((twig_length_filter($this->env, (isset($context["cumple"]) ? $context["cumple"] : $this->getContext($context, "cumple"))) > 0)) {
            // line 341
            echo "                        <li>
                            <div class=\"contentbox\">
                                <!-- <div class=\"header3\"><i class=\"fa fa-gift fa-1x\"></i>Cumpleañeros de hoy</div> -->
                                <div class=\"header3\">
                                    <span>
                                        <i class=\"fa fa-gift fa-1x\"></i>CUMPLEAÑEROS DE HOY
                                    </span>
                                </div>
                                <div class=\"line\"></div>
                                <ul style=\"padding:10px;font-size:10px;padding: 0px; list-style: none;margin-left: 10px;margin-top: 20px\">
                                    ";
            // line 351
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["cumple"]) ? $context["cumple"] : $this->getContext($context, "cumple")));
            foreach ($context['_seq'] as $context["_key"] => $context["cc"]) {
                // line 352
                echo "                                        <li style=\"color: #006699;height:100px;\">
                                            <div class=\"cumplecont\">
                                                <div class=\"cumple\"></div>
                                                <img style=\"margin-right: 3px;border-radius: 5px;border-width:3px;border-style:solid;border-color: #666666 ;width: 70px;float:left;\"
                                                     src=\"https://siemi.oopp.gob.bo/doccargados/rrhh/";
                // line 356
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["cc"]) ? $context["cc"] : $this->getContext($context, "cc")), "ci"), "html", null, true);
                echo "/FOTOS/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["cc"]) ? $context["cc"] : $this->getContext($context, "cc")), "foto"), "html", null, true);
                echo " \"
                                                     onerro=\"this.src='/bundles/new-user.png'\">
                                            </div>
                                            <div style=\"font-weight: bold;color:#006699;font-size: 15px;line-height:1.5em;\">
                                                <div>Feliz cumpleaños:</div> ";
                // line 360
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["cc"]) ? $context["cc"] : $this->getContext($context, "cc")), "name"), "html", null, true);
                echo "
                                            </div>
                                        </li>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cc'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 364
            echo "                                    <br>
                                    <li>
                                        Que el día de hoy sea un día hermoso e inolvidable en tu vida<br>Quienes
                                        compartimos el día a día contigo, queremos desearte feliz cumpleaños.
                                    </li>
                                </ul>

                            </div>
                        </li>
                    ";
        }
        // line 374
        echo "
                    <li>
                        <div class=\"contentbox\">
                            <div class=\"header3\">
                                <span>
                                    <i class=\"fa fa-gift fa-1x\"></i>CALENDARIO DE EVENTOS
                                </span>
                            </div>
                            <iframe style=\"background-color: transparent;border:none;overflow: hidden;width:280px;height:490px;margin: auto;\"
                                    src=\"";
        // line 383
        echo $this->env->getExtension('routing')->getPath("cliente_calendar");
        echo "\"></iframe>
                        </div>
                    </li>

                    <!-- Marcaciones -->
                    <li>
                        <div class=\"contentbox\">
                            <div class=\"header3\">
                                <span>
                                    <i class=\"fa fa-gift fa-1x\"></i>MARCACIONES</span>
                            </div>
                            <iframe scrolling=\"auto\" src=\"//hades.oopp.gob.bo/marcaciones/intranet/\"
                                    frameborder=\"0\" height=\"200\" width=\"100%\"></iframe>
                        </div>
                    </li>

                    <!-- El Clima -->
                    <li>
                        <div class=\"contentbox\">
                            <div class=\"header3\">
                                <span>
                                    <i class=\"fa fa-gift fa-1x\"></i>EL CLIMA
                                </span>
                            </div>
                            <a href=\"https://www.accuweather.com/es/bo/la-paz/33655/weather-forecast/33655\"
                               class=\"aw-widget-legal\">
                                <!--
                                By accessing and/or using this code snippet, you agree to AccuWeather’s terms and conditions (in English) which can be found at http://www.accuweather.com/en/free-weather-widgets/terms and AccuWeather’s Privacy Statement (in English) which can be found at http://www.accuweather.com/en/privacy.
                                -->
                            </a>
                            <div id=\"awcc1395437751690\" class=\"aw-widget-current\" data-locationkey=\"33655\" data-unit=\"c\"
                                 data-language=\"es\" data-useip=\"false\" data-uid=\"awcc1395437751690\"></div>
                            <script type=\"text/javascript\" src=\"https://oap.accuweather.com/launch.js\"></script>
                        </div>
                    </li>
                    <li>
                        <div class=\"header3\">
                            <span>
                                <i class=\"fa fa-edit fa-1x\"></i>PROYECTOS
                            </span>
                        </div>
                        <iframe style=\"width:300px;height:270px;padding: 0px;border:none;\"
                                src=\"";
        // line 425
        echo $this->env->getExtension('routing')->getPath("cliente_flip");
        echo "\"></iframe>
                    </li>

                    <!-- MOSTRAR LISTA DE INTERNOS -->
                    <li>
                        <div class=\"header3\">
                            <span>
                                <i class=\"fa fa-edit fa-1x\"></i>LISTA DE INTERNOS Y CORPORATIVOS
                            </span>
                        </div>
                        <div class=\"contentbox\">
                            <div style=\"margin:10px;font-size:12px;font-weight: bold\">
                                ";
        // line 437
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["forms"]) ? $context["forms"] : $this->getContext($context, "forms")));
        foreach ($context['_seq'] as $context["_key"] => $context["form"]) {
            // line 438
            echo "                                    <!-- Lista de Internos y Corporativos (id=282) -->
                                    ";
            // line 439
            if (($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "id") == "282")) {
                // line 440
                echo "
                                        <i style=\"color: #cc0000;font-weight: bold;\" class=\"fa fa-paperclip fa-1x\"></i>
                                        ";
                // line 442
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "titulo"), "html", null, true);
                echo "
                                        <a target='_blank' style='float:right;'
                                           href=\"";
                // line 444
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("uploads"), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "url"), "html", null, true);
                echo "\"><i style=\"color:#006699;\"
                                                                                           class=\"fa fa-download fa-2x\"></i></a>
                                        <div style=\"font-weight: normal;font-size:10px;color: #999999;\">
                                            Fecha de publicación:";
                // line 447
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "fechaPub"), "d-m-Y"), "html", null, true);
                echo "
                                        </div>
                                        <hr style='border-color: #dddddd;'>
                                    ";
            }
            // line 451
            echo "                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['form'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 452
        echo "                            </div>
                        </div>
                    </li>


                    <li>
                        <div class=\"header3\">
                            <span>
                                <i class=\"fa fa-edit fa-1x\"></i>FORMULARIOS
                            </span>
                        </div>
                        <div class=\"contentbox\">
                            <div>
                                <input type=\"text\" id=\"input-titulo-formulario\" onkeyup=\"filterFormulariosFunction()\"
                                       placeholder=\"Formulario...\"
                                       title=\"Formulario...\"
                                       style=\"width:100%;\">

                                <ul id=\"lista-formularios\" style=\"list-style-type: none; padding: 0; margin: 0.5em;\"
                                    class=\"content3\">
                                    ";
        // line 472
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["forms"]) ? $context["forms"] : $this->getContext($context, "forms")));
        foreach ($context['_seq'] as $context["_key"] => $context["form"]) {
            // line 473
            echo "                                        <li>
                                            <i style=\"color: #cc0000;font-weight: bold;\"
                                               class=\"fa fa-paperclip fa-1x\"></i>
                                            <p>";
            // line 476
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "titulo"), "html", null, true);
            echo "</p>
                                            <a target='_blank' style='float:right;'
                                               href=\"";
            // line 478
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("uploads"), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "url"), "html", null, true);
            echo "\">
                                                <i style=\"color:#006699;\" class=\"fa fa-download fa-2x\"></i>
                                            </a>
                                            <div style=\"font-weight: normal;font-size:10px;color: #999999;\">
                                                Fecha de publicación:";
            // line 482
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "fechaPub"), "d-m-Y"), "html", null, true);
            echo "
                                            </div>
                                            <hr style='border-color: #dddddd;'>
                                        </li>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['form'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 487
        echo "                                </ul>
                            </div>

                        </div>
                    </li>
                </ul>

                <!-- [INICIO] VIDEO - CAPACITACIONES -->
                <div class=\"contentbox3\" style=\"width: 40%; padding: 10px;\">
                    <div class=\"header3s\">
                        <span>
                            <i class=\"fa fa-link fa-1x\"></i> CAPACITACIÓN MATRIZ DE SEGUIMIENTO - PRIMER SEMESTRE POA 2017
                        </span>
                    </div>
                    <div class=\"sep-widget\"></div>
                    <video width=\"100%\" height=\"auto\" controls=\"\" name=\"media\" preload=\"none\">
                        <source src=\"https://intranet.oopp.gob.bo/videos/Capacitacion-Matriz-de-Seguimiento_20180627.mp4\" type=\"video/mp4\">
                    </video>
                </div>
                <!-- [FIN] VIDEO - CAPACITACIONES -->
                
                <input type=\"text\" id=\"input-titulo-comunicado\" onkeyup=\"filterComunicadosFunction()\"
                       placeholder=\"Comunicado...\"
                       title=\"Comunicado...\"
                       style=\"width:40%;\"/>
                <div>
                    <ul id=\"lista2\" class=\"lista2\"
                        style=\"margin: 0; padding: 0; overflow-y:scroll; height: 1900px; width: 40%;\">
                        ";
        // line 515
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["comunicados"]) ? $context["comunicados"] : $this->getContext($context, "comunicados")));
        foreach ($context['_seq'] as $context["_key"] => $context["com"]) {
            // line 516
            echo "                            <li>
                                <div class=\"contentbox2\">
                                    <div>
                                        <div class=\"titulobox\">
                                        <span><i class=\"fa fa-comments-o fa-1x\"></i> ";
            // line 520
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["com"]) ? $context["com"] : $this->getContext($context, "com")), "titulo"), "html", null, true);
            echo "
                                        </span>
                                        </div>
                                        <div class=\"line\"></div>
                                    </div>
                                    <div style=\" margin-top: 25px\">
                                        <div class=\"textbox\">

                                            <img style=\"border-radius:3px;margin:3px;width:50px;float:left;\"
                                                 src=\"https://siemi.oopp.gob.bo/doccargados/rrhh/";
            // line 529
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["com"]) ? $context["com"] : $this->getContext($context, "com")), "usuario"), "ci"), "html", null, true);
            echo "/FOTOS/";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["com"]) ? $context["com"] : $this->getContext($context, "com")), "usuario"), "foto"), "html", null, true);
            echo "\"/>
                                            <div style=\"width:325px;float:left;\">
                                                <div style=\"float:left;margin-top:15px;z-index:100\">
                                                    <img src=\"";
            // line 532
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
            echo "/css/images/f.png\"/>
                                                </div>
                                                <div class=\"contenidotexto\">
                                                    <div><cite>";
            // line 535
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["com"]) ? $context["com"] : $this->getContext($context, "com")), "fechaPub"), "d-m-Y"), "html", null, true);
            echo "</cite></div>
                                                    <p>";
            // line 536
            echo twig_escape_filter($this->env, twig_upper_filter($this->env, $this->getAttribute((isset($context["com"]) ? $context["com"] : $this->getContext($context, "com")), "descripcion")), "html", null, true);
            echo "</p>

                                                    ";
            // line 538
            if (($this->getAttribute((isset($context["com"]) ? $context["com"] : $this->getContext($context, "com")), "url") != null)) {
                // line 539
                echo "                                                        <div>
                                                            <a target='_blank' style='float:right;'
                                                               href=\"";
                // line 541
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("uploads"), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["com"]) ? $context["com"] : $this->getContext($context, "com")), "url"), "html", null, true);
                echo "\">
                                                                <i style=\"color:#006699;\"
                                                                   class=\"fa fa-download fa-2x\"></i>
                                                            </a>
                                                        </div>
                                                    ";
            }
            // line 547
            echo "                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['com'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 554
        echo "                        <!--
                        <li style=\" text-align: center\">
                            ";
        // line 556
        echo (isset($context["pag"]) ? $context["pag"] : $this->getContext($context, "pag"));
        echo "
                        </li>
                        -->
                    </ul>
                </div>

                <ul class=\"lista3\">
                    ";
        // line 563
        if ((twig_length_filter($this->env, (isset($context["anuncio"]) ? $context["anuncio"] : $this->getContext($context, "anuncio"))) > 0)) {
            // line 564
            echo "                        <li>
                            <div class=\"contentbox3\">
                                <div style=\" background: linear-gradient(#F6F5EC, #E5E2D9);padding: 20px;\">
                                    <div class=\"anuncio\"><i class=\"fa fa-bullhorn fa-3x\"></i></div>
                                    ";
            // line 568
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["anuncio"]) ? $context["anuncio"] : $this->getContext($context, "anuncio")));
            foreach ($context['_seq'] as $context["_key"] => $context["anun"]) {
                // line 569
                echo "                                    <div style=\"font-size:13px;font-weight: bold\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["anun"]) ? $context["anun"] : $this->getContext($context, "anun")), "titulo"), "html", null, true);
                echo "</div>
                                    <div style=\"font-size:12px;\">
                                        ";
                // line 571
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["anun"]) ? $context["anun"] : $this->getContext($context, "anun")), "descripcion"), "html", null, true);
                echo "
                                        <div>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['anun'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 574
            echo "                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    ";
        } else {
            // line 580
            echo "                        <li>
                            <div class=\"contentbox3\">
                                <div style=\" background: linear-gradient(#F6F5EC, #E5E2D9);padding: 10px;font-size:12px;\">
                                    <strong>MISIÓN INSTITUCIONAL</strong><br>
                                    <p>
                                        Promover y gestionar el acceso universal y equitativo de la población boliviana
                                        a obras y servicios de calidad, en telecomunicaciones, transportes y vivienda,
                                        en armonía con la naturaleza.</p>
                                    <strong>VISIÓN INSTITUCIONAL</strong><br>
                                    <p>Somos una entidad que con calidad y transparencia, satisface las necesidades de
                                        transportes, telecomunicaciones y vivienda de la población boliviana.</p>
                                </div>
                            </div>
                        </li>
                    ";
        }
        // line 595
        echo "                    <li>
                        <!--
                        <div class=\"contentbox3\">
                            <div class=\"header3\">
                                <span><i class=\"fa fa-link fa-1x\"></i>El Che</span></div>
                            <div class=\"sep-widget\"></div>
                            <video src=\"https://intranet.oopp.gob.bo/videos/Video_El-Che2_20171004.mp4\" controls
                                   width=\"100%\">El Che
                            </video>
                        </div>
                        -->

                        <!-- [INICIO] VIDEO - CORREDOR BIOCEANICO -->
                        <div class=\"contentbox3\">
                            <div class=\"header3\">
                                <span><i class=\"fa fa-link fa-1x\"></i>CORREDOR BIOCEÁNICO</span></div>
                            <div class=\"sep-widget\"></div>
                            <video width=\"100%\" height=\"auto\" controls=\"\" name=\"media\" preload=\"none\">
                                <source src=\"https://intranet.oopp.gob.bo/videos/Invitacion-CFBI_20180813.mp4\" type=\"video/mp4\">
                            </video>
                            <br>
                            <video width=\"100%\" height=\"auto\" controls=\"\" name=\"media\" preload=\"none\">
                                <source src=\"https://intranet.oopp.gob.bo/videos/Emotivo-CFBI_20180813.mp4\" type=\"video/mp4\">
                            </video>
                        </div>
                        <!-- [FIN] VIDEO - CORREDOR BIOCEANICO -->                        

                        <div class=\"contentbox3\">
                            <div class=\"header3\">
                                <span><i class=\"fa fa-link fa-1x\"></i>Sistemas MOPSV</span>
                            </div>
                            <input type=\"text\" id=\"input-titulo-sistemasMopsv\" onkeyup=\"filterSistemasMopsvFunction()\"
                                   placeholder=\"Sistema...\"
                                   title=\"Sistema...\"
                                   style=\"width:100%;\"/>
                            <ul id=\"lista-sistemasMOPSV\" class=\"accesos\">
                                <li>
                                    ";
        // line 632
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["enlaces"]) ? $context["enlaces"] : $this->getContext($context, "enlaces")));
        foreach ($context['_seq'] as $context["_key"] => $context["enlace"]) {
            // line 633
            echo "                                        ";
            if (($this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "interno") == 1)) {
                // line 634
                echo "                                            <a href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "url"), "html", null, true);
                echo "\" title=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "titulo"), "html", null, true);
                echo "\" target=\"_blank\">
                                                <div class=\"iconsoporte\">
                                                    <i class=\"fa ";
                // line 636
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "icon"), "html", null, true);
                echo " fa-2x\"></i>
                                                    <p style=\"font-size:8px;\">";
                // line 637
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "titulo"), "html", null, true);
                echo "</p>
                                                </div>
                                            </a>
                                        ";
            }
            // line 641
            echo "                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['enlace'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 642
        echo "                                    <!--
                                    <a href=\"";
        // line 643
        echo $this->env->getExtension('routing')->getPath("cliente_chat");
        echo "\" title=\"Chat\" target=\"_blank\">
                                        <div class=\"iconsoporte\">
                                            <i class=\"fa fa-comments-o fa-2x\"></i>
                                            <div style=\"font-size:8px;\">Chat</div>
                                        </div>
                                    </a>
                                    -->
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class=\"contentbox3\">
                            <div class=\"header3\">
                                <span><i class=\"fa fa-link fa-1x\"></i>Sistemas externos</span>
                            </div>
                            <input type=\"text\" id=\"input-titulo-sistemasExternos\"
                                   onkeyup=\"filterSistemasExternosFunction()\"
                                   placeholder=\"Sistema...\"
                                   title=\"Sistema...\"
                                   style=\"width:100%;\"/>
                            <ul id=\"lista-sistemasExternos\" class=\"accesos\">
                                <li>
                                    ";
        // line 666
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["enlaces"]) ? $context["enlaces"] : $this->getContext($context, "enlaces")));
        foreach ($context['_seq'] as $context["_key"] => $context["enlace"]) {
            // line 667
            echo "                                        ";
            if (($this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "interno") == 0)) {
                // line 668
                echo "                                            <a href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "url"), "html", null, true);
                echo "\" title=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "titulo"), "html", null, true);
                echo "\" target=\"_blank\">
                                                <div class=\"iconsoporte\">
                                                    <div style=\" height:45px;\">
                                                        <img style=\"max-width:60px;max-height:45px;\"
                                                             src=\"";
                // line 672
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("enlaces"), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "icon"), "html", null, true);
                echo "\"/>
                                                    </div>
                                                    <p style=\"font-size:8px;\">";
                // line 674
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["enlace"]) ? $context["enlace"] : $this->getContext($context, "enlace")), "titulo"), "html", null, true);
                echo "</p>
                                                </div>
                                            </a>
                                        ";
            }
            // line 678
            echo "                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['enlace'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 679
        echo "                                </li>
                            </ul>

                        </div>
                    </li>
                    <li>
                        <div class=\"contentbox3\">
                            <div class=\"header3\">
                                <span><i class=\"fa fa-users fa-1x\"></i>REGLAMENTOS</span></div>
                            <div>
                                <input type=\"text\" id=\"input-titulo-reglamento\" onkeyup=\"filterReglamentosFunction()\"
                                       placeholder=\"Reglamento...\"
                                       title=\"Reglamento...\"
                                       style=\"width:100%;\">

                                <ul id=\"lista-reglamentos\" style=\"list-style-type: none; padding: 0; margin: 0.5em;\"
                                    class=\"content3\">
                                    ";
        // line 696
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["documentos"]) ? $context["documentos"] : $this->getContext($context, "documentos")));
        foreach ($context['_seq'] as $context["_key"] => $context["documento"]) {
            // line 697
            echo "                                        <li>
                                            <i style=\"color: #cc0000;font-weight: bold;\"
                                               class=\"fa fa-paperclip fa-1x\"></i>
                                            <p>";
            // line 700
            echo twig_escape_filter($this->env, twig_upper_filter($this->env, $this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "titulo")), "html", null, true);
            echo "</p>
                                            <div style=\"font-weight: normal;font-size:10px;color: #999999;\">
                                                Fecha de publicación:";
            // line 702
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "fecha_pub"), "d-m-Y"), "html", null, true);
            echo "
                                            </div>
                                            <!--
                                            <div style=\"display: inline-block; text-align: center; width: 100%;\">
                                                <div style=\"display: block; width: 33%\">
                                                    <a target='_blank' style='float:right;'
                                                       href=\"";
            // line 708
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("uploads"), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "url"), "html", null, true);
            echo "\">
                                                        <i style=\"color:#006699;\" class=\"fa fa-download fa-2x\"></i>
                                                    </a>
                                                    <h6>Circular</h6>
                                                </div>
                                            </div>
                                            -->
                                            <div style=\"margin: 0 auto; text-align: center;\">
                                                ";
            // line 716
            if (((!(null === $this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "file_circular"))) && (!twig_test_empty($this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "file_circular"))))) {
                // line 717
                echo "                                                    <div style=\"vertical-align: top; display: inline-block; text-align: center; margin-left: 1rem; margin-right: 1rem;\">
                                                        <a href=\"";
                // line 718
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("uploads"), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "file_circular"), "html", null, true);
                echo "\">
                                                            <i style=\"color:#006699;\" class=\"fa fa-download fa-lg\"></i>
                                                        </a>
                                                        <h6 style=\"font-size: 8px;\"><strong>CIRCULAR</strong></h6>
                                                    </div>
                                                ";
            }
            // line 724
            echo "                                                ";
            if ((!(null === $this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "file_resolucion")))) {
                // line 725
                echo "                                                    <div style=\"vertical-align: top; display: inline-block; text-align: center; margin-left: 1rem; margin-right: 1rem;\">
                                                        <a href=\"";
                // line 726
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("uploads"), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "file_resolucion"), "html", null, true);
                echo "\">
                                                            <i style=\"color:#006699;\" class=\"fa fa-download fa-lg\"></i>
                                                        </a>
                                                        <h6 style=\"font-size: 8px;\">
                                                            <strong>
                                                                RESOLUCIÓN
                                                                <br>
                                                                MINISTERIAL
                                                            </strong>
                                                        </h6>
                                                    </div>
                                                ";
            }
            // line 738
            echo "                                                ";
            if ((!(null === $this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "file_reglamento")))) {
                // line 739
                echo "                                                    <div style=\"vertical-align: top; display: inline-block; text-align: center; margin-left: 1rem; margin-right: 1rem;\">
                                                        <a href=\"";
                // line 740
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("uploads"), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["documento"]) ? $context["documento"] : $this->getContext($context, "documento")), "file_reglamento"), "html", null, true);
                echo "\">
                                                            <i style=\"color:#006699;\" class=\"fa fa-download fa-lg\"></i>
                                                        </a>
                                                        <h6 style=\"font-size: 8px;\"><strong>REGLAMENTO</strong></h6>
                                                    </div>
                                                ";
            }
            // line 746
            echo "                                            </div>
                                            <hr style='border-color: #dddddd;'>
                                        </li>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['documento'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 750
        echo "                                </ul>
                            </div>
                            <!--
                            <a style=\"float:right;color: #0099ff\" href=\"javascript:mostrarr();\">ver más</a>
                            -->
                        </div>
                    </li>
                    <li>
                        <div class=\"contentbox3\">
                            <div class=\"header3\">
                                <span><i class=\"fa fa-users fa-1x\"></i>SEGUIDORES</span></div>
                            <div style=\" padding:5px\">
                                <div id=\"fb-root\"></div>
                                <script>
                                    (function (d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id))
                                            return;
                                        js = d.createElement(s);
                                        js.id = id;
                                        js.src = \"//connect.facebook.net/es_LA/all.js#xfbml=1&appId=533174466770548\";
                                        fjs.parentNode.insertBefore(js, fjs);
                                    }(document, 'script', 'facebook-jssdk'));
                                </script>
                                <div class=\"fb-like-box\"
                                     data-href=\"https://www.facebook.com/pages/Ministerio-de-Obras-P%C3%BAblicas-Servicios-y-Vivienda/767537823266104\"
                                     data-width=\"250\" data-height=\"500\" data-colorscheme=\"light\" data-show-faces=\"true\"
                                     data-header=\"FALSE\" data-stream=\"false\" data-show-border=\"true\"></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div style=\"clear: both; width: 100%;padding:5px;\">
                <ul class=\"ul1\">
                    <div class=\"header3\"><span><i class=\"fa fa-edit fa-1x\"></i>ENLACES IMPORTANTES</span></div>
                    <marquee class=\"marq\" onmouseout=\"this.start()\" onmouseover=\"this.stop()\"
                             style=\"float: right;margin: 5px;\" behavior=\"scroll\" scrollamount=\"2\">
                        <li>
                            <div class=\"lidiv\">
                                <div class=\"lay1\">
                                    <img title=\"Reglamento para el desarrollo de tecnologias de información\"
                                         src=\"";
        // line 792
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("carou"), "html", null, true);
        echo "/1.jpg\">
                                </div>
                                <div class=\"lay\">
                                    <a target=\"_blank\" style=\" margin-right:15px;\"
                                       href=\"https://www.oopp.gob.bo/uploads/Reglamento%20TIC%20%20MOPSV.pdf\">
                                        Reglamento para el desarrollo de tecnologias de información
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class=\"lidiv\">
                                <div class=\"lay1\">
                                    <img title=\"Decreto supremo 1793\" src=\"";
        // line 805
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("carou"), "html", null, true);
        echo "/2.jpg\">
                                </div>
                                <div class=\"lay\">
                                    <a target=\"_blank\"
                                       href=\"https://www.oopp.gob.bo/uploads/DS%20Reglamento%20TIC%20MOPSV.pdf\">
                                        Decreto supremo 1793
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class=\"lidiv\">
                                <div class=\"lay1\">
                                    <img title=\"La historia de como llegamos al cielo\" src=\"";
        // line 818
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("carou"), "html", null, true);
        echo "/3.jpg\">

                                </div>
                                <div class=\"lay\">
                                    <a target=\"_blank\" style=\" margin-right:15px;\"
                                       href=\"https://www.oopp.gob.bo/uploads/LIBRO%20SATELITE%20TUPAC%20COMPLETO.pdf\">
                                        La historia de como llegamos al cielo
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class=\"lidiv\">
                                <div class=\"lay1\">
                                    <img title=\"Ley 441\" src=\"";
        // line 832
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("carou"), "html", null, true);
        echo "/4.png\">
                                </div>
                                <div class=\"lay\">
                                    <a target=\"_blank\" style=\" margin-right:15px;\"
                                       href=\"http://sionet.oopp.gob.bo/Default.aspx?ReturnUrl=%2f\">
                                        Ley 441
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class=\"lidiv\">
                                <div class=\"lay1\">
                                    <img title=\"Proyectos de autovaluo\" src=\"";
        // line 845
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("carou"), "html", null, true);
        echo "/6.jpg\">
                                </div>
                                <div class=\"lay\">
                                    <a target=\"_blank\" style=\" margin-right:15px;\"
                                       href=\"https://www.oopp.gob.bo/uploads/R.M_._342_Arq_._Rocha_.pdf\">
                                        Proyectos de autovaluo
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class=\"lidiv\">
                                <div class=\"lay1\">
                                    <img title=\"Resoluciones ministeriales Unidad de recursos jerarquicos\"
                                         src=\"";
        // line 859
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("carou"), "html", null, true);
        echo "/7.jpg\">
                                </div>
                                <div class=\"lay\">
                                    <a target=\"_blank\" style=\" margin-right:15px;\"
                                       href=\"https://www.oopp.gob.bo/index.php/informacion_institucional/RESOLUCIONES-MINISTERIALES,952.html\">
                                        Resoluciones ministeriales Unidad de recursos jerarquicos
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class=\"lidiv\">
                                <div class=\"lay1\">
                                    <img title=\"UNASUR\" src=\"";
        // line 872
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("carou"), "html", null, true);
        echo "/9.gif\">
                                </div>
                                <div class=\"lay\">
                                    <a target=\"_blank\" style=\" margin-right:15px;\" href=\"#\">
                                        UNASUR
                                    </a>
                                </div>
                            </div>
                        </li>
                    </marquee>
                </ul>
                <ul style=\"list-style: none;display: none;padding:0px;margin-top:0px;\">
                    <li style=\" background-color: white;width:985px;margin: 5px;height:100px\">
                        <div class=\"header3\">
                                            <span>
                                                <i class=\"fa fa-edit fa-1x\"></i>MONITOREO INFORMATIVO</span></div>
                        <iframe style=\"border:none;width:985px;height:500px;background-color: white;\"
                                src=\"";
        // line 889
        echo $this->env->getExtension('routing')->getPath("monitoreo_monitoreo");
        echo "\"></iframe>
                    </li>
                </ul>
            </div>

            <div style=\" height: 70px; color: white;background-color: #006699;text-align: center;font-size: 12px;text-shadow: 1px 1px 3px #000000;padding:10px;\">
                Ministerio de Obras Públicas Servicios y Vivienda
                Av. Mariscal Santa Cruz Esq. Calle Oruro Edif. Centro de Comunicaciones La Paz 5to piso.
                Copyright © Sistemas 2012 - Ministerio de Obras Públicas, Servicios y Vivienda
                <br>
            </div>
        </div>
    </div>
    <div class=\"alertx\" id=\"alertx\">
        <div>
            <img class=\"foto\"
                 src=\"https://siemi.oopp.gob.bo/doccargados/rrhh/";
        // line 905
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "ci"), "html", null, true);
        echo "/FOTOS/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "foto"), "html", null, true);
        echo "\"/>
            <div class=\"titulo\">
                <div class=\"nombre\">";
        // line 907
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "name"), "html", null, true);
        echo "</div>
                INTERNO: <cite class=\"cite\">";
        // line 908
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["usuario"]) ? $context["usuario"] : $this->getContext($context, "usuario")), "interno"), "html", null, true);
        echo "</cite>
            </div>
        </div>

    </div>
    <div class=\"botonsolicitud\" onclick=\"xxx();\">
    </div>
    <script>
        function xxx() {
            var e = document.getElementById(\"alert2\");
            if (e.style.width == '400px') {
                e.style.width = \"0px\";
                e.style.animationName = '';
            } else {
                e.style.width = \"400px\";
                e.style.animationName = 'alert2';
            }
        }

        function finaliza(ids) {
            if (!confirm('Confirme')) {
                return;
            }
            var resp = prompt(\"Código de soporte:\", \"\");

            if (resp != null) {
                val = '";
        // line 934
        echo $this->env->getExtension('routing')->getPath("cliente_finalizar");
        echo "';
                var parametros = {
                    'ids': ids,
                    'codigo': resp
                };
                \$.ajax({
                    data: parametros,
                    url: val,
                    type: 'post',
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response == 'Solicitud cerrada') {
                            location.reload();
                        } else {
                            alert(response);
                        }
                        //
//location.reload();
                        //\$(\"#popup_frame\").html(response);
                    }
                });
            }


        }

        function enviar(p, nombre_soporte, correo_soporte, nombre_solicitante, problema) {

            var mensaje = nombre_solicitante + \" SOLICITA SOPORTE EN: \" + problema + \".\";

            //console.log(p);
            //console.log(nombre_soporte);
            //console.log(nombre_solicitante);
            //console.log(problema);
            console.log(mensaje);

            if (!confirm('Confirme el envio de la solicitud')) {
                return;
            }
            val = '";
        // line 975
        echo $this->env->getExtension('routing')->getPath("cliente_enviar");
        echo "';
            var parametros = {
                'p': p,
            };
            \$.ajax({
                data: parametros,
                url: val,
                type: 'post',
                beforeSend: function () {

                },
                success: function (response) {
                    location.reload();
                    console.log(response);
                    //\$(\"#popup\").fadeIn(200, \"linear\");
                    //\$(\"#popup_frame\").html(response);
                }
            });

            // Envío de Solicitud al Chat Institucional
            //var correo_soporte = \"eddy.conde@oopp.gob.bo\";            
            //correo_soporte = \"mopsv@oopp.gob.bo\";
            var usuario_chat = correo_soporte;
            //var url_chat = \"http://monitoreo.oopp.gob.bo/api/enviarMensajesChatInstitucional/\" + correo_soporte + \"/asunto/\" + mensaje + \"/\";
            var token_hook_chat = \"ZwbkYjMkGPiCpfcsq/YDBXHP7Z7HeoyPz6jkcHJqN8xFe7YjsYPwZ6J69Wj5Zvkm6A\";

            //var url_chat = \"http://monitoreo.oopp.gob.bo/api/enviarMensajesChatInstitucional/\" + \"?asunto=\" + \"asunto\" + \"&mensaje=\" + mensaje + \"&user_xmpp=\" + correo_soporte;

            var url_chat = \"https://hades.oopp.gob.bo/notificaciones/api/movil/chat/send/\" + \"?asunto=\" + \"asunto\" + \"&mensaje=\" + mensaje + \"&user_xmpp=\" + correo_soporte + \"&token=\" + token_hook_chat;

            \$.ajax({
                type: \"GET\",
                dataType: \"json\",
                url: url_chat,
                success: function (data) {
                    console.log('response: ', data);
                },
                error: function (xhr, textStatus, error) {
                    console.log('statusText:', xhr.statusText);
                    console.log('responseText:', xhr.responseText);
                    console.log('textStatus:', textStatus);
                    console.log('error:', error);
                }
            });
        }

        // FILTER: SECCIÓN 'FORMULARIOS'
        function filterFormulariosFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById(\"input-titulo-formulario\");
            filter = input.value.toUpperCase();
            ul = document.getElementById(\"lista-formularios\");
            li = ul.getElementsByTagName(\"li\");
            for (i = 0; i < li.length; i++) {
                elementP = li[i].getElementsByTagName(\"p\")[0];
                // console.log('element P: ', elementP);
                if (elementP.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = \"\";
                } else {
                    li[i].style.display = \"none\";
                }
            }
        }

        // FILTER: SECCIÓN 'COMUNICADOS'
        function filterComunicadosFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById(\"input-titulo-comunicado\");
            filter = input.value.toUpperCase();
            ul = document.getElementById(\"lista2\");
            li = ul.querySelectorAll(\"li > div\");
            for (i = 0; i < li.length; i++) {
                element = li[i].getElementsByTagName(\"p\")[0];
                console.log('element P: ', element);
                if (element.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = \"\";
                } else {
                    li[i].style.display = \"none\";
                }
            }
        }

        // FILTER: SECCIÓN 'SISTEMAS MOPSV'
        function filterSistemasMopsvFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById(\"input-titulo-sistemasMopsv\");
            filter = input.value.toUpperCase();
            ul = document.getElementById(\"lista-sistemasMOPSV\");
            li = ul.querySelectorAll(\"li > a > div\");
            for (i = 0; i < li.length; i++) {
                element = li[i].getElementsByTagName(\"p\")[0];
                //console.log('element P: ', element);
                if (element.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = \"\";
                } else {
                    li[i].style.display = \"none\";
                }
            }
        }

        // FILTER: SECCIÓN 'SISTEMAS EXTERNOS'
        function filterSistemasExternosFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById(\"input-titulo-sistemasExternos\");
            filter = input.value.toUpperCase();
            ul = document.getElementById(\"lista-sistemasExternos\");
            li = ul.querySelectorAll(\"li > a > div\");
            for (i = 0; i < li.length; i++) {
                element = li[i].getElementsByTagName(\"p\")[0];
                //console.log('element P: ', element);
                if (element.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = \"\";
                } else {
                    li[i].style.display = \"none\";
                }
            }
        }

        // FILTER: SECCIÓN 'REGLAMENTOS'
        function filterReglamentosFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById(\"input-titulo-reglamento\");
            filter = input.value.toUpperCase();
            ul = document.getElementById(\"lista-reglamentos\");
            li = ul.getElementsByTagName(\"li\");
            for (i = 0; i < li.length; i++) {
                elementP = li[i].getElementsByTagName(\"p\")[0];
                // console.log('element P: ', elementP);
                if (elementP.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = \"\";
                } else {
                    li[i].style.display = \"none\";
                }
            }
        }
    </script>

    <script src=\"";
        // line 1112
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/js/jquerypp.custom.js\"></script>
    <script src=\"";
        // line 1113
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/js/jquery.bookblock.js\"></script>
    <script>
        var Page = (function () {

            var config = {
                    \$bookBlock: \$('#bb-bookblock'),
                    \$navNext: \$('#bb-nav-next'),
                    \$navPrev: \$('#bb-nav-prev'),
                    \$navFirst: \$('#bb-nav-first'),
                    \$navLast: \$('#bb-nav-last')
                },
                init = function () {
                    config.\$bookBlock.bookblock({
                        speed: 800,
                        shadowSides: 0.8,
                        shadowFlip: 0.7
                    });
                    initEvents();
                },
                initEvents = function () {

                    var \$slides = config.\$bookBlock.children();

                    // add navigation events
                    config.\$navNext.on('click touchstart', function () {
                        config.\$bookBlock.bookblock('next');
                        return false;
                    });

                    config.\$navPrev.on('click touchstart', function () {
                        config.\$bookBlock.bookblock('prev');
                        return false;
                    });

                    config.\$navFirst.on('click touchstart', function () {
                        config.\$bookBlock.bookblock('first');
                        return false;
                    });

                    config.\$navLast.on('click touchstart', function () {
                        config.\$bookBlock.bookblock('last');
                        return false;
                    });

                    // add swipe events
                    \$slides.on({
                        'swipeleft': function (event) {
                            config.\$bookBlock.bookblock('next');
                            return false;
                        },
                        'swiperight': function (event) {
                            config.\$bookBlock.bookblock('prev');
                            return false;
                        }
                    });

                    // add keyboard events
                    \$(document).keydown(function (e) {
                        var keyCode = e.keyCode || e.which,
                            arrow = {
                                left: 37,
                                up: 38,
                                right: 39,
                                down: 40
                            };

                        switch (keyCode) {
                            case arrow.left:
                                config.\$bookBlock.bookblock('prev');
                                break;
                            case arrow.right:
                                config.\$bookBlock.bookblock('next');
                                break;
                        }
                    });
                };

            return {init: init};

        })();
    </script>
    <script>
        Page.init();
        function getContent(pag) {
            val = '";
        // line 1197
        echo $this->env->getExtension('routing')->getPath("cliente_comunicados_paginado");
        echo "';
            var parametros = {
                'pagina': pag,
            };
            \$.ajax({
                data: parametros,
                url: val,
                type: 'post',
                beforeSend: function () {
                },
                success: function (response) {
                    lista2.innerHTML = response;
                    //\$(\"#popup\").fadeIn(200, \"linear\");
                    //\$(\"#popup_frame\").html(response);
                }
            });
        }
    </script>
    <script src=\"";
        // line 1215
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bootstrap"), "html", null, true);
        echo "/js/bootstrap.min.js\"></script>



    <div style=\"position:fixed;bottom:0px;height:70px;width:100%;text-align: center;z-index: 101; margin-bottom: 20px;\">
        <iframe style=\"border:0px;padding: 0px;width:70%;\" id=\"frm33\" src=\"";
        // line 1220
        echo $this->env->getExtension('routing')->getPath("cliente_ticker");
        echo "\"></iframe>
    </div>
";
    }

    public function getTemplateName()
    {
        return "ClienteBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1747 => 1220,  1739 => 1215,  1718 => 1197,  1631 => 1113,  1627 => 1112,  1487 => 975,  1443 => 934,  1414 => 908,  1410 => 907,  1403 => 905,  1384 => 889,  1364 => 872,  1348 => 859,  1331 => 845,  1315 => 832,  1298 => 818,  1282 => 805,  1266 => 792,  1222 => 750,  1213 => 746,  1202 => 740,  1199 => 739,  1196 => 738,  1179 => 726,  1176 => 725,  1173 => 724,  1162 => 718,  1159 => 717,  1157 => 716,  1144 => 708,  1135 => 702,  1130 => 700,  1125 => 697,  1121 => 696,  1102 => 679,  1096 => 678,  1089 => 674,  1082 => 672,  1072 => 668,  1069 => 667,  1065 => 666,  1039 => 643,  1036 => 642,  1030 => 641,  1023 => 637,  1019 => 636,  1011 => 634,  1008 => 633,  1004 => 632,  965 => 595,  948 => 580,  940 => 574,  931 => 571,  925 => 569,  921 => 568,  915 => 564,  913 => 563,  903 => 556,  899 => 554,  887 => 547,  876 => 541,  872 => 539,  870 => 538,  865 => 536,  861 => 535,  855 => 532,  847 => 529,  835 => 520,  829 => 516,  825 => 515,  795 => 487,  784 => 482,  775 => 478,  770 => 476,  765 => 473,  761 => 472,  739 => 452,  733 => 451,  726 => 447,  718 => 444,  713 => 442,  709 => 440,  707 => 439,  704 => 438,  700 => 437,  685 => 425,  640 => 383,  629 => 374,  617 => 364,  607 => 360,  598 => 356,  592 => 352,  588 => 351,  576 => 341,  574 => 340,  567 => 336,  562 => 333,  554 => 331,  549 => 330,  545 => 329,  537 => 324,  525 => 315,  519 => 312,  515 => 311,  503 => 302,  484 => 285,  478 => 284,  471 => 280,  466 => 278,  457 => 272,  453 => 271,  449 => 270,  445 => 269,  441 => 268,  438 => 267,  433 => 264,  427 => 261,  424 => 260,  422 => 259,  416 => 255,  409 => 251,  404 => 249,  397 => 245,  391 => 242,  387 => 241,  383 => 240,  379 => 239,  375 => 238,  372 => 237,  365 => 232,  356 => 228,  352 => 226,  350 => 225,  345 => 223,  341 => 221,  338 => 220,  332 => 219,  329 => 218,  326 => 217,  323 => 216,  320 => 215,  315 => 214,  312 => 213,  307 => 212,  304 => 211,  302 => 210,  295 => 206,  291 => 205,  284 => 203,  253 => 174,  239 => 162,  230 => 159,  226 => 158,  223 => 157,  219 => 156,  107 => 46,  105 => 45,  86 => 28,  83 => 27,  74 => 22,  62 => 13,  58 => 12,  53 => 10,  48 => 8,  43 => 6,  39 => 5,  35 => 4,  32 => 3,  29 => 2,);
    }
}
