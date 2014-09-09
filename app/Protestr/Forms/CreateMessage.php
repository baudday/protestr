<?php namespace Protestr\Forms;

use Protestr\Validators\CustomValidators;

class CreateMessage extends Form {

  /**
   * Validation rules for creating a message
   *
   * @var array
   */
  protected $rules = [
    'message' => 'required'
  ];

  protected $filters = [
    'message' => 'trim|strip_tags'
  ];

}
