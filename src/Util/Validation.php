<?php namespace Fotheby\Util;

class Validation
{
  private $feedback = [];
  private $field = "";
  private $value;

  public function passed()
  {
    return (count($this->feedback) == 0);
  }

  public function validate($field, $value)
  {
    $this->field = $field;
    $this->value = $value;
    return $this;
  }

  public function required()
  {
    if ( empty($this->value) )
      $this->feedback[$this->field] = "This field is required";

    return $this;
  }

  public function not($test, $message = "")
  {
    if ( $message == "" ) $message = "This value is incorrect";
    if ( $this->value == $test )
      $this->feedback[$this->field] = $message;

    return $this;
  }

  public function email()
  {
    if ( is_null($this->value) ) return;
    if ( !filter_var($this->value, FILTER_VALIDATE_EMAIL) )
      $this->feedback[$this->field] = "Email Invalid";

    return $this;
  }

  public function numberInt()
  {
    if ( is_null($this->value) ) return;
    if ( !filter_var($this->value, FILTER_VALIDATE_INT) )
      $this->feedback[$this->field] = "Numbers only please";

    return $this;
  }

  public function positiveInt()
  {
    if ( is_null($this->value) ) return;
    if ( !filter_var($this->value, FILTER_VALIDATE_INT) || $this->value <= 0 )
      $this->feedback[$this->field] = "Positive numbers only please";

    return $this;
  }

  public function date()
  {
    //
    return $this;
  }

  public function future()
  {
    if ( is_null($this->value) ) return;
    if ( strtotime($this->value) < time() - (time() - strtotime($this->value)) )
      $this->feedback[$this->field] = "This date occurs in the past";

    return $this;
  }

  public function greaterThan($test = 0)
  {
    if ( is_null($this->value) ) return;
    if ( !($this->value > $test) )
      $this->feedback[$this->field] = "The {$field} needs to be greater then {$test}.";

    return $this;
  }

  public function length($test = 0)
  {
    $length = is_null($this->value) ? 0 : strlen($this->value);
    if ( $length < $test )
      $this->feedback[$this->field] = "The {$field} needs to at least {$test} character.";

    return $this;
  }

  public function ukPostCode()
  {
    if ( is_null($this->value) ) return;
    // beginning of string one||two letters, one number, a space, one number, two letters, end of string!
    $re = "/^([a-z]{1,2}\d\s\d[a-z]{2})$/i";
    if ( !preg_match($re, $this->value) )
      $this->feedback[$this->field] = "This is not a correctly formated uk post code";

    return $this;
  }

  public function noAlphaLetters()
  {
    if ( is_null($this->value) ) return;
    // match any thing that is not a number, -, or space
    $re = "/[^01234567890-\s]+/i";
    // if anything else matches then fail
    if ( preg_match($re, $this->value) )
      $this->feedback[$this->field] = "This field cannot contain letters.";

    return $this;
  }

  public function webUrl()
  {
    if ( is_null($this->value) ) return;
    $re = "/^(http|https)/"; //(://)[a-z-._~0-9]+)/i"
    if ( !preg_match($re, $this->value) || !filter_var($this->value, FILTER_VALIDATE_URL) )
      $this->feedback[$this->field] = "This is not a valid website url.";

    return $this;
  }

  public function passwordMatch($field1, $password1, $field2, $password2)
  {
    if ( is_null($password1) || is_null($password2) ) return;
    if ( !($password1 === $password2) )
    {
      $this->feedback[$field1] = "These passwords do not match.";
      $this->feedback[$field2] = "These passwords do not match.";
    }

    return $this;
  }

  public function feedback()
  {
    return $this->feedback;
  }
}

