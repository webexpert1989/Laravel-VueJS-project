<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feed extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];

  protected $fillable = ['title', 'logo'];

  public function feedDetails()
  {
    return $this->hasMany('App\FeedDetail', 'feed_id')->withDefault();
  }
}