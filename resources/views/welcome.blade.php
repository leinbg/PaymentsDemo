<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <form id="checkout-form" action="/purchase" method="POST">
            {{ csrf_field() }}
            {{--<script--}}
                {{--src="https://checkout.stripe.com/checkout.js" class="stripe-button"--}}
                {{--data-key="{{ config('services.stripe.key') }}"--}}
                {{--data-amount="2000"--}}
                {{--data-name="Buy this shoe"--}}
                {{--data-description="super christmas discount for this shoe"--}}
                {{--data-locale="auto"--}}
                {{--data-zip-code="true"--}}
                {{--data-currency="eur"--}}
            {{-->--}}
            {{--</script>--}}

            <input type="hidden" id="stripeToken" name="stripeToken">
            <input type="hidden" id="stripeEmail" name="stripeEmail">
            
            <button class="purchase-shoe">buy this shoe</button>
        </form>

        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script>
            var stripe = StripeCheckout.configure({
                key: "{{ config('services.stripe.key') }}",
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                token: function (token) {
                    document.querySelector('stripeToken').value = token.id;
                    document.querySelector('stripeEmail').value = token.stripeEmail;

                    document.querySelector('#checkout-form').submit();
                }
            });

            document.querySelector('.purchase-shoe').addEventListener('click', function (e) {
                e.preventDefault();
                stripe.open({
                    name: "Buy This Shoe",
                    description: "super christmas discount for this shoe",
                    zipCode: true,
                    currency: "eur",
                    amount: 2000
                });
            });

            // Close Checkout on page navigation:
            window.addEventListener('popstate', function() {
                stripe.close();
            });
        </script>
    </body>
</html>
