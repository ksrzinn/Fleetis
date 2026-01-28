<script setup>
import BaseModal from '../../Components/Base/BaseModal.vue'
import BaseButton from '../../Components/Base/BaseButton.vue'
import BaseInput from '../../Components/Base/BaseInput.vue'
import axios from 'axios';
import BaseSelect from '../../Components/Base/BaseSelect.vue';
import { route } from 'ziggy-js';
import dayjs from 'dayjs';

</script>

<template>
    <BaseModal
        :title="isEditing ? 'Editar Frete' : 'Novo Frete'"
        :showModal="showModal" @close="close"
    >
        <div class="grid grid-cols-2 gap-4">
            <BaseSelect
                    v-model="form.region_id"
                    label="UF"
                    placeholder="Selecione o UF"
                    :options="regions"
                    option-label="uf"
                    option-value="id"
                    searchable
            />
            <BaseSelect
                    v-model="form.vehicle_type_id"
                    label="Tipo de veículo"
                    placeholder="Selecione o tipo de veículo"
                    :options="vehicleTypes"
                    option-label="name"
                    option-value="id"
                    searchable
            />
            <BaseInput label="Valor de tarifa (por KM)" v-model="form.price_per_km" type="number" :error="errors?.description"/>
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
        name: 'KmRateStore',

        components: {
            BaseModal,
            BaseButton,
            BaseInput,
        },

        props: {
            showModal: Boolean,
            kmRate: {
                type: Object,
                default: null,
            },
        },

        emits: ['update:modelValue', 'saved'],

        data() {
            return {
                form: {
                    id: null,
                    region_id: null,
                    vehicle_type_id: null,
                    price_per_km: null,
                    active: null,
                    valid_from: dayjs().format('YYYY-MM-DD'),
                    valid_until: dayjs().add(2, 'year').format('YYYY-MM-DD'),
                },
                regions: [],
            }
        },

        watch: {
            kmRate: {
                immediate: true,
                deep: true,
                handler(newVal){
                    if(!newVal) {
                        this.resetForm();
                        return;
                    }
                    this.form = {
                        id: newVal?.id ?? null,
                        region_id: newVal?.region_id ?? null,
                        vehicle_type_id: newVal?.vehicle_type_id ?? null,
                        price_per_km: newVal?.price_per_km ?? null,
                        active: newVal?.active ?? null,
                        valid_from: newVal?.valid_from ?? dayjs().format('YYYY-MM-DD'),
                        valid_until: newVal?.valid_until ?? dayjs().add(2, 'year').format('YYYY-MM-DD'),
                    }
                }
            },
        },

        computed: {
            isEditing() {
                return !!this.form.id
            },
        },


        mounted() {
            this.fetchRegions();
            this.fetchVehicleTypes();
        },

        methods: {
            close() {
                this.$emit('close')
            },

            reset() {
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

            submit() {
                this.$emit('saved', this.form)
            },

            fetchRegions(){
                axios.get('/regions/getAllRegions')
                    .then(response => {
                        this.regions = response.data.data;
                    })
                    .catch(error => {
                        console.error('Erro ao buscar regiões: ', error);
                    });
            },

            fetchVehicleTypes(){
                axios.get('/vehicleTypes/fetchVehicleTypes')
                    .then((res) => {
                        this.vehicleTypes = res?.data?.data;
                    })
                    .catch((err) => {
                        console.error('Erro ao buscar os tipos de veículos: ', err);
                    })
            },

            resetForm() {
                    this.form = {
                        id: null,
                        region_id: null,
                        vehicle_type_id: null,
                        price_per_km: null,
                        active: null,
                        valid_from: dayjs().format('YYYY-MM-DD'),
                        valid_until: dayjs().add(2, 'year').format('YYYY-MM-DD'),
                    }
                }
        },

    }
</script>
