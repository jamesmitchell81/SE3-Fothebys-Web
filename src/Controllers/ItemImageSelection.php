<?php namespace Fotheby\Controllers;

use Fotheby\Util\DataAccess;

class ItemImageSelection extends Controller
{
  public function display()
  {
    $data = [];

    $html = $this->view->render("ItemImageEntry", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $assoc = true;
    $data = json_decode($this->request->getParameter("json"), $assoc);

    // send to server and validate

    session_start();
    $_SESSION['images'] = $data;
  }


  public function retrieve()
  {
    session_start();
    $client = $_SESSION['images'];

    // get from server.

    $data = [
      'images' => $images
    ];

    $html = $this->view->render("ItemImagesEntered", $data);
    $this->response->setContent($html);
  }

  public function upload()
  {
    $data = file_get_contents("php://input");
    $data = str_replace("data:image/jpeg;base64,", "", $data);

    $da = new DataAccess();
    $result = $da->post("item-images/dude", $data);
    // var_dump($result);

    $result = $da->get("item-images/1");
    // var_dump($result);

    $json = json_decode($result, true);

    $d = $json['data'];

    echo "<img src='data:image/png;base64," . $d ."'/>";
  }
}


