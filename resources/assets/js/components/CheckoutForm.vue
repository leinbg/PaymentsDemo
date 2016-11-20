<template>
    <form action="/purchase" method="POST" id="checkout-form">
        <input type="hidden" name="stripeToken" v-model="stripeToken">
        <input type="hidden" name="stripeEmail" v-model="stripeEmail">
        <button type="submit" @click.prevent="purchase">buy this shoe</button>
    </form>
</template>

<script>
    export default {
        props: ['products'],

        data () {
            return {
                'stripeToken' : '',
                'stripeEmail' : '',
                'product' : 1,
            };
        },

        created () {
            this.stripe = StripeCheckout.configure({
                key: myApp.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                token: (token) => {
                    this.stripeToken = token.id;
                    this.stripeEmail = token.email;

                    this.$http.post('/purchase', this.$data)
                        .then(response => alert('Completed!'));
                }
            });
        },

        methods: {
            purchase () {
                this.stripe.open({
                    name: "Buy This Shoe",
                    description: "super christmas discount for this shoe",
                    zipCode: true,
                    currency: "eur",
                    amount: 2000
                });
            }
        }
    }
</script>
