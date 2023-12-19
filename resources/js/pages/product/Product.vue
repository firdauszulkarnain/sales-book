<template>
    <div class="section">
        <h1 class="h3 mb-4 text-gray-800">Products</h1>

        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header bg-primary">
                        <router-link class="btn btn-light btn-sm px-3 py-2" :to="{name: 'product.form', params: {id : 0}}">
                            <b>Add Product</b>
                        </router-link>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Buyprice</th>
                                    <th scope="col">Sellprice</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-capitalize" v-for="(product, index) in products" :key="product.id">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ product.category_name }}</td>
                                    <td>{{ product.name }}</td>
                                    <td>{{ formatToRupiah(product.buyprice) }}</td>
                                    <td>{{ formatToRupiah(product.sellprice) }}</td>
                                    <td>
                                        <router-link class="btn btn-primary" :to="{name: 'product.form', params: {id: product.id }}">Edit</router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</template>

<script>
export default {
    data(){
        return {
            products: []
        }
    },
    mounted(){
        this.getProducts()
    },

    methods:{
        async getProducts(){
           let response = await axios.get('/api/product');
            if(response.status == 200){
                this.products = response.data.data;
            }
        },
         formatToRupiah(number) {
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(number);

            return formattedNumber;
        }
    }
}
</script>
