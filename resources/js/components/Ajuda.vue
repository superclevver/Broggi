<template>
    <main>

        <div class="header">
            <header-plantilla></header-plantilla>

            <div class="titleComponent">
                Ajuda
            </div>
        </div>

        <div class="contingut">

            <div class="boxLeftRight">

                <div class="boxLeft">
                    <div class="boxPreguntas">
                        <div class="titlePreguntas">
                            Preguntas Freqüents
                        </div>

                        <div class="bodyPreguntas">

                            <ul>
                                <li v-for="(value, key) in preguntes" :key="key">

                                    <div class="pregunta_idioma">
                                        <!-- Català -->
                                        <img class="bandera_idioma" src="/BroggiProject/public/storage/media/img/cat.svg" alt="Icona de la llengua catalana">
                                        <span class="pregunta">{{ value.pregunta_cat }}</span>
                                        <span class="respuesta">{{ value.resposta_cat }}</span>
                                    </div>

                                    <div class="pregunta_idioma">
                                        <!-- Castellà -->
                                        <img class="bandera_idioma" src="/BroggiProject/public/storage/media/img/esp.svg" alt="Icona de la llengua catalana">
                                        <span class="pregunta">{{ value.pregunta_esp }}</span>
                                        <span class="respuesta">{{ value.resposta_esp }}</span>
                                    </div>

                                    <div class="pregunta_idioma">
                                        <!-- Anglès -->
                                        <img class="bandera_idioma" src="/BroggiProject/public/storage/media/img/eng.svg" alt="Icona de la llengua catalana">
                                        <span class="pregunta">{{ value.pregunta_eng }}</span>
                                        <span class="respuesta">{{ value.resposta_eng }}</span>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

                <div class="boxRight">

                    <div class="titleCFA">
                        Com funciona l'aplicació?
                    </div>

                    <div class="videoCFA">
                        <video width="400" controls>
                            <source src="/BroggiProject/public/storage/media/videos/CFA/login_menu.mp4" type="video/mp4">
                            <p>El teu navegador no és compatible amb el vídeo.</p>
                        </video>

                        <div class="boxTitleTextCFA">
                            <div class="titleTextCFA">
                                Com entrar a l'aplicació i navegar pels menús
                            </div>

                            <div class="textCFA">
                                <p>Aquest vídeo explica com funciona com entrar a l'aplicació i la navegació per als menús.</p>
                            </div>
                        </div>
                    </div>

                    <div class="videoCFA">
                        <video width="400" controls>
                            <source src="/BroggiProject/public/storage/media/videos/CFA/incidencies.mp4" type="video/mp4">
                            El teu navegador no és compatible amb el vídeo.
                        </video>

                        <div class="boxTitleTextCFA">
                            <div class="titleTextCFA">
                                Pantalla 'Incidències'
                            </div>

                            <div class="textCFA">
                                <p>Aquest vídeo explica com funciona la pantalla d'incidències. Explica, per exemple, com afegir una nova incidència.</p>
                                <p>El tutorial també es pot aplicar a les altres taules, ja que la funcionalitat es la mateixa a la hora d'afegir, editar o borrar dades.</p>
                            </div>
                        </div>
                    </div>

                    <div class="videoCFA">
                        <video width="400" controls>
                            <source src="/BroggiProject/public/storage/media/videos/CFA/ajuda.mp4" type="video/mp4">
                            El teu navegador no és compatible amb el vídeo.
                        </video>

                        <div class="boxTitleTextCFA">
                            <div class="titleTextCFA">
                                Pantalla 'Ajuda'
                            </div>

                            <div class="textCFA">
                                <p>Aquest vídeo explica la funcionalitat de la pàgina 'Ajuda'.</p>
                                <p>Les ajudes que et mostren i la pròpia funcionalitat de l'aplicació.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="boxVideosGene">

                <!-- URL videos de la Generalitat de Catalunya: https://canalsalut.gencat.cat/ca/actualitat/recursos_multimedia/primers-auxilis/ -->

                <div class="titleGene">
                    Que fer en cas d'emergència
                </div>

                <div class="bodyGene">
                    <div class="videoGene" v-for="(value, key) in video_gene" :key="key">
                        <video width="500" controls>
                            <source :src="plantilla_url_gene + value.url" type="video/mp4">
                            <p>El teu navegador no és compatible amb el vídeo.</p>
                        </video>

                        <div class="boxTitleTextGene">
                            <div class="titleTextGene">
                                {{ value.title }}
                            </div>

                            <div class="textGene">
                                {{ value.text }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <b-button
                class="btnWordBank"
                v-b-modal.modalWordBank
                size="sm"
                variant="primary">
                Word Bank
            </b-button>

        </div>

        <b-modal id="modalWordBank" size="xl" hide-footer centered>

            <template v-slot:modal-title>
                <strong>Word bank</strong>
            </template>

            <div v-for="(paraules, index) in groupedParaules" :key="index" class="row">
                <div v-for="(paraula, index2) in paraules" :key="index2" class="col-lg-4">
                    <ul class="listaPalabra" style="background-color: #f8fafc; border: 1px solid rgba(0,0,0,0.125);">
                        <li>
                            <div class="paraulaWB">
                                <img class="bandera_idioma" src="/BroggiProject/public/storage/media/img/cat.svg" alt="Icona de la llengua catalana">
                                {{paraula.cat}}
                            </div>

                            <div class="paraulaWB">
                                <img class="bandera_idioma" src="/BroggiProject/public/storage/media/img/esp.svg" alt="Icona de la llengua catalana">
                                {{paraula.esp}}
                            </div>

                            <div class="paraulaWB">
                                <img class="bandera_idioma" src="/BroggiProject/public/storage/media/img/eng.svg" alt="Icona de la llengua catalana">
                                {{paraula.eng}}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </b-modal>
    </main>
</template>

<script>
    export default {
        data() {
            return {
                preguntes: [
                    {
                        pregunta_cat: "Necessites que truquem a una ambulància?",
                        resposta_cat: "Sí, si us plau. Crec que s'han fet mal.",
                        pregunta_esp: "¿Necesitas que llamemos a una ambulancia?",
                        resposta_esp: "Sí, por favor. Creo que se han hecho daño.",
                        pregunta_eng: "Do you need us to call an ambulance?",
                        resposta_eng: "Yes please. I think they have been injured."
                    },
                    {
                        pregunta_cat: "Que ha passat?",
                        resposta_cat: "Hi ha hagut un accident de cotxe.",
                        pregunta_esp: "¿Que ha pasado?",
                        resposta_esp: "Ha habido un accidente de coche.",
                        pregunta_eng: "What happened?",
                        resposta_eng: "There has been a car accident."
                    },
                    {
                        pregunta_cat: "Has presenciat l'accident?",
                        resposta_cat: "No exactament, he escoltat un sorroll de lluny i m'he apropat. ",
                        pregunta_esp: "¿Has presenciado el accidente?",
                        resposta_esp: "No exactamente, he escuchado un ruido de lejos y me he acercado.",
                        pregunta_eng: "Have you see the accident?",
                        resposta_eng: "Not exactly, I heard a noise far away and I approached."
                    },
                    {
                        pregunta_cat: "On estàs? Em pots dir la direcció?",
                        resposta_cat: "Sí, estic a Av. Meridiana al costat del Heron City. Justament hi ha un parc amb una estàtua d'un carruatge.",
                        pregunta_esp: "¿Dónde estás? ¿Me puedes decir la dirección?",
                        resposta_esp: "Sí, estoy en Av. Meridiana al lado de Heron City. Justamente hay un parque con una estatua de un carruaje.",
                        pregunta_eng: "Where are you? Can you tell me the address?",
                        resposta_eng: "Yes, I am on Av. Meridiana next to Heron City. I am near a park with a statue of a carriage."
                    },
                    {
                        pregunta_cat: "Saps exactament quantes persones estan implicades?",
                        resposta_cat: "No del tot, però veig a dos cotxes amb persones a dins.",
                        pregunta_esp: "¿Sabes exactamente cuántas personas están implicadas?",
                        resposta_esp: "No del todo, pero veo a dos coches con personas dentro.",
                        pregunta_eng: "Do you know exactly how many people are involved?",
                        resposta_eng: "No, but I see two cars with people inside."
                    },
                    {
                        pregunta_cat: "D'acord, ja anem cap allà. Si us plau, no es mogui del lloc i no penji fins que no arribin les ambulàncies.",
                        resposta_cat: "Sí sí, moltes gràcies!",
                        pregunta_esp: "De acuerdo, ya vamos para allá. Por favor, no se mueva del sitio y no cuelgue hasta que no lleguen las ambulancias.",
                        resposta_esp: "Sí sí, muchas gracias!",
                        pregunta_eng: "Okay, we are comming. Do not move from the accident and do not hang up until the ambulances arrive.",
                        resposta_eng: "Yes, thanks you very much!"
                    }
                ],
                plantilla_url_gene: '/BroggiProject/public/storage/media/videos/Generalitat_Catalunya/',
                video_gene: [
                    {
                        url: "rcp.mp4",
                        title: "Maniobres de reanimació cardiopulmonar (RCP)",
                        text: "Professionals del SEM expliquen com actuar davant una aturada cardíaca."
                    },
                    {
                        url: "ictus.mp4",
                        title: "Reconeixement de l'ictus",
                        text: "Professionals del SEM expliquen quines accions cal realitzar si tens sospites que algú pateix un ictus."
                    },
                    {
                        url: "pas.mp4",
                        title: "Si veus un accident, aplica el PAS: Protegir, Alertar, Socórrer",
                        text: "Professionals del SEM mostren com actuar davant una persona accidentada."
                    },
                    {
                        url: "convulsions.mp4",
                        title: "Què cal fer davant una convulsió?",
                        text: "Professionals del SEM expliquen com actuar davant les convulsions, contraccions involuntàries i violentes dels músculs del cos."
                    },
                    {
                        url: "pls.mp4",
                        title: "La Posició Lateral de Seguretat (PLS)",
                        text: "Professionals del SEM expliquen com actuar si trobem una persona inconscient que respira."
                    },
                    {
                        url: "dolor_toracic.mp4",
                        title: "Dolor toràcic. Símptomes i què cal fer",
                        text: "Professionals del SEM expliquen els símptomes i com actuar davant del dolor toràcic."
                    },
                    {
                        url: "ennuegament.mp4",
                        title: "Què cal fer davant un ennuegament?",
                        text: "Professionals del SEM expliquen què cal fer davant un ennuegament, amb obstrucció total o parcial de la via aèria."
                    },
                    {
                        url: "cremades.mp4",
                        title: "Què cal fer davant una cremada?",
                        text: "Professionals del SEM expliquen com actuar davant una cremada, lesió a la pell produïda per foc directe o per contacte amb una font de calor."
                    },
                    {
                        url: "hemorragies.mp4",
                        title: "Què fem davant una hemorràgia?",
                        text: "Professionals del SEM expliquen com actuar davant una hemorràgia, quan ens fem un cop o una ferida."
                    },
                    {
                        url: "picades.mp4",
                        title: "Consells per actuar davant les picades",
                        text: "Professionals del SEM mostren com actuar davant una picada, ja sigui produïda per un insecte o per una medusa."
                    },
                    {
                        url: "cop_calor.mp4",
                        title: "Com actuar davant un cop de calor?",
                        text: "Professionals del SEM mostren què cal fer davant un cop de calor, situació en la què el cos no pot regular la temperatura."
                    },
                    {
                        url: "hipoglucemia.mp4",
                        title: "Què fer davant una hipoglucèmia?",
                        text: "Professionals del SEM expliquen com actuar davant una hipoglucèmia o baixada del sucre que hi ha a la sang."
                    },
                    {
                        url: "administracio_broncodilatadors.mp4",
                        title: "Com administrar els broncodilatadors",
                        text: "Professionals del SEM mostren l’administració correcta dels broncodilatadors, fàrmacs que obren els bronquis i permeten respirar millor."
                    },
                    {
                        url: "intoxicacio.mp4",
                        title: "Què fer davant una intoxicació?",
                        text: "Professionals del SEM expliquen com actuar davant una intoxicació, per la ingesta d’aliments en mal estat o susbtàncies tòxiques."
                    }
                ],
                paraules: [
                    {esp: 'Accidente de coche', cat: 'Accident de cotxe', eng: 'Car accident'},
                    {esp: 'Hemorragia', cat: 'Hemorràgia', eng: 'Hemorrhage'},
                    {esp: 'Lesión', cat: 'Lesió', eng: 'Injury'},
                    {esp: 'Enfermedad', cat: 'Malaltia', eng: 'Illness'},
                    {esp: 'Camilla', cat: 'Camilla', eng: 'Gurney'},
                    {esp: 'Ictus', cat: 'Ictus', eng: 'Stroke'},
                    {esp: 'Vendaje', cat: 'Embenat', eng: 'Bandage'},
                    {esp: 'Grave', cat: 'Greu', eng: 'Severe'},
                    {esp: 'Ebriedad', cat: 'Embriaguesa', eng: 'Drunkenness'},
                    {esp: 'Neumático desinflado', cat: 'Pneumàtic desinflat', eng: 'Flat tire'},
                    {esp: 'Ataque epiléptico', cat: 'Atac epilèptic', eng: 'Epileptic seizure'},
                    {esp: 'Llegar al destino', cat: 'Arribar a la destinació', eng: 'Arrive at destination'},
                    {esp: 'Caerse', cat: 'Caure', eng: 'Fall over'},
                    {esp: 'Sangrado', cat: 'Sagnat', eng: 'Bleeding'},
                    {esp: 'Quemadura', cat: 'Cremada', eng: 'Burn'},
                ]
            }
        },

        methods: {
        },
        computed: {
            groupedParaules() {
                return _.chunk(this.paraules, 3);
            }
        }
    }
</script>
