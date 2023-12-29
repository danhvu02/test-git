<?php

namespace App\Models;

use App\Filters\V1\InvoicesFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function scopePerformSearch($query)
    {
        $filter = new InvoicesFilter();
        $queryItems = $filter->transform(request());

        if (!empty($queryItems)) {
            return $query->where($queryItems);
        }

        return $query;
    }
}
