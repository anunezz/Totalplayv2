<template>
    <div>
        <div id="filtersArea">
            <transition appear name="filters">
                <el-container class="form-filters" v-if="show">
                    <el-header style="background-color: rgb(157, 36, 56);">
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-button
                                    class="close-button"
                                    type="text"
                                    @click="show = false">
                                    <i class="el-icon-arrow-right"></i>
                                    Minimizar
                                </el-button>
                            </el-col>
                        </el-row>
                    </el-header>
                    <el-main style="border-left: 16px solid #E9EEF3 ">
                        <el-card shadow="never">
                            <div slot="header">
                                <span class="title"> <i class="fas fa-user"></i> Perfil</span>
                            </div> <br>
<!--                            <pre>{{units}}</pre>-->
                            <el-row>
                                <el-col :span="24">
                                    <div style="width: 100%; padding-bottom: 18px; font-size: 15px;" class="grid-content bg-purple-dark">
                                        <el-card shadow="always">
                                            <strong><b>Nombre: </b></strong> {{$store.state.user.fullname}}
                                        </el-card>
                                    </div>
                                </el-col>
<!--                                <el-col v-if="user.profile_id !== 1" :span="24">-->
<!--                                    <div style="width: 100%; padding-bottom: 18px; font-size: 15px;" >-->
<!--                                        <el-card shadow="always">-->
<!--                                            <strong><b>Unidad Administrativa: </b></strong><br><p></p>-->
<!--                                            <span v-for="(item, index) in user.unit" :key="index"> {{ item.name }}<br>  </span>-->
<!--                                        </el-card>-->
<!--                                    </div>-->
<!--                                </el-col>-->
                                <el-col v-if="user.profile_id !== 1" :span="24">
                                    <div style="width: 100%; padding-bottom: 18px; font-size: 15px;" >
                                        <el-form :model="strategyForm" ref="strategyForm" label-width="120px" label-position="top">
                                            <el-card shadow="always">
                                                <strong><b>Unidad Administrativa: </b></strong><br><p></p>
                                                <el-form-item prop="cat_unit_id"
                                                              :rules="[{ required: false, message: 'Este campo es requerido', trigger:['blur','change'] }]">
