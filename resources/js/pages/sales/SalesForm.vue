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
                                    <input type="text" :class="['form-control', {'is-invalid' : errors.sl_sellprice}]" id="sl_sellprice" autocomplete="off" v-model="form.sl_sellprice" @input="formatRupiah('sl_sellprice')">
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
                    this.notif('Success', response.data.message, 'success');
                    this.$router.push({name: 'sales'})
                }
            } catch (e) {
                console.log(e.response.data.errors);
                this.notif('Error!', 'Please Check Your Input!', 'error');
                this.error = e.response.data.errors
            }
        },

        notif(title, msg, icon = 'success'){
            this.$swal({
                icon: icon,
                title: title,
                text: msg,
                timer: 1000,
                showConfirmButton: false
            });
        },

        formatRupiah(field) {
            let value = this.form[field].replace(/[^,\d]/g, "").toString();
            
            let split = value.split(",");
            let remainder = split[0].length % 3;
            let rupiah = split[0].substr(0, remainder);
            let thousand = split[0].substr(remainder).match(/\d{3}/gi);
            
            if (thousand) {
                let separator = remainder ? "." : "";
                rupiah += separator + thousand.join(".");
            }
            
            this.form[field] = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
            
        }
    }
}
</script>