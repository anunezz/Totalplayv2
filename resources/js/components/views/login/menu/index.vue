<template>


<div class="row text-center d-flex flex-wrap justify-content-center">

    <div class="col-md-4" v-if="$store.state.user.profile === 1 || $store.state.user.profile === 2">
        <div class="card text-center" style="width: 100%; height: 180px;">
            <div class="card-body text-white bg-dark">
                <h5 class="card-title"><i class="el-icon-setting"></i> Configuración</h5>
                <p class="card-text">Configuracion del sistema</p>
                <router-link to="/login/configuracion" class="nolink">
                    <a class="btn btn-primary btn-sm"> Configurar</a>
                </router-link>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-dark text-center" style="width: 100%; height: 180px;">
            <div class="card-body">
                <h5 class="card-title"><i class="el-icon-message"></i> Bandeja de entrada</h5>
                <p class="card-text">Bandeja de entrada de contactos que fueron registrados en el sistema.</p>
                <router-link to="/login/contactos" class="nolink">
                    <a class="btn btn-primary btn-sm"> Configurar</a>
                </router-link>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-dark text-center" style="width: 100%; height: 180px;">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-chart-bar"></i> Graficas</h5>
                <p class="card-text">En este modulo podras visualizar tus avances del mes.</p>
                <router-link to="/login/configuracion/usuarios" class="nolink">
                    <a class="btn btn-primary btn-sm"> Configurar</a>
                </router-link>
            </div>
        </div>
    </div>

</div>


<!--
<div class="row text-center d-flex flex-wrap justify-content-between">
    <div class="col-md-4">
        <router-link to="/login/configuracion" class="nolink">
            <h5> <i class="el-icon-setting"></i> Configuración</h5>
        </router-link>
        <hr>
        <p>
            <router-link to="/login/configuracion" class="nolink">
                <small>Configuracion del sistema</small>
            </router-link>
        </p>

    </div>
    <div class="col-md-4">
        <h5> <i class="el-icon-message"></i> Bandeja de entrada</h5>
        <hr>
        <p>
            <small>Bandeja de entrada de contactos que fueron registrados en el sistema.</small>
        </p>
    </div>
    <div class="col-md-4">
        <h5><i class="fas fa-chart-bar"></i> Graficas</h5>
        <hr>
        <p>
            <small>En este modulo podras visualizar tus avances del mes.</small>
        </p>
    </div>
</div> -->
</template>

<script>
    export default {
        methods: {
        }
    }
</script>

<style scoped>
    .nolink{
        text-decoration: none;
        color: black;
    }
</style>
