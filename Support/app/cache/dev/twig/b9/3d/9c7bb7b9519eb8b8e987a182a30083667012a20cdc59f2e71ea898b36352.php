<?php

/* ClienteBundle:Default:usuarios.html.twig */
class __TwigTemplate_b93d9c7bb7b9519eb8b8e987a182a30083667012a20cdc59f2e71ea898b36352 extends Twig_Template
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
        <title id='Description'>This example shows how to create a Grid from JSON data.</title>
        <link rel=\"stylesheet\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/styles/jqx.base.css\" type=\"text/css\" />
        <link rel=\"stylesheet\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/styles/jqx.ui-redmond.css\" type=\"text/css\" />
        <script type=\"text/javascript\" src=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/scripts/jquery-1.10.2.min.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxcore.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxdata.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxbuttons.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxscrollbar.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxlistbox.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxdropdownlist.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxmenu.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxgrid.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxgrid.filter.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxgrid.sort.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxgrid.edit.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxgrid.selection.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxpanel.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxcalendar.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxdatetimeinput.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxgrid.pager.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxnumberinput.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/jqxgrid.grouping.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/scripts/demos.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/jqwidgets/globalization/globalize.js\"></script>
        <style>
            .imggrid{
                border-radius: 5px;
            }
        </style>    
        <script type=\"text/javascript\">
            \$(document).ready(function() {
                var url = \"";
        // line 35
        echo $this->env->getExtension('routing')->getPath("cliente_listar");
        echo "\";
                var source =
                        {
                            datatype: \"json\",
                            datafields:
                                    [
                                        {name: 'interno', type: 'string'},
                                        {name: 'name', type: 'string'},
                                        {name: 'cargo', type: 'string'},
                                        {name: 'ci', type: 'string'},
                                        {name: 'ip', type: 'string'},
                                        {name: 'email', type: 'string'},
                                        {name: 'telefono', type: 'string'},
                                        {name: 'movil', type: 'string'},
                                        {name: 'direccion', type: 'string'},
                                        {name: 'dependede', type: 'string'},
                                        {name: 'foto', type: 'string'}
                                    ],
                            id: 'id',
                            url: url
                        };
                var imagerenderer = function(row, datafield, value) {
                    return '<img onError=\"this.src='+String.fromCharCode(39)+'";
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/new-user.png'+String.fromCharCode(39)+'\" class=\"imggrid\" width=\"45\" height=\"50\" src=\"https://siemi.oopp.gob.bo/doccargados/rrhh/' + value + '\"/>';
                }
                var dataAdapter = new \$.jqx.dataAdapter(source);
                \$(\"#jqxgrid\").jqxGrid(  
                        {
                            width: '100%',
                            height: 450,
                            source: dataAdapter,
                            showfilterrow: true,
                            filterable: true,
                            sortable: true,
                            theme:'ui-redmond',
                            selectionmode: 'singlecell',
                            scrollmode: 'deferred',
                            scrollfeedback: function(row)
                            {
                                return '<table style=\"height: 150px;width:110px;\"><tr><td><img onError=\"this.src='+String.fromCharCode(39)+'";
        // line 73
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/new-user.png'+String.fromCharCode(39)+'\" height=\"90\" src=\"https://siemi.oopp.gob.bo/doccargados/rrhh/' + row.foto + '\"/></td></tr><tr><td>' + row.name + '</td></tr></table>';
                            },
                            rowsheight: 50,
                            columns: [
                                {text: 'Foto', filtertype: 'none',datafield: 'foto', width: 45, cellsrenderer: imagerenderer},
                                {text: 'Int', columntype: 'textbox', filtertype: 'textbox', datafield: 'interno', width: 50},
                                {text: 'Nombre(s) y Apellidos', filtertype: 'textbox', datafield: 'name', width: 300},
                                {text: 'Cargo', datafield: 'cargo', columntype: 'textbox', filtertype: 'textbox', width: 200, cellsformat: 'd'},
                                {text: 'CI', datafield: 'ci', columntype: 'textbox', filtertype: 'textbox', width: 100},
                                {text: 'IP', datafield: 'ip', columntype: 'textbox', filtertype: 'textbox', width: 100},
                                {text: 'Correo electrónico', datafield: 'email', columntype: 'textbox', filtertype: 'textbox', width: 200},
                                {text: 'Teléfono', datafield: 'telefono', columntype: 'textbox', filtertype: 'textbox', width: 100},
                                {text: 'Móvil', datafield: 'movil', columntype: 'textbox', filtertype: 'textbox', width: 100},
                                {text: 'Dirección', datafield: 'direccion', columntype: 'textbox', filtertype: 'textbox', width: 200}
                                
                            ]
                        });
            });
        </script>
    </head>
    <body class='default'>
        <div id=\"jqxgrid\" style=\"width: 100%;font-size: 13px; font-family: Verdana; float: left;\">
        </div>
    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "ClienteBundle:Default:usuarios.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  168 => 73,  149 => 57,  124 => 35,  113 => 27,  109 => 26,  105 => 25,  101 => 24,  97 => 23,  93 => 22,  89 => 21,  85 => 20,  81 => 19,  77 => 18,  73 => 17,  69 => 16,  65 => 15,  61 => 14,  57 => 13,  53 => 12,  49 => 11,  45 => 10,  41 => 9,  37 => 8,  33 => 7,  29 => 6,  25 => 5,  19 => 1,);
    }
}
