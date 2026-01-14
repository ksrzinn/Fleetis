<script setup>
import { ref } from 'vue'
import { ChevronDown } from 'lucide-vue-next'
import axios from 'axios';

const open = ref(false)

// mock enquanto auth não existe
const user = {
    name: 'Usuário'
}
</script>

<template>
    <div class="relative">
        <button
            @click="open = !open"
            class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-100"
        >
            <div
                class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-semibold"
            >
                {{ user.name.charAt(0) }}
            </div>

            <span class="text-sm font-medium text-slate-700">
                {{ user.name }}
            </span>

            <ChevronDown class="w-4 h-4 text-slate-500" />
        </button>

        <!-- Dropdown -->
        <div
            v-if="open"
            class="absolute right-0 mt-2 w-40 bg-white border rounded-md shadow"
            style="border-color: var(--color-border)"
        >
            <button
                class="w-full text-left px-4 py-2 text-sm hover:bg-slate-100"
            >
                Perfil
            </button>

            <button
                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                @click="logout"
            >
                Sair
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UserMenu',
    methods: {
        logout() {
            // Lógica de logout aqui
            axios.post('/logout')
                .then(() => {
                    localStorage.removeItem('auth_token');
                    axios.defaults.headers.common['Authorization'] = null;
                    this.$inertia.visit('/login');
                })
                .catch((err) => {
                    console.log(err);
                    alert('Erro ao fazer logout.');
                });
        }
    }
}
</script>
