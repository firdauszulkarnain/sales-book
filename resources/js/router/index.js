
import Dashboard from '../pages/Dashboard'
import Category from '../pages/category/Category'
import Product from '../pages/product/Product'
import ProductForm from '../pages/product/Form'
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
            path: '/product/form/:id',
            name: 'product.form',
            component: ProductForm,
            props:true
        },
        {
            path: '/sales',
            name: 'sales',
            component: Sales,
        }
    ]
}