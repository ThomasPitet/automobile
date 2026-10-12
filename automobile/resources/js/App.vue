<script setup>
    import VehicleCard from './components/VehicleCard.vue'
    import { ref, onMounted, computed } from 'vue'
    
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
    })

    const brands = computed(() => {
        const allBrands = liste.value.map(car => car.vehicle?.manufacturer).filter(Boolean)
        return [...new Set(allBrands)].sort()
    })

    

    const filteredVehicles = computed(() => {
        if (!selectedBrand.value) {
            return liste.value
        }
            return liste.value.filter(car => car.vehicle?.manufacturer === selectedBrand.value)
    })
</script>



<template>
    <header class="navbar">
        <div class="navbar-container">
            <h1 class="navbar-title">Glinche Automobiles</h1>
        </div>
    </header>

    <main class="main-container">
        <div class="filter-section">
            <label for="brand-select" class="filter-label">Filtrer par marque : </label>
            <select id="brand-select" v-model="selectedBrand" class="filter-select">
                <option value="">Toutes les marques</option>
                <option v-for="brand in brands" :key="brand" :value="brand">
                    {{ brand }}
                </option>
            </select>
        </div>

        <div class="vehicle-grid">
            <VehicleCard v-for="car in filteredVehicles" :key="car.reference" :vehicle="car" />
        </div>
    </main>
</template>

