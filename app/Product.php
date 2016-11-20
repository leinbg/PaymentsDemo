<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @package App
 */
class Product extends Model
{

    /**
     * @var array
     */
    protected $casts = [
        'price' => 'integer'
    ];
}
