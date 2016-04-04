<?php namespace Fotheby\Controllers;

class ItemWeightSelection extends Controller
{

  public function display()
  {
    $data = [];

    session_start();
    if ( array_key_exists('weights', $_SESSION) )
    {
      $data['weights'] = $_SESSION['weights'];
    }

    $measures = [
      'Metric' =>   ['t', 'kg', 'g'],
      'Imperial' => ['st', 'lb', 'oz']
    ];

    $data['measures'] = $measures;
    $data['action'] = 'item-weight-set';
    $data['method'] = 'GET';

    $html = $this->view->render("ItemWeightEntry", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $assoc = true;
    $data = json_decode($this->request->getParameter("json"), $assoc);

    $weights = [];
    foreach ($data as $key => $value)
    {
      if ( (gettype($value) == "boolean") )
      {
        if ($value)
        {
          $weights['unit'] = $key;
          break;
        }
      }
    }

    foreach ($data as $key => $value)
    {
      if ( (gettype($value) == "string") && ($value !== "") )
      {
        $weights[$key] = $value;
      }
    }

    session_start();
    $_SESSION['weights'] = $weights;
  }

  public function retrieve()
  {
    session_start();
    $weights = $_SESSION['weights'];

    $data = [
      'weights' => $weights
    ];

    $html = $this->view->render("ItemWeightSet", $data);
    $this->response->setContent($html);
  }
}



