<template>
    <div class="section">
         <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-5">
                    <div class="card-header bg-primary font-weight-bolder text-light">{{ title }}</div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                             <div class="form-group">
                                <label for="pd_name">Product Name</label>
                                <input type="text" :class="['form-control', {'is-invalid' : errors.pd_name}]" id="pd_name" autocomplete="off" v-model="form.pd_name">
                                <div class="invalid-feedback" v-if="errors.pd_name">
                                    {{ errors.pd_name[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select :class="['form-control', {'is-invalid' : errors.category_id}]" id="category" v-model="form.category_id">
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{category.name}}
                                    </option>
                                </select>
                                <div class="invalid-feedback" v-if="errors.category_id">
                                    {{ errors.category_id[0] }}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="pd_buyprice">Product Buyprice</label>
                                    <input type="text" :class="['form-control', {'is-invalid' : errors.pd_buyprice}]" id="pd_buyprice" autocomplete="off" v-model="form.pd_buyprice" @input="formatRupiah('pd_buyprice')">
                                    <div class="invalid-feedback" v-if="errors.pd_buyprice">
                                        {{ errors.pd_buyprice[0] }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pd_sellprice">Product Sellprice</label>
                                    <input type="text" :class="['form-control', {'is-invalid' : errors.pd_sellprice}]" id="pd_sellprice" autocomplete="off" v-model="form.pd_sellprice"  @input="formatRupiah('pd_sellprice')">
                                    <div class="invalid-feedback" v-if="errors.pd_sellprice">
                                        {{ errors.pd_sellprice[0] }}
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="pd_desc">Product Description</label>
                                <textarea :class="['form-control', {'border border-danger' : errors.pd_desc}]" id="pd_desc" rows="3" v-model="form.pd_desc"></textarea>
                                <small class="text text-danger" v-if="errors.pd_desc">
                                    {{ errors.pd_desc[0] }}
                                </small>
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
    props:['id'],
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

    computed:{
        title(){
            return this.id == 0 ? 'Add Product' : 'Update Product';
        }
    },

    mounted(){
        this.getCategories();
        if(this.id > 0){
            this.showProduct();
        }
    },

    methods:{
        async getCategories(){
            let response = await axios.get('/api/category');
            if(response.status == 200){
                this.categories = response.data.data;
            }
        },

        async showProduct(){
            let response = await axios.get('/api/product/'+this.id);
            if(response.status == 200){
               console.log(response);
               this.form = {
                    category_id: response.data.data.category_id,
                    pd_name: response.data.data.name,
                    pd_buyprice: response.data.data.buyprice,
                    pd_sellprice: response.data.data.sellprice,
                    pd_desc: response.data.data.desc,
               }
            }
        },

        async submit(){
            try {
                let response;
                if(this.id > 0){
                    response = await axios.put('/api/product/'+this.id,this.form);
                }else{
                    response = await axios.post('/api/product',this.form);
                }
                if(response.status == 200){
                    this.error = [];
                    this.notif('Success', response.data.message, 'success');
                    this.$router.push({name: 'product'})
                }
            } catch (e) {
                console.log(e.response.data.errors);
                this.notif('Error!', 'Please Check Your Input!', 'error');
                this.errors = e.response.data.errors;
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