<?php

class Comment extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'comments';

  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo('User');
  }

  public function upvotes()
  {
    return $this->belongsToMany('User');
  }

  public function toggleVote($user_id)
  {
    $this->upvoted($user_id) > 0 ? $this->upvotes()->detach($user_id) :
      $this->upvotes()->attach($user_id);
    $this->save();
  }

  public function upvoted($user_id)
  {
    return $this->upvotes()->where('user_id', $user_id)->count() > 0 ?
      true : false;
  }

}