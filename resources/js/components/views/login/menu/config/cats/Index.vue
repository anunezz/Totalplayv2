<template>
<div class="row">

    <div class="col-md-12 py-2">
        <div class="row d-flex justify-content-end">
            <div class="col-md-4">
                <router-link to="/login/configuracion">
                    <button class="btn btn-danger btn-sm float-right"> <i class="el-icon-arrow-left"></i> Regresar</button>
                </router-link>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row text-center d-flex flex-wrap justify-content-center">
            <div class="col-md-4">
                <div class="card text-white bg-dark text-center" style="width: 100%; height: 180px;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="el-icon-s-order"></i> Paquetes</h5>
                        <p class="card-text">Crear editar y borrar paquetes en la ventana principal.</p>
                        <router-link to="/login/configuracion/catalogos/paquetes" class="nolink">
                            <a class="btn btn-primary btn-sm"> Configurar</a>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
