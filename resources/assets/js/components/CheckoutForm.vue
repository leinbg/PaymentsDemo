<template>
    <form action="/purchase" method="POST" id="checkout-form">
        <input type="hidden" name="stripeToken" v-model="stripeToken">
        <input type="hidden" name="stripeEmail" v-model="stripeEmail">
        <select name="product" v-model="product">
            <option v-for="product in products" :value="product.id">
                {{ product.title }} &mdash; {{ product.price / 100 }} Euro
            </option>
        </select>

        <button type="submit" @click.prevent="purchase">buy this shoe</button>

        <p class="fail response" v-show="status" v-text="status"></p>
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
                'status': '',
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
                        .then(
                            response => alert('Completed!'),
                            response => this.status = response.body.message
                        );
                }
            });
        },

        methods: {
            purchase () {
                var product = this.findProductById(this.product);

                this.stripe.open({
                    name: product.title,
                    description: product.description,
                    zipCode: true,
                    currency: "eur",
                    amount: product.price
                });
            },

            findProductById (id) {
                return this.products.find(product => product.id == id);
            }
        }
    }
</script>
