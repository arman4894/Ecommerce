@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        
                  
                      </tr>
                    </thead>
                    <tbody>
                  
                      @if($cart)
                    @php $i=1 @endphp
                  
                  @foreach($cart->items as $product)
                      <tr>
                        <th scope="row">{{$i++}}</th>
                        
                        <td><img src="{{Storage::url($product['image'])}}" width="100"></td>
                        <td>{{$product['name']}}</td>
                        <td>Rs.{{$product['price']}}</td>
                        <td>
                            {{$product['qty']}}
                      </td>
                      </tr>
                     @endforeach
                  
                  
                  
                    </tbody>
                  </table>
                  <hr>
                  Total Price:Rs.{{$cart->totalPrice}}
                  @endif
            </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Checkout</div>
                <div class="card-body">

                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="/charge" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif
                <form 
                role="form" 
                action="{{ route('charge') }}" 
                method="POST" 
                class="require-validation"
                data-cc-on-file="false"
                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                id="payment-form">
                   {{-- <form action="{{ route('charge') }}" method="POST"> --}}
                    @csrf
                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" name="name" id="name" class="form-control" required="" value="{{auth()->user()->name}}" readonly="">
                        </div>
                      
                        <div class="form-group">
  
                          <label>Adress</label>
                          <input type="text" name="address" id="address" class="form-control" required="">
                        </div>
                        <div class="form-group">
  
                          <label>City</label>
                          <input type="text" name="city" id="city" class="form-control" required="">
                        </div>
                        <div class="form-group">
  
                          <label>State</label>
                          <input type="text" name="state" id="state" class="form-control" required="">
                        </div>
                        <div class="form-group">
  
                          <label>Postal code</label>
                          <input type="text" name="postalcode" id="postalcode" class="form-control" required="">
                        </div>

                        
                        <hr>

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> 
                                <input class='form-control' name="card_name" size='4' type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> 
                                <input autocomplete='off' name="card_number" class='form-control card-number' size='20' type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> 
                                <input autocomplete='off' name="cvc" class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input class='form-control card-expiry-month' name="exp_month" placeholder='MM' size='2' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> 
                                <input class='form-control card-expiry-year' name="exp_year" placeholder='YYYY' size='4' type='text'>
                            </div>
                        </div>
  
                        {{-- <div class='form-row row'>
                            <div class='col-md-12 hide error form-group'>
                                <div class='alert-danger alert'>Fix the errors before you begin.</div>
                            </div>
                        </div> 
  
                         <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-danger btn-lg btn-block" type="submit">Pay Now (₹100)</button>
                            </div>
                        </div> --}}
                          
                    
                <input type="hidden" name="amount" value="{{ $amount }}">
                <button type="submit" class="btn btn-primary mt-3 btn-lg btn-block">Submit Payment</button>
            </form>
            </div>
           
    </div>
</div>
    </div>
    </div>

@endsection