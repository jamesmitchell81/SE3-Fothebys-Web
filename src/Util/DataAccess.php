<?php namespace Fotheby\Util;

class DataAccess
{
  private $rootPath = "http://localhost:8080/services/";
  private $curl;

  private function setUp()
  {
    $this->curl = curl_init();

    // authenticiation.
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");
  }

  private function clearDown()
  {
    curl_close($this->curl);
  }

  public function get($resource)
  {
    $this->setUp();
    $url = $this->rootPath . $resource;
    curl_setopt($this->curl, CURLOPT_URL, $url);
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($this->curl);

    $this->clearDown();
    return $result;
  }

  public function post()
  {

    return $result;
  }

  public function put()
  {
    $this->setUp();
    $url = $this->rootPath . $resource;

    // CURLOPT_PUT

    curl_setopt($this->curl, CURLOPT_URL, $url);
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($this->curl);

    $this->clearDown();
    return $result;
  }

  public function delete()
  {

    return $result;
  }


}