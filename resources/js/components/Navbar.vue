<template>
    <div
        color="grey lighten-4"
        flat
        height="200px"
        tile
        class ="mb-5"
    >
        <v-toolbar dense>

            <v-toolbar-title>Enquete</v-toolbar-title>

            <v-spacer></v-spacer>
            <router-link :to="{name: 'home'}">
            <v-btn icon>
             <v-icon>mdi-home</v-icon>
            </v-btn>
            </router-link>
            <router-link :to="{name: 'menu'}">
            <v-btn icon>
                <v-icon>mdi-menu</v-icon>
            </v-btn>
            </router-link>
            <v-btn icon
                   @click="logout">
               <v-icon>mdi-login</v-icon>
            </v-btn>
        </v-toolbar>
    </div>
</template>
<script>
export default {
    methods:{
        logout(){
            axios.post('api/logout').then(()=>{
                this.$router.push('loginForm')
            });
        }
    }
}
</script>
