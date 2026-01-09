<template>
    <teleport to="body">
        <transition name="fade">
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center"
            >
                <!-- backdrop -->
                <div
                    class="absolute inset-0 bg-black/50 h-full w-full"
                    @click="close"
                />

                <!-- modal -->
                <div
                    class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl z-10"
                    @click.stop
                >
                    <div class="p-6">
                        <h2 class="text-lg font-semibold mb-4">
                            {{ title }}
                        </h2>

                        <slot />
                    </div>
                    <div class="mt-6 bg-[#dad7d7] px-4 py-2 flex max-w-full w-full justify-end">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>

<script>
export default {
    name: 'BaseModal',

    props: {
        showModal: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            default: '',
        },
    },

    emits: ['update:showModal'],

    methods: {
        close() {
            this.$emit('close')
        },
    },
}
</script>

<style scoped>
    .debugCol {
        background-color: rgba(255, 0, 0, 0.1);
        border: 1px solid red;
    }
</style>
