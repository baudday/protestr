<?php namespace Protestr\Forms;

use Protestr\Validators\CustomValidators;

class CreateComment extends Form {

  /**
   * Validation rules for creating update
   *
   * @var array
   */
  protected $rules = [
    'comment'  => 'required',
  ];

  protected $filters = [
    'comment'  => 'trim|strip_tags',
  ];

}
