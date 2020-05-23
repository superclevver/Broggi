<template>
  <b-container fluid class="containerPlantilla">
    <div class="header">
        <header-plantilla></header-plantilla>

        <div class="titleComponent">
            Recursos mòbils
        </div>
    </div>
    <b-row class="margintop marginbot">
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
          class="float-right btnAfegirPlantilla"
          v-on:click="infoAfegir($event.target)"
          size="sm"
          variant="primary"
        >Afegir recurs mòbil</b-button>

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
      id="recursmobiltable"
      striped
      head-variant="dark"
      class="taulaPlantilla"
      show-empty
      stacked="md"
      :selectable="false"
      :fields="fields"
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
      <template v-slot:cell(name)="row">{{ row.value.first }} {{ row.value.last }}</template>

      <template v-slot:cell(actions)="row">
          <b-button
          size="sm"
          variant="primary"
          @click="info(row.item, row.index, $event.target)"
        >Editar</b-button>

        <b-button
          size="sm"
          variant="danger"
          @click="infoDelete(row.item, row.index, $event.target)"
        >Esborrar</b-button>

        <b-button
          v-if="!row.item.usuari"
          size="sm"
          variant="secondary"
          @click="infoUsuari(row.item, row.index, $event.target)"
        >Assignar usuari</b-button>
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
    <b-modal id="modalEdit" centered :title="'Recurs '+ this.recurs.codi" ok-only>
      <div>
        <b-form-group
          label-cols-sm="3"
          label="Codi:"
          label-align-sm="right"
          label-for="nested-street"
        >
          <b-form-input id="codi" v-model="recurs.codi" disabled></b-form-input>
        </b-form-group>

        <b-form-group
          label-cols-sm="3"
          label="Tipus:"
          label-align-sm="right"
          label-for="nested-country"
        >
          <b-form-select
            v-model="recurs.tipus_recurs_id"
            :options="tipusRecurs"
            class="mb-3"
            value-field="id"
            text-field="tipus"
            disabled-field="notEnabled"
          ></b-form-select>
        </b-form-group>

        <b-form-group
          v-if="recurs.usuari"
          label-cols-sm="3"
          label="Usuari:"
          label-align-sm="right"
          label-for="nested-street"
        >
          <b-form-input v-if="recurs.usuari" id="usuari" v-model="recurs.usuari.nom" disabled></b-form-input>
        </b-form-group>
      </div>
      <template v-slot:modal-footer="{ ok, cancel }">
        <b-button size="sm" variant="primary" @click="editarRecurs()">Acceptar</b-button>
        <b-button
          size="sm"
          variant="secondary"
          @click="cancel(), cerrarModal('modalEdit', $event.target)"
        >Cancel·lar</b-button>
      </template>
    </b-modal>
    <b-modal id="modalAdd" centered :title="'Crear recurs'">
      <div>
        <b-form-group
          label-cols-sm="3"
          label="Tipus:"
          label-align-sm="right"
          label-for="nested-country"
        >
          <b-form-select
            v-model="recurs.tipus_recurs_id"
            :options="tipusRecurs"
            class="mb-3"
            value-field="id"
            text-field="tipus"
            disabled-field="notEnabled"
          ></b-form-select>
        </b-form-group>
      </div>
      <template v-slot:modal-footer="{ ok, cancel }">
        <b-button size="sm" variant="primary" @click="afegirRecurs($event.target)">Acceptar</b-button>
        <b-button
          size="sm"
          variant="secondary"
          @click="cancel(), cerrarModal('modalAdd', $event.target)"
        >Cancel·lar</b-button>
      </template>
    </b-modal>
    <b-modal id="modalAssignarUsuari" centered :title="'Assignar usuari'">
      <div>
        <b-form-group
          label-cols-sm="3"
          label="Usuari:"
          label-align-sm="right"
          label-for="nested-country"
        >
          <b-form-select
            v-show="usuariosSinRecurso.length"
            v-if="usuariosSinRecurso.length"
            v-model="recurs.id_usuario"
            :options="usuariosSinRecurso"
            class="mb-3"
            value-field="id"
            text-field="nom"
            disabled-field="notEnabled"
          ></b-form-select>

          <b-form-select v-else class="mb-3" text-field="Carregant..." disabled-field="notEnabled"></b-form-select>
        </b-form-group>
      </div>
      <template v-slot:modal-footer="{ ok, cancel }">
        <b-button size="sm" variant="primary" @click="editarRecurs($event.target)">Acceptar</b-button>
        <b-button
          size="sm"
          variant="secondary"
          @click="cancel(), cerrarModal('modalAssignarUsuari', $event.target)"
        >Cancel·lar</b-button>
      </template>
    </b-modal>

    <b-modal id="modalDelete" centered title="Esborrar recurs">
      <div>
        <p class>Segur que vols esborrar aquest recurs? ({{this.recurs.codi}})</p>
      </div>
      <template v-slot:modal-footer="{ ok, cancel }">
        <b-button size="sm" variant="primary" @click="deleteRecurs($event.target)">Esborrar</b-button>
        <b-button
          size="sm"
          variant="secondary"
          @click="cancel(), cerrarModal('modalDelete', $event.target)"
        >Cancel·lar</b-button>
      </template>
    </b-modal>
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

