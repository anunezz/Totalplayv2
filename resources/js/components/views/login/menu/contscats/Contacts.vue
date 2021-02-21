<template>
<div class="row">

    <div class="col-md-12 py-2">
        <div class="row justify-content-md-between flex-wrap">
            <div class="col-md-10">
                <h4>Bandeja de entrada de contactos registrados totalplay.</h4>
            </div>
            <div class="col-md-2">
                <router-link to="/login">
                    <button class="btn btn-danger btn-sm float-right"> <i class="el-icon-arrow-left"></i> Regresar</button>
                </router-link>
            </div>
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-secondary btn-sm"> <i class="el-icon-search"></i> Búsqueda avanzada</button>
            <button @click="downloadExcel" type="button" class="btn btn-success btn-sm"> <i class="el-icon-download"></i> Descargar Excel</button>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Ciudad</th>
                    <th>Estatus</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item,index) in contacts" :key="index">
                    <td v-text="item.name"></td>
                    <td v-text="item.phone"></td>
                    <td v-text="item.city.name"></td>
                    <td>
                        <span>Activo</span>
                    </td>
                    <td>
                        <div class="btn-group float-center">
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                <i class="el-icon-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalEliminar">
                                <i class="el-icon-close"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            contacts:[]
        }
    },
    mounted(){
        this.getContacts();
    },
    methods: {
        getContacts(){
            this.$store._modules.root.state.totalplay.loading = true;
            axios.get('/api/getContacts').then(response => {
                if(response.data.success){
                    this.contacts = response.data.lResults;
                    this.$store._modules.root.state.totalplay.loading = false;
                }
            }).catch(error => {
                console.error(error);
                this.$store._modules.root.state.totalplay.loading = false;
            });

        },
        downloadExcel(){
            this.$store._modules.root.state.totalplay.loading = true;
            axios({ responseType: 'blob',
                method: 'POST',
                url: '/api/exportContacts',
                data: {
                    data: null
                }}).then(response => {
                setTimeout(()=>{
                    const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = linkUrl;
                    link.setAttribute('download', 'Contactos_Totalplay.xlsx');
                    document.body.appendChild(link);
                    link.click();
                    this.$store._modules.root.state.totalplay.loading = false;
                },500)

            }).catch(error => {
                this.$notify({
                    title: 'Mensaje',
                    text: 'No fue posible realizar la descarga, inténtelo nuevamente.',
                    type: 'warning'
                });
                this.$store._modules.root.state.totalplay.loading = false;
            });
        }
    }
}
</script>

