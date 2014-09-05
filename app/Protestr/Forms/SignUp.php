<?php namespace Protestr\Forms;

class SignUp extends Form {

  /**
   * Validation rules for signing up
   *
   * @var array
   */
  protected $rules = [
    'email'    => 'required|email|unique:users',
    'username' => 'required|min:3|unique:users',
    'password' => 'required|min:8|confirmed',
  ];

  protected $filters = [
    'email' => 'trim|strtolower',
    'username' => 'trim',
  ];

}
