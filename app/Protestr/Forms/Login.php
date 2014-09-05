<?php namespace Protestr\Forms;

class Login extends Form {

  /**
   * Validation rules for logging up
   *
   * @var array
   */
  protected $rules = [
    'email'    => 'required|email',
    'password' => 'required',
  ];

  protected $filters = [
    'email' => 'trim|strtolower',
  ];

}
