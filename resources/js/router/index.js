
import Dashboard from '../pages/Dashboard'
import Category from '../pages/category/Category'
import Product from '../pages/product/Product'
import CreateProduct from '../pages/product/CreateProduct'
import Sales from '../pages/Sales'

export default {
    linkExactActiveClass: 'active', 
    mode: 'history',
    routes:[
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard,
        },
        {
            path: '/category',
            name: 'category',
            component: Category,
        },
        {
            path: '/product',
            name: 'product',
            component: Product,
        },
        {
            path: '/product/create',
            name: 'product.create',
            component: CreateProduct,
        },
        {
            path: '/sales',
            name: 'sales',
            component: Sales,
        }
    ]
}