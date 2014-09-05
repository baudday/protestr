<?php namespace Protestr\Forms;

abstract class Form {
  use FormValidator;
  use FormSanitizer;
}
