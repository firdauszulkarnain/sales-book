<template>
    <div class="section">
        <h1 class="h3 mb-4 text-gray-800">Products</h1>

        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                       <div class="row">
                            <div class="col-lg-6">
                                <router-link class="btn btn-light btn-sm px-3 py-2" :to="{name: 'product.form', params: {id : 0}}">
                                    <b>Add Product</b>
                                </router-link>
                            </div>
                            <div class="col-lg-2">
                            </div>
                            <div class="col-lg-4">
                                <input type="text" v-model="keyword" class="form-control" placeholder="Search Here...." @input="getProducts(1)">
                            </div>
                       </div>
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
                                    <th scope="col">Stock</th>
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
                                    <td>{{ product.stock }}</td>
                                    <td>
                                        <a class="btn btn-secondary btn-sm" @click.prevent="openModal(product.id)"><i class="fas fa-fw fa-plus"></i></a>
                                        <router-link class="btn btn-primary btn-sm" :to="{name: 'product.form', params: {id: product.id }}"><i class="fas fa-fw fa-edit"></i></router-link>
                                         <a class="btn btn-danger btn-sm" @click.prevent="confirmDelete(product.id)"><i class="fas fa-fw fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                    <a class="page-link" href="#" @click.prevent="getProducts(pagination.current_page - 1)">Previous</a>
                                </li>

                                <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
                                    <a class="page-link" href="#" @click.prevent="getProducts(page)">{{ page }}</a>
                                </li>

                                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                    <a class="page-link" href="#" @click.prevent="getProducts(pagination.current_page + 1)">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

         <div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="updateStock">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
               <h5 class="modal-title text-dark">Update Stock</h5>
               <button type="button" class="close" data-dismiss="modal" @click.prevent="closeModal">
                  <span aria-hidden="true">&times;</span>
               </button>
               </div>
               <form action="" method="POST" @submit.prevent="submit">
                  <div class="modal-body">
                     <input type="hidden" name="id" v-model="form.id">
                     <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control" id="stock" autocomplete="off" v-model="form.stock">
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Save</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
    </div>

    
</template>

<script>
export default {
    data(){
        return {
            products: [],
            form: {
                id: '',
                stock: 0,
            },
            pagination: {},
            keyword: '',
        }
    },
    mounted(){
        this.getProducts()
    },

    computed:{
        totalPages() {
            return Array.from({ length: this.pagination.last_page }, (v, k) => k + 1);
        },
    },

    methods:{
        async getProducts(page=1){
            let response = await axios.get(`/api/product?page=${page}&search=${this.keyword}`);
            if(response.status == 200){
                this.products = response.data.data;
                this.pagination = response.data.meta;
            }
        },

        async delProduct(id){
           try {
             let response = await axios.delete('/api/product/'+id);
                if(response.status == 200){
                    this.notif('Success', response.data.message)
                    this.getProducts();
                }
           } catch (e) {
                console.log(e);
                this.notif('Error', 'Error Delete Data', 'error');
           }

        },

        formatToRupiah(number) {
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(number);

            return formattedNumber;
        },

        openModal(id) {
            this.form.id = id;
            $(this.$refs.updateStock).modal('show');
        },

        closeModal() {
            $(this.$refs.updateStock).modal('hide');
        },

        async submit(){
            try {
                console.log('id'+this.form.id);
                let response = await axios.put('/api/product/stock/'+this.form.id, this.form);
                if(response.status == 200){
                    this.getProducts();
                    this.closeModal();
                    this.notif('Success','Berhasil Update Stock')
                }
            } catch (e) {
                console.log(e.response.data.errors);
                this.notif('Error!', 'Please Check Your Input!', 'error')
                this.error = e.response.data.errors;
            }
        },

        confirmDelete(idProduct){
         this.$swal({
         title: 'Are you sure?',
         text: 'You will not be able to recover this data!',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#d33',
         cancelButtonColor: '#3085d6',
         confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
         if (result.isConfirmed) {
            this.delProduct(idProduct);
         }
         });
      },

      notif(title, msg, icon = 'success'){
         console.log('notif called with:', { title, msg, icon });
         this.$swal({
            icon: icon,
            title: title,
            text: msg,
            timer: 1000,
            showConfirmButton: false
         });
      }
    },

     
}
</script>
