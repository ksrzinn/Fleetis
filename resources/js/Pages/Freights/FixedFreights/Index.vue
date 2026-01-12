<script setup>
    import { Inertia } from '@inertiajs/inertia'
    import AppLayout from '../../../Layouts/AppLayout.vue';
    import BaseButton from '../../../Components/Base/BaseButton.vue';
    import BaseCard from '../../../Components/Base/BaseCard.vue';
import Store from './Store.vue';
</script>

<template>
    <AppLayout title="Fretes Tabelados">
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-slate-800">
                    Fretes Tabelados
                </h1>

                <BaseButton @click="openModal" class="bg-primary text-white">
                    Novo Frete
                </BaseButton>
            </div>

            <!-- Tabela -->
            <BaseCard>
                <table class="w-full text-sm">
                    <thead class="text-slate-500 border-b">
                        <tr>
                            <th class="text-center p-3">Rota</th>
                            <th class="text-center p-3">UF</th>
                            <th class="text-center p-3">Valor</th>
                            <th class="text-center p-3">Média de KMs</th>
                            <th class="text-center p-3">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="freight in freights"
                            :key="freight.id"
                            class="border-b hover:bg-slate-50"
                        >
                            <td class="p-3 text-center">{{ freight.description }}</td>
                            <td class="p-3 text-center">{{ freight?.region?.uf }}</td>
                            <td class="p-3 text-center">R$ {{ freight.fixed_value }}</td>
                            <td class="p-3 text-center">{{ freight.average_km }}</td>
                            <td class="p-3 ">
                                <div class="flex items-center justify-center">

                                    <BaseBtn icon rounded
                                    class="mr-3 text-primary hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openModal(freight)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </BaseBtn>
                                    <BaseBtn icon rounded
                                    class="mr-3 text-danger hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="deleteData(freight)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                                </svg>
                                </BaseBtn>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </BaseCard>

            <!-- Modal / Form -->
            <Store
                :showModal="showModal"
                :freight="selectedFreight"
                @saved="submitFreight"
                @close="showModal = false"
            />

        </div>
    </AppLayout>
</template>

<script>

export default {
    components: { AppLayout },

    props: {
        freights: Array,
    },

    data() {
        return {
            showModal: false,
            showForm: false,
            isEditing: false,
            freights: this.freights ?? [],
            form: {
                id: null,
                client: '',
                origin: '',
                destination: '',
                value: '',
            },
        }
    },
    mounted() {
        this.fetchFreights();
    },
    methods: {
        openModal() {
            this.resetForm()
            this.showModal = true
        },

        openEdit(freight) {
            this.form = { ...freight }
            this.isEditing = true
            this.showForm = true
        },

        closeForm() {
            this.resetForm()
            this.showForm = false
        },

        resetForm() {
            this.isEditing = false
            this.form = {
                id: null,
                client: '',
                origin: '',
                destination: '',
                value: '',
            }
        },

        async submitFreight(form) {
            await axios.post('/api/fixedFreights/store', form)
                .then(() => {
                    this.fetchFreights();
                    this.showModal = false
                    this.reset()
                })
                .catch(error => {
                    console.error('Erro ao salvar o frete fixo:', error);
                });
        },

        remove(id) {
            if (!confirm('Deseja realmente excluir este frete?')) return

            // Inertia.delete(route('freights.fixed.destroy', id))
        },

        async fetchFreights() {
            await axios.get('/api/fixedFreights/getFixedFreights')
                .then(response => {
                    this.freights = response.data.data;
                })
                .catch(error => {
                    console.error('Erro ao buscar fretes fixos:', error);
                });
        },

    },
}
</script>
