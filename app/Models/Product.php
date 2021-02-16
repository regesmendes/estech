<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    /**
     * Get the lowest price for the given products considering the account
     * @param array $productList
     * @param ?string $accountRef
     * @return array
     */
    public static function getPrice(array $productList, ?string $accountRef = null): array {

        $qry = DB::select('call getPrices(?,?)', [
            implode(',', $productList),
            $accountRef
        ]);

        return $qry;
    }
}

