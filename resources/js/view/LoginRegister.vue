<template>
    <div class="container">
        <div class="d-flex justify-content-center">
            <v-card
            width="70%">
                <div class=" container mb-2">
                <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
                >
                    <h2 v-if="cad == false">Login</h2>
                    <h2 v-if="cad == true">Cadastro</h2>
                    <v-text-field
                        v-if="cad == true"
                        v-model="name"
                        label="Name"
                        required
                    ></v-text-field>

                    <v-text-field
                        v-model="email"
                        :label="this.errors.email == null ? 'Email': this.errors.email "
                        required
                    ></v-text-field>
                         <v-text-field
                             v-model="password"
                             :label="this.errors.password == null ? 'Senha': this.errors.password "
                             :counter="cad == true ? 20 : null"
                             required
                         ></v-text-field>
                    <v-btn
                        v-if="cad == true"
                        :disabled="!valid"
                        class="mr-4"
                        @click="submit"
                    >
                        enviar
                    </v-btn>

                    <v-btn
                        v-if="cad == false"
                        :disabled="!valid"
                        class="mr-4"
                        @click="login"
                    >
                        logar
                    </v-btn>

                    <v-btn

                        @click="troca"
                    >
                        <p class="mt-3"v-if="cad == false">Cadastro</p>
                        <p class="mt-3" v-if="cad == true">Login</p>
                    </v-btn>
                </v-form>
              </div>
             </v-card>

    </div>
   </div>
</template>
<script>
const re = /\S+@\S+\.\S+/;
export default {
    data: function() {
        return {
            valid: false,
            cad:false,
            name: '',
            password:'',
            email: '',
            errors: {
                name:null,
                email:null,
                password:null,
            }
        }
    },
    methods: {


            submit(){
                this.validate(this.email, this.password)
                if(!this.email || !this.password || !this.name){
                    return
                }
                const localData = new FormData()
                localData.append('name', this.name)
                localData.append('email', this.email)
                localData.append('password', this.password)
                axios.post('/api/register', localData, )
                    .then(() => {
                        this.$fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Cadastrado com sucesso',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            this.name = '';
                            this.email = '';
                            this.password = '';
                            this.cad = true;
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

        login(){
               this.validate(this.email, this.password)

                if(!this.email || !this.password){
                    return
                }
            const loginlData = new FormData()
            loginlData.append('email', this.email)
            loginlData.append('password', this.password)
            axios.post('/api/login', loginlData).then((res) =>{
                console.log(res)
                this.$router.push({ name: "home"});
            }).catch((error) =>{
                this.errors = error.response.data.errors;
            })
        },

        troca(){
             this.cad =! this.cad;
             this.email = '';
             this.name = '';
             this.password = '';
             this.errors.email ='Email'
             this.errors.password ='Senha'
        },

        validate(email, senha){
            if(email){
            if(re.test(email) == false){
                return this.errors.email = 'Digite um Email valido'
            }}
            if(senha.length < 8 ){
                return this.errors.password = 'Digite uma senha maior'
            }
            if(senha.length > 20 ){
                return this.errors.password = 'Digite uma senha menor'
            }
        }


 }
}

</script>
