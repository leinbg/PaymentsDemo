<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <form action="/your-server-side-code" method="POST">
            <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_bUIjNwftvYW8ndwKtQ7yee1t"
                    data-amount="2000"
                    data-name="Demo Site"
                    data-description="2 widgets"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-zip-code="true"
                    data-currency="eur">
            </script>
        </form>
    </body>
</html>
