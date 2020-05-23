<template>
  <main>
    <header-menu></header-menu>

    <a :href="incidenciasURL">
      <div class="split left">
        <div class="centered">
          <img src="/BroggiProject/public/storage/media/img/incidencies.svg" alt="Incidències">
          <h2>Incidències</h2>
        </div>
      </div>
    </a>

    <a :href="incidenciesAsignadasURL">
      <div class="split right">
        <div class="centered">
          <img src="/BroggiProject/public/storage/media/img/incidencies_assignades.svg" alt="Incidències assignades">
          <h2>Incidències Assignades</h2>
        </div>
      </div>
    </a>
  </main>
</template>

<script>
  export default {
    data() {
      return {
        incidenciasURL: './incidencies',
        incidenciesAsignadasURL: './incidenciesasignades'
      }
    },
    methods: {

    }
  }
</script>
