<template>
   <div class="section">
      <div class="row">
         <h1 class="h3 mb-4 text-gray-800">Category</h1>
      </div>
      
      <div class="row d-flex justify-content-center">
         <div class="col-lg-10">
            <div class="card">
               <div class="card-header bg-primary">
                  <button type="button" class="btn btn-light btn-sm px-3 py-2" @click.prevent="openModal('0')">
                     <b>Add Category</b>
                  </button>
               </div>
               <div class="card-body">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th scope="col">No</th>
                           <th scope="col">Name</th>
                           <th scope="col">Created at</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="text-capitalize" v-for="(category, index) in categories" :key="category.id">
                           <th scope="row">{{ index+1 }}</th>
                           <td>{{ category.name }}</td>
                           <td>{{ category.created_at }}</td>
                           <td>
                              <a class="btn btn-primary" @click.prevent="openModal(category.id)">Edit</a>
                              <a class="btn btn-danger" @click.prevent="deleteCategory(category.id)">Hapus</a>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="addModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
               <h5 class="modal-title text-dark">Add Category</h5>
               <button type="button" class="close" data-dismiss="modal" @click.prevent="closeModal">
                  <span aria-hidden="true">&times;</span>
               </button>
               </div>
               <form action="" method="POST" @submit.prevent="submit">
                  <div class="modal-body">
                     <input type="hidden" name="id" v-model="form.id">
                     <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" autocomplete="off" v-model="form.name">
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
         categories : [],
         form: {
            id : '',
            name: '',
         },
         error: [],
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
         console.log(this.form);
         try{
            let response;
            if(this.form.id == '0'){
               response = await axios.post('/api/category', this.form);
            }else{
               console.log('updated');
               response = await axios.put('/api/category/'+this.form.id, this.form);
            }
            if(response.status == 200){
               this.error = [];
               this.$toasted.show(response.data.message,{
                  type: 'success',
                  duration: 3000,
               });
               this.getCategories();
               $(this.$refs.addModal).modal('hide');
            }
         }catch(e){
            console.log(e.response.data.errors);
            this.$toasted.show('Please Check Your Input!',{
                type: 'error',
                duration: 3000,
            });
            this.error = e.response.data.errors;
         }
      },

      openModal(id) {
         if(id !== '0'){
            this.showCategory(id);
         }else{
            this.form.id = id;
         }
         $(this.$refs.addModal).modal('show');
      },

      closeModal() {
         $(this.$refs.addModal).modal('hide');
      },

      async deleteCategory(idCategory){
         try {
            let response = await axios.delete('/api/category/'+idCategory);
            if(response.status == 200){
               this.$toasted.show(response.data.message,{
                  type: 'success',
                  duration: 3000
               });
               this.getCategories();
            }
         } catch (error) {
            console.log(error);
            this.$toasted.show('Error Delete Data',{
               type: 'error',
               duration: 3000
            });
         }
      },
      async showCategory(id){
         let response = await axios.get('/api/category/'+id);
         if(response.status == 200){
            console.log(response);
            this.form = {
               id: response.data.data.id,
               name: response.data.data.name
            }
         }
      },
   },

   
}
</script>
