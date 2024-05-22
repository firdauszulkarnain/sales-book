<template>
     <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-text mx-3">Sales Book</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <router-link class="nav-link" exact :to="{name: 'dashboard'}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </router-link>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Master Data
        </div>

        <li :class="['nav-item', {'active': isActive('/category')}]">
            <router-link class="nav-link" :to="{name: 'category'}">
                <i class="fas fa-fw fa-th-large"></i>
                <span>Category</span>
            </router-link>
        </li>

        <li :class="['nav-item', {'active': isActive('/product')}]">
            <router-link class="nav-link" :to="{name: 'product'}">
                <i class="fas fa-fw fa-th-large"></i>
                <span>Product</span>
            </router-link>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            MAIN FEATURE
        </div>

        <li :class="['nav-item', {'active': isActive('/sales')}]">
            <router-link class="nav-link" :to="{name:'sales'}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Sales Report</span>
            </router-link>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
</template>

<script>
export default {
    methods: {
    isActive(route) {
      return this.$route.path === route;
    },
  },
}
</script>