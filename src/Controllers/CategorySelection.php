<?php namespace Fotheby\Controllers;

use Fotheby\Util\DataAccess;

class CategorySelection extends Controller
{

  public function display()
  {
    $dataAccess = new DataAccess();
    $json = $dataAccess->get('category');
    $list = json_decode($json);

    session_start();
    if ( array_key_exists('category', $_SESSION) )
    {
      $data['selected'] = $_SESSION['category'];
    }

    $data['categories'] = $list;
    $data['action'] = 'category-selected';
    $data['method']  = 'POST';

    $html = $this->view->render("CategorySelection", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $data = json_decode($this->request->getParameter("json"), true);
    $id = (int)preg_replace('/^category-/', '', $data['category']);

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
}