<!--                                                    v-if="units.length >= 1"
                                                                disabled-->
                                                    <el-select style="width: 100%;" size="medium"
                                                               v-model="strategyForm.cat_unit_id"
                                                               placeholder="Seleccionar">
                                                        <el-option
                                                            v-for="(unit , index) in units"
                                                            :key="index"
                                                            :label="unit.name"
                                                            :value="unit.id">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </el-card>
                                        </el-form>
                                    </div>
                                </el-col>
                                <el-col v-if="user.profile_id === 1" :span="24">
                                    <div style="width: 100%; padding-bottom: 18px; font-size: 15px;" >
                                        <el-card shadow="always">
                                            <strong><b>Unidad Administrativa: </b></strong><br><p></p>
                                            <span>Todas <br>  </span>
                                        </el-card>
                                    </div>
                                </el-col>
                                <el-col :span="24">
                                    <div style="width: 100%; padding-bottom: 18px; font-size: 15px;" class="grid-content bg-purple-dark">
                                        <el-card shadow="always">
                                            <strong><b>Rol o perfil: </b></strong> {{user.profile}}
                                        </el-card>
                                    </div>
                                </el-col>
                                <el-col :span="24">
                                    <div style="width: 100%; padding-bottom: 18px; font-size: 15px;" class="grid-content bg-purple-dark">
                                        <el-card shadow="always">
                                            <strong><b>Puesto: </b></strong> {{user.office}}
                                        </el-card>
                                    </div>
                                </el-col>
                                <el-col :span="24">
                                    <div style="width: 100%; padding-bottom: 18px; font-size: 15px;" class="grid-content bg-purple-dark">
                                        <el-card shadow="always">
                                            <strong><b>Email: </b></strong> {{user.email}}@sre.gob.mx
                                        </el-card>
                                    </div>
                                </el-col>
                                <el-col v-if="user.profile_id !== 1" :span="24">
                                    <div style="width: 100%; padding-bottom: 18px; font-size: 15px;" >
                                        <el-card shadow="always">
                                            <strong><b>Privilegio de modulos: </b></strong><br><p></p>
                                            <span>Registro <br> </span>
                                            <span>Búsqueda <br> </span>
                                            <span>Formatos <br> </span>
                                            <span>Histórico <br> </span>
                                        </el-card>
                                    </div>
                                </el-col>
                                <el-col v-if="user.profile_id === 1" :span="24">
                                    <div style="width: 100%; padding-bottom: 18px; font-size: 15px;" >
                                        <el-card shadow="always">
                                            <strong><b>Privilegio de modulos: </b></strong><br><p></p>
                                            <span>Perfiles <br> </span>
                                            <span>Registro <br> </span>
                                            <span>Búsqueda <br> </span>
                                            <span>Formatos <br> </span>
                                            <span>Histórico <br> </span>
                                            <span>CGCA X SERIE <br> </span>
                                            <span>CGCA X AREA <br> </span>
                                        </el-card>
                                    </div>
                                </el-col>
                            </el-row>
                            <br> <p></p>
                            <el-row>
                                <div align="right">
                                    <el-button v-if="user.profile_id !==1" type="success" size="medium" plain @click="show = false">
                                        Actualizar
                                    </el-button>
                                    <el-button type="danger" size="medium" plain @click="show = false">
                                        Salir
                                    </el-button>
                                </div>
                            </el-row>
                        </el-card>
                    </el-main>
                </el-container>
            </transition>
        </div>

        <div class="custom-splash" v-show="animate === true">
            <div id="splash_cont" class="animate">
                <svg height="400" width="400" xmlns="http://www.w3.org/2000/svg">
                    <circle class="circle" cx="200" cy="200" r="195"></circle>
                </svg>
                <img id="ruby" src="img/relacion_vert.svg" alt="" width="65%"/>
            </div>
        </div>

        <el-container  v-loading.fullscreen.lock="status"
                       :element-loading-text="message"
                       element-loading-background="rgba(255, 255, 255, 0.75)"
                       :class="{ 'blur': animate === true }">
            <el-header style="background-color: rgb(157, 36, 56);">
                <el-row type="flex" justify="space-between">

                    <el-col :span="2">
                        <img
                            src="/img/sre_header_logo2.png"
                            class="logo-sre2"
                            alt="header"
                            style="margin-top: 10px; margin-left: 5px;">

                    </el-col>
                    <el-col :span="11">
                        <div class="header-title-home" @click="$router.push('/')" style="cursor: pointer">
                            <span style="font-size: 15px">SIRGE v {{$version}}</span>
                        </div>
                    </el-col>


                    <el-col :span="11">
                        <el-menu
                            :router="true"
                            mode="horizontal"
                            background-color="#9D2438"
                            text-color="#fff"
                            active-text-color="#fff">
                            <el-popover
                                placement="top-start"
                                width="200"
                                trigger="hover"
                                content="Cerrar sesión">
                                <el-menu-item
                                    index="#"
                                    class="border-menu-item"
                                    @click="logout"
                                    slot="reference"
                                    style="cursor:pointer;float: right">
                                    <i class="fas fa-sign-out-alt" style="color: whitesmoke"></i>
                                </el-menu-item>
                            </el-popover>
                            <el-popover
                                placement="top-start"
                                width="200"
                                trigger="hover"
                                :content="$store.state.user.fullname">
                                <el-menu-item
                                    index="#"
                                    slot="reference"
                                    class="border-menu-item"
                                    @click="show=!show"
                                    style="cursor:pointer;float: right">
                                    <i class="fas fa-user" style="color: whitesmoke;"></i>
                                </el-menu-item>
                            </el-popover>
                            <el-menu-item
                                index="#"
                                class="border-menu-item"
                                style="float: right">
                                <i class="fas fa-calendar-alt" style="color: whitesmoke"></i>
                                <span>
                                    {{ date | moment('timezone', 'America/Mexico_City') | moment('DD/MM/YYYY h:mm a') }}
                                </span>
                            </el-menu-item>
                        </el-menu>
                    </el-col>
                </el-row>
            </el-header>
            <el-main>
                <el-card shadow="never">
                    <router-view></router-view>
                </el-card>
            </el-main>
        </el-container>
    </div>

</template>

