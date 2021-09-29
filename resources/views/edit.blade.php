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
                                <a class="dropdown-item" href="#">Create A New Client</a>
                                <a class="dropdown-item" href="#">Create A New Stock</a>
                                <a class="dropdown-item" href="#">Purchase A Stock</a>
                            </div>
                    </div>


                 
                    <div class="card mt-5">
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

                            <form action="{{route('updatestock', ['stock_id'=> $stock->id])}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="text" name="company_name" value={{$stock->company_name}} class="form-control form-control-lg" id="colFormLabelLg" placeholder="Company Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">€</div>
                                            </div>
                                            <input type="number" name="unit_price" value={{$stock->current_unit_price}} class="form-control form-control-lg" id="inlineFormInputGroup" placeholder="Unit Price">
                                          </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
