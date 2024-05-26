<template>
    <div class="section">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary font-weight-bolder text-light">Add Sales</div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <label for="product">Product</label>
                                <select :class="['form-control', {'is-invalid' : errors.product_id}]" id="product" v-model="form.product_id">
                                    <option v-for="product in products" :key="product.id" :value="product.id">
                                        {{product.name}}
                                    </option>
                                </select>
                                 <div class="invalid-feedback" v-if="errors.product_id">
                                    {{ errors.product_id[0] }}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="sl_sellprice">Sellprice</label>
                                    <input type="text" :class="['form-control', {'is-invalid' : errors.sl_sellprice}]" id="sl_sellprice" autocomplete="off" v-model="form.sl_sellprice">
                                     <div class="invalid-feedback" v-if="errors.sl_sellprice">
                                    {{ errors.sl_sellprice[0] }}
                                </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sl_qty">Qty</label>
                                    <input type="number" :class="['form-control', {'is-invalid' : errors.sl_qty}]" id="sl_qty" autocomplete="off" v-model="form.sl_qty">
                                    <div class="invalid-feedback" v-if="errors.sl_qty">
                                        {{ errors.sl_qty[0] }}
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary px-4 float-right">Add</button>
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
            products: [],
            form:{
                product_id : '',
                sl_sellprice : '',
                sl_qty : 0,
            },
            errors: [],
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

        async submit(){
            try {
                let response = await axios.post('/api/sales',this.form);
                if(response.status == 200){
                    this.$toasted.show(response.data.message,{
                        type: 'success',
                        duration: 3000,
                    });
                    this.$router.push({name: 'sales'})
                }
            } catch (e) {
                console.log(e.response.data.errors);
                this.$toasted.show('Please Check Your Input!',{
                    type: 'error',
                    duration: 3000,
                });
                this.error = e.response.data.errors
            }
        }
    }
}
</script>