<script>
    import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
    import HeaderSection from "../layouts/partials/HeaderSection";

    export default {
        components: {
            HeaderSection
        },
        data() {
            return {
                date: new Date(),
                notifications: [],
                animate: false,
                ElDialogAdministrativeUnit:false,
                show: false,
                user:{},
                lResults:{},
                units:[],
                strategyForm:{
                    cat_unit_id: null,
                }
            };
        },

        computed: {
            ...mapGetters('loading', ['message','status']),
        },

        created() {
            this.details();
            this.init();
            this.startLoading();
            let _this = this;

            /*axios.get('/api/count-notifications').then(response => {
                this.notifications = response.data.notifications;
            }).catch(error => {
                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });*/

            setInterval(function(){
                _this.date = new Date();
            },60000);

            this.stopLoading();
        },

        methods: {

            logout() {

                axios.post("/api/logout").then(response => {
                    if (response.data.authenticated === false) {
                        sessionStorage.removeItem("SICAR_token");
                        sessionStorage.removeItem("SICAR_token_expiration");
                        sessionStorage.removeItem("SICAR_hash");

                        axios.defaults.headers.common = {
                            Authorization: "Bearer"
                        };

                        this.$store.commit('deleteUser');
                        this.$router.push("/ingresar");
                    } else {
                        this.$message({
                            type: "warning",
                            message: "No fue posible cerrar su sesión, inténtelo nuevamente."
                        });
                    }
                });
            },
            init() {
                let currentUrl = window.location.href.length
                let url = window.origin.length + 1;

                if (currentUrl<=url){
                    this.animate = true;
                    setTimeout(() => {
                        this.animate = false;
                    }, 2100);
                }
            },
            details(){
                axios.get('/api/cats/getDetailsUser').then(response => {
                    if(response.data.success){
                        this.units = response.data.lResults.user.unit;
                        this.user.full_name = response.data.lResults.user.full_name;
                        this.user.profile = response.data.lResults.user.profile.name;
                        this.user.profile_id = response.data.lResults.user.cat_profile_id;
                        this.user.office = response.data.lResults.user.office;
                        this.user.email = response.data.lResults.user.username;
                        this.user.admin = response.data.lResults.user.admin.name;
                        this.strategyForm.cat_unit_id = response.data.lResults.user.cat_unit_id;

                 //       this.units = response.data.lResults.units;

                    }
                }).catch(error => {

                });
            },
        }
    }
</script>

