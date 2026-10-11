<script setup>
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
        <p>Nombre de véhicules chargés : {{ liste.length }}</p>
    </main>
</template>


