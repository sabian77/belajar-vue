import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

// Import komponen
import Login from './components/Login.vue';
import DivisiList from './components/DivisiList.vue';
import JobList from './components/JobList.vue';
import EmployeeList from './components/EmployeList.vue';
import App from './components/App.vue';

// Setup router
const router = createRouter({
    history: createWebHistory(),
    routes: [
        { 
            path: '/login',
            component: Login,
            name: 'login'
        },
        {
            path: '/',
            component: App,
            meta: { requiresAuth: true },
            children: [
                { path: '', redirect: '/employee' },
                { path: '/divisi', component: DivisiList },
                { path: '/job', component: JobList },
                { path: '/employee', component: EmployeeList }
            ]
        }
    ]
});

// Navigation guard
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!token) {
            next('/login');
        } else {
            next();
        }
    } else {
        if (token && to.name === 'login') {
            next('/');
        } else {
            next();
        }
    }
});

// Setup axios default header jika token ada
const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

// Create Vue app
const app = createApp({});
app.use(router);
app.mount('#app');