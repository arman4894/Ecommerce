@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{ route('more.products') }}" method="GET">
            <div class="form-row">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="search..">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-secondary">Search</button>
                </div>
            </div>
        </form>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            @foreach ($products as $product)
                
            <div class="col">
            <div class="card shadow-sm">
              <img src="{{ Storage::url($product->image) }}" height="200" style="width: 100%">
  
              <div class="card-body">
                <p><b>{{ $product->name }}</b></p>
                <p class="card-text">{{ Str::limit($product->description,120) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="{{ route('product.show',[$product->id]) }}"><button type="button" class="btn btn-sm btn-outline-success">View</button></a>
                    <a href="{{ route('add.cart',[$product->id]) }}"><button type="button" class="btn btn-sm btn-outline-primary">Add to cart</button></a>
                  </div>
                  <small class="text-muted"><b>Rs.{{ $product->price }}</b></small>
                </div>
              </div>
            </div>
          </div>

          @endforeach

        </div>
        {{ $products->links() }}
    </div>
@endsection