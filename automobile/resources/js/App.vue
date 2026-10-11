<script setup>
    import VehicleCard from './components/VehicleCard.vue'
    import { ref, onMounted } from 'vue'
    const liste = ref([])
    const isLoading = ref(true)
    const error = ref(null)
    onMounted(async () => {
        try {
            const response = await fetch('/api/vehicles')
            const data = await response.json()
            liste.value = data
        } catch (err) {
            error.value = "Erreur lors de la récupération des véhicules"
        } finally {
            isLoading.value = false
        }
})
</script>

<template>
    <header class="navbar">
        <div class="navbar-container">
            <h1 class="navbar-title">Glinche Automobiles</h1>
        </div>
    </header>

    <main class="main-container">
        <div class="vehicle-grid">
            <VehicleCard v-for="car in liste" :key="car.id" :vehicle="car" />
        </div>
    </main>
</template>

