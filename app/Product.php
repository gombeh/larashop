<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Nicolaslopezj\Searchable\SearchableTrait;


class Product extends Model
{
    use SearchableTrait;
    use Searchable;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
        'products.name' => 10,
        'products.details' => 5,
        'products.description' => 2,
        ]
    ];

    public function categories() {
        return $this->belongsToMany('App\Category');
    }

    public function presentPrice() {
        return '$' . number_format($this->price, 2);
    }

    public function scopeMightAlsoLike($query) {
        $query->inRandomOrder()->take(4);
    }
}