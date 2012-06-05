<?php namespace Services;

class UserValidator extends \Laravel\Validator {
  public $validation;

  public function __construct($input)
  {
    $rules = array(
      'firstName' => 'required|max:35',
      'lastName' => 'required|max:35',
      'email' => 'required|max:120|email|unique:user',
      'password' => 'required|confirmed',
    );

    $this->validation = \Laravel\Validator::make($input, $rules);

    return $this;
  }

  public function fails()
  {
    return $this->validation->fails();
  }

  public function errors()
  {
    return $this->validation;
  }
}