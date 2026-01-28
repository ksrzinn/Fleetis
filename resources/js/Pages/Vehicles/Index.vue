<script setup>
    import { Inertia } from '@inertiajs/inertia'
    import AppLayout from '../../Layouts/AppLayout.vue';
    import BaseButton from '../../Components/Base/BaseButton.vue';
    import BaseCard from '../../Components/Base/BaseCard.vue';
    import Store from './Store.vue';
    import axios from 'axios';
    import BaseConfirmDeleteModal from '../../Components/Base/BaseConfirmDeleteModal.vue';
</script>

<template>
    <AppLayout title="Veículos">
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-slate-800">
                    Veículos
                </h1>

                <BaseButton @click="openModal" class="bg-primary text-white">
                    Novo Veículo
                </BaseButton>
            </div>

            <!-- Tabela -->
            <BaseCard>
                <table class="w-full text-sm">
                    <thead class="text-slate-500 border-b">
                        <tr>
                            <th class="text-center p-3">Placa</th>
                            <th class="text-center p-3">Tipo de veículo</th>
                            <th class="text-center p-3">Região</th>
                            <th class="text-center p-3">Modelo</th>
                            <th class="text-center p-3">Ano</th>
                            <th class="text-center p-3">Quilometragem atual</th>
                            <th class="text-center p-3">Status</th>
                            <th class="text-center p-3">Km para Troca de Óleo</th>
                            <th class="text-center p-3">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="v in vehicles"
                            :key="v.id"
                            class="border-b hover:bg-slate-50"
                        >
                            <td class="p-3 text-center">{{ v?.plate }}</td>
                            <td class="p-3 text-center">{{ v?.vehicle_type?.name ?? '-' }}</td>
                            <td class="p-3 text-center">{{ v?.base_region?.name ?? '-' }}</td>
                            <td class="p-3 text-center">{{ v?.model ?? '-' }}</td>
                            <td class="p-3 text-center">{{ v?.year ?? '-' }}</td>
                            <td class="p-3 text-center">{{ v?.current_km ?? '-' }}</td>
                            <td class="p-3 text-center">{{ v?.status_label ?? '-' }}</td>
                            <td class="p-3 text-center">{{ v?.oil_change_km ?? '-'}}</td>
                            <td class="p-3 ">
                                <div class="flex items-center justify-center">

                                    <BaseBtn icon rounded
                                    class="mr-3 text-primary hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openEdit(v)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </BaseBtn>
                                    <BaseBtn icon rounded
                                    class="mr-3 text-danger hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openDelete(v)">
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
                :vehicle="selectedVehicle"
                :vehicleTypes="vehicleTypes"
                :regions="regions"
                @saved="submitVehicles"
                @close="showModal = false"
            />

            <BaseConfirmDeleteModal
                :show="showDelete"
                :loading="deleting"
                title="Excluir veículo"
                message="Este veículo será removido. Deseja continuar?"
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
        vehicles: Array,
    },

    data() {
        return {
            showModal: false,
            showDelete: false,
            deletedVehicle: false,
            showForm: false,
            isEditing: false,
            selectedVehicle: null,
            vehicles: this.vehicles ?? [],
            vehicleTypes: [],
            regions: [],
            form: {
                id: null,
                plate: null,
                vehicle_type_id: null,
                model: null,
                year: null,
                region_id: null,
                current_km: null,
                status: null,
                oil_change_km: null,
            },
        }
    },
    mounted() {
        this.fetchVehicles();
        this.fetchVehicleTypes();
        this.fetchRegions();
    },
    methods: {
        openModal(vt) {
            this.resetForm()
            this.showModal = true
        },

        openEdit(vehicle) {
            this.selectedVehicle = vehicle
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

        async submitVehicles(form) {
            if(!form.id){
                await axios.post('vehicles/store', form)
                    .then(() => {
                        this.fetchVehicles();
                        this.showModal = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao salvar o veículo:', error);
                    });
            } else {
                await axios.post(`vehicles/update/${form.id}`, form)
                .then(() => {
                        this.fetchVehicles();
                        this.showModal = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao salvar o veículo:', error);
                    });
            }
        },

        openDelete(vehicle){
            this.deletedVehicle = vehicle;
            this.showDelete = true;
        },

        async remove() {
            await axios.delete(`/vehicles/destroy/${this.deletedVehicle?.id}`)
            .then((res) => {
                this.fetchVehicles();
                this.showDelete = false;
            })
            .catch((err) => {
                console.log(err)
            })
        },

        async fetchVehicles() {
            await axios.get('/vehicles/fetchVehicles')
                .then(response => {
                    this.vehicles = response.data.data;
                })
                .catch(error => {
                    console.error('Erro ao buscar os veículos:', error);
                });
        },

        async fetchVehicleTypes(){
            await axios.get('vehicleTypes/fetchVehicleTypes')
            .then((res)=>{
                this.vehicleTypes = res.data.data
            })
            .catch((err) => {
                console.error('Erro ao buscar os tipos de veículos:', err);
            })
        },

        async fetchRegions(){
            await axios.get('regions/getAllRegions')
            .then((res)=>{
                this.regions = res.data.data
            })
            .catch((err) => {
                console.error('Erro ao buscar as regiões:', err);
            })
        },

    },
}
</script>
