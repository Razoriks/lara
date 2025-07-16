<script setup>
import { useRouter } from "vue-router";
import { useAuthApi } from "../composables/api/useAuth.api";

const router = useRouter();
const { loading, logout: submitLogout } = useAuthApi();

const logout = async () => {
    try {
        await submitLogout();
        localStorage.removeItem("auth_token");
        router.push("/login");
    } catch (error) {
        console.log(error);
    }
};
</script>
<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">Lara</a>

            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <router-link to="/" class="nav-link" activeClass="active">
                        Главная
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link
                        to="/transactions"
                        class="nav-link"
                        activeClass="active"
                    >
                        История
                    </router-link>
                </li>
            </ul>

            <button
                class="btn btn-sm btn-outline-secondary"
                type="button"
                :disabled="loading"
                @click="logout"
            >
                Выйти
            </button>
        </div>
    </nav>

    <div class="container">
        <slot></slot>
    </div>

    <footer class="text-center">© {{ new Date().getFullYear() }}</footer>
</template>
