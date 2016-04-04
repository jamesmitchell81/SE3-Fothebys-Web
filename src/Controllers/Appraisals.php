<?php namespace Fotheby\Controllers;

class Appraisals extends Controller
{
  public function display()
  {
    $data["james"] = "james";
    $html = $this->view->render("ItemAppraisalForm", $data);
    $this->response->setContent($html);
  }

  public function insert()
  {
    $data = $this->request->getParameters();

    var_dump($data);


  }
}
