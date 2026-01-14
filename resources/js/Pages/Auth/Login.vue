<script setup>
    import AuthLayout from '../../Layouts/AuthLayout.vue'
    import BaseButton from '../../Components/Base/BaseButton.vue'
    import { route } from 'ziggy-js';
</script>

<template>
    <AuthLayout>
        <div class="w-full max-w-sm px-6">
            <!-- Logo / Title -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-medium text-slate-900 tracking-tight">
                    Fleetis
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Gestão de frota
                </p>
            </div>

            <!-- Box -->
            <div class="bg-white rounded-2xl px-6 py-8 shadow-lg">
                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label class="text-sm text-slate-600">
                            E-mail
                        </label>
                        <input
                            v-model="form.email"
                            type="email"
                            class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    <div>
                        <label class="text-sm text-slate-600">
                            Senha
                        </label>
                        <input
                            v-model="form.password"
                            type="password"
                            class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    <BaseButton
                        type="submit"
                        :loading="loading"
                        class="w-full mt-2"
                    >
                        Entrar
                    </BaseButton>
                </form>
            </div>
        </div>
    </AuthLayout>
</template>

<script>
    export default {
        name: 'Login',

        components: {
            AuthLayout,
            BaseButton,
        },

        data() {
            return {
                form: {
                    email: '',
                    password: '',
                },
                loading: false,
            }
        },

        methods: {
            submit() {
                this.loading = true
                axios.post('/webLogin', {email: this.form.email, password: this.form.password})
                    .then((res) => {
                        this.$inertia.visit('/')
                    })
                    .catch((err) => {
                        console.log(err)
                        alert(err?.response?.data?.message ?? 'Erro ao fazer login. Verifique suas credenciais.')
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
        },
    }
</script>
