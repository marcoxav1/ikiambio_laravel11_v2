<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\DB;

trait WrapsTransactions
{
    protected function tx(\Closure $callback)
    {
        return DB::transaction($callback);
    }
}
