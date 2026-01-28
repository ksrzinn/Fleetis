<script setup>
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '../../Layouts/AppLayout.vue';
import BaseButton from '../../Components/Base/BaseButton.vue';
import BaseCard from '../../Components/Base/BaseCard.vue';
import Store from './Store.vue';
import dayjs from 'dayjs';
import BaseConfirmDeleteModal from '../../Components/Base/BaseConfirmDeleteModal.vue';
</script>

<template>
    <AppLayout title="Tarifa por região">
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-slate-800">
                    Tarifa por Região
                </h1>

                <BaseButton @click="openModal" class="bg-primary text-white">
                    Nova tarifa
                </BaseButton>
            </div>

            <!-- Tabela -->
            <BaseCard>
                <table class="w-full text-sm">
                    <thead class="text-slate-500 border-b">
                        <tr>
                            <th class="text-center p-3">Região</th>
                            <th class="text-center p-3">Tipo de veículo</th>
                            <th class="text-center p-3">Valor p/Km</th>
                            <th class="text-center p-3">Ativo</th>
                            <th class="text-center p-3">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="kmRate in kmRates"
                            :key="kmRate.id"
                            class="border-b hover:bg-slate-50"
                        >
                        <td class="p-3 text-center">{{ kmRate?.region?.uf }}</td>
                            <td class="p-3 text-center">{{ kmRate?.vehicle_type?.name }}</td>
                            <td class="p-3 text-center">R$ {{ kmRate?.price_per_km }}</td>
                            <td class="p-3 text-center">{{ kmRate?.active ? 'Sim' : 'Não' }}</td>
                            <td class="p-3 ">
                                <div class="flex items-center justify-center">

                                    <BaseBtn icon rounded
                                    class="mr-3 text-primary hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openEdit(kmRate)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </BaseBtn>
                                    <BaseBtn icon rounded
                                    class="mr-3 text-danger hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openDelete(kmRate)">
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
                :kmRate="selectedKm"
                @saved="submitKmr"
                @close="showModal = false"
            />

            <BaseConfirmDeleteModal
                :show="showDelete"
                :loading="deleting"
                title="Excluir tarifa"
                message="Esta tarifa será removida. Deseja continuar?"
                @confirm="remove"
                @close="showDelete = false"
            />

        </div>
    </AppLayout>
</template>

<script>

export default {
    components: { AppLayout },

    props: {
        kmRates: Array,
    },

    data() {
        return {
            showModal: false,
            showDelete: false,
            showForm: false,
            selectedKm: false,
            deletedKmr: null,
            isEditing: false,
            kmRates: this.kmRates ?? [],
            form: {
                id: null,
                region_id: null,
                vehicle_type_id: null,
                price_per_km: null,
                active: null,
                valid_from: dayjs().format('YYYY-MM-DD'),
                valid_until: dayjs().add(2, 'year').format('YYYY-MM-DD'),
            },
        }
    },
    mounted() {
        this.fetchKmRates();
    },
    methods: {
        openModal() {
            this.resetForm()
            this.showModal = true
        },

        openEdit(kmr) {
            this.selectedKm = kmr
            console.log(this.selectedKm)
            console.log(kmr)
            this.isEditing = true
            this.showModal = true
        },

        closeForm() {
            this.resetForm()
            this.showForm = false
        },

        resetForm() {
            this.isEditing = false
            this.form = {
                id: null,
                region_id: null,
                vehicle_type_id: null,
                price_per_km: null,
                active: null,
                valid_from: dayjs().format('YYYY-MM-DD'),
                valid_until: dayjs().add(2, 'year').format('YYYY-MM-DD'),
            }
        },

        openDelete(kmr){
            this.deletedKmr = kmr;
            this.showDelete = true;
        },

        async remove() {
            await axios.delete(`/kmRates/destroy/${this.deletedKmr?.id}`)
            .then((res) => {
                this.fetchKmRates();
                this.showDelete = false;
            })
            .catch((err) => {
                console.log(err)
            })
        },

        async submitKmr(form) {
            if(!form.id){
                await axios.post('/kmRates/store', form)
                    .then(() => {
                        this.fetchKmRates();
                        this.showModal = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao salvar a tarifa:', error);
                    });
            } else {
                await axios.post(`/kmRates/update/${form.id}`, form)
                .then(() => {
                        this.fetchKmRates();
                        this.showModal = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao salvar a tarifa:', error);
                    });
            }
        },

        async fetchKmRates() {
            await axios.get('/kmRates/fetchKmRates')
                .then(response => {
                    this.kmRates = response.data.data;
                })
                .catch(error => {
                    console.error('Erro ao buscar as tarifas por região:', error);
                });
        },

    },
}
</script>
