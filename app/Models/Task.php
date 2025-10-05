<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title','description','status','priority','due_date','assigned_to','created_by'
    ];

    // user assigned to the task
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // user who created the task
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
