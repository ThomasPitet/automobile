<script setup>
const props = defineProps(['vehicle'])
</script>

<template>
    <h3>{{ vehicle.brand }} {{ vehicle.model }}</h3>
    <img 
        v-if="vehicle.pictures?.[0]?.url" 
        :src="vehicle.pictures[0].url" 
        alt="Photo du véhicule"
    />
    <div v-else class="no-photo">
        photo indisponible
    </div>

</template>