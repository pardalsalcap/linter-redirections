<?php

namespace Pardalsalcap\LinterRedirections\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $hash
 * @property string $url
 * @property string $fix
 * @property int $http_status
 * @property string $created_at
 * @property string $updated_at
 */
class Redirection extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['hash', 'url', 'fix', 'http_status', 'created_at', 'updated_at'];
}
