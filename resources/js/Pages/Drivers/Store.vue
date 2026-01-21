<script setup>
import BaseModal from '../../Components/Base/BaseModal.vue'
import BaseButton from '../../Components/Base/BaseButton.vue'
import BaseInput from '../../Components/Base/BaseInput.vue'
import BaseSelect from '../../Components/Base/BaseSelect.vue';
import { route } from 'ziggy-js';

</script>

<template>
    <BaseModal
        :title="isEditing ? 'Editar motorista' : 'Novo motorista'"
        :showModal="showModal" @close="close"
    >
        <div class="grid grid-cols-2 gap-4">
            <BaseInput label="Nome" v-model="form.name" type="text" :error="errors?.name"/>
            <BaseInput label="Telefone" v-model="form.phone" type="text" :error="errors?.phone" v-mask="'(##)#####-####'"/>
            <BaseInput label="CPF" v-model="form.cpf" type="text" :error="errors?.cpf" v-mask="'###.###.###-##'" />
            <BaseInput label="CNH" v-model="form.cnh" type="text" :error="errors?.cnh" v-mask="'#########-##'"/>
            <BaseSelect
                    v-model="form.cnh_type"
                    label="Tipo da CNH"
                    placeholder="Selecione o tipo da CNH"
                    :options="cnh_types"
                    option-label="model"
                    option-value="type"
                    searchable
            />
            <BaseInput label="Salário" v-model="form.salary" type="number" :error="errors?.salary"/>
            <BaseSelect
                    v-model="form.bonus_type"
                    label="Tipo do bônus"
                    placeholder="Selecione o tipo de bônus"
                    :options="bonus_types"
                    option-label="model"
                    option-value="type"
                    searchable
            />
            <BaseInput label="Valor do bônus" v-model="form.bonus_value" type="number" :error="errors?.bonus_value"/>
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
        name: 'DriverStore',

        components: {
            BaseModal,
            BaseButton,
            BaseInput,
        },

        props: {
            showModal: Boolean,
            driver: {
                type: Object,
                default: null,
            },
        },

        emits: ['update:modelValue', 'saved'],

        data() {
            return {
                form: {
                    id: this.driver?.id ?? null,
                    name: this.driver?.name ?? '',
                    phone: this.driver?.phone ?? '',
                    cpf: this.driver?.cpf ?? '',
                    cnh: this.driver?.cnh ?? '',
                    cnh_type: this.driver?.cnh_type ?? '',
                    salary: this.driver?.salary ?? null,
                    bonus_type: this.driver?.bonus_type ?? '',
                    bonus_value: this.driver?.bonus_value ?? null,
                },
                bonus_types: [
                    {model: 'Fixo', type: 'fixed'},
                    {model: 'Porcentagem (ex: 1 = 1%)', type: 'percentage'},
                    {model: 'Nenhum', type: 'none'},
                ],
                cnh_types: [
                    {model: 'A', type: 'a'},
                    {model: 'ACC', type: 'acc'},
                    {model: 'B', type: 'B'},
                    {model: 'AB', type: 'ab'},
                    {model: 'C', type: 'c'},
                    {model: 'D', type: 'd'},
                    {model: 'E', type: 'e'},
                ],
            }
        },

        watch: {
            driver: {
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
                        phone: newVal.phone ?? '',
                        cpf: newVal.cpf ?? '',
                        cnh: newVal.cnh ?? '',
                        cnh_type: newVal.cnh_type ?? '',
                        salary: newVal.salary ?? null,
                        bonus_type: newVal.bonus_type ?? '',
                        bonus_value: newVal.bonus_value ?? null,
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

            resetForm() {
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
            }
        },
    }
</script>
