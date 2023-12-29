<?php

namespace App\Models;

use App\Filters\V1\CustomersFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'email', 'address', 'city', 'state', 'postal_code'];

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function scopePerformSearch($query)
    {
        $filter = new CustomersFilter();
        $queryItems = $filter->transform(request());

        $includeInvoices = request()->query('includeInvoices');

        if (!empty($queryItems)) {
            $query = $query->where($queryItems);
        }

        if ($includeInvoices){
            $query = $query->with('invoices');
        }

        return $query;
    }
}
