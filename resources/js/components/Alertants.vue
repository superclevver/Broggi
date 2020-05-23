<template>
    <b-container fluid class="containerPlantilla">
        <div class="header">
            <header-plantilla></header-plantilla>

            <div class="titleComponent">
                Alertants
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
                    class="float-right btnAfegirPlantilla"
                    v-on:click="infoAfegir($event.target)"
                    size="sm"
                    variant="primary">
                    Afegir alertant
                </b-button>

                <b-button
                    class="float-right mr-3 btnDescargarPlantilla"
                    v-on:click="descargarPDF()"
                    size="sm"
                    variant="info">
                    Descargar PDF
                </b-button>
            </b-col>
        </b-row>

        <b-table
            id="alertantsTaula"
            striped
            head-variant="dark"
            class="taulaPlantilla"
            show-empty
            stacked="md"
            :selectable="false"
            :fields="fields"
            :items="alertants"
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
            </template>

            <template v-slot:row-details="row">
                <b-card>
                    <ul>
                        <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                    </ul>
                </b-card>
            </template>
        </b-table>

        <b-modal  size="lg" id="modalEdit" centered  :title="'Alertant '+ alertant.nom" ok-only>
            <div>

                <b-form-group
                    label-cols-sm="3"
                    label="Nom:"
                    label-align-sm="right"
                    label-for="nested-city"
                >
                    <b-form-input v-model="alertant.nom" id="nested-city"></b-form-input>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Cognoms:"
                    label-align-sm="right"
                    label-for="nested-city"
                >
                    <b-form-input v-model="alertant.cognoms" id="nested-city"></b-form-input>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Adreça:"
                    label-align-sm="right"
                    label-for="nested-state"
                >
                    <b-form-input v-model="alertant.adreca" id="nested-state"></b-form-input>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Número de telèfon:"
                    label-align-sm="right"
                    label-for="nested-street"
                >
                    <b-form-input v-model="alertant.telefon" id="asda"></b-form-input>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Municipi:"
                    label-align-sm="right"
                    label-for="nested-country"
                >
                    <b-form-select
                        v-model="alertant.municipis_id"
                        :options="municipis"
                        class="mb-3"
                        value-field="id"
                        text-field="nom"
                        disabled-field="notEnabled"
                    ></b-form-select>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Tipus d'alertant:"
                    label-align-sm="right"
                    label-for="nested-country"
                >
                    <b-form-select
                        v-model="alertant.tipus_alertant_id"
                        :options="tipusAlertant"
                        class="mb-3"
                        value-field="id"
                        text-field="tipus"
                        disabled-field="notEnabled"
                    ></b-form-select>
                </b-form-group>

            </div>

            <template v-slot:modal-footer="{ ok, cancel }">
                <b-button size="sm" variant="primary" @click="editarAlertant(alertant.id, $event.target)">
                    Aceptar
                </b-button>

                <b-button size="sm" variant="secondary" @click="cancel(), cerrarModal('modalEdit', $event.target)">
                    Cancel·lar
                </b-button>
            </template>


        </b-modal>

        <b-modal size="lg" id="modalAdd" centered  :title="'Crear alertant'">
            <div>

                <b-form-group
                    label-cols-sm="3"
                    label="Nom:"
                    label-align-sm="right"
                    label-for="nested-city"
                >
                    <b-form-input v-model="alertant.nom" id="nested-city"></b-form-input>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Cognoms:"
                    label-align-sm="right"
                    label-for="nested-city"
                >
                    <b-form-input v-model="alertant.cognoms" id="nested-city"></b-form-input>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Adreça:"
                    label-align-sm="right"
                    label-for="nested-state"
                >
                    <b-form-input v-model="alertant.adreca" id="nested-state"></b-form-input>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Municipi:"
                    label-align-sm="right"
                    label-for="nested-country"
                >
                    <b-form-select
                        v-model="alertant.municipis_id"
                        :options="municipis"
                        class="mb-3"
                        value-field="id"
                        text-field="nom"
                        disabled-field="notEnabled"
                    ></b-form-select>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Número de telèfon:"
                    label-align-sm="right"
                    label-for="nested-street"
                >
                    <b-form-input v-model="alertant.telefon" id="asda"></b-form-input>
                </b-form-group>

                <b-form-group
                    label-cols-sm="3"
                    label="Tipus d'alertant:"
                    label-align-sm="right"
                    label-for="nested-country"
                >
                    <b-form-select
                        v-model="alertant.tipus_alertant_id"
                        :options="tipusAlertant"
                        class="mb-3"
                        value-field="id"
                        text-field="tipus"
                        disabled-field="notEnabled"
                    ></b-form-select>
                </b-form-group>

            </div>

            <template v-slot:modal-footer="{ ok, cancel }">
                <b-button size="sm" variant="primary" @click="afegirAlertant($event.target)">
                    Aceptar
                </b-button>

                <b-button size="sm" variant="secondary" @click="cancel(), cerrarModal('modalAdd', $event.target)">
                    Cancel·lar
                </b-button>
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
				selected: null,
				municipis: [],
                tipusAlertant: [],
				alertants: [],
				alertant: {
					'id': null,
					'nom': '',
					'cognoms': '',
					'adreca': '',
                    'municipis_id':  null,
                    'municipi': null,
                    'telefon': '',
                    'tipus_alertant_id': null,
                    'tipus_alertant': null
				},
				fields: [
					{ key: 'nom', label: 'Nom', sortable: true, class: 'text-center' },
					{ key: 'cognoms', label: 'Cognoms', sortable: true, class: 'text-center' },
                    { key: 'adreca', label: 'Adreça', sortable: true, class: 'text-center' },
                    { key: 'municipi.nom', label: "Municipi", sortable: true, class: 'text-center' },
					{ key: 'telefon', label: 'Telèfon', sortable: true, class: 'text-center' },
                    { key: 'tipus_alertant.tipus', label: "Tipus d'alertant", sortable: true, class: 'text-center' },
                    { key: 'actions', label: '' }
				],
				addAlertant: null,
				totalRows: 1,
				currentPage: 1,
				perPage: null,
				pageOptions: [5, 10, 15],
				sortBy: '',
				sortDesc: false,
				sortDirection: 'asc',
				filter: null,
				filterOn: [],
			}
		},

		created() {
            this.mostrarAlertants();
			this.getMunicipis();
			this.getTipusAlertant();
		},

		computed: {
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

            getTipusAlertant() {
                let me = this;

                axios.get('/BroggiProject/public/api/TipusA').then(function (response) {
                    me.tipusAlertant = response.data;
                    // const tipusAlertant = data.items;
                    // return(tipusAlertant);
                })
                .catch (function (error) {
                    console.log(error);
                })
            },

            getMunicipis() {
                let me = this;

                axios.get('/BroggiProject/public/api/municipi').then(function (response) {
                    me.municipis = response.data;
                    // const municipis = data.items;
                    // return(municipis);
                })
                .catch (function (error) {
                    console.log(error);
                })
            },

            mostrarAlertants() {
                let me = this;

                axios.get('/BroggiProject/public/api/alertant').then(function (response) {
                    me.alertants = response.data;
                    // const items = data.items;
                    // return(items);
                })
                .catch (function (error) {
                    console.log(error);
                })
            },

            editarAlertant(id, button) {
                let me = this;

                axios.put('/BroggiProject/public/api/alertant/'+id, this.alertant).then(function (response) {
                    me.$root.$emit('bv::hide::modal', "modalEdit", button);
                    me.mostrarAlertants();
                })
                .catch (function (error) {
                    console.log(error);
                    me.$root.$emit('bv::hide::modal', "modalEdit", button);
                })
            },

            afegirAlertant(button) {
                let me = this;

                axios.post('/BroggiProject/public/api/alertant', this.alertant).then(function (response) {
                    me.$root.$emit('bv::hide::modal', "modalAdd", button);
                    me.mostrarAlertants();
                })
                .catch (function (error) {
                    console.log(error);
                    me.$root.$emit('bv::hide::modal', "modalAdd", button);
                })
            },

            infoDelete(item, index, button) {
                let me = this;

                axios.delete('/BroggiProject/public/api/alertant/'+item).then(function (response) {
                    me.mostrarAlertants();
                })
                .catch (function (error) {
                    console.log(error);
                })
            },

            info(item, index, button) {
                this.addAlertant = false;
                this.alertant = item;
                this.$root.$emit('bv::show::modal', "modalEdit", button);
            },

            clean() {
                this.alertant.id = null,
                this.alertant.nom = '',
                this.alertant.cognoms = '',
                this.alertant.adreca = '',
                this.alertant.municipis_id = null,
                this.alertant.municipis = null,
                this.alertant.telefon = '',
                this.alertant.tipus_alertant_id = null,
                this.alertant.tipus_alertant = null
            },

            infoAfegir(button) {
                this.addAlertant = true;

                this.clean();

                this.$root.$emit('bv::show::modal', "modalAdd", button);
                this.mostrarAlertants();
            },

            descargarPDF() {
                var pdf = new jsPDF();

                pdf.autoTable({
                    html: '#alertantsTaula',
                })

                pdf.save('alertant.pdf');
            },

            cerrarModal(modalID, e) {
                this.clean();

                this.$root.$emit('bv::hide::modal', modalID, e);

                this.mostrarAlertants()
            },

            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            }

        }
    }
</script>
