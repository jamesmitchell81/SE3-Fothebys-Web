<?php namespace Fotheby\Controllers;

use Fotheby\Util\DataAccess;

class CategorySelection extends Controller
{

  public function display()
  {
    $dataAccess = new DataAccess();
    $json = $dataAccess->get('category');
    $list = json_decode($json);

    $data = [
      'categories' => $list,
      'action'  => 'category-selected',
      'method'  => 'POST'
    ];

    $html = $this->view->render("CategorySelection", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $data = json_decode($this->request->getParameter("json"), true);

    foreach ($data as $key => $value) {
      if ( $value['value'] == true )
      {
        $id = (int)preg_replace('/^category-/', '', $value['key']);
      }
    }

    $dataAccess = new DataAccess();
    $json = $dataAccess->get("category/{$id}");
    $list = json_decode($json, true);

    $category = [
      'id' => $id,
      'name' => $list['name']
    ];

    session_start();
    $_SESSION['category'] = $category;
  }

  public function retrieve()
  {
    session_start();
    $category = $_SESSION['category'];

    $data = [
      'category' => $category
    ];

    $html = $this->view->render("CategoryDetails", $data);
    $this->response->setContent($html);
  }

  // public function search($params)
  // {
  //   $dataAccess = new DataAccess();
  //   // $json = $dataAccess->get('expert/search');
  //   $json = $dataAccess->get('expert');
  //   $list = json_decode($json);

  //   $data = [
  //     'experts' => $list
  //   ];

  //   $html = $this->view->render("ExpertSelection", $data);
  //   $this->response->setContent($html);
  // }

}