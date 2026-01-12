<script setup>
import BaseModal from '../../../Components/Base/BaseModal.vue'
import BaseButton from '../../../Components/Base/BaseButton.vue'
import BaseInput from '../../../Components/Base/BaseInput.vue'
import axios from 'axios';
import BaseSelect from '../../../Components/Base/BaseSelect.vue';
import { route } from 'ziggy-js';
import dayjs from 'dayjs';

</script>

<template>
    <BaseModal
        :title="isEditing ? 'Editar Frete' : 'Novo Frete'"
        :showModal="showModal" @close="close"
    >
        <div class="grid grid-cols-2 gap-4">
            <BaseInput label="Rota" v-model="form.description" type="text" :error="errors?.description"/>
            <BaseSelect
                    v-model="form.region_id"
                    label="UF"
                    placeholder="Selecione o UF"
                    :options="regions"
                    option-label="uf"
                    option-value="id"
                    searchable
            />
            <BaseInput label="Valor do Frete" v-model="form.fixed_value" type="text" :error="errors?.fixed_value"/>
            <BaseInput label="Kilomêtros Médio" v-model="form.average_km" type="number" :error="errors?.average_km"/>
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
        name: 'FixedFreightStore',

        components: {
            BaseModal,
            BaseButton,
            BaseInput,
        },

        props: {
            showModal: Boolean,
            freight: {
                type: Object,
                default: null,
            },
        },

        emits: ['update:modelValue', 'saved'],

        data() {
            return {
                form: {
                    id: null,
                    description: '',
                    region_id: null,
                    average_km: '',
                    fixed_value: '',
                    valid_from: dayjs().format('YYYY-MM-DD'),
                    valid_until: dayjs().add(2, 'year').format('YYYY-MM-DD'),
                },
                regions: [],
            }
        },

        computed: {
            isEditing() {
                return !!this.form.id
            },
        },


        mounted() {
            this.fetchRegions();
        },

        methods: {
            close() {
                this.$emit('close')
            },

            reset() {
                this.form = {
                    region_id: null,
                    description: '',
                    fixed_value: '',
                    average_km: '',
                    valid_from: dayjs().format('YYYY-MM-DD'),
                    valid_until: dayjs().add(2, 'year').format('YYYY-MM-DD'),
                }
            },

            submit() {
                this.$emit('saved', this.form)
            },

            fetchRegions(){
                axios.get('/api/regions/getAllRegions')
                    .then(response => {
                        this.regions = response.data.data;
                    })
                    .catch(error => {
                        console.error('Error fetching regions:', error);
                    });
            },
        },
    }
</script>
