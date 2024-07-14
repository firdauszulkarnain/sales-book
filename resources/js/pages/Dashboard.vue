<template>
    <div class="section">
       <div class="row">
         <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
       </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Category</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span v-if="totalCategory > 10">
                                        {{ totalCategory }}
                                    </span>
                                    <span v-else>
                                        0{{ totalCategory }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-th-large fa-2x text-gray-300"></i>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Product</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span v-if="totalProduct > 10">
                                        {{ totalProduct }}
                                    </span>
                                    <span v-else>
                                        0{{ totalProduct }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-th-large fa-2x text-gray-300"></i>
                            </div>
                        
                        </div>
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
            totalCategory : 0,
            totalProduct : 0,
        }
    },

    mounted(){
        this.getDashboard()
    },

    methods: {
        async getDashboard(){
            try {
                const response = await axios('/api/dashboard');
                this.totalCategory = response.data.data.totCat;
                this.totalProduct = response.data.data.totProduct;
            } catch (error) {
                console.error('Error fetching counts:', error);
            }
        }
    }
}
</script>
