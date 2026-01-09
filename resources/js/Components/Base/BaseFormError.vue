<script>
export default {
    name: 'BaseFormError',

    props: {
        message: {
            type: String,
            required: true,
        },
    },
}
</script>

<template>
    <p class="text-xs text-red-500 mt-1">
        {{ message }}
    </p>
</template>
