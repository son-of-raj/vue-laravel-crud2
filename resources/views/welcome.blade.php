<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Vuejs + Laravel</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                
                justify-content: center;
                margin-left: 20%;
                margin-right: 20%;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>

        <div  id="app" >
            <div class="flex-center position-ref full-height">
                <div class="content">
                    <div class="alert alert-danger" role="alert" v-bind:class="{hidden: hasError}">
                        All fields are required!
                    </div>
                    <div class="form-group">
                        <label for="oem">OEM</label>
                        <input type="text" class="form-control" id="oem" required placeholder="OEM" name="oem" v-model="newProduct.oem">
                    </div>
                                        
                    <div class="form-group">
                        <label for="model_no">Model Number</label>
                        <input type="text" class="form-control" id="model_no" required placeholder="Model Number" name="model_no" v-model="newProduct.model_no">
                    </div>

                    <div class="form-group">
                        <label for="product_type">Product Type</label>
                        <!-- <input type="text" class="form-control" id="product_type" required placeholder="Product Type" name="product_type" v-model="newProduct.product_type"> -->
                        <select class="form-control" id="product_type" required v-model="newProduct.product_type">
                            <option value="Server">Server</option>
                            <option value="Storage,">Storage</option>
                            <option value="Network">Network</option>
                            <option value="Backup">Backup</option>
                         </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" required placeholder="Price" name="price" v-model="newProduct.price">
                    </div>

                    <div class="form-group">
                        <label for="config">Configuration</label>
                        <!-- <input type="text" class="form-control" id="config" required placeholder="Configuration" name="config" v-model="newProduct.config"> -->
                        <textarea class="form-control"id="config" required placeholder="Configuration" name="config" v-model="newProduct.config"></textarea>
                    </div>

                    <button class="btn btn-primary" @click.prevent="createProducts()">
                        Add Product
                    </button>

                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                        <th scope="col">id</th>
                        <th scope="col">OEM</th>
                        <th scope="col">Model Number</th>
                        <th scope="col">Product Type</th>
                        <th scope="col">Price</th>
                        <th scope="col">Configuration</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for ="product in products">
                        <th scope="row">@{{product.id}}</th>
                        <td>@{{product.oem}}</td>
                        <td>@{{product.model_no}}</td>
                        <td>@{{product.product_type}}</td>
                        <td>@{{product.price}}</td>
                        <td>@{{product.config}}</td>

                        <td @click="setVal(product.id, product.oem, product.model_no, product.product_type, product.price, product.config)"  class="btn btn-info" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil"></i>
                        </td>
                        <td  @click.prevent="deleteProduct(product)" class="btn btn-danger"> 
                        <i class="fa fa-trash"></i>
                        </td>
                        </tr>
                    </tbody>
                </table>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Product</h4>
                        </div>
                        <div class="modal-body">
                            
                        <input type="hidden" disabled class="form-control" id="e_id" name="id"
                                                    required  :value="this.e_id">
                                            OEM: <input type="text" class="form-control" id="e_oem" name="oem"
                                                    required  :value="this.e_oem">
                                            Model Number: <input type="text" class="form-control" id="e_model_no" name="model_no"
                                            required  :value="this.e_model_no">
                                            <!-- Product Type: <input type="text" class="form-control" id="e_product_type" name="product_type"
                                            required  :value="this.e_product_type"> -->
                                            Product Type: <select class="form-control" id="e_product_type" name="product_type"  :value="this.e_product_type">
                                                <option value="Server">Server</option>
                                                <option value="Storage,">Storage</option>
                                                <option value="Network">Network</option>
                                                <option value="Backup">Backup</option>
                                            </select>
                                            Price: <input type="text" class="form-control" id="e_price" name="price"
                                            required  :value="this.e_price">
                                            <!-- Configuration: <input type="text" class="form-control" id="e_config" name="config"
                                            required  :value="this.e_config"> -->
                                            Configuration: <textarea class="form-control" id="e_config" required placeholder="Configuration" name="config" :value="this.e_config"></textarea>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="editProduct()">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="/js/app.js"></script>
    </body>
</html>
