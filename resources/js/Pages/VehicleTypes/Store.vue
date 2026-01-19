<script setup>
import BaseModal from '../../Components/Base/BaseModal.vue'
import BaseButton from '../../Components/Base/BaseButton.vue'
import BaseInput from '../../Components/Base/BaseInput.vue'
import BaseSelect from '../../Components/Base/BaseSelect.vue';
import { route } from 'ziggy-js';

</script>

<template>
    <BaseModal
        :title="isEditing ? 'Editar tipo de veículo' : 'Novo tipo de veículo'"
        :showModal="showModal" @close="close"
    >
        <div class="grid grid-cols-2 gap-4">
            <BaseInput label="Nome" v-model="form.name" type="text" :error="errors?.name"/>
            <BaseSelect
                    v-model="form.type"
                    label="Modalidade"
                    placeholder="Selecione a modalidade"
                    :options="modalities"
                    option-label="model"
                    option-value="type"
                    searchable
            />
            <BaseInput label="Qtd. Eixos" v-model="form.truck_axles" type="text" :error="errors?.truck_axles"/>
            <BaseInput label="Descrição" v-model="form.description" type="text" :error="errors?.description"/>
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
        name: 'FixedFreightStore',

        components: {
            BaseModal,
            BaseButton,
            BaseInput,
        },

        props: {
            showModal: Boolean,
            vehicleType: {
                type: Object,
                default: null,
            },
        },

        emits: ['update:modelValue', 'saved'],

        data() {
            return {
                form: {
                    id: this.vehicleType?.id ?? null,
                    name: this.vehicleType?.name ?? null,
                    type: this.vehicleType?.type ?? '',
                    description: this.vehicleType?.description ?? '',
                    truck_axles: this.vehicleType?.truck_axles ?? '',
                    oil_change_km: this.vehicleType?.oil_change_km ?? '',
                },
                modalities: [
                    {model: 'Caminhão', type: 'truck'},
                    {model: 'Carreta', type: 'trailer'}
                ],
            }
        },

        watch: {
            vehicleType: {
                immediate: true,
                deep: true,
                handler(newVal){
                    if(!newVal) {
                        this.resetForm();
                        return;
                    }
                    this.form = {
                        id: newVal.id ?? null,
                        name: newVal.name ?? '',
                        type: newVal.type ?? '',
                        description: newVal.description ?? '',
                        truck_axles: newVal.truck_axles ?? '',
                        oil_change_km: newVal.oil_change_km ?? '',
                    }
                }
            }
        },

        computed: {
            isEditing() {
                return !!this.form.id
            },
        },

        mounted() {
            console.log(this.vehicleType);
        },

        methods: {
            close() {
                this.$emit('close')
            },

            submit() {
                this.$emit('saved', this.form)
            },

            resetForm() {
                this.form = {
                    id: null,
                    name: '',
                    type: '',
                    description: '',
                    truck_axles: '',
                    oil_change_km: '',
                }
            }
        },
    }
</script>
