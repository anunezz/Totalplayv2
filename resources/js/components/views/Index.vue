<template>
<div>

    <loading-component v-if="$store._modules.root.state.totalplay.loading" />

    <!-- style="background: url('img/publico/fondo.jpg');
                background-size: 100% 100%;
                background-attachment: fixed;" -->

    <el-dialog
        :visible.sync="modal"
        :width="mediaWidth"
        class="ddd"
        :title="titleModal"
        :close-on-click-modal="false"
        :close-on-press-escape="false">
        <div class="text-light" v-if="section">
            <el-row :gutter='20'>
                <el-col :span='24'>
                    <el-input
                        prefix-icon="el-icon-search"
                        size="mini"
                        style="width: 100%;"
                        placeholder="Buscar estado"
                        v-model="searchState"
                        clearable>
                    </el-input>
                </el-col>
                <el-col :span='24'>
                    <br>
                        <el-radio-group
                                :max="1"
                                v-model="selectCity">
                            <el-row :gutter='20'>
                                <el-col  :span='8' v-for="(item, index) in $store._modules.root.state.totalplay.catCities.filter(data => !searchState || data.name.toLowerCase().includes(searchState.toLowerCase()))" :key="index">
                                    <el-radio style="width: 100%;" :label="item.id"> {{item.name}} </el-radio>
                                </el-col>
                            </el-row>
                        </el-radio-group>
                </el-col>
                <el-col :span='24'>
                    <div style='width:100%; padding: 5px 0px; display:flex; justify-content: flex-end;'>
                        <div>
                            <el-button size="mini" type="danger" @click="submitCity">Selecciomnar cobertura</el-button>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <div  class="text-light" v-else>
            <el-row :gutter='20'>
                <el-form :model="form" ref="formLogin">
                    <el-col :span='24'>
                        <el-form-item prop="email"
                            :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: email, message: message.ruleForm.special_characters_email, trigger: ['blur','change']}]">
                            <el-input v-model="form.email" size="mini" placeholder="Correo eléctronico"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span='24'>
                        <el-form-item>
                            <el-input type="password" v-model="form.password" size="mini" placeholder="Password"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span='24'>
                        <el-form-item style="display:flex; justify-content: center;">
                            <div style="margin: 0px auto;">
                                <el-button type="primary" size="mini" @click="login">Iniciar Sesión</el-button>
                            </div>
                        </el-form-item>
                    </el-col>
                </el-form>
            </el-row>
        </div>
    </el-dialog>

    <div class="bg-inverse fixed-top">
        <div class="bg-light" style="color: #6d5c96;">
            <div class="d-flex flex-wrap py-2" :class="{'justify-content-between':(screenWidth >= 469 ),'justify-content-center': (screenWidth <= 469 )}">
                <div class="d-flex cobertura">
                    <div class="animate__animated animate__backInLeft animate__delay-3s">Selecciona tu cobertura: <a @click="modal = true, section = true" style="cursor:pointer;"><i class="el-icon-location-outline"></i> {{ state_name === null ? 'Ciudad de México': state_name }} </a></div>
                </div>
                <div class="d-flex cobertura" v-if="$store.state.user.fullname">
                    <div class="animate__animated animate__backInRight animate__delay-3s">
                        <el-popover
                        title="Sesion"
                        placement="left"
                        width="260"
                        v-model="visibleLogout">
                            <p>¿Estas completamente seguro de cerrar sessión?</p>
                            <div style="text-align: right; margin: 0">
                                <el-button size="mini" type="text" @click="visibleLogout = false">cancelar</el-button>
                                <el-button type="danger" size="mini" @click="visibleLogout = false,logout()">confirmar</el-button>
                            </div>
                            <a slot="reference" style="cursor:pointer; color: #6d5c96; text-decoration: none;"><i class="el-icon-user-solid"></i>  {{ $store.state.user.username }} </a>
                        </el-popover>
                    </div>
                </div>
                <div class="d-flex cobertura" v-else style="color: #6d5c96;">
                    <div class="animate__animated animate__backInRight animate__delay-3s"><a @click="modalLogin" style="cursor:pointer;"><i class="el-icon-user-solid"></i> Iniciar sesion</a></div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a @click="linkss" class="animate__animated animate__pulse animate__infinite infinite">
                    <router-link  class="navbar-brand" to="/">
                        <img src="/img/publico/logo-totalplay-n.svg" width="200" height="30" class="d-inline-block align-top" alt="logo-totalplay-n">
                    </router-link>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"   data-toggle="collapse" data-target="#navbarNav" >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navbar-nav text-center text-sm-center" id="navbarNav">
                    <ul class="nav navbar-nav animatedd fastt fadeInn" :class="{ 'mc-auto': (screenWidth <= 991 ),'ml-auto': (screenWidth >= 992 )}">
                        <li @click="linkss" class="nav-item">
                            <router-link to="/" class="nav-link" aria-current="page"> <span id="inicio"> Paquetes hogar </span> </router-link>
                        </li>
                        <!-- <li @click="linkss" class="nav-item">
                            <router-link to="/netflix" exact class="nav-link" aria-current="page"> <span id="netflix"> Paquetes Netflix </span> </router-link>
                        </li>
                        <li @click="linkss" class="nav-item">
                            <router-link to="/amazon" exact class="nav-link" aria-current="page"> <span id="amazon"> Paquetes Amazon </span> </router-link>
                        </li> -->
                        <li class="nav-item" v-if="$store.state.user.fullname">
                            <router-link @click="linkss" to="/login" exact class="nav-link" aria-current="page"> <span id="dashboard"> Acceso </span> </router-link>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>

    <div style="width: 100%; height: 48px;"></div>

    <router-view class="py-5" />

    <div class="bg-inverse text-white py-3 bg-dark">
        <div class="container text-center">
            <el-row :gutter='20'>
                <el-col :span='24'>
                    <div style="padding: 8px 0px;">
                        <p>
                            <a @click="linkss">
                                <router-link to="/terminos-y-condiciones" > Terminos y condiciones. </router-link>
                            </a>
                        </p>
                    </div>
                </el-col>

                <el-col :span='24'>
                    <div style='padding: 8px 0px; width:100%; display:flex; justify-content: center;'>
                        <div class="animate__animated animate__pulse animate__infinite infinite">
                            <img src="/img/publico/logo-totalplay-n.svg" width="300" height="40" class="d-inline-block align-top" alt="">
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
    </div>

