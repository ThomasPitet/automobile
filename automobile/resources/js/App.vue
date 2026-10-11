<script setup>
    import VehicleCard from './components/VehicleCard.vue'
    import { ref, onMounted } from 'vue'
    import { reactive, computed } from 'vue'
    
    const liste = ref([])
    const isLoading = ref(true)
    const error = ref(null)
    const selectedBrand = ref('')
    
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

        const filteredVehicles = computed(() => {
    if (!selectedBrand.value) {
        return liste.value
    }
    return liste.value.filter(car => car.vehicle?.manufacturer === selectedBrand.value)
})

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
            <VehicleCard v-for="car in filteredVehicle" :key="car.id" :vehicle="car" />
        </div>
    </main>
</template>

