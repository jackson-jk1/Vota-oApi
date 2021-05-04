<template>
    <div data-app>
    <v-card
        class="mx-auto"
        max-width="500"

    >
        <v-toolbar
            color="pink"
            dark
        >
            <v-toolbar-title>Suas Enquetes</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn class="mr-5"> <router-link :to="{name: 'resgisterEnquete'}">Nova Enquete</router-link></v-btn>
        </v-toolbar>
        <v-list>
            <v-list-group
                v-for="item in items"
                :key="item.id"
                v-model="item.active"
                no-action
                @click="requestOpcoes(item.id)"
            >
                <template v-slot:activator>
                    <v-btn class="mr-1" @click="getAttEnq(item.inicio, item.fim,item.titulo,item.id)"> <v-icon>mdi-pencil</v-icon> </v-btn>
                    <v-btn class="mr-5" @click ="destroyEnquete(item.id)"> <v-icon>mdi-delete</v-icon> </v-btn>
                    <v-list-item-content>
                        <v-list-item-title v-text="item.titulo"> </v-list-item-title>
                    </v-list-item-content>
                </template>

                <v-list-item
                    v-for="(child) in respostas"
                    :key="child.id"
                >
                    <v-list-item-content>
                        <v-list-item>

                           {{child.titulo}}
                            <v-spacer></v-spacer>
                            <v-btn  class="mr-1" v-if="add > 3"  @click="destroy(child.id)"> <v-icon>mdi-delete</v-icon> </v-btn>
                            <v-btn  @click.stop="getAtt(child.titulo, child.id)"> <v-icon>mdi-pencil</v-icon> </v-btn>
                        </v-list-item>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item
                >
                    <v-list-item-content>
                        <v-list-item>
                            <p>Inicio: {{item.inicio}}</p>
                        </v-list-item>
                        <v-list-item>
                            <p> Fim: {{item.fim}}</p>
                        </v-list-item>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item-content v-if="add < 5">
                    <v-list-item>
                        <v-spacer></v-spacer>
                        <v-btn  @click="addOpcao(item.id)"> <v-icon>mdi-plus</v-icon> </v-btn>
                    </v-list-item>
                </v-list-item-content>

            </v-list-group>
        </v-list>
    </v-card>

    <v-row justify="center">
        <v-dialog

            v-model="dialog"
            max-width="50%"

        >
            <v-card>
                <v-card-title class="headline">
                 Opção
                </v-card-title>
                <div class="container">
                <v-text-field
                    label="Regular"
                    placeholder="Placeholder"
                    v-model="titulo"
                ></v-text-field>
                </div>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-if="enqueteAdd == true"
                        color="green darken-1"
                        text
                        @click="addNovaOpcao"
                    >
                        Enviar
                    </v-btn>

                    <v-btn
                        v-if="enqueteAdd == false"
                        color="green darken-1"
                        text
                        @click="updateOpcao"
                    >
                        Enviar
                    </v-btn>
                </v-card-actions>
            </v-card>
         </v-dialog>
      </v-row>

        <v-row justify="center">
            <v-dialog

                v-model="dialog2"
                max-width="50%"

            >
                <v-card>
                    <v-card-title class="headline">
                        Enquete
                    </v-card-title>

                    <div class="container">
                        <v-text-field
                            label="Nome"
                            placeholder="Placeholder"
                            v-model="titulo"
                        ></v-text-field>
                    </div>
                    <div class="container">
                        <v-row>
                            <v-col
                                md="6"
                                xs ="12">
                                <div>
                                    <p>Inicio</p>
                                    <input  type="date" v-model="dataI">
                                    <input class="mt-2" type="time" v-model="horaI">
                                </div>
                            </v-col>
                            <v-col
                                md="6"
                                xs ="12">
                                <div>
                                    <p>Fim</p>
                                    <input type="date" v-model="dataF">
                                    <input class="mt-2" type="time" v-model="horaF">

                                </div>
                            </v-col>
                        </v-row>
                    </div>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="updateEnquete()"
                        >
                            Enviar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
import moment from "moment"
export default {
    data: () => ({
        user:null,
        show: false,
        selected: [2],
        items: {
            active: true,
        },
        respostas:{},
        add:'',
        enqueteAdd:false,
        dialog: false,
        dialog2:false,
        titulo:null,
        idEnquete:'',
        idOpcao:'',
        dataI:'',
        dataF:'',
        horaI:'',
        horaF:'',



    }),
    mounted(){
        axios.get('/api/user').then((res)=>{
            this.user = res.data;
            axios.post('/api/view/' + this.user.id).then((res)=>{
                this.items = res.data.enquetes;
                console.log(res);

            });
        });

    },
    methods:{
        requestOpcoes(id){
        axios.post('/api/view/opcao/' + id).then((res)=>{
            this.respostas = res.data.opcoes;
            this.add = res.data.opN;


        });
    },
        updateEnquete(){
            const localData = new FormData();
            localData.append('titulo', this.titulo);
            localData.append('inicio',  this.dataI + " " + this.horaI);
            localData.append('fim', this.dataF + " " + this.horaF);

            axios.post('/api/update/' + this.idEnquete, localData)
                .then((res) => {
                    console.log(res);
                    this.$fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Alterado com sucesso',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    })
                })
                .catch((error) => {
                    this.$fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Dados inconsistentes',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {

                    });
                })
        },
        updateOpcao(){
            const localData = new FormData()
            localData.append('titulo', this.titulo)
            console.log(this.idEnquete);
            axios.post('/api/update/opcoes/'+ this.idOpcao, localData).then((res)=>{
                this.$fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Alterado com sucesso',
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
        addOpcao(id){
        this.idOpcao = id;
        this.enqueteAdd = true;
        this.dialog =! this.dialog;
        },

        addNovaOpcao(){
            const localData = new FormData();
            localData.append('titulo', this.titulo);
            console.log(this.idEnquete);
            axios.post('/api/store/opcoes/' + this.idOpcao, localData).then((res)=>{
                this.$fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Inserido com Sucesso',
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
        getAttEnq(inicio,fim,titulo,id){
            let i = moment(inicio);
            let f = moment(fim);
                this.idEnquete = id;
                this.titulo = titulo;
                this.dataI = i.format("yyyy-MM-DD");
                this.horaI = '';
                this.horaF ='';
                this.dataF =f.format("yyyy-MM-DD");
                this.dialog2 =! this.dialog2;
        },
        getAtt(titulo,id){
            this.titulo = titulo;
            this.idOpcao = id;
            this.dialog =! this.dialog;
        },
        destroy(id){
            axios.post('/api/destroy/opcoes/' + id).then((res)=>{
                this.$fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Deletado com sucesso',
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
        destroyEnquete(id){
            axios.post('/api/destroy/' + id).then((res)=>{
                this.$fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Deletado com sucesso',
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
        }

    }
}
</script>
