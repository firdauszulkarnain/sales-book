<template>
    <div class="section">
         <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-5">
                    <div class="card-header bg-primary font-weight-bolder text-light">Add Product</div>
                    <div class="card-body">
                        <form action="" method="POST" @submit.prevent="submit">
                             <div class="form-group">
                                <label for="pd_name">Product Name</label>
                                <input type="text" class="form-control" id="pd_name" autocomplete="off" v-model="form.pd_name">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" id="category" v-model="form.category_id">
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{category.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="pd_buyprice">Product Buyprice</label>
                                    <input type="text" class="form-control" id="pd_buyprice" autocomplete="off" v-model="form.pd_buyprice">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pd_sellprice">Product Sellprice</label>
                                    <input type="text" class="form-control" id="pd_sellprice" autocomplete="off" v-model="form.pd_sellprice">
                                </div>
                            </div>
                             <div class="form-group">
                                    <label for="pd_desc">Product Description</label>
                                    <textarea class="form-control" id="pd_desc" rows="3" v-model="form.pd_desc"></textarea>
                            </div>
                            <router-link class="btn btn-danger" :to="{name: 'product'}">Back</router-link>
                            <button type="submit" class="btn btn-primary float-right">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            categories : [],
            form:{
                category_id: '',
                pd_name: '',
                pd_buyprice: '',
                pd_sellprice: '',
                pd_desc: '',
            },
            errors: [],
        }
    },

    mounted(){
        this.getCategories();
    },

    methods:{
        async getCategories(){
            let response = await axios.get('/api/category');
            if(response.status == 200){
                this.categories = response.data.data;
            }
        },

        async submit(){
            try {
                let response = await axios.post('/api/product',this.form);
                if(response.status == 200){
                    this.error = [];
                    this.$toasted.show(response.data.message,{
                        type: 'success',
                        duration: 3000,
                    });
                    this.$router.push({name: 'product'})
                }
            } catch (e) {
                console.log(e.response.data.errors);
                this.$toasted.show('Please Check Your Input!',{
                    type: 'error',
                    duration: 3000,
                });
                this.error = e.response.data.errors;
            }
        }
    }
}
</script>