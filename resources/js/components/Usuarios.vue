<template>
  <b-container fluid class="containerPlantilla">
    <div class="header">
        <header-plantilla></header-plantilla>

        <div class="titleComponent">
            Usuarios
        </div>
    </div>
    <b-row class="margintop">
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
          class="btnAfegirPlantilla float-right"
          v-on:click="infoAfegir($event.target)"
          size="sm"
          variant="primary"
        >Afegir usuari</b-button>
        <b-button
          class="btnDescargarPlantilla float-right mr-3"
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
      id="usuaristable"
      class="taulaPlantilla"
      show-empty
      stacked="md"
      :selectable="false"
      :fields="fields"
      :items="usuarios"
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
          @click="infoDelete(row.item.id, row.index, $event.target)"
        >Esborrar</b-button>

        <template v-if="cargado">
        <b-button
          v-if="mirarUsuarioEnRecurso(row.item.id)"
          size="sm"
          variant="secondary"
          @click="infoRecurs(row.item, row.index, $event.target)"
        >Assignar recurs</b-button>
        </template>
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
    <b-modal
      id="modalEdit"
      centered
      :title="'Usuari '+ this.usuario.nom + ' // ' + this.usuario.codi"
      ok-only
    >
      <div>
        <b-form-group
          label-cols-sm="3"
          label="Codi:"
          label-align-sm="right"
          label-for="nested-street"
        >
          <b-form-input id="codi" v-model="usuario.codi" disabled></b-form-input>
        </b-form-group>

        <b-form-group
          label-cols-sm="3"
          label="Nom:"
          label-align-sm="right"
          label-for="nested-country"
          :invalid-feedback="invalidFeedbackNom"
        >
          <b-form-input id="nom" :state="nomState" v-model="usuario.nom"></b-form-input>
        </b-form-group>

        <b-form-group
          label-cols-sm="3"
          label="Contrasenya:"
          label-align-sm="right"
          label-for="nested-country"
          :invalid-feedback="invalidFeedbackContrasenya"
        >
          <b-form-input type="password" :state="contrasenyaState" id="contrasenya" v-model="usuario.contrasenya"></b-form-input>
        </b-form-group>
        <b-form-group
          label-cols-sm="3"
          label="Rol:"
          label-align-sm="right"
          label-for="nested-country"
        >
          <b-form-select
            v-if="usuario.rol"
            v-model="usuario.rols_id"
            :options="roles"
            class="mb-3"
            value-field="id"
            text-field="nom"
            disabled-field="notEnabled"
          ></b-form-select>
        </b-form-group>
      </div>
      <template v-slot:modal-footer="{ ok, cancel }">
        <b-button size="sm" variant="primary" @click="editarUsuario()">Acceptar</b-button>
        <b-button
          size="sm"
          variant="secondary"
          @click="cancel(), cerrarModal('modalEdit', $event.target)"
        >Cancel·lar</b-button>
      </template>
    </b-modal>

    <b-modal id="modalAdd" centered :title="'Crear usuari'">
      <div>
        <b-form-group
          label-cols-sm="3"
          label="Nom:"
          label-align-sm="right"
          label-for="nested-country"
          :invalid-feedback="invalidFeedbackNom"
        >
          <b-form-input id="nom" :state="nomState" v-model="usuario.nom" required></b-form-input>
        </b-form-group>
        <b-form-group
          label-cols-sm="3"
          label="Contrasenya:"
          label-align-sm="right"
          label-for="nested-country"
          :invalid-feedback="invalidFeedbackContrasenya"
        >
          <b-form-input type="password" :state="contrasenyaState" id="contrasenya" v-model="usuario.contrasenya"></b-form-input>
        </b-form-group>
        <b-form-group
          label-cols-sm="3"
          label="Rol:"
          label-align-sm="right"
          label-for="nested-country"
        >
          <b-form-select
            v-model="usuario.rols_id"
            :options="roles"
            class="mb-3"
            value-field="id"
            text-field="nom"
            disabled-field="notEnabled"
          ></b-form-select>
        </b-form-group>
      </div>
      <template v-slot:modal-footer="{ ok, cancel }">
        <b-button size="sm" variant="primary" @click="afegirUsuario($event.target)">Acceptar</b-button>
        <b-button
          size="sm"
          variant="secondary"
          @click="cancel(), cerrarModal('modalAdd', $event.target)"
        >Cancel·lar</b-button>
      </template>
    </b-modal>
    <b-modal id="modalAssignarRecurs" centered :title="'Assignar recurs'">
      <div>
        <b-form-group
          label-cols-sm="3"
          label="Recurs:"
          label-align-sm="right"
          label-for="nested-country"
        >
          <b-form-select
            v-model="recurso"
            :options="recursosSinUsuario"
            class="mb-3"
            value-field="id"
            text-field="codi"
            disabled-field="notEnabled"
          ></b-form-select>
        </b-form-group>
      </div>
      <template v-slot:modal-footer="{ ok, cancel }">
        <b-button size="sm" variant="primary" @click="afegirUsuari_a_Recurs($event.target)">Acceptar</b-button>
        <b-button
          size="sm"
          variant="secondary"
          @click="cancel(), cerrarModal('modalAssignarUsuari', $event.target)"
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
      cargado: null,
      options: [],
      roles: [],
      recursosSinUsuario: [],
      recursos: [],
      usuarios: [],
      usuario: {
        id: null,
        codi: null,
        nom: "",
        contrasenya: "",
        rols_id: "",
        rol: null
      },
      recurso: null,
      fields: [
        { key: "codi", label: "Codi", sortable: true, sortDirection: "asc" },
        { key: "nom", label: "Nom", sortable: true, class: "text-center" },
        { key: "rol.nom", label: "Rol" },
        { key: "actions", label: "" }
      ],
      addUsuari: null,
      totalRows: 1,
      currentPage: 1,
      perPage: null,
      pageOptions: [5, 10, 15],
      sortBy: "",
      sortDesc: false,
      sortDirection: "asc",
      filter: null,
      filterOn: [],
      validation: true
    };
  },
  created() {
    this.getUsuarios();
    this.getRoles();
    if (!this.usuarios.length) this.getRecursos();
    this.cargado = true;
  },
  computed: {
    invalidFeedbackNom() {
      if (this.usuario.nom == "" || this.usuario.nom == null) {
        return 'Introdueix un nom si us plau.'
      }
    },
    nomState() {
      if (this.usuario.nom.length) {
        this.validation = true;
        return (null);
      } else {
        this.validation = false;
        return (false);
      }
    },
    invalidFeedbackContrasenya() {
      if (this.usuario.contrasenya == "" || this.usuario.contrasenya == null) {
        return 'Introdueix una contrasenya si us plau.'
      }
    },
    contrasenyaState() {
      if (this.usuario.contrasenya.length > 0) {
        this.validation = true;
        return (null);
      } else {
        this.validation = false;
        return (false);
      }
    },
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
     * todos los usuarios de la BBDD y lo almacena en el array {usuarios}.
     */
    getUsuarios() {
      let me = this;

      axios
        .get("/BroggiProject/public/api/usuarios")
        .then(function(response) {
          me.usuarios = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    /**
     * Función que hace una llamada a la API que nos devuelve
     * todos los roles de la BBDD y lo almacena en el array {roles}.
     */
    getRoles() {
      let me = this;

      axios
        .get("/BroggiProject/public/api/rols")
        .then(function(response) {
          me.roles = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    /**
     * Función que hace una llamada a la API que nos devuelve
     * todos los recursos de la BDDD y lo almacena en el
     * array {recursos}.
     */
    getRecursos() {
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
     * Función que nos devuelve todos los recursos
     * que no tiene ningún usuario asignado.
     */
    getRecursosSinUsuario() {
      //Vacía el array {recursosSinUsuario} si no lo estaba.
      if (!this.recursosSinUsuario.length) this.recursosSinUsuario = [];

      //Recorremos el array {recursos} que contiene todos los recursos
      this.recursos.forEach(element => {
        /**
         * Si del array {usuarios} algún usuario tiene
         * como [id] el mismo que el [id_usuario] del
         * recurso actual del array.
         */
        const recursoSinUsuario = this.usuarios.some(
          el => el.id === element.id_usuario
        );
        //Si no lo encuentra lo añadimos al array {recursosSinUsuario}
        if (!recursoSinUsuario) this.recursosSinUsuario.push(element);
      });
    },
    /**
     * Función que hace un PUT a la API para editar
     * un usuario proveniente del objeto {usuario} y
     * volvemos a mostrar todos los usuario (API).
     */
    editarUsuario(button) {
      let me = this;
      if (this.validation) {
        axios
          .put(
            "/BroggiProject/public/api/usuarios/" + this.usuario.id,
            this.usuario
          )
          .then(function(response) {
            me.$root.$emit("bv::hide::modal", "modalEdit", button);
            me.getUsuarios();
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    },
    /**
     * Función que al presionar el botón 'Acceptar'
     * del modal {modalAssignarRecurs} hace un
     * PUT a la API añadiéndole el [id] del objeto
     * {usuario} a un recurso en el campo [id_usuario].
     */
    afegirUsuari_a_Recurs(button) {
      let me = this;
      axios
        .put("/BroggiProject/public/api/recurso/" + this.recurso, {
          id_usuario: me.usuario.id
        })
        .then(function(response) {
          me.$root.$emit("bv::hide::modal", "modalAssignarRecurs", button);
          me.getUsuarios();
          me.getRecursos();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    /**
     * Función que al presionar el botón 'Acceptar' del modal {modalAdd}
     * hace una llamada a la API y añade un nuevo usuario proveniente
     * del objeto {usuario} y volvemos a cargar los usuario (API).
     */
    afegirUsuario(button) {
      let me = this;
      if (this.validation) {
        axios
          .post("/BroggiProject/public/api/usuarios", this.usuario)
          .then(function(response) {
            me.$root.$emit("bv::hide::modal", "modalAdd", button);
            me.getUsuarios();
          })
          .catch(function(error) {
            console.log(error);
            me.$root.$emit("bv::hide::modal", "modalAdd", button);
          });
      }
    },
    infoDelete(item, index, button) {
      let me = this;
      axios
        .delete("/BroggiProject/public/api/usuarios" + "/" + item)
        .then(function(response) {
          me.getUsuarios();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    /**
     * Función que al presionar el botón 'Editar' obtiene
     * el objeto {usuario} donde hemos hecho clic y abre
     * un modal para editarlo.
     */
    info(item, index, button) {
      this.addUsuari = false;
      this.usuario = item;
      this.$root.$emit("bv::show::modal", "modalEdit", button);
    },
    /**
     * Función que al presionar el botón 'Afegir usuari'
     * abre un modal para añadir un nuevo {usuario} y borra las
     * propiedades del objeto {usuario} por si había uno anteriormente.
     */
    infoAfegir(button) {
      this.addUsuari = true;
      //Campos del recurso a null
      this.usuario.id = null;
      this.usuario.codi = null;
      this.usuario.nom = "";
      this.usuario.contrasenya = "";
      this.usuario.rol = "";
      this.usuario.rols_id = null;
      this.$root.$emit("bv::show::modal", "modalAdd", button);
      this.getUsuarios();
    },
    /**
     * Función que al presionar un botón 'Assignar recurs'
     * abre un modal obteniendo el objeto {usuario} donde
     * hemos hecho clic y llama a la API que nos devuelve
     * todos los recursos y hacemos una selección de
     * solo los recursos que no tienen usuario.
     */
    infoRecurs(item, index, button) {
      this.recursosSinUsuario = [];
      this.getRecursosSinUsuario();
      this.usuario = item;
      this.$root.$emit("bv::show::modal", "modalAssignarRecurs", button);
    },
    /**
     * Función que al presionar un botón 'Cancel·lar' del modal
     * borra las propiedades del objeto {usuario} y llama a la
     * API que devuelve todo los usuarios y los mostramos.
     */
    cerrarModal(modalID, e) {
      this.usuario.id = null;
      this.usuario.codi = null;
      this.usuario.nom = "";
      this.usuario.contrasenya = "";
      this.usuario.rol = "";
      this.usuario.rols_id = null;
      this.recurso = null;
      this.getUsuarios();
    },
    /**
     * Función que devuelve si un usuario está asignado
     * a algún recurso.
     */
    mirarUsuarioEnRecurso(id) {
        /*const recursosSinUsuario = this.getRecursosSinUsuario();
        const recursos = this.getRecursos();*/

        //Concatenamos el array {recursosSinUsuario} y el array {recursos}
        let recursosConUsuario = this.recursosSinUsuario.concat(this.recursos);

        /**
         * Eliminamos los recursos que sean iguales, así nos quedan solo
         * los que tienen usuario
         */
        recursosConUsuario = recursosConUsuario.filter(function(item, pos) {
            return recursosConUsuario.indexOf(item) == pos;
        });

        /**
         * Buscamos en el array {recursosConUsuario} un [id_usuario] igual
         * al [id] del usuario que hemos seleccionado.
         */
        const recurso = recursosConUsuario.find(recurso => recurso.id_usuario === id);

        let noTieneRecurso;

        /**
         * if () -> Si no lo encuentra no tiene recurso
         * else -> Si lo encuentra tiene recurso
         */
        if (typeof recurso === 'undefined') {
            noTieneRecurso = true;
        } else {
            noTieneRecurso = false;
        }

        return noTieneRecurso;
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    descargarPDF() {
        var pdf = new jsPDF();

        pdf.autoTable({
            html: '#usuaristable',
        })

        pdf.save('usuaris.pdf');
    },
  }
};
</script>
