<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript">
            var myApp = {
                "csrfToken" : "{{ csrf_token() }}",
                "stripeKey" : "{{ config('services.stripe.key') }}"
            };
        </script>
    </head>
    <body>
        <div id="app">
            <checkout-form :products="{{ $products }}"></checkout-form>
        </div>

        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script src="/js/app.js"></script>
    </body>
</html>
