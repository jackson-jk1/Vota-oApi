<template>
    <div>
        <template>
            <v-card
                class="mx-auto"
                max-width="300"
                tile
            >
                <v-list shaped>
                    <v-subheader>
                        <h4>
                            <v-icon>mdi-account
                            </v-icon>
                            {{user.name}}
                        </h4>
                    </v-subheader>
                    <v-list-item-group
                        color="primary"
                    >
                        <v-list-item
                            v-for="(item, i) in items"
                            :key="i"
                        >
                            <v-list-item-icon>
                                    <v-icon v-text="item.icon"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <router-link :to="item.route">
                                <v-list-item-title v-text="item.text"></v-list-item-title>
                                </router-link>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-card>
        </template>
    </div>
</template>
<script>
export default {
    data: function() {
        return {

            items: [
                { text: 'Cadastrar Enquetes', icon: 'mdi-book',route:'/register'},
                { text: 'Suas as Enquetes', icon: 'mdi-pencil',route:'/view'},
                { text: 'Todas as Enquetes', icon: 'mdi-flag',route:'/'},

            ],

            user:{
                id:'',
                name:'',
            }
        }
    },
    mounted(){
        axios.get('/api/user').then((res)=>{
            this.user.id = res.data.id
            this.user.name = res.data.name
            console.log(this.user)
        })
    }
}
</script>
