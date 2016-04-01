<?php namespace Fotheby\Util;

class Session
{
  public function __construct()
  {
    if ( session_status() != PHP_SESSION_ACTIVE)
    {
        session_start();
    }
  }

  public function redirect_on_failed_validation($key, $value, $redirect = "index.php")
  {
    if ( isset($_SESSION[$key]) )
    {
      if ( !($_SESSION[$key] === $value) ) {
        $this->clear();
        if ( strlen($redirect) > 0 ) header("Location: {$redirect}");
      }
    } else {
      if ( strlen($redirect) > 0 ) header("Location: {$redirect}");
    }
  }

  public static function set($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  public static function get($key)
  {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : "";
  }

  public static function is_set($key)
  {
    return isset($_SESSION[$key]);
  }

  public static function clear()
  {
    session_destroy();
    $_SESSION = [];
  }
}


?>