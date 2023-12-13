<template>
    <div class="section">
        <h1 class="h3 mb-4 text-gray-800">Products</h1>

        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header bg-primary">
                        <router-link class="btn btn-light btn-sm px-3 py-2" :to="{name: 'product.create'}">
                            <b>Add Product</b>
                        </router-link>
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</template>

<script>
export default {

}
</script>
