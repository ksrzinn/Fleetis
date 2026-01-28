<script setup>
import BaseModal from '../../Components/Base/BaseModal.vue'
import BaseButton from '../../Components/Base/BaseButton.vue'
import BaseSelect from '../../Components/Base/BaseSelect.vue'
import BaseInput from '../../Components/Base/BaseInput.vue'
import axios from 'axios'
import dayjs from 'dayjs'
</script>

<template>
    <BaseModal
        title="Lançar frete fixo"
        :showModal="showModal"
        @close="close"
    >
        <div class="grid grid-cols-2 gap-4">

            <BaseSelect
                v-model="form.vehicle_id"
                label="Veículo"
                :options="vehicles"
                option-label="plate"
                option-value="id"
                searchable
            />

            <BaseSelect
                v-model="form.trailer_id"
                label="Reboque"
                :options="trailers"
                option-label="plate"
                option-value="id"
                clearable
            />

            <BaseSelect
                v-model="form.driver_id"
                label="Motorista"
                :options="drivers"
                option-label="name"
                option-value="id"
                searchable
            />

            <BaseSelect
                v-model="form.region_id"
                label="Região"
                :options="regions"
                option-label="uf"
                option-value="id"
            />

            <BaseSelect
                v-model="form.freight_fixed_price_id"
                label="Frete fixo"
                :options="fixedPrices"
                option-label="description"
                option-value="id"
            />

            <BaseInput
                v-model="form.date"
                label="Data do frete"
                type="date"
            />
        </div>

        <template #footer>
            <div class="flex justify-end gap-2">
                <BaseButton variant="secondary" @click="close">
                    Cancelar
                </BaseButton>

                <BaseButton @click="submit">
                    Lançar frete
                </BaseButton>
            </div>
        </template>
    </BaseModal>
</template>

<script>
export default {
    name: 'FixedFreightStore',

    props: {
        showModal: Boolean,
        freight: {
            type: Object,
            default: null,
        }
    },

    emits: ['saved', 'close'],

    data() {
        return {
            form: {
                id: null,
                vehicle_id: null,
                trailer_id: null,
                driver_id: null,
                region_id: null,
                freight_fixed_price_id: null,
                date: dayjs().format('YYYY-MM-DD'),
            },
            vehicles: [],
            trailers: [],
            drivers: [],
            regions: [],
            fixedPrices: [],
        }
    },

    watch: {
        freight: {
            immediate: true,
            deep: true,
            handler(newVal){
                if(!newVal) {
                    this.resetForm();
                    return;
                }
                this.form = {
                    id: newVal?.id ?? null,
                    vehicle_id: newVal?.vehicle_id ?? null,
                    trailer_id: newVal?.trailer_id ?? null,
                    driver_id: newVal?.driver_id ?? null,
                    region_id: newVal?.region_id ?? null,
                    freight_fixed_price_id: newVal?.freight_fixed_price_id ?? null,
                    date: dayjs(newVal?.date).format('YYYY-MM-DD'),
                }
            }
        },
    },

    mounted() {
        this.fetchData()
    },

    methods: {
        close() {
            this.$emit('close')
        },

        submit() {
            this.$emit('saved', this.form)
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

        async fetchData() {
            const [
                vehicles,
                // trailers,
                drivers,
                regions,
                fixedPrices,
            ] = await Promise.all([
                axios.get('/vehicles/fetchVehicles'),
                // axios.get('/trailers/active'), //Fazer rota pra isso
                axios.get('/drivers/fetchDrivers'),
                axios.get('/regions/getAllRegions'),
                axios.get('/freights/fixedFreights/getFixedFreights'),
            ])

            this.vehicles = vehicles.data.data
            // this.trailers = trailers.data.data
            this.drivers = drivers.data.data
            this.regions = regions.data.data
            this.fixedPrices = fixedPrices.data.data
        },
    }
}
</script>
