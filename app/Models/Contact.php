<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected array with the keys that are valid, when create method get the data array will have access to this keys
    protected $fillable = [
        'user_id',
        'type',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'city',
        'location',
        'birthdate',
        'info'
    ];

     /**
     * Get the user associated with the Entry.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            foreignKey: 'user_id'
        );
    }
}
