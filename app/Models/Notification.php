<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function isUnread()
    {
        return $this->read_at === null;
    }
}
