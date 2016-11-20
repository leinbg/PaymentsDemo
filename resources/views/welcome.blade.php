<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <form action="/purchase" method="POST">
            {{ csrf_field() }}
            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{ config('services.stripe.key') }}"
                data-amount="2000"
                data-name="Buy this shoe"
                data-description="super chrismas discount for this shoe"
                data-locale="auto"
                data-zip-code="true"
                data-currency="eur"
            >
            </script>
        </form>
    </body>
</html>
