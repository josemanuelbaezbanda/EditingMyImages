<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'images';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'path',
        'user_id',
        'modifications',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'updated_by',
        'deleted_by'
    ];

    /**
     * Get the attributes that should be cast.
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'modifications' => 'array',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
            'deleted_at' => 'datetime:Y-m-d H:i:s'
        ];
    }

    /**
     * Relación con usuarios
     * @return BelongsTo
     */
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
