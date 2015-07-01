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

  public function user()
  {
    return $this->belongsTo('User');
  }

  public function topic()
  {
    return $this->belongsTo('Topic');
  }

  public function attendees()
  {
    return $this->belongsToMany('User')->orderBy('username');
  }

  public function updates()
  {
    return $this->hasMany('Update')->orderBy('created_at', 'desc');
  }

  public function comments()
  {
    return $this->hasMany('Comment')
      ->where('parent', 0);
  }

  public function scopeUpcoming($query)
  {
    return $query->where('when_date', '>', time());
  }

  public function scopePopular($query)
  {
    return $query->select(DB::raw('protests.*, count(protest_user.protest_id) as attendeeCount'))
          ->leftJoin('protest_user', 'protests.id', '=', 'protest_user.protest_id')
          ->groupBy('id')
          ->orderBy('attendeeCount', 'desc');
  }

  public function scopeNear($query, $lat, $lon)
  {
    $MILE_LAT = 1/69.11;
    $MILE_LON = 1/(69.11*cos($lat));
    $lat_radius = 10*$MILE_LAT;
    $lon_radius = 10*$MILE_LON;

    return $query->whereBetween('latitude', [
              min($lat-$lat_radius, $lat+$lat_radius),
              max($lat-$lat_radius, $lat+$lat_radius)
            ])
            ->whereBetween('longitude', [
              min($lon-$lon_radius, $lon+$lon_radius),
              max($lon-$lon_radius, $lon+$lat_radius)
            ]);
  }

  public function scopeLocationLess($query)
  {
    return $query->whereLatitude(0)->whereLongitude(0);
  }

  public function toggleAttending($user_id)
  {
    $this->attending($user_id) ? $this->attendees()->detach($user_id)
      : $this->attendees()->attach($user_id);
    $this->save();
  }

  public function attending($user_id)
  {
    return $this->attendees()->where('user_id', $user_id)->count() > 0 ?
      true : false;
  }

}