</div>
</template>

<script>
import { Globals } from "../../mixins/Globals";
import loadingComponent from "./fragments/Loading";

export default {
mixins:[Globals],
components:{
    'loading-component': loadingComponent
},
data() {
    return {
        visibleLogout:false,
        link: null,
        modal: false,
        section: true,
        searchState: null,
        selectCity: [],
        state_name: null,
        form:{
            email: null,
            password: null
        }
    }
},
computed: {
//https://github.com/reegodev/vue-screen
    mediaWidth() {
        let width = '';
        if( this.$screen.width < 950 ){
            if (this.section === true) {
                width = '95%';
            }else{
                width = '70%';
            }
        }else{
            if (this.section === true) {
                width = '65%';
            }else{
                width = '25%';
            }
        }
        return width;
    },
    screenWidth() {
        // let aux = 'mr-auto';
        // if(this.$screen.width >= 991 ){
        //     let aux = 'mc-auto';
        // }
        let aux = this.$screen.width;

        return aux;
    },
    titleModal(){
        return this.section ? "Selecciona la cobertura de tu estado" : "Iniciar sesión";
    }
},
created() {
        this.getCats();
        let dialog = localStorage.getItem("dialog");
        //localStorage.clear();

        if (dialog) {
            this.modal = false;
            this.selectCity = parseInt( localStorage.getItem('selectCity') );
            this.state_name = localStorage.getItem('state_name');
        }else{
            setTimeout(() => {
                this.modal = true;
            }, 3800);
        }

        //this.$store._modules.root.state.publicc.loading = false;
},
mounted(){
    this.linkss();
    $(".ddd > div").css({"background-color":"#343a40","color":"white"});
    $(".el-dialog__title").css({"color":"white"});
},
methods: {
    modalLogin(){
        this.modal = true;
        this.section = false;
        this.form = {
            email: 'adriann@gmail.com',
            password: 'adrian90'
        };
        setTimeout(() => {
            this.$refs['formLogin'].clearValidate();
        }, 500);
    },
    logout() {
        this.$store._modules.root.state.totalplay.loading = true;
        axios.post("/api/logout").then(response => {
            if (response.data.authenticated === false) {
                sessionStorage.removeItem("access_token");
                sessionStorage.removeItem("access_token_expiration");
                sessionStorage.removeItem("access_hash");

                setTimeout(() => {
                    this.$store._modules.root.state.totalplay.loading = false;
                    axios.defaults.headers.common = {
                        Authorization: "Bearer"
                    };
                    this.$store.commit('deleteUser');
                    this.$router.push("/");
                }, 3000);
            } else {
                this.$store._modules.root.state.totalplay.loading = false;
                this.$message({
                    type: "warning",
                    message: "No fue posible cerrar su sesión, inténtelo nuevamente."
                });
            }
        });
    },
    login(){
        //if (sessionStorage.getItem('access_token') === null) {
            this.$store._modules.root.state.totalplay.loading = true;
            this.$refs['formLogin'].validate((valid) => {
                if (valid) {
                    axios.post('/api/login',this.form, {
                                        headers:
                                            {
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'Accept': 'application/json',
                                                'Accept-C': window.acceptC
                                            }
                    }).then(response => {
                        if (response.data.authenticated === true) {
                            sessionStorage.setItem('access_token', response.data.access_session);
                            sessionStorage.setItem('access_token_expiration', response.data.access_session_expiration);
                            sessionStorage.setItem('access_hash', response.data.access_hash);

                            axios.defaults.headers.common = {
                                'Accept-C': window.acceptC,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Authorization': 'Bearer ' + sessionStorage.getItem('access_token')
                            };

                            this.$store.commit('setUser', response.data.user);
                            setTimeout(() => {
                                this.modal = false;
                                this.$store._modules.root.state.totalplay.loading = false;
                                if(response.data.first_sesion){
                                    this.$router.push('/login/credenciales');
                                }else{
                                    this.$router.push('/login');
                                }
                            }, 3000);
                        } else{
                            this.$store._modules.root.state.totalplay.loading = false;
                            this.accessLogin = false;
                            this.$message({
                                message: 'Error en las credenciales.',
                                type: 'warning'
                            });
                            //this.$router.push('/');
                        }
                    }).catch(error => {
                        this.$message({
                            message: 'No se pudo completar la acción.',
                            type: 'warning'
                        });
                        this.modal = false;
                        this.$store._modules.root.state.totalplay.loading = false;
                        this.$router.push('/');
                    });

                } else {
                    this.$message({
                        message: 'No se pudo completar la acción.',
                        type: 'warning'
                    });
                    return false;
                }
            });

        //}
    },
    submitCity(){
        if( this.selectCity === 0 || this.selectCity === null || this.selectCity.length === 0 ){
            this.state_name = 'Ciudad de México';
            localStorage.setItem('selectCity','9');
            this.modal = true;
        }else{
            this.state_name =  this.$store._modules.root.state.totalplay.catCities.find(item => item.id === this.selectCity).name;
            this.modal = false;
        }

        localStorage.setItem('selectCity',String(this.selectCity));
        localStorage.setItem('state_name',String(this.state_name));
        localStorage.setItem('dialog',String(this.modal));
        this.setPacks(true);
    },

    linkss(){
        let aux = this.$router.history.current.path;
        switch (aux) {
            // case '/netflix':
            // {
            //     document.getElementById("netflix").style.color = "#b12222";
            //     document.getElementById("inicio").style.color = "#fff";
            //     document.getElementById("amazon").style.color = "#fff";
            //     break;
            // }
            // case '/amazon':
            // {
            //     document.getElementById("amazon").style.color = "#427b96";
            //     document.getElementById("inicio").style.color = "#fff";
            //     document.getElementById("netflix").style.color = "#fff";
            //     break;
            // }
            case '/':
            {
               // document.getElementById("amazon").style.color = "#fff";
                document.getElementById("inicio").style.color = "rgb(210, 165, 69)";
              //  document.getElementById("netflix").style.color = "#fff";
                break;
            }
            case '/terminos-y-condiciones':
            {
              //  document.getElementById("amazon").style.color = "#fff";
                document.getElementById("inicio").style.color = "#fff";
              //  document.getElementById("netflix").style.color = "#fff";
                break;
            }
            default:
            {
               // document.getElementById("amazon").style.color = "#fff";
                document.getElementById("inicio").style.color = "rgb(210, 165, 69)";
               // document.getElementById("netflix").style.color = "#fff";
                break;
            }
        }
    },

},
}
</script>


<style scoped>

.cobertura{
    text-align: right;
    align-items: flex-end;
}

.logo{
    animation: pulse; /* referring directly to the animation's @keyframe declaration */
    animation-duration: infiniti; /* don't forget to set a duration! */
}

.nav-link:hover{
    animation: heartBeat;
    animation-duration: 2s;
}

a:hover{
    cursor:pointer;
}

.state-content{
    width: 33%;
    background-color: #343a40;
    box-sizing: border-box;
    border: solid #343a40 1px;
    cursor: pointer;
}
.state-content:hover{
    width: 33%;
    background-color: #ffffff;
    box-sizing: border-box;
    border: solid #343a40 1px;
    color: black;

}

html nav.navbar.navbar-custom {
    padding: 0;
    margin: 0;
}

.colorr{
    background-color: blue;
}

.navbar-dark .navbar-nav .nav-item{
    margin: 0px 10px !important;
}

@media screen and (min-width: 0px) and (max-width: 991px) {
    .cobertura{
        text-align: center;
        align-items: center;
    }
}

</style>
