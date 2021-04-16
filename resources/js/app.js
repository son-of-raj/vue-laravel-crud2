/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

const { default: Axios } = require('axios');

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('modal', {
    template: '#modal-template'
})

const app = new Vue({
    el: '#app',
    data: {
        newProduct: { 'oem': '', 'model_no': '', 'product_type': '', 'price': '', 'config': '' },
        hasError: true,
        products: [],
        e_id: '',
        e_oem: '',
        e_model_no: '',
        e_product_type: '',
        e_price: '',
        e_config: '',
    },
    mounted: function mounted() {
        this.getProducts();
    },
    methods: {
        getProducts: function getProducts() {
            var _this = this;
            axios.get('/getProducts').then(function(response) {
                _this.products = response.data;
            }).catch(error => {
                console.log("Get All: " + error);
            });
        },
        createProducts: function createProducts() {
            var input = this.newProduct;
            var _this = this;
            if (input['oem'] == '' || input['model_no'] == '' || input['product_type'] == '' || input['price'] == '' || input['config'] == '') {
                this.hasError = false;
            } else {
                this.hasError = false;
                alert("The product " + input['oem'] + "   has inserted successfully");
                axios.post('/storeProduct', input).then(function(response) {
                    _this.newProduct = { 'oem': '', 'model_no': '', 'product_type': '', 'price': '', 'config': '' }
                    _this.getProducts();
                }).catch(error => {
                    console.log("Insert: " + error);
                });
            }
        },
        deleteProduct: function deleteProduct(product) {
            var _this = this;
            axios.post('/deleteProduct/' + product.id).then(function(response) {
                _this.getProducts();
            }).catch(error => {
                console.log("Delete product: " + error);
            });
        },
        setVal(val_id, val_oem, val_model_no) {
            this.e_id = val_id;
            this.e_oem = val_oem;
            this.e_model_no = val_model_no;
            this.e_product_type = val_product_type;
            this.e_price = val_price;
            this.e_config = val_config;
        },
        editProduct: function() {
            var _this = this;
            var id_val_1 = document.getElementById('e_id');
            var oem_val_1 = document.getElementById('e_oem');
            var model_no_val_1 = document.getElementById('e_model_no');
            var product_type_val_1 = document.getElementById('e_product_type');
            var price_val_1 = document.getElementById('e_price');
            var config_val_1 = document.getElementById('e_config');
            var model = document.getElementById('myModal').value;
            axios.post('/editProducts/' + id_val_1.value, { val_1: oem_val_1.value, val_2: model_no_val_1.value, val_3: product_type_val_1.value, val_4: price_val_1.value, val_5: config_val_1.value })
                .then(response => {
                    _this.getProducts();
                });
        },
    }
});