<template>
<div class="row animatedd fadeInn fastt">

    <div class="col-md-12 py-2">
        <div class="row d-flex justify-content-end">
            <div class="col-md-4">
                <router-link to="/login">
                    <button class="btn btn-danger btn-sm float-right"> <i class="el-icon-arrow-left"></i> Regresar</button>
                </router-link>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row text-center d-flex flex-wrap justify-content-center">
            <div class="col-md-4" v-if="$store.state.user.profile === 1 || $store.state.user.profile === 2">
                <div class="card text-white bg-dark text-center" style="width: 100%; height: 180px;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="el-icon-user"></i> Usuarios</h5>
                        <p class="card-text">Crear editar y borrar usuarios del sistema.</p>
                        <router-link to="/login/configuracion/usuarios" class="nolink">
                            <a class="btn btn-primary btn-sm"> Configurar</a>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-md-4" v-if="$store.state.user.profile === 1 || $store.state.user.profile === 2">
                <div class="card text-white bg-dark text-center" style="width: 100%; height: 180px;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="el-icon-notebook-2"></i> Catalogos</h5>
                        <p class="card-text">Configuración de catalogos Totalplay.</p>
                        <router-link to="/login/configuracion/catalogos" class="nolink">
                            <a class="btn btn-primary btn-sm"> Configurar</a>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
