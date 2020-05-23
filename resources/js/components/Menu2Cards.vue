<template>
  <main>
    <header-menu></header-menu>

    <a :href="incidenciasURL">
      <div class="split left">
        <div class="centered">
          <img src="/BroggiProject/public/storage/media/img/incidencies.svg" alt="Incidències img">
          <h2>Incidències</h2>
        </div>
      </div>
    </a>

    <a :href="recursosURL">
      <div class="split mid">
        <div class="centered">
          <img src="/BroggiProject/public/storage/media/img/recursos-mobils.svg" alt="Recursos mòbils img">
          <h2>Recursos mòbils</h2>
        </div>
      </div>
    </a>

    <a :href="alertantsURL">
      <div class="split right">
        <div class="centered">
          <img src="/BroggiProject/public/storage/media/img/alertant.svg" alt="Alertants img">
          <h2>Alertants</h2>
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
        recursosURL: './recursos-mobils',
        alertantsURL: './alertants',
      }
    },
    methods: {

    }
  }
</script>
