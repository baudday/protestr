<?php

class Topic extends Eloquent {

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'topics';

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */

    protected $guarded = [];

    public function protests()
    {
        return $this->hasMany('Protest');
    }

}