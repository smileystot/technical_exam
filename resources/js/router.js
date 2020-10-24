import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

import Roles from './components/Roles';
import Dashboard from './components/Dashboard';
import Login from './components/Login';
import Users from './components/Users';
import ExpenseCategories from './components/ExpenseCategories';
import Expenses from './components/Expenses';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            beforeEnter (to, from, next) {
                store.state.isLoggedIn ? next() : next('/login')
            },
        },
        {
            path: '/roles',
            name: 'roles',
            component: Roles,
            beforeEnter (to, from, next) {
                if(store.state.isLoggedIn){
                    store.state.user.AccessRights == 1 ? next() : next('/dashboard')
                }else{
                    next('/login')
                }
            },
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter (to, from, next) {
                store.state.isLoggedIn ? next('/dashboard') : next()
            },
        },
        {
            path: '/users',
            name: 'users',
            component: Users,
            beforeEnter (to, from, next) {
                if(store.state.isLoggedIn){
                    store.state.user.AccessRights == 1 ? next() : next('/dashboard')
                }else{
                    next('/login')
                }
            },
        },
        {
            path: '/expense_categories',
            name: 'expense_categories',
            component: ExpenseCategories,
            beforeEnter (to, from, next) {
                if(store.state.isLoggedIn){
                    if(store.state.user.AccessRights == 1){
                        next()
                    }else{
                        next('/dashboard')
                    }
                }else{
                    next('/login')
                }
            },
        },
        {
            path: '/expenses',
            name: 'expenses',
            component: Expenses,
            beforeEnter (to, from, next) {
                store.state.isLoggedIn ? next() : next('/login')
            },
        },
        { 
            path: "*", 
            beforeEnter (to, from, next) {
                store.state.isLoggedIn ? next('/dashboard') : next('/login')
            },
        }
    ]
});