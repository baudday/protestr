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
    return $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId)
                ->orWhere('receiver_id', $senderId)
                ->where('sender_id', $receiverId);
  }

  public function scopeThreads($query)
  {
    $sub = $query->orderBy('created_at', 'desc');
    return $query->select(DB::raw('*'))
    ->from(DB::raw("({$sub->toSql()}) as sub"))
    ->groupBy('sender_id');
  }

  public function scopeUnread($query)
  {
    $query->where('read', false);
  }

  public function sender()
  {
    return $this->belongsTo('User', 'sender_id');
  }

}
