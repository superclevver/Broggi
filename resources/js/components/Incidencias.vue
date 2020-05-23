<template>
  <b-container fluid class="containerPlantilla">
    <div class="header">
        <header-plantilla></header-plantilla>

        <div class="titleComponent">
            Incidències
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
        <b-button class="float-right btnAfegirPlantilla"
          v-on:click="infoAfegir($event.target)"
          size="sm"
          variant="primary">Afegir incidència</b-button>

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
      id="incidenciestable"
      striped
      head-variant="dark"
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

      <template v-slot:cell(actions)="row">
        <b-button size="sm" variant="primary" @click="info(row.item, row.index, $event.target)">
          Editar
        </b-button>
        <b-button size="sm" variant="danger" @click="infoDelete(row.item.id, row.index, $event.target)">
          Esborrar
        </b-button>
        <b-button v-if="row.item.incidenciaspruebaderecursos == null || row.item.incidenciaspruebaderecursos.incidencies_id == null"  size="sm" variant="secondary" @click="infoRecurs(row.item, row.index, $event.target)">
          Assignar
        </b-button>
      </template>

      <template v-slot:row-details="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
          </ul>
        </b-card>
      </template>
    </b-table>

    <!-- Info modal -->
    <b-modal  size="lg" id="modalEdit" no-close-on-esc no-close-on-backdrop centered trim>
      <template v-slot:modal-header="{}">
      <h5>Incidencia {{incidencia.num_incidencia}}</h5>
      </template>
      <div>
              <b-form-group
              label-cols-sm="3"
              label="Numero incidencia:"
              label-align-sm="right"
              label-for="nested-street"
              :invalid-feedback="invalidFeedbackNum"
            >
            <b-form-input required :state="numState" type="number" v-model="incidencia.num_incidencia" id="asda" trim></b-form-input>
            </b-form-group>
              <b-form-group
              label-cols-sm="3"
              label="Numero teléfon:"
              label-align-sm="right"
              label-for="nested-street"
              :invalid-feedback="invalidFeedbackTelefon"
            >
            <b-form-input required :state="telefonState" type="number"  v-model="incidencia.telefon_alertant" id="asda"></b-form-input>
            </b-form-group>

            <b-form-group
              label-cols-sm="3"
              label="Descripció:"
              label-align-sm="right"
              label-for="nested-city"
            >
            <b-form-input v-model="incidencia.descripcio" id="nested-city"></b-form-input>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Adreça:"
              label-align-sm="right"
              label-for="nested-state"
            >
            <b-form-input v-model="incidencia.adreca" id="nested-state"></b-form-input>
            </b-form-group>

            <b-form-group

              label-cols-sm="3"
              label="Complement adreça:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-input  v-model="incidencia.complement_adreca" id="nested-country"></b-form-input>
            </b-form-group>

            <b-form-group
              label-cols-sm="3"
              label="Data:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-input v-model="incidencia.data" type="date" id="nested-country"></b-form-input>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Hora:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-input v-model="incidencia.hora" type="time" id="nested-country"></b-form-input>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Estat:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.estats_incidencia_id"
              :options="options"
              class="mb-3"
              value-field="id"
              text-field="estat"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Municipi:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.municipis_id"
              :options="municipis"
              class="mb-3"
              value-field="id"
              text-field="nom"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Alertant:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.alertants_id"
              :options="alertants"
              class="mb-3"
              value-field="id"
              text-field="nom"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Tipus incident:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.tipus_incident_id"
              :options="tipusIncident"
              class="mb-3"
              value-field="id"
              text-field="tipus"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Tipus alertant:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.tipus_alertant_id"
              :options="tipusAlertant"
              class="mb-3"
              value-field="id"
              text-field="tipus"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <template v-if="incidencia.incidenciaspruebaderecursos.recursos_id == null">
            <b-form-group
              label-cols-sm="3"
              label="Recurs:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.incidenciaspruebaderecursos.recursos_id"
              :options="recursos"
              class="mb-3"
              value-field="id"
              text-field="tipus_recurs.tipus"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Prioritat:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-input v-model="incidencia.incidenciaspruebaderecursos.prioritat" type="number" id="nested-country"></b-form-input>
            </b-form-group>
            </template>
            <template v-else-if="incidencia.incidenciaspruebaderecursos.recursos_id != null">
            <b-form-group
              label-cols-sm="3"
              label="Recurs:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.incidenciaspruebaderecursos.recursos_id"
              disabled
              :options="recursos"
              class="mb-3"
              value-field="id"
              text-field="tipus_recurs.tipus"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Prioritat:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-input readonly v-model="incidencia.incidenciaspruebaderecursos.prioritat" type="number" id="nested-country"></b-form-input>
            </b-form-group>
            </template>
      </div>
      <template v-slot:modal-footer="{ }">
        <b-button size="sm" variant="primary" @click="editarIncidencia(incidencia.id, $event.target)">
          Acceptar
        </b-button>
        <b-button size="sm" variant="secondary" @click="cancelar('modalEdit', $event.target)">
          Cancel·lar
        </b-button>
      </template>
    </b-modal>
    <b-modal size="lg" id="modalAdd" no-close-on-esc no-close-on-backdrop centered trim>
      <template v-slot:modal-header="{}">
      <h5>Crear incidencia</h5>
      </template>
      <div>
            <b-form-group
              label-cols-sm="3"
              label="Numero incidencia:"
              label-align-sm="right"
              label-for="nested-street"
              :invalid-feedback="invalidFeedbackNum"

            >
            <b-form-input required :state="numState" type="number" name="fname" v-model="incidencia.num_incidencia" id="asda"></b-form-input>
            </b-form-group>
              <b-form-group
              label-cols-sm="3"
              label="Numero teléfon:"
              label-align-sm="right"
              label-for="nested-street"
              :invalid-feedback="invalidFeedbackTelefon"

            >
            <b-form-input required type="number" :state="telefonState" v-model="incidencia.telefon_alertant" id="asda"></b-form-input>
            </b-form-group>

            <b-form-group
              label-cols-sm="3"
              label="Descripció:"
              label-align-sm="right"
              label-for="nested-city"
            >
            <b-form-input v-model="incidencia.descripcio" id="nested-city"></b-form-input>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Adreça:"
              label-align-sm="right"
              label-for="nested-state"
            >
            <b-form-input v-model="incidencia.adreca" id="nested-state"></b-form-input>
            </b-form-group>

            <b-form-group

              label-cols-sm="3"
              label="Complement adreça:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-input  v-model="incidencia.complement_adreca" id="nested-country"></b-form-input>
            </b-form-group>

            <b-form-group
              label-cols-sm="3"
              label="Data:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-input v-model="incidencia.data" type="date" id="nested-country"></b-form-input>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Hora:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-input v-model="incidencia.hora" type="time" id="nested-country"></b-form-input>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Estat:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.estats_incidencia_id"
              :options="options"
              class="mb-3"
              value-field="id"
              text-field="estat"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Municipi:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.municipis_id"
              :options="municipis"
              class="mb-3"
              value-field="id"
              text-field="nom"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Alertant:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.alertants_id"
              :options="alertants"
              class="mb-3"
              value-field="id"
              text-field="nom"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Tipus incident:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.tipus_incident_id"
              :options="tipusIncident"
              class="mb-3"
              value-field="id"
              text-field="tipus"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Tipus alertant:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.tipus_alertant_id"
              :options="tipusAlertant"
              class="mb-3"
              value-field="id"
              text-field="tipus"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Recurs:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-select
              v-model="incidencia.incidenciaspruebaderecursos.recursos_id"
              :options="recursos"
              class="mb-3"
              value-field="id"
              text-field="tipus_recurs.tipus"
              disabled-field="notEnabled"
            ></b-form-select>
            </b-form-group>
            <b-form-group
              label-cols-sm="3"
              label="Prioritat:"
              label-align-sm="right"
              label-for="nested-country"
            >
            <b-form-input v-model="incidencia.incidenciaspruebaderecursos.prioritat" type="number" id="nested-country"></b-form-input>
          </b-form-group>
      </div>
      <template v-slot:modal-footer="{}">
        <b-button size="sm" variant="primary" @click="afegirIncidencia($event.target)">
          Acceptar
        </b-button>
        <b-button size="sm" variant="secondary" @click="cancelar('modalAdd', $event.target)">
          Cancel·lar
        </b-button>
      </template>
    </b-modal>
    <template>
     <b-modal id="modalRecurs" no-close-on-esc no-close-on-backdrop trim centered size="lg">
      <template v-slot:modal-header="{}">
      <h5>Asignar recurs</h5>
    </template>
    <template v-slot:default="{}">
      <b-form-group
        label-cols-sm="2"
        label="Prioritat:"
        label-for="nested-country"
      >
      <b-form-input v-model="incidencia.incidenciaspruebaderecursos.prioritat" type="number" id="nested-country"></b-form-input>
      </b-form-group>
      <b-table
        class=""
        show-empty
        stacked="md"
        head-variant="dark"
        @row-selected="recursosSeleccionados"
        :selectable="true"
        :fields="fields2"
        :items="recursos"
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

        </b-table>
        </template>
        <template v-slot:modal-footer="{}">
          <b-button size="sm" variant="primary" @click="editarIncidencia2(incidencia.id ,$event.target)">
            Acceptar
          </b-button>
          <b-button size="sm" variant="secondary" @click="cancelar('modalRecurs', $event.target)">
            Cancel·lar
          </b-button>
        </template>
      </b-modal>
    </template>
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
          { key: 'actions', label: '' },
        ],fields2: [
          { key: 'tipus_recurs.tipus', label: 'Tipus de recurs', sortable: true, class: 'text-center' },
          { key: 'usuari.nom', label: 'Nom usuario', sortable: true, class: 'text-center' },
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
      this.mostrarIncidencias();
      this.getEstats();
      this.getMunicipis();
      this.getAlertants();
      this.getTipusIncident();
      this.getTipusAlertant();
      this.getRecursos();
    },
    computed: {
      numState() {
        if (this.incidencia.num_incidencia.length <= 7 && this.incidencia.num_incidencia.length >= 1)
        {
          this.validationN = true;
          return (null);
        }
        else if (this.incidencia.num_incidencia.length >= 7)
        {
          this.validationN = false;
          return (false);
        }
        else if (this.incidencia.num_incidencia.length == 0) {
          this.validationN = false;
          return (false);
        }
        else {
          this.validationN = true;
          return null;
        }
      },
      invalidFeedbackNum() {
        if (this.incidencia.num_incidencia.length < 7 && this.incidencia.num_incidencia.length >= 1) {
          return ''
        } else if (this.incidencia.num_incidencia.length > 0) {
          return 'No puede tener más de 7 numeros'
        } else if (this.incidencia.num_incidencia.length == 0)
        {
          return 'Por favor introduzca un numero'
        }
      },
      telefonState() {
        if (this.incidencia.telefon_alertant.length <= 9 && this.incidencia.telefon_alertant.length >= 1)
        {
          this.validation = true;
          return (null);
        }
        else if (this.incidencia.telefon_alertant.length > 9)
        {
          this.validation = false;
          return (false);
        }
        else if (this.incidencia.telefon_alertant.length == 0) {
          this.validation = false;
          return (false);
        }
        else {
          this.validation = true;
          return null;
        }
      },
      invalidFeedbackTelefon() {
        if (this.incidencia.telefon_alertant.length < 9 && this.incidencia.telefon_alertant.length >= 1) {
          return ''
        } else if (this.incidencia.telefon_alertant.length > 0) {
          return 'No puede tener más de 9 numeros'
        } else if (this.incidencia.telefon_alertant.length == 0)
        {
          return 'Por favor introduzca un numero'
        }
      },

      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
        })
      }
    },
    mounted() {
    },
    methods: {
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
        axios.get('/BroggiProject/public/api/recurso').then(function (response) {
            me.recursos = response.data;
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
            me.incidencias = response.data;
            const items = data.items;
            return(items);
        })
        .catch (function (error) {
            console.log(error);
        })
      },
      cerrarModal() {
        this.close;
      },

      editarIncidencia (id, button) {

        if(this.validationN !=false && this.validationN != false)
        {
          let me = this;
          axios.put('/BroggiProject/public/api/incidencias'+'/'+id, this.incidencia).then(function (response) {
            me.$root.$emit('bv::hide::modal', "modalEdit", button);
            me.mostrarIncidencias();
            return(items);
          })
          .catch (function (error) {
              console.log(error);
              me.$root.$emit('bv::hide::modal', "modalEdit", button);
          })
        }
        else {
          alert("Tienes errores de validación");
        }
      },
      editarIncidencia2 (idIncidencia, button) {
        let me = this;
        this.incidencia.incidenciaspruebaderecursos.recursos_id = this.recurs[0].id;

        axios.put('/BroggiProject/public/api/incidencias'+'/'+idIncidencia, this.incidencia).then(function (response) {
          me.$root.$emit('bv::hide::modal', "modalRecurs", button);
          me.mostrarIncidencias();
          return(items);
        })
        .catch (function (error) {
            console.log(error);
            me.$root.$emit('bv::hide::modal', "modalRecurs", button);
        })
      },
      afegirIncidencia (button) {
        let me = this;
        axios.post('/BroggiProject/public/api/incidencias', this.incidencia).then(function (response) {
          me.$root.$emit('bv::hide::modal', "modalAdd", button);
          me.mostrarIncidencias();
        })
        .catch (function (error) {
            console.log(error);
            me.$root.$emit('bv::hide::modal', "modalAdd", button);
        })
      },
      infoDelete(item, index, button) {
        let me = this;
          axios.delete('/BroggiProject/public/api/incidencias'+'/'+item).then(function (response) {
          me.mostrarIncidencias();
          })
          .catch (function (error) {
              console.log(error);
          })
      },

      info(item, index, button){
        this.addIncidencia = false;
        this.incidencia = item;
        if (this.incidencia.incidenciaspruebaderecursos == null) {
          this.incidencia.incidenciaspruebaderecursos = {};
          this.incidencia.incidenciaspruebaderecursos.incidencies_id = null;
          this.incidencia.incidenciaspruebaderecursos.recursos_id = null;
          this.incidencia.incidenciaspruebaderecursos.prioritat = null;
          this.incidencia.incidenciaspruebaderecursos.hora_mobilitzacio = null;
          this.incidencia.incidenciaspruebaderecursos.hora_assistencia = null;
          this.incidencia.incidenciaspruebaderecursos.hora_transport = null;
          this.incidencia.incidenciaspruebaderecursos.hora_arribada_hospital = null;
          this.incidencia.incidenciaspruebaderecursos.hora_transferencia = null;
          this.incidencia.incidenciaspruebaderecursos.hora_finalitzacio = null;
        }
        this.$root.$emit('bv::show::modal', "modalEdit", button);
      },
      infoRecurs(item, index, button){
        this.incidencia = item;
        if (this.incidencia.incidenciaspruebaderecursos == null) {
          this.incidencia.incidenciaspruebaderecursos = {};
          this.incidencia.incidenciaspruebaderecursos.incidencies_id = null;
          this.incidencia.incidenciaspruebaderecursos.recursos_id = null;
          this.incidencia.incidenciaspruebaderecursos.prioritat = null;
          this.incidencia.incidenciaspruebaderecursos.hora_mobilitzacio = null;
          this.incidencia.incidenciaspruebaderecursos.hora_assistencia = null;
          this.incidencia.incidenciaspruebaderecursos.hora_transport = null;
          this.incidencia.incidenciaspruebaderecursos.hora_arribada_hospital = null;
          this.incidencia.incidenciaspruebaderecursos.hora_transferencia = null;
          this.incidencia.incidenciaspruebaderecursos.hora_finalitzacio = null;
        }
        this.$root.$emit('bv::show::modal', "modalRecurs", button);
      },
      infoAfegir(button){
        this.clean();
        this.addIncidencia = true;
        this.$root.$emit('bv::show::modal', "modalAdd", button);
        this.mostrarIncidencias();
      },
      cancelar(modalID, button) {
        this.mostrarIncidencias();
        this.$root.$emit('bv::hide::modal', modalID, button);
      },
      clean() {
        this.incidencia.id = null,
        this.incidencia.alertants = null,
        this.incidencia.num_incidencia = '',
        this.incidencia.telefon_alertant = '',
        this.incidencia.data = null,
        this.incidencia.hora = null,
        this.incidencia.adreca =  '',
        this.incidencia.complement_adreca =  '',
        this.incidencia.descripcio = null,
        this.incidencia.municipis_id =  null,
        this.incidencia.tipus_incident_id =  null,
        this.incidencia.estats_incidencia_id =  null,
        this.incidencia.tipus_alertant_id =  null,
        this.incidencia.alertants_id =  null,
        // this.incidencia.hora = null,
        // this.incidencia.data = null,
        this.incidencia.incidenciaspruebaderecursos.incidencies_id = null,
        this.incidencia.incidenciaspruebaderecursos.recursos_id = null,
        this.incidencia.incidenciaspruebaderecursos.prioritat = null,
        this.incidencia.incidenciaspruebaderecursos.hora_mobilitzacio = null,
        this.incidencia.incidenciaspruebaderecursos.hora_assistencia = null,
        this.incidencia.incidenciaspruebaderecursos.hora_transport = null,
        this.incidencia.incidenciaspruebaderecursos.hora_arribada_hospital = null,
        this.incidencia.incidenciaspruebaderecursos.hora_transferencia = null,
        this.incidencia.incidenciaspruebaderecursos.hora_finalitzacio = null
      },
      onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length
      this.currentPage = 1
      },
      descargarPDF() {
        var pdf = new jsPDF();

        pdf.autoTable({
            html: '#incidenciestable',
        })

        pdf.save('incidencies.pdf');
    },
    }
  }
</script>
