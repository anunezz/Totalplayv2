<template>
    <div>
        <header-section icon="fas fa-copy" title="Listado de expedientes">
            <template slot="buttons">
                <el-button
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/')">
                    Regresar
                </el-button>
                <el-button
                    :disabled="formalitiesTable.length === 0"
                    size="small"
                    type="warning"
                    @click="labelBox"
                    icon="fas fa-box-open">
                    Descargar etiqueta de caja
                </el-button>
                <el-button
                    :disabled="formalitiesTable.length === 0"
                    size="small"
                    type="primary"
                    icon="far fa-file-excel"
                    @click="downloadExcel">
                    Descargar Excel
                </el-button>
                <el-button-group>
                    <el-button
                        size="small"
                        type="success"
                        icon="fas fa-edit"
                        @click="$router.push({name: 'NewFormalities' })">
                        Nuevo registro
                    </el-button>
                </el-button-group>
            </template>
        </header-section>
        <el-row type="flex" justify="end">
            <el-col :span="5">
                <el-button
                    size="small"
                    icon="fas fa-search"
                    style="width: 100%"
                    @click="filters.show = true">
                    Filtros avanzados
                </el-button>
            </el-col>
        </el-row> <br>
        <el-pagination
            :page-size="parseInt(pagination.perPage)"
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            layout="total"
            :total="pagination.total"
            :current-page.sync="pagination.currentPage">
        </el-pagination>
        <el-row :gutter="20">
            <el-col :span="24">
                <el-table
                    size="mini"
                    :data="formalitiesTable"
                    style="width: 100%">
                    <el-table-column
                        label="Determinante">
                        <template slot-scope="scope">
                            {{scope.row.unit.determinant}}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="sort_code"
                        label="Clasificación">
                    </el-table-column>
                    <el-table-column
                        label="Fecha de cierre">
                        <template slot-scope="scope">
                            {{ formatDate(scope.row.close_date) | moment('timezone', 'America/Mexico_City') | moment('DD/MM/YYYY') }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Creado por:">
                        <template slot-scope="scope">
                            {{scope.row.user.full_name}}
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Fecha y Hora de  Creación">
                        <template slot-scope="scope">
                            {{ scope.row.created_at | moment('timezone', 'America/Mexico_City') | moment('DD/MM/YYYY h:mm a') }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Acciones" header-align="left" align="center">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-tooltip
                                    v-if="$store.state.user.profile !== 1"
                                    class="item"
                                    effect="dark"
                                    content="Consultar"
                                    placement="top-start">
                                    <el-button
                                        type="primary"
                                        size="mini"
                                        icon="fas fa-eye"
                                        @click="editRegister(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    v-else
                                    class="item"
                                    effect="dark"
                                    content="Editar"
                                    placement="top-start">
                                    <el-button
                                        type="primary"
                                        size="mini"
                                        icon="fas fa-edit"
                                        @click="editRegister(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    v-if="$store.state.user.profile !== 3"
                                    class="item"
                                    effect="dark"
                                    content="Eliminar"
                                    placement="top-start">
                                    <el-button
                                        type="danger"
                                        size="mini"
                                        icon="el-icon-delete"
                                        @click="deleteRegister(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Carátula"
                                    placement="top-start">
                                    <el-button
                                        type="info"
                                        size="mini"
                                        icon="fas fa-book"
                                        @click="cover(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Ceja"
                                    placement="top-start">
                                    <el-button
                                        type="warning"
                                        size="mini"
                                        icon="far fa-bookmark"
                                        @click="eyebrow(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <!--<el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Caja"
                                    placement="top-start">
                                    <el-button
                                        type="success"
                                        size="mini"
                                        icon="fas fa-box-open"
                                        @click="box(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>-->
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
                <br>
            </el-col>
        </el-row>
        <el-row>
            <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page.sync="pagination.currentPage"
                :page-sizes="[10, 20, 50, 100]"
                :page-size="parseInt(pagination.perPage)"
                layout="sizes, ->, prev, pager, next"
                :total="pagination.total">
            </el-pagination>
        </el-row>

<!--        Mostrar filtros-->
        <show-filters :items="filters" @search="getFormalities"/>
    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import ShowFilters from "./FormFiltros";

    export default {
        components: {
            HeaderSection,
            ShowFilters
        },
        data(){
            return{
                filters:{
                    show: false,
                    determinant:'',
                    classification:'',
                    year:null,
                    userId:null
                },
                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },
                formalitiesTable:[],
            }
        },
        created() {
            this.getFormalities();
            console.log( this.$store.state.user.profile)
        },
        methods:{
            SearchData(){
                this.startLoading();
                let _this = this;
                setTimeout(function(){
                    _this.filters.show = false;
                    _this.stopLoading();
                    }, 3000);
            },
            getFormalities(currentPage =  1) {
                this.filters.show = false;
                this.startLoading();
                let data = { params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        filters: this.filters}
                };
                axios.get('/api/formalities',data).then(response => {
                    this.formalitiesTable = response.data.formalities.data;
                    console.log("this.formalitiesTable", this.formalitiesTable)

                    this.pagination.total = response.data.formalities.total;
                    this.stopLoading();
                }).catch(error => {
                    this.stopLoading();
                    console.log(error)
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getFormalities();
            },
            handleCurrentChange(currentPage) {
                this.getFormalities(currentPage);
            },
            showRegister(id){
                this.$router.push({
                    name: 'ShowFormalities',
                    params: {id: id}
                });
            },
            editRegister(id){
                this.$router.push({
                    name: 'EditFormalities',
                    params: {id: id}
                });
            },
            deleteRegister(id){
                this.$confirm('¿Está seguro que quiere eliminar este expediente?',{
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    type: 'warning'
                }).then(() => {
                    axios.delete(`/api/formalities/${id}`).then(response => {
                        this.getFormalities();
                        this.$message({
                            type: "success",
                            title: 'Éxito',
                            message: "Se elimino el expediente"
                        });
                    }).catch(error => {
                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Eliminación cancelada'
                    });
                });
            },
            formatDate(date){
                 return new Date(date)
            },
            cover(id){
                console.log('carátula',id)
                this.startLoading();
                axios({
                    responseType: 'blob',
                    method: 'POST',
                    url: '/api/report/proceedings',
                    data: {id: id}
                }).then(response => {
                    this.loading = true;
                    setTimeout(() => {
                        const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = linkUrl;
                        link.setAttribute('download', 'Expediente.pdf');
                        document.body.appendChild(link);
                        link.click();
                        this.loading = false;
                        this.stopLoading();
                    }, 500)

                }).catch(error => {
                    this.stopLoading();
                    this.$notify({
                        title: 'Mensaje',
                        text: 'No fue posible realizar la descarga, inténtelo nuevamente.',
                        type: 'warning'
                    });
                });
            },
            eyebrow(id){
                console.log('ceja',id)
                this.startLoading();
                axios({ responseType: 'blob',
                    method: 'POST',
                    url: '/api/report/label',
                    data: {id: id} }).then(response => {
                    this.loading = true;
                    setTimeout(()=>{
                        const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = linkUrl;
                        link.setAttribute('download', 'Etiquetas.xlsx');
                        document.body.appendChild(link);
                        link.click();
                        this.loading = false;
                        this.stopLoading();
                    },500)

                }).catch(error => {
                    this.stopLoading();
                    this.$notify({
                        title: 'Mensaje',
                        text: 'No fue posible realizar la descarga, inténtelo nuevamente.',
                        type: 'warning'
                    });
                });
            },
            labelBox(){
                this.startLoading();
                console.log("unidad: ",  this.$store.state.user.cat_unit_id );
                axios({
                    responseType: 'blob',
                    method: 'post',
                    url: '/api/report/labelBox',
                    data: { 'cat_unit_id': this.$store.state.user.cat_unit_id   }
                }).then(response => {
                    this.loading = true;
                    setTimeout(() => {
                        const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = linkUrl;
                        link.setAttribute('download', 'Etiquetas_de_caja.xlsx');
                        document.body.appendChild(link);
                        link.click();
                        this.loading = false;
                        this.stopLoading();
                    }, 500)

                }).catch(error => {
                    this.stopLoading();
                    this.$notify({
                        title: 'Mensaje',
                        text: 'No fue posible realizar la descarga, inténtelo nuevamente.',
                        type: 'warning'
                    });
                });
            },
            downloadExcel(){
                let data = { params: {
                        filters: this.filters}
                };
                this.startLoading();
                axios.get('/api/download/excel',data).then(response => {
                    const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = linkUrl;
                    link.setAttribute('download', 'users.xlsx');
                    document.body.appendChild(link);
                    link.click();
                    this.stopLoading();
                }).catch(error => {
                    console.log(error)
                    this.stopLoading();
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            }
        }

    }
</script>

<style scoped>

</style>
