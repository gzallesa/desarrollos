<?php

/* SupportBundle:Default:login.html.twig */
class __TwigTemplate_e3fb3df6485ccb647dfa9c08559d43b09af8e21dfdb22082297d132035f12e26 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 3
        echo "<link rel='stylesheet' href='";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles"), "html", null, true);
        echo "/css/style_1.css' type='text/css' media='all' />
";
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        // line 6
        echo "<div class=\"box\">
    <div style=\"color:red;font-size: 10px;font-family: arial\">";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["err"]) ? $context["err"] : $this->getContext($context, "err")), "html", null, true);
        echo "</div>
    <form action=\"";
        // line 8
        echo $this->env->getExtension('routing')->getPath("support_support_login_check");
        echo "\" method=\"post\">
        <div class=\"input\">
            <i class=\"fa fa-user fa-2x\"></i>
            <input type=\"text\" id=\"username\" name=\"_username\" placeholder=\"nombre de usuario\"/>
        </div>
        <div class=\"input\">
            <i class=\"fa fa-lock fa-2x\"></i>
            <input type=\"password\" id=\"password\" name=\"_password\" placeholder=\"contraseña\"/>
        </div>
    <input class=\"boton\" type=\"submit\" name=\"login\" value=\"Acceder\" />
</form>
</div>    
";
    }

    public function getTemplateName()
    {
        return "SupportBundle:Default:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 8,  45 => 7,  42 => 6,  39 => 5,  32 => 3,  29 => 2,);
    }
}
