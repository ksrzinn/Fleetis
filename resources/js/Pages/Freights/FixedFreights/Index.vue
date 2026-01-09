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
                            <th class="text-left p-3">Cliente</th>
                            <th class="text-left p-3">Origem</th>
                            <th class="text-left p-3">Destino</th>
                            <th class="text-right p-3">Valor</th>
                            <th class="text-center p-3">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="freight in freights"
                            :key="freight.id"
                            class="border-b hover:bg-slate-50"
                        >
                            <td class="p-3">{{ freight.client }}</td>
                            <td class="p-3">{{ freight.origin }}</td>
                            <td class="p-3">{{ freight.destination }}</td>
                            <td class="p-3 text-right">
                                R$ {{ freight.value }}
                            </td>
                            <td class="p-3 text-center space-x-2">
                                <button
                                    class="text-blue-600 hover:underline"
                                    @click="openEdit(freight)"
                                >
                                    Editar
                                </button>

                                <button
                                    class="text-red-600 hover:underline"
                                    @click="remove(freight.id)"
                                >
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </BaseCard>

            <!-- Modal / Form -->
            <Store
                :showModal="showModal"
                :freight="selectedFreight"
                @saved="reload"
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
            form: {
                id: null,
                client: '',
                origin: '',
                destination: '',
                value: '',
            },
        }
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

        submit() {
            if (this.isEditing) {
                Inertia.put(
                    route('freights.fixed.update', this.form.id),
                    this.form
                )
            } else {
                Inertia.post(route('freights.fixed.store'), this.form)
            }

            this.closeForm()
        },

        remove(id) {
            if (!confirm('Deseja realmente excluir este frete?')) return

            Inertia.delete(route('freights.fixed.destroy', id))
        },
    },
}
</script>
