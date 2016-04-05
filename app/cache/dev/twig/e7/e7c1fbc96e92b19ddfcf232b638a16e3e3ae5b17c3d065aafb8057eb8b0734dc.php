<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_8f609a678251c9fc20d3e7092d7d853be660905541574e82115c6cc730930a6e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_5ab3c37df26f579b2536c308348f9ab15817ea36d5b3620d24b23374863bad11 = $this->env->getExtension("native_profiler");
        $__internal_5ab3c37df26f579b2536c308348f9ab15817ea36d5b3620d24b23374863bad11->enter($__internal_5ab3c37df26f579b2536c308348f9ab15817ea36d5b3620d24b23374863bad11_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5ab3c37df26f579b2536c308348f9ab15817ea36d5b3620d24b23374863bad11->leave($__internal_5ab3c37df26f579b2536c308348f9ab15817ea36d5b3620d24b23374863bad11_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_3e72fdc7686c55ef4a48a342d8a94ca3cbf83260407bb998dcb02b4b2fb32ee3 = $this->env->getExtension("native_profiler");
        $__internal_3e72fdc7686c55ef4a48a342d8a94ca3cbf83260407bb998dcb02b4b2fb32ee3->enter($__internal_3e72fdc7686c55ef4a48a342d8a94ca3cbf83260407bb998dcb02b4b2fb32ee3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_3e72fdc7686c55ef4a48a342d8a94ca3cbf83260407bb998dcb02b4b2fb32ee3->leave($__internal_3e72fdc7686c55ef4a48a342d8a94ca3cbf83260407bb998dcb02b4b2fb32ee3_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_92e768eb483e21db1f8ea792ec4db9d2e6a9a5318744e1b2f6c4618a8089791e = $this->env->getExtension("native_profiler");
        $__internal_92e768eb483e21db1f8ea792ec4db9d2e6a9a5318744e1b2f6c4618a8089791e->enter($__internal_92e768eb483e21db1f8ea792ec4db9d2e6a9a5318744e1b2f6c4618a8089791e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_92e768eb483e21db1f8ea792ec4db9d2e6a9a5318744e1b2f6c4618a8089791e->leave($__internal_92e768eb483e21db1f8ea792ec4db9d2e6a9a5318744e1b2f6c4618a8089791e_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_9dabf489a364b56f9a921cbc4d2050eb33bb579d911528149ee2622ba0ba445b = $this->env->getExtension("native_profiler");
        $__internal_9dabf489a364b56f9a921cbc4d2050eb33bb579d911528149ee2622ba0ba445b->enter($__internal_9dabf489a364b56f9a921cbc4d2050eb33bb579d911528149ee2622ba0ba445b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_9dabf489a364b56f9a921cbc4d2050eb33bb579d911528149ee2622ba0ba445b->leave($__internal_9dabf489a364b56f9a921cbc4d2050eb33bb579d911528149ee2622ba0ba445b_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block toolbar %}{% endblock %}*/
/* */
/* {% block menu %}*/
/* <span class="label">*/
/*     <span class="icon">{{ include('@WebProfiler/Icon/router.svg') }}</span>*/
/*     <strong>Routing</strong>*/
/* </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     {{ render(path('_profiler_router', { token: token })) }}*/
/* {% endblock %}*/
/* */
