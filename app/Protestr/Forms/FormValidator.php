<?php namespace Protestr\Forms;

use Illuminate\Validation\Factory as Validator;

trait FormValidator {

  /**
   * @var Validator
   */
  protected $validator;

  protected $validation;

  /**
   * @var Validator $validator
   */
  function __construct(Validator $validator)
  {
    $this->validator = $validator;
  }

  public function validate(array $formData)
  {
    $this->validation = $this->validator->make($formData, $this->getValidationRules());

    if($this->validation->fails())
    {
      throw new FormValidationException('Validation failed', $this->getValidationErrors());
    }

    return true;
  }

  /**
   * @return mixed
   */
  protected function getValidationRules()
  {
    return $this->rules;
  }

  /**
   * @return mixed
   */
  protected function getValidationErrors()
  {
    return $this->validation->errors();
  }

}
