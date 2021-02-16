<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Price-check</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="productIpt">Product code(s) (allows csv)</label>
                                <input id="productIpt" class="form-control" type="text" v-model="product" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="accountRefIpt">Account Reference</label>
                                <input id="accountRefIpt" class="form-control" type="text" maxlength="100" step="1" v-model="accountRef">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <button type="button" @click="query">Query</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div v-for="price in priceList" :key="price" class="row">
                            <div class="col-md-6 text-right">{{ price.sku }}</div>
                            <div class="col-md-6 text-right">{{ parseFloat(price.price).toFixed(2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    export default {
        data() {
            return {
                product: '',
                accountRef: '',
                priceList: [],
                livePricesTable: []
            }
        },
        methods: {
            query() {
                this.priceList = [];

                if (this.product.trim().length) {

                    const missing = this.queryFeed();
                    if (missing.length) {
                        this.queryDB(missing);
                    }
                }
            },
            queryFeed() {
                const productList = this.product.split(',');
                this.priceList = this.livePricesTable.reduce(
                    // filters all products with sku in the list
                    (acc, price) => productList.indexOf(price.sku) >= 0
                        // filters by account, when available - prices without an account can match all queries
                        && (price.account === undefined || price.account === this.accountRef) 
                        // if found, compares the prices, and gets the lowest
                        && (price.price < (acc.filter(y => y.sku === price.sku)[0] || {price: Number.MAX_VALUE}).price)
                        // if passed all tests, adds it to the resulting list
                        ? [...acc, price] : acc, 
                    []);
                // returns the missing SKUs
                return (productList.filter(sku => this.priceList.filter(il => il.sku === sku).length === 0));
            },
            queryDB(productList) {
                
                const data = {
                    params: {
                        'product_list': productList
                    }
                }
                if (this.accountRef) {
                    data.params.account_ref = this.accountRef;
                }

                this.$axios.get('/api/prices', data)
                    .then(response=>{
                        if (response.data.status === "ok") {
                            // console.log(response.data.data, this.priceList);
                            this.priceList = [...this.priceList, ...response.data.data];
                        } else {
                            console.error(response);
                        }
                    })
                    .catch(error=>console.error(error));
            }
        },
        mounted() {
            this.$axios.get('/api/live-prices')
                .then(response=>{
                    this.livePricesTable = response.data;
                    console.log(this.livePricesTable);
                })
                .catch(error=>console.error(error));
        }
    }
</script>
