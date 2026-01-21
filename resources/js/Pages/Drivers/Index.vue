<script setup>
    import { Inertia } from '@inertiajs/inertia'
    import AppLayout from '../../Layouts/AppLayout.vue';
    import BaseButton from '../../Components/Base/BaseButton.vue';
    import BaseCard from '../../Components/Base/BaseCard.vue';
    import Store from './Store.vue';
    import axios from 'axios';
    import BaseConfirmDeleteModal from '../../Components/Base/BaseConfirmDeleteModal.vue';
    import { formatCpf, formatPhone, formatCNH, formatCnhType } from '../../Utils/formatters';
</script>

<template>
    <AppLayout title="Motoristas">
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-slate-800">
                    Cadastro de Motoristas
                </h1>

                <BaseButton @click="openModal" class="bg-primary text-white">
                    Novo Motorista
                </BaseButton>
            </div>

            <!-- Tabela -->
            <BaseCard>
                <table class="w-full text-sm">
                    <thead class="text-slate-500 border-b">
                        <tr>
                            <th class="text-center p-3">Nome</th>
                            <th class="text-center p-3">Telefone</th>
                            <th class="text-center p-3">CPF</th>
                            <th class="text-center p-3">CNH</th>
                            <th class="text-center p-3">Tipo CNH</th>
                            <th class="text-center p-3">Salário</th>
                            <th class="text-center p-3">Tipo de Bônus</th>
                            <th class="text-center p-3">Valor do Bônus</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="dr in drivers"
                            :key="dr.id"
                            class="border-b hover:bg-slate-50"
                        >
                            <td class="p-3 text-center">{{ dr.name }}</td>
                            <td class="p-3 text-center">{{ formatPhone(dr.phone) ?? '-'}}</td>
                            <td class="p-3 text-center">{{ formatCpf(dr.cpf) }}</td>
                            <td class="p-3 text-center">{{ formatCNH(dr.cnh) }}</td>
                            <td class="p-3 text-center">{{ formatCnhType(dr.cnh_type) ?? '-'}}</td>
                            <td class="p-3 text-center">{{ dr.salary ?? '-'}}</td>
                            <td class="p-3 text-center">{{ dr.bonus_type_label ?? '-'}}</td>
                            <td class="p-3 text-center">{{ dr.bonus_value ?? '-'}}</td>
                            <td class="p-3 ">
                                <div class="flex items-center justify-center">

                                    <BaseBtn icon rounded
                                    class="mr-3 text-primary hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openEdit(dr)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </BaseBtn>
                                    <BaseBtn icon rounded
                                    class="mr-3 text-danger hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openDelete(dr)">
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
                :driver="selectedDriver"
                @saved="submitDriver"
                @close="showModal = false"
            />

            <BaseConfirmDeleteModal
                :show="showDelete"
                :loading="deleting"
                title="Excluir Motorista"
                message="Este motorista será removido. Deseja continuar?"
                @confirm="remove"
                @close="showDeleteModal = false"
            />

        </div>
    </AppLayout>
</template>

<script>

export default {
    components: { AppLayout },

    props: {
        drivers: Array,
    },

    data() {
        return {
            showModal: false,
            showDelete: false,
            deletedDriver: false,
            showForm: false,
            isEditing: false,
            selectedDriver: null,
            drivers: this.drivers ?? [],
            form: {
                id: null,
                name: null,
                phone: null,
                cnh: null,
                cpf: null,
                cnh_type: null,
                salary: null,
                bonus_type: null,
                bonus_value: null,
            },
        }
    },
    mounted() {
        this.fetchDrivers();
    },
    methods: {
        openModal(vt) {
            this.resetForm()
            this.showModal = true
        },

        openEdit(driver) {
            this.selectedDriver = driver
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
                name: null,
                phone: null,
                cnh: null,
                cpf: null,
                cnh_type: null,
                salary: null,
                bonus_type: null,
                bonus_value: null,
            }
        },

        async submitDriver(form) {
            this.normalizeData(form);
            if(!form.id){
                await axios.post('drivers/store', form)
                    .then(() => {
                        this.fetchDrivers();
                        this.showModal = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao salvar cadastro do motorista:', error);
                    });
            } else {
                await axios.post(`drivers/update/${form.id}`, form)
                .then(() => {
                        this.fetchDrivers();
                        this.showModal = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao atualizar o cadastro do motorista:', error);
                    });
            }
        },
        normalizeData(form){
            form.cpf = form?.cpf?.replace(/\D/g, '').slice(0, 11);
            form.phone = form?.phone?.replace(/\D/g, '').slice(0,11);
            form.cnh = form?.cnh?.replace(/\D/g, '').slice(0,11);
        },
        openDelete(dr){
            this.deletedDriver = dr;
            this.showDelete = true;
        },

        async remove() {
            await axios.delete(`/drivers/destroy/${this.deletedDriver?.id}`)
            .then((res) => {
                this.fetchDrivers();
                this.showDelete = false;
            })
            .catch((err) => {
                console.log(err)
            })
        },

        async fetchDrivers() {
            await axios.get('/drivers/fetchDrivers')
                .then(response => {
                    this.drivers = response.data.data;
                })
                .catch(error => {
                    console.error('Erro ao buscar os motoristas:', error);
                });
        },

    },
}
</script>
