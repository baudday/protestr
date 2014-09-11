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
    return $this->belongsToMany('User')->orderBy('username');
  }

  public function scopeUpcoming($query)
  {
    return $query->where('when_date', '>', time());
  }

  public function scopePopular($query)
  {
    return $query->select(DB::raw('*, count(*) as attendeeCount'))
          ->join('protest_user', 'protests.id', '=', 'protest_user.protest_id')
          ->groupBy('protest_id')
          ->orderBy('attendeeCount', 'desc');
  }

}
