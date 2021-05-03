<template>
    <v-container fluid>
        <v-toolbar
            color="pink"
            dark
        >
            <v-toolbar-title>Nova Enquete</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn class="mr-5"> <router-link :to="{name: 'enquetes'}">Suas Enquetes</router-link></v-btn>
        </v-toolbar>
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation>

        <v-row>
            <v-col cols="4">
                <v-subheader>Titulo</v-subheader>
            </v-col>
            <v-col cols="8">
                <v-text-field
                    :rules="Perguntas"
                    v-model="enquete.titulo"
                    required

                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="4">
                <v-subheader>Duraçao</v-subheader>
            </v-col>
            <v-col cols="8">
                <v-row>
                    <v-col
                        cols="12"

                    >
                        <div data-app>
                            <v-row>
                                <v-col
                                    md="6"
                                    xs ="12">
                                    <div>
                                    <p>Inicio</p>
                                    <input  type="date" v-model="enquete.inicio">
                                    <input class="mt-2" type="time" v-model="enquete.horaN">
                                    </div>
                                </v-col>
                                <v-col
                                    md="6"
                                    xs ="12">
                                    <div>
                                    <p>Fim</p>
                                    <input type="date" v-model="enquete.fim">
                                    <input class="mt-2" type="time" v-model="enquete.horaF">
                                     </div>
                                </v-col>
                            </v-row>
                        </div>

                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <div v-for="n in enquete.quant">
        <v-row >
            <v-col cols="4">
                <v-subheader>{{n}}º Pergunta</v-subheader>
            </v-col>
            <v-col cols="8">
                 <v-text-field
                     :rules="Perguntas"
                     v-model="enquete.resposta[n]"
                     required

                ></v-text-field>
            </v-col>
        </v-row>
        </div>
        <v-btn
        @click="addPergunta">
            <h1>+</h1>
        </v-btn>
        <v-btn
            :disabled="!valid"
            @click="submit()">
            <p class="mt-3">Enviar</p>
        </v-btn>
        </v-form>
    </v-container>
</template>

<script>
import moment from "moment"


const hoje = moment(new Date());
export default {
    data: function () {
        return{
            dialog: false,
            valid: true,
            enquete: {
                titulo: '',
                inicio:hoje.format("yyyy-MM-DD"),
                horaN:'',
                horaF:'',
                fim: hoje.format("yyyy-MM-DD"),
                resposta: {
                    1: '',
                    2: '',
                    3: '',
                    4: '0',
                    5: '0',
                },
                quant: 3,
             },
            Perguntas: [
                v => !!v || 'Campo Obrigatório',
            ],
            }

    },
    methods: {
        addPergunta() {
            if (this.enquete.quant < 5) {
                this.enquete.quant += 1;
                this.enquete.resposta[this.enquete.quant] = '';
            } else {
                return this.enquete.quant;
            }
        },
        submit() {
            axios.post('/api/store', this.enquete)
                .then((res) => {

                    this.$fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Cadastrado com sucesso',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    })
                }).catch((error) => {
                this.$fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Dados inconsistentes',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            });
        },
    }



}
</script>
