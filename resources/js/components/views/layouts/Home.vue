<template>
    <div>
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

                    <el-col :xl="6" :lg="6" :md="8" :sm="8">
                        <div style="width: 100%; display: flex; justify-content: center;">
                            <div style="width: 80%;">
                                <router-link to="/">
                                    <img
                                    src="img/relaciones_header.jpeg"
                                    class="logo-sre2"
                                    alt="header">
                                </router-link>
                            </div>
                            <div style="width: 285px; height: 20%;">

<div class="header-title-home" style="text-align:center; cursor: pointer">
                            <router-link style="text-decoration:none; color: #fff;" to="/">
                                <span style="font-size: 15px">SIRGo v {{$version}}</span>
                            </router-link>
                        </div>

                            </div>
                        </div>
                    </el-col>

                    <el-col :xl="11" :lg="11" :md="11" :sm="16">
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
                                    slot="reference"
                                    class="border-menu-item"
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-primary" role="alert">
  A simple primary alert—check it out!
</div>
<div class="alert alert-secondary" role="alert">
  A simple secondary alert—check it out!
</div>
<div class="alert alert-success" role="alert">
  A simple success alert—check it out!
</div>
                        </div>
                        <div class="col-md-6">


<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Link with href
  </a>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Button with data-target
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
  </div>
</div>


<div class="animate__animated animate__bounce animate__faster">Example</div>
                        </div>
                    </div>

                    <router-view></router-view>
                </el-card>
            </el-main>
        </el-container>
    </div>

</template>

<script>

    import { mapState, mapGetters, mapActions, mapMutations } from "vuex";


    export default {

        data() {
            return {
                date: new Date(),
                notifications: [],
                animate: false,
                ElDialogAdministrativeUnit:false,
                show: false,
                user:{},
                lResults:{},
                allunits:[],
                units:[],
                userForm:{
                    cat_unit_id: null,
                }
            };
        },

        computed: {
            ...mapGetters('loading', ['message','status']),
        },

        created() {
            // this.details();
            this.init();
            let _this = this;
            setInterval(function(){
                _this.date = new Date();
            },60000);

            this.stopLoading();
        },

        methods: {

            logout() {
                console.log("click");

                axios.post("/api/logout").then(response => {
                    console.log("+++++",response);
                    if (response.data.authenticated === false) {
                        sessionStorage.removeItem("access_token");
                        sessionStorage.removeItem("access_token_expiration");
                        sessionStorage.removeItem("access_hash");

                        console.log("Estas aqui",sessionStorage.getItem('access_token'));

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
            // details(){
            //     axios.get('/api/cats/getDetailsUser').then(response => {
            //         console.log(response);
            //         if(response.data.success){
            //             this.units = response.data.lResults.user.unit;
            //             this.user.id = response.data.lResults.user.id;
            //             this.user.full_name = response.data.lResults.user.full_name;
            //             this.user.profile = response.data.lResults.user.profile.name;
            //             this.user.profile_id = response.data.lResults.user.cat_profile_id;
            //             this.userForm.cat_unit_id = response.data.lResults.user.cat_unit_id;
            //             this.user.office = response.data.lResults.user.office;
            //             this.user.email = response.data.lResults.user.username;
            //             this.user.admin = response.data.lResults.user.admin.name;
            //             this.user.determinant = response.data.lResults.user.admin.determinant;
            //         }
            //     }).catch(error => {

            //     });
            // },
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
        margin-top: 7px;
        width: 275px;
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
