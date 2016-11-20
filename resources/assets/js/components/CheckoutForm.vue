<template>
    <form action="/subscribe" method="POST" id="checkout-form">
        <input type="hidden" name="stripeToken" v-model="stripeToken">
        <input type="hidden" name="stripeEmail" v-model="stripeEmail">
        <select name="plan" v-model="plan">
            <option v-for="plan in plans" :value="plan.id">
                {{ plan.name }} &mdash; {{ plan.price / 100 }} Euro
            </option>
        </select>

        <button type="submit" @click.prevent="subscribe">Subscribe</button>

        <p class="fail response" v-show="status" v-text="status"></p>
    </form>
</template>

<script>
    export default {
        props: ['plans'],

        data () {
            return {
                'stripeToken' : '',
                'stripeEmail' : '',
                'plan' : 1,
                'status': '',
            };
        },

        created () {
            this.stripe = StripeCheckout.configure({
                key: myApp.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                email: myApp.user.email,
                panelLabel: "Subscribe For",
                token: (token) => {
                    this.stripeToken = token.id;
                    this.stripeEmail = token.email;

                    this.$http.post('/subscribe', this.$data)
                        .then(
                            response => alert('Completed!'),
                            response => this.status = response.body.message
                        );
                }
            });
        },

        methods: {
            subscribe () {
                var plan = this.findPlanById(this.plan);

                this.stripe.open({
                    name: plan.name,
                    description: plan.description,
                    zipCode: true,
                    currency: "eur",
                    amount: plan.price
                });
            },

            findPlanById (id) {
                return this.plans.find(plan => plan.id == id);
            }
        }
    }
</script>
