<template>
  <div class="section">
    <h1 class="h3 mb-4 text-gray-800">Sales Report</h1>
      <div class="card">
         <div class="card-header bg-primary">
            <router-link class="btn btn-light btn-sm px-3 py-2" :to="{name: 'sales.add'}">
               <b>Add Sales</b>
            </router-link>
         </div>
         <div class="card-body">
             <div class="card-body">
               <table class="table table-bordered table-striped text-center">
                     <thead>
                        <tr>
                           <th scope="col">No</th>
                           <th scope="col">Product Name</th>
                           <th scope="col">Buyprice</th>
                           <th scope="col">Sellprice</th>
                           <th scope="col">Qty</th>
                           <th scope="col">Subtotal</th>
                           <th scope="col">Sales Date</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="text-capitalize" v-for="(row, index) in sales" :key="row.id">
                           <td>{{ index+1 }}</td>
                           <td>{{ row.product_name }}</td>
                           <td>{{ formatToRupiah(row.buyprice) }}</td>
                           <td>{{ formatToRupiah(row.sellprice) }}</td>
                           <td>{{ row.qty }}</td>
                           <th>{{ formatToRupiah(row.subtotal) }}</th>
                           <th>{{ row.created_at }}</th>
                        </tr>
                     </tbody>
               </table>
            </div>
         </div>
      </div>
  </div>
</template>

<script>
export default {
   data(){
      return{
         sales : [],
      }
   },

   mounted(){
      this.getSales();
   },

   methods:{

      async getSales(){
         let response = await axios.get('/api/sales');
         if(response.status == 200){
            this.sales = response.data.data;
         }
      },
      formatToRupiah(number) {
         const formattedNumber = new Intl.NumberFormat('id-ID', {
               style: 'currency',
               currency: 'IDR'
         }).format(number);

         return formattedNumber;
      },
   }
}
</script>
