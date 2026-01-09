<script>
import AppLayout from '../Layouts/AppLayout.vue'
import BaseCard from '../Components/Base/BaseCard.vue'

export default {
    name: 'Dashboard',

    components: {
        AppLayout,
        BaseCard,
    },
}
</script>

<template>
    <AppLayout>
        <div class="grid grid-cols-3 gap-6">
            <BaseCard title="Fretes Hoje">
                <p class="text-3xl font-bold">12</p>
            </BaseCard>

            <BaseCard title="KM Rodados">
                <p class="text-3xl font-bold">1.240 km</p>
            </BaseCard>

            <BaseCard title="Custo Total">
                <p class="text-3xl font-bold">R$ 8.540</p>
            </BaseCard>
        </div>
    </AppLayout>
</template>
