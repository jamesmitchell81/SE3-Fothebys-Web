<?php namespace Fotheby\Controllers;

class ExpertSelection extends Controller
{

  public function display()
  {


    $html = $this->view->render("ExpertSelection");
    $this->response->setContent($html);
  }


}