<?php namespace Fotheby\Controllers;

class DatePeriodSelection extends Controller
{

  public function display()
  {

    session_start();
    if ( array_key_exists('dates', $_SESSION) )
    {
      $data['dates'] = $_SESSION['dates'];
    }

    $data['action'] = 'date-period-selected';
    $data['method'] = 'GET';

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
      if ( $value !== "" )
      {
        $date = [
          'label' => join(" ", preg_split("/(?=[A-Z])/", $key)), // REFERENCE: http://stackoverflow.com/questions/8998382/php-explode-at-capital-letters
          'value' => $value
        ];
        $dates[$key] = $date;
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