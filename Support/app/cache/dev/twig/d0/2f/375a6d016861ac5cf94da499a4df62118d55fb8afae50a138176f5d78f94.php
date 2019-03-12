<?php

/* ::cliente.html.twig */
class __TwigTemplate_d02f375a6d016861ac5cf94da499a4df62118d55fb8afae50a138176f5d78f94 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'scripts' => array($this, 'block_scripts'),
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
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
        <link href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/css/font-awesome.min.css\" rel=\"stylesheet\"/>
        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/12.png\" />
        <link rel=\"stylesheet\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/slide.css\" type=\"text/css\" media=\"screen\" />
\t<script src=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/js/jquery-1.7.2.min.js\" type=\"text/javascript\"></script>
\t<script src=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/js/slide.js\" type=\"text/javascript\"></script>
\t<link href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/css/ticker-style.css\" rel=\"stylesheet\" type=\"text/css\" />
\t<script src=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundleCliente"), "html", null, true);
        echo "/js/jquery.ticker.js\" type=\"text/javascript\"></script>
        ";
        // line 15
        $this->displayBlock('scripts', $context, $blocks);
        // line 17
        echo "    </head>
    <body>
        ";
        // line 19
        $this->displayBlock('body', $context, $blocks);
        // line 20
        echo "        
    </body>
    
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Solicitud de Soporte";
    }

    // line 15
    public function block_scripts($context, array $blocks = array())
    {
        // line 16
        echo "        ";
    }

    // line 19
    public function block_body($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::cliente.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 19,  87 => 16,  84 => 15,  78 => 5,  70 => 20,  68 => 19,  64 => 17,  54 => 13,  50 => 12,  46 => 11,  42 => 10,  38 => 9,  34 => 8,  28 => 5,  22 => 1,  1747 => 1220,  1739 => 1215,  1718 => 1197,  1631 => 1113,  1627 => 1112,  1487 => 975,  1443 => 934,  1414 => 908,  1410 => 907,  1403 => 905,  1384 => 889,  1364 => 872,  1348 => 859,  1331 => 845,  1315 => 832,  1298 => 818,  1282 => 805,  1266 => 792,  1222 => 750,  1213 => 746,  1202 => 740,  1199 => 739,  1196 => 738,  1179 => 726,  1176 => 725,  1173 => 724,  1162 => 718,  1159 => 717,  1157 => 716,  1144 => 708,  1135 => 702,  1130 => 700,  1125 => 697,  1121 => 696,  1102 => 679,  1096 => 678,  1089 => 674,  1082 => 672,  1072 => 668,  1069 => 667,  1065 => 666,  1039 => 643,  1036 => 642,  1030 => 641,  1023 => 637,  1019 => 636,  1011 => 634,  1008 => 633,  1004 => 632,  965 => 595,  948 => 580,  940 => 574,  931 => 571,  925 => 569,  921 => 568,  915 => 564,  913 => 563,  903 => 556,  899 => 554,  887 => 547,  876 => 541,  872 => 539,  870 => 538,  865 => 536,  861 => 535,  855 => 532,  847 => 529,  835 => 520,  829 => 516,  825 => 515,  795 => 487,  784 => 482,  775 => 478,  770 => 476,  765 => 473,  761 => 472,  739 => 452,  733 => 451,  726 => 447,  718 => 444,  713 => 442,  709 => 440,  707 => 439,  704 => 438,  700 => 437,  685 => 425,  640 => 383,  629 => 374,  617 => 364,  607 => 360,  598 => 356,  592 => 352,  588 => 351,  576 => 341,  574 => 340,  567 => 336,  562 => 333,  554 => 331,  549 => 330,  545 => 329,  537 => 324,  525 => 315,  519 => 312,  515 => 311,  503 => 302,  484 => 285,  478 => 284,  471 => 280,  466 => 278,  457 => 272,  453 => 271,  449 => 270,  445 => 269,  441 => 268,  438 => 267,  433 => 264,  427 => 261,  424 => 260,  422 => 259,  416 => 255,  409 => 251,  404 => 249,  397 => 245,  391 => 242,  387 => 241,  383 => 240,  379 => 239,  375 => 238,  372 => 237,  365 => 232,  356 => 228,  352 => 226,  350 => 225,  345 => 223,  341 => 221,  338 => 220,  332 => 219,  329 => 218,  326 => 217,  323 => 216,  320 => 215,  315 => 214,  312 => 213,  307 => 212,  304 => 211,  302 => 210,  295 => 206,  291 => 205,  284 => 203,  253 => 174,  239 => 162,  230 => 159,  226 => 158,  223 => 157,  219 => 156,  107 => 46,  105 => 45,  86 => 28,  83 => 27,  74 => 22,  62 => 15,  58 => 14,  53 => 10,  48 => 8,  43 => 6,  39 => 5,  35 => 4,  32 => 3,  29 => 2,);
    }
}
