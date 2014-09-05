<?php namespace Protestr\Forms;

trait FormSanitizer {

  public function sanitize(array $data, array $filters = null)
  {
    $filters = $filters ?: $this->getFilters();

    foreach ($filters as $field => $sanitizers) {
      if ( ! isset($data[$field])) continue;
      $data[$field] = $this->applySanitizersTo($data[$field], $sanitizers);
    }

    return $data;
  }

  private function splitSanitizers($sanitizers)
  {
    return is_array($sanitizers) ? $sanitizers : explode('|', $sanitizers);
  }

  private function applySanitizersTo($value, $sanitizers)
  {
    foreach ($this->splitSanitizers($sanitizers) as $sanitizer) {
      $method = 'sanitize' . ucwords($sanitizer);

      $value = method_exists($this, $method)
        ? call_user_func([$this, $method], $value)
        : call_user_func($sanitizer, $value);
    }

    return $value;
  }

  public function getFilters()
  {
    return $this->filters;
  }

}
