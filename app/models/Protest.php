<?php

class Protest extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'protests';

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */

  protected $guarded = [];

  public function attendees()
  {
    return $this->belongsToMany('User');
  }

  public function scopeUpcoming($query)
  {
    return $query->where('when_date', '>', time());
  }

}
