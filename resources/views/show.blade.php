@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         User Actions
                        </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="http://localhost:8000/home">Dashboard</a>
                            </div>
                    </div>


                 

                    <div class="card mt-5">
                       
                                <h4 class="card-header">List of All Clients Stock <span style="font-size:10px;">{{$client_details[0]->client_name}}</span></h4>
                                <div class="card-body">

                                <table class="table">
                                    
                                    <thead>
                                    <tr>
                                        <th scope="col">Company</th>
                                        <th scope="col">Volume</th>
                                        <th scope="col">Purchase Price</th>
                                        <th scope="col">Current Price</th>
                                        <th scope="col">Gain/Loss</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($transaction_details))
                                    @foreach ($transaction_details as $transaction_detail)
                                        
                                    <tr>
                                        <th scope="row">{{$transaction_detail->company_name }}</th>
                                        <td>{{$transaction_detail->volume}}</td>
                                        <td>{{$transaction_detail->purchase_unit_price}}</td>
                                        <td>{{$transaction_detail->current_unit_price}}</td>
                                        <td><span class="{{$transaction_detail->profitorloss > 0 ? 'text-secondary' : 'text-danger' }}">{{$transaction_detail->profitorloss}}</span></td>
                                    </tr>

                                        @endforeach
                                    @endif
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">Total</td>
                                        <td><span class="{{$total_profitorloss > 0 ? 'text-secondary' : 'text-danger' }}">{{$total_profitorloss}}</span></td>
                                    </tr>

                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">Invested</td>
                                        <td><span class="{{$invested > 0 ? 'text-secondary' : 'text-danger' }}">{{$invested}}</span></td>
                                    </tr>

                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">Performance</td>
                                        <td><span class="{{$performance > 0 ? 'text-secondary' : 'text-danger' }}">{{$performance}}</span>%</td>
                                    </tr>

                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">Cash Balance</td>
                                        <td><span class="{{$client_balance > 0 ? 'text-secondary' : 'text-danger' }}">{{$client_balance}}</span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
