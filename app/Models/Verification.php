<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory, HasUuids;

    public const PROPERTY_USER_NAME = 'user_name';

    public const PROPERTY_FILE_TYPE = 'file_type';

    public const PROPERTY_RESULT = 'result';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        self::PROPERTY_USER_NAME,
        self::PROPERTY_FILE_TYPE,
        self::PROPERTY_RESULT,
    ];
}
