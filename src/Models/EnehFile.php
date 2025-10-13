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
     * Appendable columns
     *
     * @var array
     */
    public $appends = [
        'file_url'
    ];


    /**
     * file_url
     *
     * @return string
     */
    public function getFileUrlAttribute()
    {
        return config('eneh-filemanager.url_prefix', '/storage') . '/' . $this->path;
    }


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


    /**
     * Find by Uuid
     *
     * @param string $uuid
     * @return static|null
     */
    public static function findByUuid($uuid)
    {
        return static::where('uuid', $uuid)->firstOrFail();
    }
}
