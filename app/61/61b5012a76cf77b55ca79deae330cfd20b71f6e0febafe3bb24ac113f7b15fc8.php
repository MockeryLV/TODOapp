<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* main.template.php */
class __TwigTemplate_c93e7c53de877e1ebbf459c6a82c257e01c2bd4547ae45732da010f61caf419c extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<?php

require_once 'partials/header.php';


?>


<body>



    <div class=\"container\">

        <?php foreach (\$todos as \$todo):?>
            <div class=\"box\">
                <?= \$todo->getTitle() ?>
                <br>
                <?= 'Until: ' . \$todo->getDue() ?>
                <br>
                <?php
                    if(\$todo->getStatus() === 'created'){

                        ?>
                        <form action=\"/setstatus\" method=\"post\">
                            <input hidden name=\"status\" value=\"<?=\$todo->getStatus()?>\">
                            <input hidden name=\"id\" value=\"<?=\$todo->getId()?>\">
                            <input class=\"submitButton\" type=\"submit\" class=\"status\" value=\"Done?\">
                        </form>
                        <?php
                    }else{ ?>
                        <form action=\"/setstatus\" method=\"post\">
                                <input hidden name=\"status\" value=\"<?=\$todo->getStatus()?>\">
                                <input hidden name=\"id\" value=\"<?=\$todo->getId()?>\">
                                <input class=\"submitButton\" type=\"submit\" class=\"status\" value=\"Undone?\">
                                </form>
                        <form action=\"/delete\" method=\"post\">
                            <input hidden name=\"id\" value=\"<?=\$todo->getId()?>\">
                            <input class=\"submitButton\" type=\"submit\" value=\"X\">
                        </form>
                <?php
                    }
                ?>

            </div>
        <?php endforeach;?>
        <div class=\"box\">
            <form action=\"/create\" method=\"get\">
                <input  class=\"submitButton\" type=\"submit\" value=\"Add\">
            </form>
        </div>
    </div>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "main.template.php";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "main.template.php", "/mnt/c/users/tripe/desktop/TODOAPP/app/Views/main.template.php");
    }
}
