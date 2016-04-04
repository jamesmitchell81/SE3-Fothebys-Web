<?php namespace Fotheby\Controllers;

use Fotheby\Util\DataAccess;
use Fotheby\Util\Session;

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

    session_start();
    $_SESSION['images'] = $data;
  }

  public function retrieve()
  {
    session_start();
    if ( isset($_SESSION['images']) )
    {
      $data = [
        'images' => $_SESSION["images"]
      ];
    }

    $html = $this->view->render("ItemImagesEntered", $data);
    $this->response->setContent($html);
  }

  public function upload()
  {
    $input = file_get_contents("php://input");
    $data = str_replace("data:image/jpeg;base64,", "", $input);
    $data = str_replace("data:image/png;base64,", "", $data);

    $da = new DataAccess();
    $da->setContentType('image/png;base64');
    $response = $da->post("item-images", $data);

    // if not created return early.
    if ( !preg_match('/(201 Created)/', $response) ) {
      $output = [
        'status' => 'failed'
      ];

      $output = json_encode($output);
      $this->response->setContent($output);
      return;
    }

    // only if success!!!!
    $response = preg_split("/\n/", $response);
    $id = 0;
    foreach ($response as $value) {
      if ( preg_match("/(Location:)/", $value))
      {
        $parts = preg_split("/\//", $value);
        $last = count($parts) - 1;
        $id = str_replace("\r", "", $parts[$last]);
      }
    }

    if ( Session::is_set('images') )
    {
      $images = Session::get('images');
    } else {
      $images[] = [
        'id'    => $id,
        'data'  => $input
      ];
      Session::set('images', $images);
    }

    $output = [
      'status' => 'success',
      'id' => $id
    ];

    $output = json_encode($output);
    $this->response->setContent($output);
    // $response = $da->get("item-images/1");
    // var_dump($response);
    // $json = json_decode($response, true);
    // $d = $json['data'];
    // echo "<img src='data:image/png;base64," . $d ."'/>";
  }

  public function remove($params)
  {
    $id = $params['id'];

    $da = new DataAccess();
    $path = "item-images/{$id}";

    $response = $da->delete($path);

    // test $response for ok...
    // remove from session.

    $output = [
      'status' => 'success'
    ];

    $output = json_encode($output);
    $this->response->setContent($output);
  }
}


