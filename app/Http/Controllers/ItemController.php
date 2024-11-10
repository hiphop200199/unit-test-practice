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

   public function create(Request $request)
   {
    $content = $request->content;
    item::create(['content'=>$content]);
    return response()->json(['message'=>'create success.']) ;
   }

   public function update(Request $request)
   {
    $content = $request->content;
    $id = $request->id;
    item::where('id','=',$id)->update(['content'=>$content]);
    return response()->json(['message'=>'update success.']) ;
   }
}
