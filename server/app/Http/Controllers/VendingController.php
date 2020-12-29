<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\User;
use App\Item;
use App\UserInventory;


class VendingController extends Controller
{
    /**
     * Deposit coin
     *
     * @return \Illuminate\Http\Response
     */
    public function deposit(Request $request)
    {
        $cacheCheck = Cache::has('transaction_'.auth()->user()->id);

        if(empty($cacheCheck)){

            Cache::put('transaction_'.auth()->user()->id,intval($request->get('coin')));

        }else{

            Cache::increment('transaction_'.auth()->user()->id, intval($request->get('coin')));

        }

        $balance = Cache::get('transaction_'.auth()->user()->id);

        return response()->json('', 204)->header('X-Coins', $balance);
    }

    /**
     * Check available Item Inventory
     *
     * @return \Illuminate\Http\Response
     */
    public function inventory()
    {
        $items = Item::get()->pluck('inventory','id')->toArray();;
        
        return response()->json($items, 200);
    }

    /**
     * Purchase a coin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function purchase(Request $request)
    {
        $item_id = intval($request->id);
        $item = Item::find($item_id);
        $coinDeposit = intval($request->get('coin'));

        $cacheCheck = Cache::has('transaction_'.auth()->user()->id);

        if(!$cacheCheck){
            return response()->json('', 403)->header('X-Coins', 0);
        }


        $balance = Cache::get('transaction_'.auth()->user()->id);
        if($balance<2){
            return response()->json('', 403)->header('X-Coins', 0);
        }

        if(!empty($item)){
           if($item->inventory > 0){
                $item->inventory = $item->inventory-1;
                $item->save();

                $change = $balance - 2;
                
                $userInventory = UserInventory::firstOrCreate(['user_id' => intval(auth()->user()->id), 'item_id' => $item->id]);

                $userInventory->amount = $userInventory->amount+1;
                $userInventory->save();

                Cache::forget('transaction_'.auth()->user()->id);

                return response()->json(array('quantity'=>1), 200)->header('X-Coins', $change)->header('X-Inventory-Remaining', $item->inventory);
           }elseif($item->inventory == 0) {
                Cache::increment('transaction_'.auth()->user()->id, $coinDeposit);

                return response()->json('', 404)->header('X-Coins', $coinDeposit);
           }
        }else{
            return response()->json('', 404)->header('X-Coins', $coinDeposit);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
