<script setup>
import { ref } from "vue";
import { useAuthApi } from "../composables/api/useAuth.api";
import { useRouter } from "vue-router";

const router = useRouter();
const { loading, login } = useAuthApi();

const form = ref({
    email: null,
    password: null,
});

const auth = async () => {
    try {
        const token = await login(form.value.email, form.value.password);
        localStorage.setItem("auth_token", token);
        router.push("/");
    } catch (error) {
        console.log(error);
    }
};
</script>
<template>
    <div class="container">
        <div
            class="min-vh-100 d-flex align-items-center justify-content-center"
        >
            <div class="card p-4" style="width: 100%; max-width: 400px">
                <h2 class="text-center mb-4">Авторизация</h2>

                <form @submit.prevent="auth">
                    <div class="mb-3">
                        <label class="form-label"> Email </label>
                        <input
                            v-model="form.email"
                            type="text"
                            required
                            placeholder="Type your email"
                            class="form-control"
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Пароль </label>
                        <input
                            v-model="form.password"
                            type="password"
                            placeholder="Type your password"
                            required
                            class="form-control"
                        />
                    </div>

                    <div>
                        <button class="btn btn-primary" :disabled="loading">
                            Войти
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
