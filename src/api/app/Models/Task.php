<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Task extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task';

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = ['title', 'description', 'status', 'attachment_url'];

    protected static function booted()
    {
        static::creating(fn(Task $task) => $task->uuid = (string) Uuid::uuid4());
    }

}
