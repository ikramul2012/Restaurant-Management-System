<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Stripe Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Checkout</h1>

    {{-- Display success or error messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h3>Order Summary</h3>
<ul>
    @foreach ($order->foods as $food)
        <li>{{ $food->name }} - ${{ $food->price }} x {{ $food->pivot->quantity }}</li>
    @endforeach
</ul>

<h4>Total: ${{ $order->foods->sum(function ($food) {
    return $food->price * $food->pivot->quantity;
}) }}</h4>


        {{-- 50% Advance Payment Form --}}
        <form id="payment-form" action="{{ route('stripe.advance', $order->id) }}" method="POST">
            @csrf
            <div id="card-element" class="form-control"></div>
            <button id="pay-btn" class="btn btn-primary mt-3" type="button" onclick="createToken()">Pay 50%</button>
        </form>

        <br>

        {{-- Full Payment Form --}}
        <form id="full-payment-form" action="{{ route('stripe.final', $order->id) }}" method="POST">
            @csrf
            <div id="card-element" class="form-control"></div>
            <button id="full-pay-btn" class="btn btn-primary mt-3" type="button" onclick="createFullPaymentToken()">Pay Full</button>
        </form>
    </div>


<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
$(document).ready(function(){
    // Initialize Stripe with your publishable key
    var stripe = Stripe('{{ env("STRIPE_KEY") }}');
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    // Payment button click event
    $("#pay-btn").click(function(){
        $(this).attr("disabled", true);
        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                $("#pay-btn").attr("disabled", false);
                alert(result.error.message);
            } else if (result.token) {
                $("#stripe-token-id").val(result.token.id);
                $("#payment-form").submit();
            }
        });
    });
});
</script>
</body>
</html>
