<script setup>
const props = defineProps(['vehicle'])
const fuelLabels = {
    GO: 'Gazole',
    ES: 'Essence',
    EH: 'Hybride',
    EL: 'Électrique',

}
</script>

<template>
    <article class="card">
        <img 
            v-if="vehicle.pictures?.[0]?.url" 
            :src="vehicle.pictures[0].url" 
            alt="Photo du véhicule"
        />
        <div v-else class="no-photo">
            Photo indisponible
        </div>

        <h3>{{ vehicle.vehicle?.manufacturer }} {{ vehicle.vehicle?.model }}</h3>
        <p class="version">
            {{ vehicle.vehicle?.finish }}
        </p>

        <p class="price">
            {{ Number(vehicle.vehicle?.prices?.merchantPrice).toLocaleString('fr-FR') }} €
        </p>
        <span class="km">
            {{ vehicle.vehicle?.mileage?.toLocaleString('fr-FR') }} km
        </span>
        <span class="year">
            {{ vehicle.vehicle?.year ?? 'Année non renseignée' }}
        </span>
        <span class="fuel">
            {{ fuelLabels[vehicle.vehicle?.energy] ?? vehicle.vehicle?.energy }}
        </span>
    </article>
</template>