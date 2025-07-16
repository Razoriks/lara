import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "home",
        component: () => import("../views/HomeView.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/login",
        name: "login",
        component: () => import("../views/LoginView.vue"),
        meta: { guestOnly: true },
    },
    {
        path: "/transactions",
        name: "transactions",
        component: () => import("../views/TransactionsView.vue"),
        meta: {
            requiresAuth: true,
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem("auth_token") !== null;

    if (to.meta.requiresAuth && !isAuthenticated) {
        next("/login");
    } else if (to.meta.guestOnly && isAuthenticated) {
        next("/");
    } else {
        next();
    }
});
export default router;
