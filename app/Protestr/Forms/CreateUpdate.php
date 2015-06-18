<?php namespace Protestr\Forms;

use Protestr\Validators\CustomValidators;

class CreateUpdate extends Form {

  /**
   * Validation rules for creating update
   *
   * @var array
   */
  protected $rules = [
    'title' => 'required',
    'body'  => 'required',
  ];

  protected $filters = [
    'title' => 'trim|strip_tags',
    'body'  => 'trim|strip_tags',
  ];

}
