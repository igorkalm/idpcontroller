<?php

namespace Igorkalm\IDPcontroller\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControllerEvent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'datetime', 'event', 'status', 'data', 'door_id', 'source', 'source_id',
    ];

}
