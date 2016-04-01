<?php

namespace Fotheby\Template;

// Reference
// https://github.com/PatrickLouys/no-framework-tutorial
use Twig_Environment;

class TwigRenderer implements View
{
  private $engine;

  public function __construct(Twig_Environment $engine)
  {
    $this->engine = $engine;
  }

  public function render($template, $data = [])
  {
    return $this->engine->render("$template.html", $data);
  }

}