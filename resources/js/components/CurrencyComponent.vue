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
                <div>
                    <p class="rate-info">Last updated: {{ this.latestDate }}</p>
                </div>
            </div>

            <div v-if="this.currencyRates.length > 0">
                <div>
                    <div id="table">
                        <table>
                            <thead>
                                <tr>
                                    <th @click="sortTable()">Date</th>
                                    <th>EUR to {{ this.currency }}</th>
                                </tr>
                            </thead>
                                <tbody>
                                    <tr v-for="currency in sortedCurrencyRates" :key="currency.date">
                                        <td>{{ formatDate(currency.created_at) }}</td>
                                        <td>{{ parseFloat(currency.rate).toFixed(2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div class="rate-info">
                    <p>
                        Minimum: {{ parseFloat(this.minRate).toFixed(2) }} {{ this.currency }}, 
                        Maximum: {{ parseFloat(this.maxRate).toFixed(2) }} {{ this.currency }}, 
                        Average: {{ parseFloat(this.avgRate).toFixed(2) }}  {{ this.currency }}
                    </p>
                </div>
                    <nav aria-label="navigation">
                    <ul class="pagination">
                        <li class="page-item" v-for="page in pagination.links" :key="page.label" :class="{ 'active': page.active }">
                            <a class="page-link" @click="fetchData(page.url)">{{ page.label }}</a>
                        </li>
                    </ul>
                </nav>
            </div>
                <div id="no-data-message" v-else>
                    <p> There is no data about this currency right now </p>
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
            avgRate: '',
            pagination: {},
            sortOrder: 'asc',
            lastUpdated: '',
        }
    },
    mounted() {
        this.getCurrency('USD')
    },

    computed: {
    sortedCurrencyRates() {
        return [...this.currencyRates]; // Create a copy to avoid mutating the original array
        },
    },


    methods: {
        getCurrency (currency) {
            this.currency = currency
            axios.post('/get-rates/' + currency)
                .then((response) => {
                    if (response.data == 0) {
                    } else {
                        this.currencyRates = response.data.data
                        this.pagination = response.data;

                        let rates = []

                        let latestDate = null;

                        for (const currency of this.currencyRates) {
                            const currentDate = new Date(currency.created_at);

                            if (!latestDate || currentDate > latestDate) {
                                latestDate = currentDate;
                            }
                        }

                        if (latestDate) {
                            this.latestDate = this.formatDate(latestDate);

                        } else {
                            this.latestDate = 'Never';
                        }

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
        },

        fetchData(url) {
            axios.post(url)
                .then(response => {
                    this.currencyRates = response.data.data;
                    this.pagination = response.data;

                    let rates = [];

                    for (let i = 0; i < this.currencyRates.length; i++) {
                        rates.push(this.currencyRates[i].rate);
                    }

                    this.minRate = Math.min(...rates);
                    this.maxRate = Math.max(...rates);
                    this.avgRate = this.getAverage(this.currencyRates);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
            },


        sortTable() {
            this.currencyRates.sort((a, b) => {
                const dateA = new Date(a.created_at);
                const dateB = new Date(b.created_at);

                return this.sortOrder === 'desc' ? dateA - dateB : dateB - dateA;
            });

            this.sortOrder = this.sortOrder === 'desc' ? 'asc' : 'desc';
        }
    },
}
</script>