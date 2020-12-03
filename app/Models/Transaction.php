<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
      'category_id','amount','note','user_id'
    ];

    protected $appends=['type'];
    public function  category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function getTypeAttribute()
    {
        return $this->category->type;
    }

}
