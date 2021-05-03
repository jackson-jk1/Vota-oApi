import Home from "../view/Home";
import Menu from "../view/Menu";
import LoginRegister from "../view/LoginRegister";
import Enquetes from "../view/Enquetes";
import ListEnquete from "../view/ListEnquete";
import RegisterEnquete from "../view/RegisterEnquete";
import Opcoes from "../view/Opcoes";


const routes = [
     {
        path: '/',
        name: 'home',
        component: Home,
         beforeEnter:(to,from,next) =>{
             axios.get('/api/athenticated').then(()=>{
                 next();
             }).catch(()=>{
                 return next({name: 'loginForm'})
             })
         }
    },
    {
        path: '/menu',
        name: 'menu',
        component: Menu,
        beforeEnter:(to,from,next) =>{
        axios.get('/api/athenticated').then(()=>{
            next();
        }).catch(()=>{
            return next({name: 'loginForm'})
        })
       }
    }
    ,
    {
        path: '/loginForm',
        name: 'loginForm',
        component: LoginRegister
    },
    {
        path: '/view',
        name: 'enquetes',
        component: Enquetes,
        beforeEnter:(to,from,next) =>{
            axios.get('/api/athenticated').then(()=>{
                next();
            }).catch(()=>{
                return next({name: 'loginForm'})
            })
        }
    },
    {
        path: '/list',
        name: 'listEnquete',
        component: ListEnquete,
        beforeEnter:(to,from,next) =>{
            axios.get('/api/athenticated').then(()=>{
                next();
            }).catch(()=>{
                return next({name: 'loginForm'})
            })
        }
    },
    {
        path: '/register',
        name: 'resgisterEnquete',
        component: RegisterEnquete,
        beforeEnter:(to,from,next) =>{
            axios.get('/api/athenticated').then(()=>{
                next();
            }).catch(()=>{
                return next({name: 'loginForm'})
            })
        }
    },
]
export default routes
