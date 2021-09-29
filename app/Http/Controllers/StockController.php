<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Carbon\Carbon;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //validate the form
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the form
        $this->validate($request, ['company_name' => 'required|min:3', 'unit_price' => 'required']);
        
        //insert into the database
        DB::table('stock')->insert(
            [
                'company_name' => $request->company_name,
                'unit_price' => $request->unit_price,
                'current_unit_price' => $request->unit_price,
                'created_at' => Carbon::now()->toDateTimeString(),
			    'updated_at' => Carbon::now()->toDateTimeString(),
            ]
        );

        //redirect and display flash message
        Session::flash('success', 'Your data has been succesfully saved');
        return redirect('home'); 
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clientStore(Request $request)
    {
        //validate the form
        $this->validate($request, ['client_name' => 'required|min:3']);
        
        //insert into tables with required info
        DB::table('client')->insert(
            [
                'client_name' => $request->client_name,
                // 'balance' => $request->volume,
                'created_at' => Carbon::now()->toDateTimeString(),
			    'updated_at' => Carbon::now()->toDateTimeString(),
            ]
        );

        //redirect and display flash message
        Session::flash('success', 'Your data has been succesfully saved');
        return redirect('home'); 
    }



     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function purchaseStock(Request $request)
    {
        //validate the form
        $this->validate($request, ['stock' => 'required', 'client' => 'required','volume' => 'required']);

        //get purchase stock
        $stock = DB::table('stock')->where('id', $request->stock)->get();

        //get purchasing client
        $client = DB::table('client')->where('id', $request->client)->get();


        //insert into the database
        DB::table('transactions')->insert([
            'purchase_unit_price' => $stock[0]->unit_price,
            'current_unit_price' => $stock[0]->current_unit_price,
            'client_id' => $request->client,
            'stock_id' => $request->stock,
            'company_name' => $stock->company_name,
            'volume' => $request->volume,
            'profitorloss' => ($stock[0]->current_unit_price - $stock[0]->unit_price) * $request->volume,
            'invested' => $request->volume * $stock[0]->unit_price,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        //get the total sum of all transactione belonging to a particular client
        $totalprofitorloss = DB::table('transactions')
                ->where('client_id', $request->client)
                ->sum('profitorloss');

        //update the balance of the client on each transaction
        $affected = DB::table('client')
        ->where('id', $request->client)
        ->update([
            'balance' => $client[0]->balance-($request->volume * $stock[0]->unit_price),
            'profitorloss' => $totalprofitorloss,
          ]);

        //redirect and display flash message
        Session::flash('success', 'Your data has been succesfully saved');
        return redirect('home');       
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get the various stocks of the client  
        $total_profitorloss = DB::table('transactions')
            ->where('client_id', $id)
            ->sum('profitorloss');

        //get the sum of the total amount invested by the client
        $invested = DB::table('transactions')
        ->where('client_id', $id)
        ->sum('invested');

        $transaction_details = DB::table('transactions')->get();

        //get the performance
        $performance = ($total_profitorloss / $invested) * 100;

        $client_balance = DB::table('client')->where('id', $id)->value('balance');

        //return view with data
        return view('show', ['client_balance'=>$client_balance, 'total_profitorloss'=>$total_profitorloss,'transaction_details'=>$transaction_details, 'invested'=>$invested, 'performance'=>$performance]);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //use the ID to get required details from the database
        $stock = DB::table('stock')->where('id', $id)->first();

        //return view with data
        return view('edit', ['stock' => $stock]);
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
        //get purchase stock
        $stock = DB::table('stock')->where('id', $id)->get();

        DB::table('transactions')->where('stock_id', $request->stock)
        ->chunkById(100, function ($stocks) {
            foreach ($stocks as $stock) {
                DB::table('transactions')
                    ->where('stock_id', $request->stock)
                    ->update([
                     'purchase_unit_price' => $stock->unit_price,
                     'current_unit_price' => $request->unit_price,
                    'profitorloss' => (($request->unit_price - $stock->unit_price) * $stock->volume) + $stock->profitorloss,
                    'updated_at' => Carbon::now()->toDateTimeString(),

                ]);
            }
        });

        //get the total profit and loss for each client and update the client table
        DB::table('client')->orderBy('id')
        ->chunkById(100, function ($clients) {
                foreach ($clients as $client) {
                    $totalprofitorloss=DB::table('transactions')
                        ->where('client_id', $client->id)
                        ->sum('profitorloss');
                    
                    //update the clietnts table
                    DB::table('client')
                    ->where('id', $client->id)
                    ->update([
                    'profitorloss' => $totalprofitorloss + $client->profitorloss,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        });
        
        //also update the current price on the stock table
        DB::table('stock')
              ->where('id', $id)
              ->update([
                  //below isthe current unit price in this instance
                  'current_unit_price' => $request->unit_price,
                  //update the unit price with the former price
                  'unit_price' => $stock[0]->unit_price
                ]);
   
        //redirect and display flash message
        Session::flash('success', 'Your data has been succesfully updated');
        return redirect('home'); 
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete the  selected row from the database
        DB::table('stock')->where('id', $id)->delete();

        //redirect and display flash message
        Session::flash('success', 'Your data has been succesfully deleted');
        return redirect('home'); 
    }
}
