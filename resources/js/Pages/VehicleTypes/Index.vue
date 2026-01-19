<script setup>
    import { Inertia } from '@inertiajs/inertia'
    import AppLayout from '../../Layouts/AppLayout.vue';
    import BaseButton from '../../Components/Base/BaseButton.vue';
    import BaseCard from '../../Components/Base/BaseCard.vue';
    import Store from './Store.vue';
import axios from 'axios';
</script>

<template>
    <AppLayout title="Fretes Tabelados">
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-slate-800">
                    Tipos de veículos
                </h1>

                <BaseButton @click="openModal" class="bg-primary text-white">
                    Novo Tipo de Veículo
                </BaseButton>
            </div>

            <!-- Tabela -->
            <BaseCard>
                <table class="w-full text-sm">
                    <thead class="text-slate-500 border-b">
                        <tr>
                            <th class="text-center p-3">Nome</th>
                            <th class="text-center p-3">Modalidade</th>
                            <th class="text-center p-3">Eixos</th>
                            <th class="text-center p-3">Descrição</th>
                            <th class="text-center p-3">Km para Troca de Óleo</th>
                            <th class="text-center p-3">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="vt in vehicleTypes"
                            :key="vt.id"
                            class="border-b hover:bg-slate-50"
                        >
                            <td class="p-3 text-center">{{ vt.name }}</td>
                            <td class="p-3 text-center">{{ vt.type }}</td>
                            <td class="p-3 text-center">{{ vt.truck_axles }}</td>
                            <td class="p-3 text-center">{{ vt.description }}</td>
                            <td class="p-3 text-center">{{ vt.oil_change_km ?? '-'}}</td>
                            <td class="p-3 ">
                                <div class="flex items-center justify-center">

                                    <BaseBtn icon rounded
                                    class="mr-3 text-primary hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openEdit(vt)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </BaseBtn>
                                    <BaseBtn icon rounded
                                    class="mr-3 text-danger hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="deleteData(vt)">
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
                :vehicleType="selectedVt"
                @saved="submitVehicleType"
                @close="showModal = false"
            />

        </div>
    </AppLayout>
</template>

<script>

export default {
    components: { AppLayout },

    props: {
        vehicleTypes: Array,
    },

    data() {
        return {
            showModal: false,
            showForm: false,
            isEditing: false,
            selectedVt: null,
            vehicleTypes: this.vehicleTypes ?? [],
            form: {
                id: null,
                description: '',
                fixed_value: '',
                average_km: '',
                valid_from: '',
                valid_until: '',
            },
        }
    },
    mounted() {
        this.fetchVehicleTypes();
    },
    methods: {
        openModal(vt) {
            this.resetForm()
            this.showModal = true
        },

        openEdit(vehicleType) {
            this.selectedVt = vehicleType
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
                description: '',
                fixed_value: '',
                average_km: '',
                valid_from: '',
                valid_until: '',
            }
        },

        async submitVehicleType(form) {
            if(!form.id){
                await axios.post('vehicleTypes/store', form)
                    .then(() => {
                        this.fetchVehicleTypes();
                        this.showModal = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao salvar o tipo de veículo:', error);
                    });
            } else {
                await axios.post(`vehicleTypes/update/${form.id}`, form)
                .then(() => {
                        this.fetchVehicleTypes();
                        this.showModal = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao salvar o tipo de veículo:', error);
                    });
            }
        },

        remove(id) {
            if (!confirm('Deseja realmente excluir este tipo de veículo?')) return

            // Inertia.delete(route('freights.fixed.destroy', id))
        },

        async fetchVehicleTypes() {
            await axios.get('/vehicleTypes/fetchVehicleTypes')
                .then(response => {
                    this.vehicleTypes = response.data.data;
                })
                .catch(error => {
                    console.error('Erro ao buscar os tipos de veículos:', error);
                });
        },

    },
}
</script>
