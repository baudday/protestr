<?php namespace Protestr\Forms;

use Protestr\Validators\CustomValidators;

class CreateProtest extends Form {

  /**
   * Validation rules for logging up
   *
   * @var array
   */
  protected $rules = [
    'mission'   => 'required',
    'type'     => 'required',
    'history'   => 'required',
    'plan'      => 'required',
    'date'      => 'required|date|notPast',
    'time'      => 'time',
    'website'   => 'active_url',
  ];

  protected $filters = [
    'mission'   => 'trim|strip_tags',
    'history'   => 'trim|strip_tags',
    'plan'      => 'trim|strip_tags',
    'website'   => 'trim|strip_tags|website',
    'address'   => 'trim|strip_tags',
    'city'      => 'trim|strip_tags',
    'date'      => 'trim|strip_tags',
    'time'      => 'trim|strip_tags|time',
  ];

  public function sanitizeTime($time)
  {
    $pattern = '/^([0-9]|0[0-9]|1[0-9]|2[0-3])(?>:?)(?>([0-5][0-9])?)(?> ?)(?>(AM|PM|am|pm)?)$/';
    preg_match($pattern, $time, $matches);
    if ($time == '') return;
    if (!isset($matches[1])) return 'invalid';
    $hours = $matches[1];
    $minutes = isset($matches[2]) ? $matches[2] : '00';
    $minutes = $minutes == '' ? '00' : $minutes;
    $amPm = isset($matches[3]) ? $matches[3] : '';
    return rtrim("$hours:$minutes $amPm");
  }

  public function sanitizeWebsite($value)
  {
    $http = substr($value, 0, 7);
    if ($value !== '' && $http !== 'http://') return "http://$value";
    return $value;
  }

}
