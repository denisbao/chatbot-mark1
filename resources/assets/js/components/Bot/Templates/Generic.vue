<template>
    <div>
        <div v-if="products.length > 0">
            <p><strong>Produtos:</strong></p>
            <div v-for="product in products" class="chip">
                {{ product.title }}
                <a href="" class="btn-floating red" @click.prevent="removeProduct(product.id)">
                    <i class="material-icons">close</i></a>
            </div>
        </div>

        <div class="card red" v-if="products.length === 0">
            <div class="card-content white-text">
                Nenhum produto...
            </div>
        </div>

        <form class="grey lighten-4" @submit.prevent="newProduct()" style="margin-top: 40px; padding: 10px; border-radius: 2px">
            <strong>Novo Produto:</strong>
            <div class="input-field">
                <select class="browser-default" v-model="newProductData">
                    <option value="" disabled selected>Escolha um produto</option>
                    <option v-for="product in productsList.data" :value="product">
                        {{ product.title }}
                    </option>
                </select>
            </div>
            <input id="elementSaveBtn" type="submit" value="+" class="btn">
        </form>
    </div>
</template>

<script>
    export default {
        props: [
            'messageData'
        ],
        data: function () {
            return {
                message: this.messageData,
                dataToSave: {},
                newProductData: '',
                products: []
            }
        },
        methods: {
            newProduct: function () {
                console.log("## - NEW PRODUCT");
                let data = {
                    id: this.message.id,
                    product_id: this.newProductData.id
                };
                this.$store.dispatch('setMessageProduct', data).then(() => {
                    this.$store.dispatch('getMessageProduct', this.message.id).then((res) => {
                        this.products = res.data;
                        this.newProductData = '';
                    });
                })
            },

            removeProduct: function (productId) {
                console.log("## - REMOVE PRODUCT START = "+productId);
                let data = {
                    id: this.message.id,
                    product_id: productId
                };
                console.log("## - DATA SET = " + data.id + ' E ' + data.product_id);
                this.$store.dispatch('removeMessageProduct', data).then(() => {
                    console.log("## - DISPATCH: removeMessageProduct");
                    this.$store.dispatch('getMessageProduct', this.message.id).then((res) => {
                        this.products = res.data;
                    });
                })
            },
        },
        computed: {
            productsList () {
                return this.$store.state.product.listProducts;
            }
        },
        mounted () {
            this.$store.dispatch('getProducts');
            this.$store.dispatch('getMessageProduct', this.message.id).then((res) => {
                this.products = res.data;
            });
        }
    }
</script>