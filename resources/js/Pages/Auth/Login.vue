<script setup>
import AuthLayout from "@/layouts/AuthLayout.vue";
</script>

<template>
    <AuthLayout>
        <div class="bg-white p-8 rounded-lg shadow">
            <h1 class="text-2xl font-semibold text-center mb-6">
                Acesso ao sistema
            </h1>

            <form class="space-y-4">
                <input
                    type="email"
                    placeholder="E-mail"
                    class="w-full border rounded px-3 py-2"
                />

                <input
                    type="password"
                    placeholder="Senha"
                    class="w-full border rounded px-3 py-2"
                />

                <button
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
                >
                    Entrar
                </button>
            </form>
        </div>
    </AuthLayout>
</template>
