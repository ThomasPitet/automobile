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
        if (!response.ok) {
            throw new Error(`Erreur HTTP : ${response.status}`)
        }
        const data = await response.json()
        if (!Array.isArray(data)) {
            throw new Error('Format de réponse invalide')
        }
        liste.value = data
    } catch (err) {
        error.value = err.message || "Erreur lors de la récupération des véhicules"
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

        <div v-if="isLoading" class="state-message">
            Chargement des véhicules
        </div>

        <div v-else-if="error" class="state-message error">
            {{ error }}
        </div>

        <div v-else-if="filteredVehicles.length === 0" class="state-message">
            Aucun véhicule ne correspond à cette marque.
        </div>

        <div v-else class="vehicle-grid">
            <VehicleCard v-for="car in filteredVehicles" :key="car.reference" :vehicle="car" />
        </div>
    </main>
</template>

