<?php namespace Protestr\Forms;

class Splash extends Form {

  /**
   * Validation rules for logging up
   *
   * @var array
   */
  protected $rules = [
    'email'    => 'required|email',
  ];

  protected $filters = [
    'email' => 'trim|strtolower',
  ];

}
