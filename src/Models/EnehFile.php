<?php

namespace EnEH2\FileManager\Models;

use Illuminate\Database\Eloquent\Model;

class EnehFile extends Model
{
    /**
     * Boot function
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (EnehFile $enehFile) {
            $enehFile->uuid = (string) \Str::uuid();
        });
    }


    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'path',
        'mime_type',
        'extension',
        'size',
        'disk',
        'visibility',
        'model_type',
        'model_id',
        'auth_type',
        'auth_id',
        'deleted',
    ];


    /**
     * Relation with Related Model
     *
     * @return MorphTo
     */
    public function fileable()
    {
        return $this->morphTo();
    }


    /**
     * Relation with Creator
     *
     * @return MorphTo
     */
    public function authenticable()
    {
        return $this->morphTo();
    }
}
