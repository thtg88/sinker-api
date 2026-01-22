<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @psalm-suppress MissingTemplateParam
 */
abstract class Model extends BaseModel
{
    use HasFactory;
}
