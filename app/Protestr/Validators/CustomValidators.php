<?php namespace Protestr\Validators;

class CustomValidators extends \Illuminate\Validation\Validator {

  public function validateNotPast($field, $value, $parameters)
  {
    return time() < strtotime($value);
  }

  public function validateTime($field, $value, $parameters)
  {
    return $value !== 'invalid';
  }

  protected function replaceNotPast($message, $attribute, $rule, $parameters)
  {
    return 'Date cannot be in the past.';
  }

  protected function replaceTime($message, $attribute, $rule, $parameters)
  {
    return 'Invalid time supplied.';
  }

}
