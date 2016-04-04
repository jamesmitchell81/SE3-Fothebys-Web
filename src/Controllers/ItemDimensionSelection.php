<?php namespace Fotheby\Controllers;

class ItemDimensionSelection extends Controller
{

  public function display()
  {
    $data = [];

    session_start();
    if ( array_key_exists('dimensions', $_SESSION) )
    {
      $data['dimensions'] = $_SESSION['dimensions'];
    }

    $measures = [
      'Metric' => ['m', 'cm', 'mm'],
      'Imperial' => ['yd', 'ft', 'in']
    ];

    $data['measures'] = $measures;
    $data['action'] = 'item-dimensions-set';
    $data['method'] = 'GET';

    $html = $this->view->render("ItemDimensionEntry", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $assoc = true;
    $data = json_decode($this->request->getParameter("json"), $assoc);

    $dimensions = [];
    foreach ($data as $key => $value)
    {
      if ( (gettype($value) == "boolean") )
      {
        if ($value)
        {
          $dimensions['unit'] = $key;
          break;
        }
      }
    }

    foreach ($data as $key => $value)
    {
      if ( (gettype($value) == "string") && ($value !== "") )
      {
        $dimensions[$key] = $value;
      }
    }

    session_start();
    $_SESSION['dimensions'] = $dimensions;
  }

  public function retrieve()
  {
    session_start();
    $dimensions = $_SESSION['dimensions'];

    $data = [
      'dimensions' => $dimensions
    ];

    $html = $this->view->render("ItemDimensionDetails", $data);
    $this->response->setContent($html);
  }
}



