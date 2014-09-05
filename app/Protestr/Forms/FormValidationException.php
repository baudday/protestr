<?php namespace Protestr\Forms;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Contracts\MessageProviderInterface;

class FormValidationException extends \Exception implements MessageProviderInterface {

  protected $errors;

  function __construct($message, MessageBag $errors)
  {
    $this->errors = $errors;

    parent::__construct($message);
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function getMessageBag()
  {
    return $this->getErrors();
  }

}
