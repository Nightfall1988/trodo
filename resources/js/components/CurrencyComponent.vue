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
                            <td>{{ parseFloat(currency.rate).toFixed(2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="rate-info">
                <p>Minimum: {{ parseFloat(this.minRate).toFixed(2) }}, Maximum: {{ parseFloat(this.maxRate).toFixed(2) }}, Average: {{ parseFloat(this.avgRate).toFixed(2) }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    
    data () {
        return {
            currency: '',
            currencyRates: [],
            minRate: '',
            maxRate: '',
            avgRate: ''
        }
    },
    mounted() {
        this.getCurrency('USD')
    },

    methods: {
        getCurrency (currency) {
            this.currency = currency
            axios.post('/get-rates/' + currency)
                .then((response) => {
                    if (response.data == 0) {
                        this.currencyRates = response.data
                    } else {
                        this.currencyRates = response.data

                        let rates = []

                        for (let i = 0; i < this.currencyRates.length; i++) {
                            rates.push(this.currencyRates[i].rate);
                        }

                        this.minRate = Math.min(...rates)
                        this.maxRate = Math.max(...rates)
                        this.avgRate = this.getAverage(this.currencyRates)
                    }
                })
            },

        formatDate(date) {
            const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
            return new Date(date).toLocaleDateString(undefined, options);
        },

        getAverage(currencyRates) {
            let sum = 0;

            for (let i = 0; i < currencyRates.length; i++) {
                sum += currencyRates[i].rate;
            } 
            
            const average = sum / currencyRates.length; 
            return average;
        }
    }
}
</script>