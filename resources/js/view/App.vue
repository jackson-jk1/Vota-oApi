<template>
 <div>
     <Navbar></Navbar>
     <div class="container">
         <router-view></router-view>
     </div>
 </div>
</template>
<script>
const idUser = null;
import Navbar from "../components/Navbar";
export default {
    user:{},
    components: {Navbar},
    comments: {Navbar},
    mounted(){
        axios.get('/api/user').then((res)=>{
            const idUser = res.data;
        });
    }
}
</script>
<style lang="sass">
@import "resources/sass/app"

</style>
