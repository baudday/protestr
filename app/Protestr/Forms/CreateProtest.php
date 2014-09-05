<?php namespace Protestr\Forms;

use Carbon\Carbon;

class CreateProtest extends Form {

  /**
   * Validation rules for logging up
   *
   * @var array
   */
  protected $rules = [
    'mission'   => 'required',
    'history'   => 'required',
    'plan'      => 'required',
    'when_date' => 'required',
  ];

  protected $filters = [
    'mission'   => 'trim|strip_tags',
    'history'   => 'trim|strip_tags',
    'plan'      => 'trim|strip_tags',
    'website'   => 'trim|strip_tags',
    'address'   => 'trim|strip_tags',
    'city'      => 'trim|strip_tags',
    'when_date' => 'trim|strip_tags|date',
    'when_time' => 'trim|strip_tags|time',
  ];

  public function sanitizeDate($date)
  {
    return Carbon::createFromTimeStamp(strtotime($date));
  }

  public function sanitizeTime($time)
  {
    return Carbon::createFromTimeStamp(strtotime($time));
  }

  public function validateWhenDate($date)
  {
    dd($date);
  }

}
