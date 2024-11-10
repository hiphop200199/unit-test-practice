<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
   public function items()
   {
    return item::select('content')->take(10)->get();
   }
}
