@extends('layouts.app')

@section('content')
    <div style="text-align: center;">
        <h2>Sign up for Giscus</h2>

        <form action="" method="POST">
          <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_API_KEY') }}"
            data-amount="1200"
            data-name="Giscus"
            data-description="Yearly Subscription ($12.00)"
            data-image="/giscus-stripe.png">
          </script>
        </form>
    </div>
@stop
