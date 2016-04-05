<?php

/* @Twig/Exception/exception_full.html.twig */
class __TwigTemplate_a2ab834206768f9b4d261e66798b40d5228d5c0fc129b5148b9804961907cd76 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "@Twig/Exception/exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Twig/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_3337031a1c84c2e95ca952af4ef1f73f3a12de6d14e292dded915ace012ff468 = $this->env->getExtension("native_profiler");
        $__internal_3337031a1c84c2e95ca952af4ef1f73f3a12de6d14e292dded915ace012ff468->enter($__internal_3337031a1c84c2e95ca952af4ef1f73f3a12de6d14e292dded915ace012ff468_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_3337031a1c84c2e95ca952af4ef1f73f3a12de6d14e292dded915ace012ff468->leave($__internal_3337031a1c84c2e95ca952af4ef1f73f3a12de6d14e292dded915ace012ff468_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_8b0e2246ce82efd03b1252cdd6497f3f8f5285a806e4798b8b15079f18e8c545 = $this->env->getExtension("native_profiler");
        $__internal_8b0e2246ce82efd03b1252cdd6497f3f8f5285a806e4798b8b15079f18e8c545->enter($__internal_8b0e2246ce82efd03b1252cdd6497f3f8f5285a806e4798b8b15079f18e8c545_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_8b0e2246ce82efd03b1252cdd6497f3f8f5285a806e4798b8b15079f18e8c545->leave($__internal_8b0e2246ce82efd03b1252cdd6497f3f8f5285a806e4798b8b15079f18e8c545_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_045a1b9d0982a2ebdcad0b44e1a6a3da8df537c247c19c9148ff9a80418e7e59 = $this->env->getExtension("native_profiler");
        $__internal_045a1b9d0982a2ebdcad0b44e1a6a3da8df537c247c19c9148ff9a80418e7e59->enter($__internal_045a1b9d0982a2ebdcad0b44e1a6a3da8df537c247c19c9148ff9a80418e7e59_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_045a1b9d0982a2ebdcad0b44e1a6a3da8df537c247c19c9148ff9a80418e7e59->leave($__internal_045a1b9d0982a2ebdcad0b44e1a6a3da8df537c247c19c9148ff9a80418e7e59_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_081e32a78881a51dcddd153f5c113ebaed85c98dcc15e8dc852330639ad66b3c = $this->env->getExtension("native_profiler");
        $__internal_081e32a78881a51dcddd153f5c113ebaed85c98dcc15e8dc852330639ad66b3c->enter($__internal_081e32a78881a51dcddd153f5c113ebaed85c98dcc15e8dc852330639ad66b3c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_081e32a78881a51dcddd153f5c113ebaed85c98dcc15e8dc852330639ad66b3c->leave($__internal_081e32a78881a51dcddd153f5c113ebaed85c98dcc15e8dc852330639ad66b3c_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@Twig/layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include '@Twig/Exception/exception.html.twig' %}*/
/* {% endblock %}*/
/* */
