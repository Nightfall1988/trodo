<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="buttons">
                            <button @click="getCurrency('AUD')">AUD</button>
                            <button @click="getCurrency('GBP')">GBP</button>
                            <button @click="getCurrency('USD')">USD</button>
                        </div>
                    </div>
                </div>
            </div>
        <div id="table">
            <table>
                <thead>
                    <tr>
                    <th>Date</th>
                    <th>EUR to {{ this.currency }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="currency in currencyRates" :key="currency.date">
                        <td>{{ formatDate(currency.created_at) }}</td>
                        <td>{{ currency.rate }}</td>
                    </tr>
                </tbody>
                </table>

                </div>
        </div>
    </div>
</template>

<script>
    export default {
    
    data () {
        return {
            currency: '',
            currencyRates: []
        }
    },

    methods: {
        getCurrency (currency) {
            console.log(currency)
            this.currency = currency
            axios.post('/get-rates/' + currency)
                .then((response) => {
                    if (response.data == 0) {
                        this.currencyRates = response.data
                    } else {
                        this.currencyRates = response.data
                        console.log(response.data)
                        // this.recipientCurrency = response.data;
                        // this.recipientMessage =  'Recipient account currency: ' + this.recipientCurrency;
                    }
                })
            },

        formatDate(date) {
            const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
            return new Date(date).toLocaleDateString(undefined, options);
        }
    }
}
</script>