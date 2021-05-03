<template>
    <div data-app>

            <v-container class="grey lighten-5">
                <v-row>
                    <v-col
                        v-for="item in items"
                        :key="item.id"
                        col="12"
                        xs="12"
                        md="4"
                    >
                        <v-card
                        >
                    <v-card-text>
                        <v-list-item-content>
                             <v-card-title>  {{item.titulo}} </v-card-title>
                            <ul>
                                <li class="mb-2">Inicio: {{item.inicio}}</li>
                                <li>Fim: {{item.fim}}</li>
                            </ul>
                            <div class="mt-4" v-if="item.status == 'A'">
                               <v-btn  @click="requestOpcoes(item.id)">Votar</v-btn>
                            </div>

                        </v-list-item-content>
                    </v-card-text>
              </v-card>
                <v-row justify="center">

                    <v-dialog
                        v-model="dialog"
                        max-width="200"

                    >
                        <v-card>
                            <div class="container">
                            <v-card-title class="headline">
                            </v-card-title>
                            <v-container
                                class="px-0"
                                fluid
                            >
                                <ul v-for="resposta in respostas">
                                    <li> {{resposta.titulo}} Votos: {{resposta.votos}}
                                        <v-spacer></v-spacer>
                                        <v-btn
                                        @click="submit(resposta.id)">
                                            Enviar
                                        </v-btn>

                                    </li>
                                </ul>
                            </v-container>
                            <v-spacer></v-spacer>
                            </div>
                        </v-card>

                    </v-dialog>
                </v-row>
                    </v-col>
                </v-row>
     </v-container>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
        radioGroup: 1,
        user:null,
        show: false,
        items: {
            active: true,
        },
        respostas:{},
        dialog:false,
        votos:'',

    }
    }

,
    mounted(){
        axios.get('/api/user').then((res)=>{
            this.user = res.data;
            axios.post('/api/view/' + this.user.id).then((res)=>{
                this.items = res.data;
            });
        });

    },
    methods:{
        requestOpcoes(id){
            axios.post('/api/view/opcao/' + id).then((res)=>{
                this.respostas = res.data.opcoes;
                this.dialog = true;
            });
        },
        submit(id){
            axios.post('/api/voto/opcao/' + id).then((res)=>{
                this.respostas[id-1].votos +=1;
            });
        }
    },

}
</script>
