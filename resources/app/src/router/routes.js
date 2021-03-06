import resetPasswordPage from 'pages/ResetPasswordPage';
import dashboardPage from 'pages/DashboardPage';

import customersPage from 'pages/CustomersPage';
import addCustomerPage from 'pages/AddCustomerPage';
import editCustomerPage from 'pages/EditCustomerPage';

import productsPage from 'pages/ProductsPage';
import addProductPage from 'pages/AddProductPage';
import editProductPage from 'pages/EditProductPage';

import ordersPage from 'pages/OrdersPage';
import addOrderPage from 'pages/AddOrderPage';
import editOrderPage from 'pages/EditOrderPage';
import orderProductsPage from 'pages/OrderProductsPage';

import settingsPage from 'pages/SettingsPage';
import invoicesPage from 'pages/InvoicesPage';

import workersPage from 'pages/WorkersPage';

const routes = [{
    path: '/dashboard',
    name: 'dashboard',
    component: dashboardPage
}, {
    path: '/password/reset',
    name: 'password_reset',
    component: resetPasswordPage
}, {
    path: '/customers',
    name: 'customers',
    component: customersPage
}, {
    path: '/customer/add',
    name: 'addcustomer',
    component: addCustomerPage
}, {
    path: '/customer/edit',
    name: 'edit-customer',
    component: editCustomerPage
}, {
    path: '/products',
    name: 'products',
    component: productsPage
}, {
    path: '/product/add',
    name: 'add-product',
    component: addProductPage
}, {
    path: '/product/edit',
    name: 'edit-product',
    component: editProductPage
}, {
    path: '/orders',
    name: 'orders',
    component: ordersPage
}, {
    path: '/order/add',
    name: 'add-order',
    component: addOrderPage
}, {
    path: '/order/edit',
    name: 'edit-order',
    component: editOrderPage
}, {
    path: '/order/products',
    name: 'order-products',
    component: orderProductsPage
}, {
    path: '/settings',
    name: 'settings',
    component: settingsPage
}, {
    path: '/invoices',
    name: 'invoices',
    component: invoicesPage
}, {
    path: '/workers',
    name: 'workers',
    component: workersPage
}]

export default routes
