<script setup>
const props = defineProps(['vehicle'])
</script>

<template>
    <article class="card">
    <h3>{{ vehicle.brand }} {{ vehicle.model }}</h3>
    <p class="version">
        {{ vehicle.version }}
    </p>
    <img 
        v-if="vehicle.pictures?.[0]?.url" 
        :src="vehicle.pictures[0].url" 
        alt="Photo du véhicule"
    />
    <div v-else class="no-photo">
        photo indisponible
    </div>
            <p class="price">
                {{ vehicle.prices?.merchantPrice?.toLocaleString('fr-FR') }} €
            </p>
            <span class="km">
                {{ vehicle.mileage?.toLocaleString('fr-FR') }} km
            </span>
            <span class="year">
                {{ vehicle.year ?? 'Année non renseignée' }}
            </span>
            <span class="fuel">
                {{ vehicle.fuel }}
            </span>
        </article>
</template>