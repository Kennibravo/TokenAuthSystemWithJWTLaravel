<?php

namespace Workload;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id', 'id_string', 'category_id', 'id_state', 'id_lga', 'title', 'description', 'remote', 'start_date', 'priority', 'budget',
         'contract', 'photo', 'attachment', 'landmark', 'slug', 'status', 'view_count',
    ];

    public function user() {
        return $this->belongsTo(User::class);
      }

    public function category() {
    
        return $this->belongsTo(Category::class);
    }

    public function getCreatedAtAttribute() {
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }

}
