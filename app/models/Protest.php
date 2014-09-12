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

}
