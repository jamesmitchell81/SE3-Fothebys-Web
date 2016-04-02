<?php namespace Fotheby\Controllers;

class DatePeriodSelection extends Controller
{

  public function display()
  {
    $data = [
      'action' => 'date-period-selected',
      'method' => 'GET'
    ];

    $html = $this->view->render("DatePeriodEntry", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $assoc = true;
    $data = json_decode($this->request->getParameter("json"), $assoc);
    $dates = [];

    foreach ( $data as $key => $value )
    {
      if ( $value['value'] !== "" )
      {
        $date = [
          'id' => $value['key'],
          'label' => str_replace("-", " ", $value['key']),
          'value' => $value['value']
        ];
        $dates[] = $date;
      }
    }

    session_start();
    $_SESSION['dates'] = $dates;
  }

  public function retrieve()
  {
    session_start();
    $dates = $_SESSION['dates'];

    $data = [
      'dates' => $dates
    ];

    $html = $this->view->render("DatePeriodEntered", $data);
    $this->response->setContent($html);
  }

}