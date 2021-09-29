@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    
                    <div class="col-md-12 mb-3">
                        <!--Size dropdown menu-->
                        
                        <select id="size_select" name="size_selected" class = "form-select-lg mb-3">
                            <option value="none" selected disabled hidden> - User Actions - </option> 
                            <option value="option1">Create A New Stock</option>
                            <option value="option2">Purchase A Stock</option>
                            <option value="option3">Create A New Client</option>
                            <option value="option4">List of All Stocks</option>
                            <option value="option5">List of All Clients</option>
                        </select>
                    </div>


                 
                    <div class="card mt-5 size_chart" id="option1">
                        <h5 class="card-header">Create A New Stock</h5>
                        <div class="card-body">
                          <h5 class="card-title">Please Enter All fields*</h5>
                            
                            <!-- checking if an error exist -->
                            @if(Session::has('success'))
                            {{-- to handle success --}}
                            <div class="alert alert-success" role="alert">
                                <strong>Success:</strong>{{ Session::get('success') }}
                            </div>  
                            @endif
        
                            @if(Session::has('danger'))
                            {{-- to handle failure --}}
                            <div class="alert alert-danger" role="alert">
                                <strong>Errors:</strong>{{ Session::get('danger') }}
                            </div>  
                            @endif
        
                            {{-- to handle errors --}}
                            @if (count($errors) > 0)
                            <div class="alert alert-danger" role="alert">
                                <strong>Errors:</strong><ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach 
                                </ul>
                            </div>  
                            @endif

                            <form action="{{route('stock')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    {{-- <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Company Name:</label> --}}
                                    <div class="col-sm-12">
                                        <input type="text" name="company_name" class="form-control form-control-lg" id="colFormLabelLg" placeholder="Company Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{-- <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Company Name:</label> --}}
                                    <div class="col-sm-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">€</div>
                                            </div>
                                            <input type="number" name="unit_price" class="form-control form-control-lg" id="inlineFormInputGroup" placeholder="Unit Price">
                                          </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" id="addstock" class="btn btn-primary pull-right">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>




                    <div class="card mt-5 size_chart" id="option2">
                        <h5 class="card-header">Purchase A Stock</h5>
                        <div class="card-body">
                          <h5 class="card-title">Please Enter All fields*</h5>
                            <form action="{{route('purchasestock')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    {{-- <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Company Name:</label> --}}
                                    <div class="col-sm-12">
                                        <select class="form-select form-control form-control-lg" name="client" aria-label="Default select example">
                                            <option selected>Choose A client</option>
                                            @foreach ($client_all as $client)
                                                <option value="{{$client->id}}">{{$client->client_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{-- <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Company Name:</label> --}}
                                    <div class="col-sm-12">
                                        <select class="form-select form-control form-control-lg" name="stock" aria-label="Default select example">
                                            <option selected>Choose A Stock</option>
                                                @foreach ($stock_all as $stock)
                                                    <option value="{{$stock->id}}">{{$stock->company_name}} Stocks</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="number" name="volume" class="form-control form-control-lg" id="colFormLabelLg" placeholder="Volume">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>



                    <div class="card mt-5 size_chart" id="option3">
                        <h5 class="card-header">Create A New Client</h5>
                        <div class="card-body">
                          <h5 class="card-title">Please Enter All fields*</h5>

                            <!-- checking if an error exist -->
                            @if(Session::has('success'))
                            {{-- to handle success --}}
                            <div class="alert alert-success" role="alert">
                                <strong>Success:</strong>{{ Session::get('success') }}
                            </div>  
                            @endif
        
                            @if(Session::has('danger'))
                            {{-- to handle failure --}}
                            <div class="alert alert-danger" role="alert">
                                <strong>Errors:</strong>{{ Session::get('danger') }}
                            </div>  
                            @endif
        
                            {{-- to handle errors --}}
                            @if (count($errors) > 0)
                            <div class="alert alert-danger" role="alert">
                                <strong>Errors:</strong><ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach 
                                </ul>
                            </div>  
                            @endif

                          <form action="{{route('client')}}" method="POST">
                            {{ csrf_field() }}
                                <div class="form-group row">
                                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Create A New Name:</label>
                                    <div class="col-sm-10">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">@</div>
                                            </div>
                                            <input type="text" name="client_name" class="form-control form-control-lg" id="inlineFormInputGroup" placeholder="Username">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>




                    <div class="card mt-5 size_chart" id="option4">
                        <h5 class="card-header">List of All Stocks</h5>
                        <div class="card-body">

                            <table class="table" id="stocktable">
                                <thead>
                                  <tr>
                                    <th scope="col">Company</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Updated At</th>
                                    <th scope="col">Actions</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($stock_all))
                                        @foreach ($stock_all as $stock)
                                            <tr>
                                                <th scope="row">{{$stock->company_name }}</th>
                                                <td>{{$stock->current_unit_price}}</td>
                                                <td>{{$stock->updated_at}}</td>
                                                
                                                <td>
                                                    <div class="dropdown">
                                                        <a  type="button" data-toggle="dropdown"><span><i class="fas fa-ellipsis-h fa-2x"></i></span></a>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="{{route('editstock', ['stock_id'=> $stock->id])}}">Update Unit Price</a></li>
                                                            <li><a href="{{route('deletestock', ['stock_id'=> $stock->id])}}">Delete Stock</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <div class="card mt-5 size_chart" id="option5">
                        <h5 class="card-header">List of All Clients</h5>
                        <div class="card-body">

                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">Client</th>
                                    <th scope="col">Cash Balance</th>
                                    <th scope="col">Gain/Loss</th>
                                    <th scope="col">Actions</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($client_all))
                                        @foreach ($client_all as $client)
                                            <tr>
                                                <th scope="row">{{$client->client_name }}</th>
                                                <td>{{$client->balance}}</td>
                                                <td>{{$client->profitorloss}}</td>
                                                
                                                <td>
                                                    <div class="dropdown">
                                                        <a  type="button" data-toggle="dropdown"><span><i class="fas fa-ellipsis-h fa-2x"></i></span></a>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="{{route('viewstock', ['clientid'=> $client->id])}}">View Stock</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
            //hides dropdown content
            $(".size_chart").hide();
            //unhides first option content
            $("#option1").show();
            //listen to dropdown for change
            $("#size_select").change(function(){
            //rehide content on change
            $('.size_chart').hide();
            //unhides current item
            $('#'+$(this).val()).show();
        });
    });
</script>
@endsection
