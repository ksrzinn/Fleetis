<script setup>
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '../../Layouts/AppLayout.vue';
import BaseButton from '../../Components/Base/BaseButton.vue';
import BaseCard from '../../Components/Base/BaseCard.vue';
// import Store from './Store.vue';
import dayjs from 'dayjs';
import BaseConfirmDeleteModal from '../../Components/Base/BaseConfirmDeleteModal.vue';
import FixedFreightStore from './FixedFreightStore.vue';
import { formatPlate, formatDate } from '../../Utils/formatters';
</script>

<template>
    <AppLayout title="Fretes">
        <div class="space-y-6">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-slate-800">
                    Lançamento de fretes
                </h1>

                <BaseButton @click="openModal" class="bg-primary text-white">
                    Lançar frete fixo
                </BaseButton>
            </div>

            <!-- Tabela -->
            <BaseCard>
                <table class="w-full text-sm">
                    <thead class="text-slate-500 border-b">
                        <tr>
                            <th class="text-center p-3">Placa cavalo</th>
                            <th class="text-center p-3">Placa carreta</th>
                            <th class="text-center p-3">Motorista</th>
                            <th class="text-center p-3">UF</th>
                            <th class="text-center p-3">Rota</th>
                            <th class="text-center p-3">Tipo do frete</th>
                            <th class="text-center p-3">Km. inicial</th>
                            <th class="text-center p-3">Km. final</th>
                            <th class="text-center p-3">Data</th>
                            <th class="text-center p-3">Status</th>
                            <th class="text-center p-3">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="freight in freights"
                            :key="freight.id"
                            class="border-b hover:bg-slate-50"
                        >
                            <td class="p-3 text-center">{{ formatPlate(freight?.vehicle?.plate )?? '-'}}</td>
                            <td class="p-3 text-center">{{ freight?.trailer ? formatPlate(freight?.trailer?.plate) : '-' }}</td>
                            <td class="p-3 text-center">{{ freight?.driver?.name ?? '-'}}</td>
                            <td class="p-3 text-center">{{ freight?.region?.uf ?? '-'}}</td>
                            <td class="p-3 text-center">{{ freight?.fixed_price?.description ?? '-' }}</td>
                            <td class="p-3 text-center">{{ freight?.freight_type_label ?? '-' }}</td>
                            <td class="p-3 text-center">{{ freight?.km_start ?? '-' }}</td>
                            <td class="p-3 text-center">{{ freight?.km_end ?? '-' }}</td>
                            <td class="p-3 text-center">{{ freight?.status_label ?? '-' }}</td>
                            <td class="p-3 text-center">{{ formatDate(freight?.date) ?? '-' }}</td>
                            <td class="p-3 ">
                                <div class="flex items-center justify-center">

                                    <BaseBtn icon rounded
                                    class="mr-3 text-primary hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openEdit(freight)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </BaseBtn>
                                    <BaseBtn icon rounded
                                    v-show="!freight?.status === 'closed'"
                                    class="mr-3 text-danger hover:bg-gray-200 dark:hover:bg-foreground"
                                    @click="openDelete(freight)">
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
            <FixedFreightStore
                :showModal="showModalFixed"
                :freight="selectedFreight"
                @saved="submitFixedFreight"
                @close="showModalFixed = false"
            />

            <BaseConfirmDeleteModal
                :show="showDelete"
                :loading="deleting"
                title="Excluir frete"
                message="Este frete será removido. Deseja continuar?"
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
        freights: Array,
    },

    data() {
        return {
            showModalFixed: false,
            showDelete: false,
            selectedFreight: false,
            deletedFreight: null,
            isEditing: false,
            freights: this.freights ?? [],
            form: {
                id: null,
                vehicle_id: null,
                trailer_id: null,
                driver_id: null,
                region_id: null,
                freight_type: null,
                status: null,
                freight_fixed_price_id: null,
                date: dayjs().format('YYYY-MM-DD'),
                km_start: null,
                km_end: null
            },
        }
    },
    mounted() {
        this.fetchFreights();
    },
    methods: {
        openModal() {
            this.resetForm()
            this.showModalFixed = true
        },

        openEdit(freight) {
            this.selectedFreight = freight
            this.isEditing = true
            if(this.selectedFreight.freight_type === 'fixed'){
                this.showModalFixed = true;
            }
        },

        resetForm() {
            this.isEditing = false
            this.form = {
                id: null,
                vehicle_id: null,
                trailer_id: null,
                driver_id: null,
                region_id: null,
                freight_type: null,
                status: null,
                freight_fixed_price_id: null,
                date: dayjs().format('YYYY-MM-DD'),
                km_start: null,
                km_end: null
            }
        },

        openDelete(freight){
            this.deletedFreight = freight;
            this.showDelete = true;
        },

        async remove() {
            await axios.delete(`/freights/${this.deletedFreight?.id}`)
            .then((res) => {
                this.fetchFreights();
                this.showDelete = false;
            })
            .catch((err) => {
                console.log(err)
            })
        },

        async submitFixedFreight(form) {
            console.log(form);
            if(!form.id){
                await axios.post('/freights/fixed', form)
                    .then(() => {
                        this.fetchFreights();
                        this.showModalFixed = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao salvar a tarifa:', error);
                    });
            } else {
                await axios.put(`/freights/fixed/${form.id}`, form)
                .then(() => {
                        this.fetchFreights();
                        this.showModalFixed = false
                        this.resetForm()
                    })
                    .catch(error => {
                        console.error('Erro ao salvar a tarifa:', error);
                    });
            }
        },

        async fetchFreights() {
            await axios.get('/freights/fetchFreights') //TODO: azer essa rota ainda
                .then(response => {
                    console.log(response);
                    this.freights = response.data;
                })
                .catch(error => {
                    console.error('Erro ao buscar os fretes:', error);
                });
        },

    },
}
</script>
