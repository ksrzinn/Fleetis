<script setup>
import BaseModal from '../../../Components/Base/BaseModal.vue'
import BaseButton from '../../../Components/Base/BaseButton.vue'
import BaseInput from '../../../Components/Base/BaseInput.vue'
</script>

<template>
    <BaseModal
        :title="isEditing ? 'Editar Frete' : 'Novo Frete'"
        :showModal="showModal" @close="close"
    >
        <div class="grid grid-cols-2 gap-4">
            <BaseInput label="Região" v-model="form.region" type="text" :error="errors?.region"/>
            <BaseInput label="Rota" v-model="form.description" type="text" :error="errors?.description"/>
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
                    client: '',
                    origin: '',
                    destination: '',
                    value: '',
                },
            }
        },

        computed: {
            isEditing() {
                return !!this.form.id
            },
        },

        watch: {
            freight: {
                immediate: true,
                handler(freight) {
                    if (freight) {
                        this.form = { ...freight }
                    } else {
                        this.reset()
                    }
                },
            },
        },

        methods: {
            close() {
                this.$emit('close')
            },

            reset() {
                this.form = {
                    id: null,
                    client: '',
                    origin: '',
                    destination: '',
                    value: '',
                }
            },

            submit() {
                console.log(this.form);
            },
        },
    }
</script>
