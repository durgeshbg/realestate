<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['workflow_id', 'template', 'created_by', 'updated_by', 'deleted_by'];

    protected $casts = [
        'workflow_id' => 'string',
    ];
}
