import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/Login.vue";
import Home from "../pages/Home.vue";

const routes = [
    {
        path: "/login",
        component: Login,
    },
    {
        path: "/",
        component: Home,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;