<table class="table table-stripped">
    <thead>
      
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Price</th>
        <th scope="col">Qty</th>
       
      </tr>
    </thead>
    <tbody>
        @php
            $i=1;
        @endphp
        @foreach($cart->items as $product)
        <tr>
            <th>{{ $i+1 }}</th>
            <th>{{ $product['name'] }}</th>
            <th>{{$product['price'] }}</th>
            <th>{{ $product['qty'] }}</th>
        </tr>
        @endforeach
        <br>
        Total Price:{{ $cart->totalPrice }}
        Please click the link to view your order.<a href="{{ route('order') }}">Click here</a>
    </tbody>
</table>