</style>

<script>
export default {
  data() {
    return {
      tipusRecurs: [],
      recursos: [],
      usuariosSinRecurso: [],
      recurs: {
        id: null,
        codi: null,
        tipus_recurs_id: "",
        tipus_recurs: null,
        id_usuario: "",
        usuari: null
      },
      fields: [
        { key: "codi", label: "Codi", sortable: true, sortDirection: "asc" },
        {
          key: "tipus_recurs.tipus",
          label: "Tipus Recurs",
          sortable: true,
          class: "text-center"
        },
        { key: "usuari.nom", label: "Usuari" },
        { key: "actions", label: "" }
      ],
      addRecurs: null,
      totalRows: 1,
      currentPage: 1,
      perPage: null,
      pageOptions: [5, 10, 15],
      sortBy: "",
      sortDesc: false,
      sortDirection: "asc",
      filter: null,
      filterOn: []
    };
  },
  /**
   * Al crear la instancia llamamos a la API para que nos
   * devuelva todos los recursos y los tipos de recurso.
   */
  created() {
    this.mostrarRecursos();
    this.getTipusRecurs();
  },
  computed: {
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter(f => f.sortable)
        .map(f => {
          return { text: f.label, value: f.key };
        });
    }
  },
  mounted() {},
  methods: {
    /**
     * Función que hace una llamada a la API que nos devuelve
     * todos los tipos de recurso y los almacena en {tipusRecurs}
     */
    getTipusRecurs() {
      let me = this;
      axios
        .get("/BroggiProject/public/api/TipusR")
        .then(function(response) {
          me.tipusRecurs = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    /**
     * Función que hace una llamada a la API que nos devuelve
     * todos los usuarios y hacemos una selección de solo
     * los usuarios que no tienen recursos.
     */
    getUsuariosSinRecurso() {
      let me = this;
      //Vacía el array {usuariosSinRecurso} si no lo estaba.
      if (!me.usuariosSinRecurso.length) me.usuariosSinRecurso = [];
      axios
        .get("/BroggiProject/public/api/usuarios")
        .then(function(response) {
          //{usuarios} -> todos los usuarios de la BBDD
          const usuarios = response.data;
          //Recorremos el array
          usuarios.forEach(element => {
            /**
             * Si del array {recursos} algún recurso tiene
             * como [id_usuario] el mismo que el [id] del usuario
             * actual del array.
             */
            const usuarioSinRecurso = me.recursos.some(
              el => el.id_usuario === element.id
            );
            //Si no lo encuentra lo añadimos al array {usuariosSinRecurso}
            if (!usuarioSinRecurso) me.usuariosSinRecurso.push(element);
          });
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    /**
     * Función que hace un GET de todos los recursos a la API
     */
    mostrarRecursos() {
      let me = this;
      axios
        .get("/BroggiProject/public/api/recurso")
        .then(function(response) {
          me.recursos = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    /**
     * Función que hace un PUT a la API para editar
     * un recurso proveniente del objeto {recurs} y
     * volvemos a mostrar todos los recursos (API).
     */
    editarRecurs(button) {
      let me = this;
      axios
        .put("/BroggiProject/public/api/recurso/" + this.recurs.id, this.recurs)
        .then(function(response) {
          me.$root.$emit("bv::hide::modal", "modalEdit", button);
          me.$root.$emit("bv::hide::modal", "modalAssignarUsuari", button);
          me.mostrarRecursos();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    /**
     * Función que al presionar el botón 'Acceptar' del modal {modalAdd}
     * hace una llamada a la API y añade un nuevo recurso proveniente
     * del objeto {recurs} y volvemos a cargar los recursos (API).
     */
    afegirRecurs(button) {
      let me = this;
      axios
        .post("/BroggiProject/public/api/recurso", this.recurs)
        .then(function(response) {
          me.$root.$emit("bv::hide::modal", "modalAdd", button);
          me.mostrarRecursos();
        })
        .catch(function(error) {
          console.log(error);
          me.$root.$emit("bv::hide::modal", "modalAdd", button);
        });
    },
    /**
     * Función que al presionar el botón 'Esborrar' obtiene
     * el objeto {recurs} donde hemos hecho clic y abre
     * un modal preguntando si queremos borrarlo.
     */
    infoDelete(item, index, button) {
      this.addRecurs = false;
      this.recurs = item;
      this.$root.$emit("bv::show::modal", "modalDelete", button);
    },
    /**
     * Función que al presionar el botón 'Editar' obtiene
     * el objeto {recurs} donde hemos hecho clic y abre
     * un modal para editarlo.
     */
    info(item, index, button) {
      this.addRecurs = false;
      this.recurs = item;
      this.$root.$emit("bv::show::modal", "modalEdit", button);
    },
    /**
     * Función que al presionar el botón 'Afegir recurs mòbil'
     * abre un modal para añadir un nuevo {recurs} y borra las
     * propiedades del objeto {recurs} por si había uno anteriormente.
     */
    infoAfegir(button) {
      this.addRecurs = true;
      //Campos del recurso a null
      this.recurs.id = null;
      this.recurs.codi = null;
      this.recurs.tipus_recurs_id = "";
      this.recurs.tipus_recurs = null;
      this.recurs.id_usuario = "";
      this.recurs.usuari = null;
      this.$root.$emit("bv::show::modal", "modalAdd", button);
      this.mostrarRecursos();
    },
    /**
     * Función que al presionar un botón 'Assignar usuari'
     * abre un modal obteniendo el objeto {recurs} donde
     * hemos hecho clic y llama a la API que nos devuelve
     * todos los usuarios y hacemos una selección de
     * solo los usuarios que no tienen recursos.
     */
    infoUsuari(item, index, button) {
      this.usuariosSinRecurso = [];
      this.getUsuariosSinRecurso();
      this.recurs = item;
      this.$root.$emit("bv::show::modal", "modalAssignarUsuari", button);
    },
    /**
     * Función que al presionar un botón 'Cancel·lar' del modal
     * borra las propiedades del objeto {recurs} y llama a la
     * API que devuelve todo los recursos y los mostramos.
     */
    cerrarModal(modalID, e) {
      this.recurs.id = null;
      this.recurs.codi = null;
      this.recurs.tipus_recurs_id = "";
      this.recurs.tipus_recurs = null;
      this.recurs.id_usuario = "";
      this.recurs.usuari = null;
      this.mostrarRecursos();
    },
    /**
     * Función que al presionar el botón 'Esborrar' del modal
     * {modalDelete} hace una llamada a la API para borrar
     * ese {recurs} y volvemos a cargar los recursos (API).
     */
    deleteRecurs(button) {
      let me = this;
      axios
        .delete("/BroggiProject/public/api/recurso" + "/" + this.recurs.id)
        .then(function(response) {
          me.mostrarRecursos();
          me.$root.$emit("bv::hide::modal", "modalDelete", button);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    descargarPDF() {
        var pdf = new jsPDF();

        pdf.autoTable({
            html: '#recursmobiltable',
        })

        pdf.save('recurs-mobil.pdf');
    }
  }
};
</script>
