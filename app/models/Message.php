<?php

class Message extends Eloquent {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'messages';

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */

  protected $guarded = [];

  public function scopeSentBy($query, $senderId)
  {
    return $query->where('sender_id', $senderId);
  }

  public function scopeReceivedBy($query, $receiverId)
  {
    $query->where('receiver_id', $receiverId);
  }

  public function scopeThread($query, $senderId, $receiverId)
  {
    $query->where('sender_id', $senderId)
          ->orWhere('sender_id', $receiverId)
          ->where('receiver_id', $receiverId)
          ->orWhere('receiver_id', $senderId)
          ->orderBy('created_at', 'asc');
  }

  public function sender()
  {
    return $this->belongsTo('User', 'sender_id');
  }

}
