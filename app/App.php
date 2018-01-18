<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];

  public function feedItems() {
    $this->hasMany('App\FeedDetail', 'app_bundle_id', 'bundle_id')->withDefault();
  }
}
