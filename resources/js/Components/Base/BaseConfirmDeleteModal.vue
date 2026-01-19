<script setup>
import BaseModal from './BaseModal.vue'
import BaseButton from './BaseButton.vue'

defineProps({
    show: {
        type: Boolean,
        required: true
    },
    title: {
        type: String,
        default: 'Confirmar exclusão'
    },
    message: {
    type: String,
    default: 'Tem certeza que deseja excluir este registro? Esta ação não poderá ser desfeita.'
    },
    loading: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['confirm', 'close'])
</script>

<template>
    <BaseModal
        :showModal="show"
        :title="title"
        @close="emit('close')"
    >
    <div class="space-y-4">
        <p class="text-sm text-gray-600">
            {{ message }}
        </p>

        <div class="flex justify-end gap-2 pt-4">
                <BaseButton
                variant="secondary"
                :disabled="loading"
                @click="emit('close')"
                >
                Cancelar
                </BaseButton>

                <BaseButton
                variant="danger"
                :loading="loading"
                @click="emit('confirm')"
                >
                Excluir
                </BaseButton>
            </div>
        </div>
    </BaseModal>
</template>
