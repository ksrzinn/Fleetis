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
                    name: null,
                    type: '',
                    description: '',
                    truck_axles: '',
                    oil_change_km: '',
                },
                modalities: [
                    {model: 'Caminhão', type: 'truck'},
                    {model: 'Carreta', type: 'trailer'}
                ],
            }
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

            reset() {
                this.form = {
                    description: '',
                    fixed_value: '',
                    average_km: '',
                    valid_from: '',
                    valid_until: '',
                }
            },

            submit() {
                this.$emit('saved', this.form)
            },
        },
    }
</script>
