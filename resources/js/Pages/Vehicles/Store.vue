<script setup>
import BaseModal from '../../Components/Base/BaseModal.vue'
import BaseButton from '../../Components/Base/BaseButton.vue'
import BaseInput from '../../Components/Base/BaseInput.vue'
import BaseSelect from '../../Components/Base/BaseSelect.vue';

import { route } from 'ziggy-js';
import { formatPlate } from '../../Utils/formatters';

</script>

<template>
    <BaseModal
        :title="isEditing ? 'Editar veículo' : 'Novo veículo'"
        :showModal="showModal" @close="close"
    >
        <div class="grid grid-cols-2 gap-4">
            <BaseInput
                label="Placa"
                :modelValue="form.plate"
                :maxlength="7"
                :error="errors?.plate"
                @update:modelValue="onPlateChange"
            />
            <BaseSelect
                    v-model="form.vehicle_type_id"
                    label="Tipo do Veículo"
                    placeholder="Selecione o tipo do veículo"
                    :options="vehicleTypes"
                    option-label="name"
                    option-value="id"
                    searchable
            />
            <BaseSelect
                    v-model="form.region_id"
                    label="Região"
                    placeholder="Selecione a região"
                    :options="regions"
                    option-label="uf"
                    option-value="id"
                    searchable
            />
            <BaseInput label="Modelo" v-model="form.model" type="text" :error="errors?.model"/>
            <BaseInput label="Ano" v-model="form.year" type="number" :error="errors?.year"/>
            <BaseInput label="Quilometragem Atual" v-model="form.current_km" type="number" :error="errors?.current_km"/>
            <BaseSelect
                v-model="form.status"
                label="Status"
                placeholder="Selecione o status"
                :options="status"
                option-label="model"
                option-value="type"
                searchable
            />
            <BaseInput label="KM pra troca de óleo" v-model="form.oil_change_km" type="number" :error="errors?.oil_change_km"/>
        </div>

        <template #footer>
            <div class="flex justify-end gap-2">
                <BaseButton variant="secondary" @click="close">
                    Cancelar
                </BaseButton>

                <BaseButton @click="submit">
                    Salvar
                </BaseButton>
            </div>
        </template>
    </BaseModal>
</template>

<script>
    export default {
        name: 'VehicleStore',

        components: {
            BaseModal,
            BaseButton,
            BaseInput,
        },

        props: {
            showModal: Boolean,
            vehicle: {
                type: Object,
                default: null,
            },
            vehicleTypes: Array,
            regions: Array,
        },

        emits: ['update:modelValue', 'saved'],

        data() {
            return {
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
                status: [
                    {model: 'Ativo', type: 'active'},
                    {model: 'Manutenção', type: 'maintenance'},
                    {model: 'Vendido', type: 'sold'}
                ],
            }
        },

        watch: {
            vehicle: {
                immediate: true,
                deep: true,
                handler(newVal){
                    if(!newVal) {
                        this.resetForm();
                        return;
                    }
                    this.form = {
                        id: newVal.id ?? null,
                        plate: newVal.plate ?? null,
                        vehicle_type_id: newVal.vehicle_type_id ?? null,
                        model: newVal.model ?? null,
                        year: newVal.year ?? null,
                        region_id: newVal.region_id ?? null,
                        current_km: newVal.current_km ?? null,
                        status: newVal.status ?? null,
                        oil_change_km: newVal.oil_change_km ?? null,
                    }
                }
            },
        },

        computed: {
            isEditing() {
                return !!this.form.id
            },
        },
        methods: {
            close() {
                this.$emit('close')
            },
            submit() {
                this.$emit('saved', this.form)
            },
            onPlateChange(value) {
                this.form.plate = formatPlate(value)
                console.log('formatado:', this.form.plate)
            },
            resetForm() {
                this.form = {
                    id: null,
                    plate: null,
                    vehicle_type_id: null,
                    model: null,
                    year: null,
                    region_id: null,
                    current_km: null,
                    status: null,
                    oil_change_km: null,
                }
            }
        },
    }
</script>