<style scoped>
    .el-submenu__title {
        border-bottom: 2px solid #9D2438 !important;
    }

    .el-menu-item, .el-submenu__title {
        height: 60px !important;
    }

    .header-title-home {
        font-size: 24px;
        color: rgb(255, 255, 255);
        margin-top: 15px;
    }

    .el-button {
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
        border-bottom: none;
        box-shadow: none;
        font-weight: bold;
    }

    .logo-sre2 {
        width: 80px;
        height: 50px;
        display: block;
    }

    .bannerMain {
        /*background-image:url('/img/login/sre_white.png');*/
        background-repeat: no-repeat;
        background-size: cover;
        width: 100% !important;
    }

    @media screen and ( min-height: 512px ) {
        /* Content */
        .bannerMain {
            height: calc(512px + 50px)
        }
    }

    @media screen and ( min-height: 640px ) {
        /* Content */
        .bannerMain {
            height: calc(640px + 50px)
        }
    }

    @media screen and ( min-height: 768px ) {
        /* Content */
        .bannerMain {
            height: calc(768px + 50px)
        }
    }

    @media screen and ( min-height: 896px) {
        /* Content */
        .bannerMain {
            height: calc(896px + 50px)
        }
    }

    @media screen and ( min-height: 912px ) {
        /* Content */
        .bannerMain {
            height: calc(912px + 50px)
        }
    }

    @media screen and ( min-height: 1024px ) {
        /* Content */
        .bannerMain {
            height: calc(1024px + 50px)
        }
    }

    @media screen and ( min-height: 1180px ) {
        /* Content */
        .bannerMain {
            height: calc(1180px + 50px)
        }
    }

    @media screen and ( min-height: 1280px ) {
        /* Content */
        .bannerMain {
            height: calc(1280px + 50px)
        }
    }

    .el-menu-item{

        border-bottom: none !important;
    }

    .el-menu-item:focus, .el-menu-item:hover {
        outline: 0;
        background-color: rgba(0, 0, 0, 0.2) !important;
    }

    .el-menu-item.border-menu-item.is-active {
        border-color: rgba(0, 0, 0, 0.1) !important;
    }

    .wabble-effect:nth-child(2n) {
        animation: keyframes1;
        animation-iteration-count: infinite;
        transform-origin: 50% 10%;
        animation-delay: -0.75s;
        animation-duration: .25s
    }

    .wabble-effect:nth-child(2n-1) {
        animation-name: keyframes2;
        animation-iteration-count: infinite;
        animation-direction: alternate;
        transform-origin: 30% 5%;
        animation-delay: -0.75s;
        animation-duration: .25s
    }

    @keyframes keyframes1 {
        0% {
            transform: rotate(-1deg);
            animation-timing-function: ease-in;
        }
        50% {
            transform: rotate(1.5deg);
            animation-timing-function: ease-out;
        }
    }

    @keyframes keyframes2 {
        0% {
            transform: rotate(1deg);
            animation-timing-function: ease-in;
        }
        50% {
            transform: rotate(-1.5deg);
            animation-timing-function: ease-out;
        }
    }

    /*//Animatae*/

    .blur {
        background: #fff;
        -webkit-filter: blur(5px);
        -moz-filter: blur(5px);
        -o-filter: blur(5px);
        -ms-filter: blur(5px);
        filter: blur(5px);
    }

    .custom-splash {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;

        z-index: 9999;

    }

    #splash_cont {
        background: rgba(255, 255, 255, 0.52);
        position: relative;
        z-index: 9999999;
    }

    #splash_cont.animate {

        height: 400px;
        width: 400px;
        position: relative;
        border-radius: 50%;
        margin: 0 auto;
        top: 45%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        -webkit-animation: move-ruby 0.7s ease 2.4s forwards;
        animation: move-ruby 0.7s ease 2.4s forwards;
    }

    #splash_cont.animate #ruby {
        position: absolute;
        top: 125px;
        left: 64.5px;
        -webkit-transform: scale(0);
        transform: scale(0);
        -webkit-animation: scale-ruby 0.48s ease 0s forwards;
        animation: scale-ruby 0.48s ease 0s forwards;
    }

    #splash_cont.animate .circle {
        fill: rgba(254, 82, 79, 0);
        stroke: rgba(254, 82, 79, 0);
        stroke-width: 4;
        stroke-dasharray: 1228;
        stroke-dashoffset: 0;
        -webkit-transform-origin: 50% 50%;
        transform-origin: 50% 50%;
        -webkit-transform: rotate(-90deg);
        transform: rotate(-90deg);
        -webkit-animation: animate-ruby-circle 1.3s ease 0.3s forwards;
        animation: animate-ruby-circle 1.3s ease 0.3s forwards;
    }

    #splash_cont.animate #splash_title {
        text-align: center;
        font-weight: 500;
        font-size: 1.75em;
        color: rgba(80, 80, 80, 0);
        -webkit-animation: splash_title 1.2s ease 1.2s forwards;
        animation: splash_title 1.2s ease 1.2s forwards;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        -webkit-transform: translateY(150%);
        transform: translateY(150%);
    }

    @-webkit-keyframes scale-ruby {
        0% {
            -webkit-transform: scale(0);
            transform: scale(0);
            top: 125px;
        }
        60% {
            -webkit-transform: scale(1.25);
            transform: scale(1.25);
            top: 120px;
        }
        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            top: 125px;
        }
    }

    @keyframes scale-ruby {
        0% {
            -webkit-transform: scale(0);
            transform: scale(0);
            top: 125px;
        }
        60% {
            -webkit-transform: scale(1.25);
            transform: scale(1.25);
            top: 120px;
        }
        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            top: 125px;
        }
    }

    @-webkit-keyframes animate-ruby-circle {
        0% {
            stroke-dashoffset: 1228;
            stroke: #dfcdb2;
        }
        70% {
            stroke: #c9af8d;
            stroke-width: 4;
        }
        90% {
            stroke-dashoffset: 0;
        }
        100% {
            stroke-dashoffset: 0;
            stroke: #dec4a1;
            stroke-width: 10;
        }
    }

    @keyframes animate-ruby-circle {
        0% {
            stroke-dashoffset: 1228;
            stroke: #dfcdb2;
        }
        70% {
            stroke: #c9af8d;
            stroke-width: 4;
        }
        90% {
            stroke-dashoffset: 0;
        }
        100% {
            stroke-dashoffset: 0;
            stroke: #dec4a1;
            stroke-width: 10;
        }
    }

    @-webkit-keyframes splash_title {
        0% {
            color: rgba(80, 80, 80, 0);
        }
        18% {
            color: #505050;
        }
        65% {
            color: #505050;
        }
        100% {
            color: rgba(80, 80, 80, 0);
        }
    }

    @keyframes splash_title {
        0% {
            color: rgba(80, 80, 80, 0);
        }
        18% {
            color: #505050;
        }
        65% {
            color: #505050;
        }
        100% {
            color: rgba(80, 80, 80, 0);
        }
    }

    @-webkit-keyframes move-ruby {
        0% {
            opacity: 1;
            top: 45%;
            -webkit-transform: scale(1) translateY(-50%);
            transform: scale(1) translateY(-50%);
        }
        20% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            top: 35%;
            -webkit-transform: scale(0.01) translateY(-280%);
            transform: scale(0.01) translateY(-280%);
        }
    }

    .form-filters {
        position: absolute;
        top: 0;
        right: 0;
        width: 35%;
        min-width: 650px;
        height: 100%;
        background: #fff !important;
        z-index: 1000;
    }

    @keyframes move-ruby {
        0% {
            opacity: 1;
            top: 45%;
            -webkit-transform: scale(1) translateY(-50%);
            transform: scale(1) translateY(-50%);
        }
        20% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            top: 35%;
            -webkit-transform: scale(0.01) translateY(-280%);
            transform: scale(0.01) translateY(-280%);
        }
    }
</style>
