<template>
  <b-container fluid class="containerPlantilla">
    <div class="header">
        <header-plantilla></header-plantilla>

        <div class="titleComponent">
            Incidències Asignades
        </div>
    </div>

    <b-row class="marginbot margintop">
      <b-col lg="6" class="my-1">
        <b-form-group
          label="Cercador"
          label-cols-sm="2"
          label-align-sm="left"
          label-for="filterInput"
          class="mb-0 ml-3"
        >
          <b-input-group>
            <b-form-input
              v-model="filter"
              type="search"
              id="filterInput"
              placeholder="Escriu per cercar"
            ></b-form-input>
            <b-input-group-append>
              <b-button class="btnEsborrarBuscadoPlantilla" :disabled="!filter" @click="filter = ''">Esborrar</b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col lg="6" class="my-1">
          <b-button
            class="float-right mr-3 btnDescargarPlantilla"
            v-on:click="descargarPDF()"
            size="sm"
            variant="info">
            Descargar PDF
        </b-button>
      </b-col>
    </b-row>

    <!-- Main table element -->
    <b-table
      striped
      head-variant="dark"
      id="incidenciesasignadestable"
      class="taulaPlantilla"
      show-empty
      stacked="md"
      :selectable="false"
      :fields="fields"
      :items="incidencias"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :filterIncludedFields="filterOn"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      @filtered="onFiltered"
    >
      <template v-slot:cell(name)="row">
        {{ row.value.first }} {{ row.value.last }}
      </template>
      <template v-slot:row-details="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
          </ul>
        </b-card>
      </template>
    </b-table>
  </b-container>
</template>

<style>

.margintop
{
  margin-top: 6rem;
}

.marginbot
{
  margin-bottom: 2vh;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>

<script>
  export default {
    data() {
      return {
        selected: null,
        recursos: [],
        municipis: [],
        tipusAlertant: [],
        tipusIncident: [],
        alertants: [],
        options: [],
        selectedRecurs: [],
        option: {
          'id': null,
          'estat': '',
        },
        incidencias: [],
        incidencia: {
            'id': null,
            'alertants': null,
            'recursos': null,
            'num_incidencia': '',
            'telefon_alertant' : '',
            'data': null,
            'hora': null,
            'adreca':  '',
            'complement_adreca':  '',
            'descripcio': null,
            'municipis_id':  null,
            'tipus_incident_id':  null,
            'estats_incidencia_id':  null,
            'tipus_alertant_id':  null,
            'alertants_id':  null,
            'hora': null,
            'data': null,
            'incidenciaspruebaderecursos': {
              'incidencies_id': null,
              'recursos_id': null,
              'prioritat': null,
              'hora_mobilitzacio': null,
              'hora_assistencia': null,
              'hora_transport': null,
              'hora_arribada_hospital': null,
              'hora_transferencia': null,
              'hora_finalitzacio': null,
            }
        },
        recurs: {
            'id': null,
            'codi': null,
            'tipus_recurs_id': '',
            'id_usuario' : '',
            'usuaris' : [],
            'tipus_recurs' : [],
        },
        fields: [
          { key: 'num_incidencia', label: 'Numero', sortable: true, sortDirection: 'desc', class: 'text-center' },
          { key: 'telefon_alertant', label: 'Telèfon', sortable: true, class: 'text-center' },
          { key: 'descripcio', label: 'Descripció', sortable: true, class: 'text-center' },
          { key: 'adreca', label: 'Adreça', sortable: true, class: 'text-center' },
          { key: 'complement_adreca', label: 'Complement Adreça', sortable: true, class: 'text-center' },
          { key: 'data', label: 'Data', sortable: true, class: 'text-center' },
          { key: 'hora', label: 'Hora', sortable: true, class: 'text-center' },
          { key: 'alertants.nom', label: 'Nom de alertant', sortable: true, class: 'text-center' },
        ],
        addIncidencia: null,
        totalRows: 1,
        currentPage: 1,
        perPage: 50,
        pageOptions: [5, 10, 15],
        sortBy: '',
        sortDesc: false,
        sortDirection: 'asc',
        filter: null,
        filterOn: [],
        validation: true,
        validationN: true,
      }
    },
    created() {
    },
    computed: {
      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
        })
      },

    },
    mounted() {

      this.getRecursos();
      this.mostrarIncidencias();
      this.getEstats();
      this.getMunicipis();
      this.getAlertants();
      this.getTipusIncident();
      this.getTipusAlertant();
    },
    methods: {
    filtrarIncidencias() {
        for( var i = 0; i < this.incidencias.length; i++) {
            if ( this.incidencias[i].incidenciaspruebaderecursos === null) {
            arr.splice(i, 1);
            }
        }
    },
      recursosSeleccionados(items) {
        this.recurs = items
      },

    getEstats () {
        let me = this;
        axios.get('/BroggiProject/public/api/estats_incidencia').then(function (response) {
            me.options = response.data;
            const options = data.items;
            return(options);
        })
        .catch (function (error) {
            console.log(error);
        })
    },
    getTipusIncident () {
    let me = this;
    axios.get('/BroggiProject/public/api/TipusI').then(function (response) {
        me.tipusIncident = response.data;
        const tipusIncident = data.items;
        return(tipusIncident);
    })
    .catch (function (error) {
        console.log(error);
    })
    },
    getMunicipis () {
    let me = this;
    axios.get('/BroggiProject/public/api/municipi').then(function (response) {
        me.municipis = response.data;
        const municipis = data.items;
        return(municipis);
    })
    .catch (function (error) {
        console.log(error);
    })
    },
    getAlertants () {
    let me = this;
    axios.get('/BroggiProject/public/api/alertant').then(function (response) {
        me.alertants = response.data;
        const alertants = data.items;
        return(alertants);
    })
    .catch (function (error) {
        console.log(error);
    })
    },
    getRecursos () {
    let me = this;
    let cookie = this.getCookie("user_id");
    axios.get('/BroggiProject/public/api/recurso').then(function (response) {

    for (var i = 0; i < response.data.length; i++)
      {   //filtrar x id
          if (response.data[i].id_usuario == cookie)
          {
              me.recursos.push(response.data[i]);
          }
      }
      const recursos = data.items;
      return(recursos);
    })
    .catch (function (error) {
        console.log(error);
    })
    },
    getTipusAlertant () {
    let me = this;
    axios.get('/BroggiProject/public/api/TipusA').then(function (response) {
        me.tipusAlertant = response.data;
        const tipusAlertant = data.items;
        return(tipusAlertant);
    })
    .catch (function (error) {
        console.log(error);
    })
    },
    mostrarIncidencias () {
    let me = this;
    axios.get('/BroggiProject/public/api/incidencias').then(function (response) {
        for (var i = 0; i < response.data.length; i++)
        {
          for( var y = 0; y < me.recursos.length; y++)
          {
            if (response.data[i].incidenciaspruebaderecursos.recursos_id == me.recursos[y].id)
            {
                me.incidencias.push(response.data[i]);
            }
          }
        }
        const items = data.items;
        return(items);
    })
    .catch (function (error) {
        console.log(error);
    })
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length
      this.currentPage = 1
    },
    descargarPDF() {
      var pdf = new jsPDF();

      pdf.autoTable({
          html: '#incidenciesasignadestable',
      })

      pdf.save('incidenciesAsignades.pdf');
    },
    getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    },
    },

}
</script>
