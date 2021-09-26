<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public static function fromArray(array $array): self
    {
        $self = new self();
        // hydrate product from array

        return $self;
    }
}
