<template>
    <div style="width:90%; margin:0px auto;">

        <header-section icon="fas fa-copy" title="Bandeja de entrada">
            <template slot="buttons">
                <el-button
                    size="mini"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/')">
                    Regresar
                </el-button>
                <el-button-group>
                    <el-button
                        v-if="$store.state.user.profile === 1 || 2"
                        size="mini"
                        type="success"
                        icon="fas fa-edit"
                        @click="$router.push({name: 'RecommendationCreate' })">
                        + Operativo
                    </el-button>
                </el-button-group>
            </template>
        </header-section>

        <el-row :gutter='20' style="padding: 20px 0px;">
            <el-col :span='24'>
                <div style="width: 100%; padding: 5px 0px; display:flex; justify-content: flex-end;">
                    <div>
                        <el-button-group>
                                <el-button
                                    type="default"
                                    size="mini"
                                    icon="fa fa-filter">
                                        Filtros avanzados
                                </el-button>
                                <el-button
                                    type="success"
                                    size="mini"
                                    icon="fa fa-file-excel">
                                    Descargar excel
                                </el-button>
                        </el-button-group>
                    </div>
                </div>
            </el-col>
        </el-row>


        <el-row :gutter="20">
            <el-col :span="24">
                <el-table
                    size="mini"
                    border
                    ref="elTableRecommendation"
                    :data="dataConsulates"
                    style="width: 100%; margin: 0px auto;">
                    <el-table-column
                        prop="consulate"
                        sortable
                        label="Consulado"
                        width="300">
                    </el-table-column>
                    <el-table-column
                        prop="no_operatives"
                        sortable
                        label="Operativos"
                        width="200">
                    </el-table-column>
                    <el-table-column
                        prop="no_aseguramientos"
                        sortable
                        width="200"
                        label="Aseguramientos">
                    </el-table-column>
                    <el-table-column
                        prop="status"
                        sortable
                        label="Estatus"
                        width="174">
                        <template slot-scope="scope">
                           Activo
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="status"
                        sortable
                        label="Periodo"
                        width="174">
                        <template slot-scope="scope">
                           S 14
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Acciones" header-align="left" align="center" width="200">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Editar operativos"
                                    placement="top-start">
                                    <el-button
                                        type="primary"
                                        size="mini"
                                        icon="fa fa-sticky-note"
                                        @click="addOperative(scope.row)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Publicar"
                                    placement="top-start">
                                    <el-button
                                        type="success"
                                        size="mini"
                                        icon="fa fa-edit"
                                        @click="addOperative(scope.row)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Eliminar"
                                    placement="top-start">
                                    <el-button
                                        type="danger"
                                        size="mini"
                                        icon="fa fa-trash-alt"
                                        @click="addOperative(scope.row)">
                                    </el-button>
                                </el-tooltip>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
                <br>
                <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page.sync="pagination.currentPage"
                    :page-sizes="[10, 20, 50, 100]"
                    :page-size="parseInt(pagination.perPage)"
                    layout="sizes, ->, prev, pager, next"
                    :total="pagination.total">
                </el-pagination>
            </el-col>
        </el-row>


    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import FiltersComponent from "../recommendations/FiltersRecomendations";
    import {mapGetters, mapActions} from 'vuex';

    export default {
        components: {
            HeaderSection,
            FiltersComponent
        },

        data() {
            return {

                //Armas
                dataConsulates:[],


                // Filtros
                trashRecomendation: false,
                selectRecomendation: [],

                showFiltersRecommendations: false,

                // Fin de filtros

                show: false,

                recommendations: [],
                downloading: false,
                downloadText: 'Descargar Excel',
                dialogVisible: false,

                filters: {
                    recommendation: '',
                },

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },
                showFilters: false,
                removeDialog: false,
                publicDialog: false,
                unpublicDialog: false,
                removeHash: null,
                hashId: null,
                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
                errorCarga: false,
                errorRecommendations: [],
                totalErrors: 0,
                checkList: [],
                catEntity: [],
                checked: false,
                checked2: false,
                search: {
                    date: null,
                    recommendation: null,
                    cat_entity_id: null,
                    isPublished: []
                }


            }
        },

        created() {
          this.getConsulates();
        },
        computed: {
            ...mapGetters("bulkLoading", [
                "errorsBulk"
            ])
        },


        methods: {

            ...mapActions("bulkLoading", ['addRows', 'indexRow']),
            addOperative(data){
            console.log("addOperative -> val", data.consulate_id)


            },
            getConsulates(){

                axios.get('/api/guncontrol/getGunControl').then(response => {
                console.log("getConsulates -> response", response)
                this.dataConsulates = response.data.lResults;
                console.log("getConsulates -> this.dataConsulates", this.dataConsulates)

                }).catch(error =>{
                console.log("getConsulates -> error", error)

                });

            },
            clearSelects(){
                this.$refs.elTableRecommendation.clearSelection();
            },
            handleSelectionChange(val) {
                this.selectRecomendation = [];
                for (let i = 0; i < val.length; i++) {
                    this.selectRecomendation.push(val[i].id);
                }

                console.log("Elementos seleccionados: ",this.selectRecomendation);
            },
            advancedFiltersRecomendation(){





                axios.post('/api/recommendations/advancedFiltersRecommendation',{
                    deleteId:  this.selectRecomendation
                }).then(response => {
                    if (response.data.success) {
                        console.log("Response buscador de recomendaciones: ",response);
                        this.getRecommendations();
                        this.trashRecomendation = false;
                    }
                });


            },
            getFile() {
                document.location.href = '/template/Recomendaciones.xlsx';
            },
            filterEstatus(value, row) {
                return row.isPublished === value;
            },

            submitUpload() {
                if (this.$refs.upload.uploadFiles.length===0){
                    this.$message({
                        type: 'warning',
                        message: 'No se seleccionó ningún archivo'
                    });
                }
                this.addRows([]);
                this.$refs.upload.submit();
                this.dialogVisible = false;

            },

            cleanFilters() {
                this.search.recommendation = null;
                this.search.isPublished = [];
                this.search.date = null;
                this.search.cat_entity_id = null;

                this.getRecommendations();

            },

            getByFilter() {
                let _search = {
                    filters: this.search,
                    page: this.pagination.currentPage,
                    perPage: this.pagination.perPage,
                };

                axios.get('/api/filter-recommendations', {params: _search}).then(response => {
                    if (response.data.success) {
                        this.recommendations = response.data.recommendations.data;
                        this.pagination.total = response.data.recommendations.total;
                        this.pagination.currentPage = response.data.recommendations.current_page;
                        this.pagination.perPage = response.data.recommendations.per_page;
                    }
                });
                this.show = false;

            },

            onError(err, file, fileList) {
                console.log(err);
                this.stopLoading();
                this.$message({
                    type: 'warning',
                    message: 'No fue posible leer el archivo, inténtelo nuevamente.',
                });
            },
            beforeUploadFile(file) {
                this.startLoading();
                var type = file.name;
                var find = type.search(".xlsx");
                if (file.size / 1024 / 1024 > 6) {
                    this.stopLoading();
                    this.$message.error('El archivo seleccionado excede el limite permitido');
                    return false;
                }
                if (find === -1) {
                    this.stopLoading();
                    this.$message.error('Tipo de Archivo no permitido');
                    return false;
                }
                return true;
            },

            onSeccess(response, file, fileList) {
                this.$refs.upload.uploadFiles=[];
                if (response.success) {
                    this.recommendations = [];
                    this.getRecommendations();
                    let data = {
                        cat_transaction_type_id: 6,
                        action: 'Iportación de Recomendaciones'
                    };

                    axios.post('/api/transaction', data).then(response => {
                    }).catch(error => {
                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    });

                    if (response.filas.length > 0) {
                        this.addRows(response.filas);
                        this.totalErrors = response.filas.length;
                        this.errorCarga = true;
                    }else {
                        this.$message({
                            type: 'success',
                            message: 'Se cargaron las recomendaciones con éxito'
                        });
                    }
                    this.stopLoading();
                } else {
                    this.stopLoading();
                    this.$message({
                        type: 'warning',
                        message: 'Archivo incorrecto, descargue el Formato Excel correcto.',
                    });
                }
            },

            bulkLoad(e, index) {
                e.index = index;
                this.indexRow(index);
                this.$router.push({
                    name: 'RecommendationCreate',
                    params: {index: index}
                })
            },

            changeLanguage(language) {
                if (language == 1) {

                }
            },

            addRegister() {
                this.indexRow(null);
                let data = {
                    cat_transaction_type_id: 1,
                    action: 'Ingresa a crear una recomendación'
                };

                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: 'RecommendationCreate'
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            editRegister(id) {
                let data = {
                    cat_transaction_type_id: 1,
                    action: 'Ingresa a editar una recomendación'
                };

                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: 'RecommendationEdit',
                        params: {id: id}
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            publishRegister() {
                let data = {
                    id: this.hashId
                };

                axios.post(`/api/recommendations/publish/register`, data).then(response => {
                    this.$message({
                        type: "success",
                        message: "Se ha Publicado correctamente."
                    });

                    this.publicDialog = false;
                    this.getRecommendations();
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            unpublishRegister() {
                let data = {
                    id: this.hashId
                };

                axios.post('/api/recommendations/unpublish/register', data).then(response => {
                    this.$message({
                        type: "success",
                        message: "Se ha quitado la publicacion correctamente."
                    });

                    this.unpublicDialog = false;
                    this.getRecommendations();
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            getRecommendations(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                    }
                };

                axios.get('/api/recommendations', data).then(response => {
                    if (response.data.success) {
                        this.recommendations = response.data.recommendations.data;
                        this.pagination.total = response.data.recommendations.total;
                        this.pagination.currentPage = response.data.recommendations.current_page;
                        this.pagination.perPage = response.data.recommendations.per_page;
                        this.catEntity = response.data.entity;
                        this.showFilters = false;
                        this.stopLoading();
                    }

                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            handleCurrentChange(currentPage) {
                this.pagination.currentPage = currentPage;

                let sum = 0;
                sum = (this.search.date === null )? sum + 0 :sum + 1;
                // console.log("Date: ",sum);
                sum = (this.search.recommendation === null)? sum + 0 : sum + 1;
                // console.log("Recomendation: ",sum);
                sum = (this.search.cat_entity_id === null)? sum + 0 : sum +1;
                //  console.log("cat_entity: ",sum);
                sum = (this.search.isPublished.length > 0)? sum + 1 : sum + 0;
                //  console.log("publicado: ",sum);


                if( sum !== 0  ){
                    console.log("ESTAS DENTRO DE LA CONDICION");
                    // console.log("Suma de resultados: ",sum);
                    // console.log("fecha:",this.search.date);
                    // console.log("Tipo de valor: ",typeof(this.search.date));

                    console.log("Pagina: ",this.pagination.currentPage);


                    this.getByFilter();
                    return
                }

                console.log("TOTAL: ",sum);



                this.getRecommendations(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getRecommendations();
            },

            disableDialog(id) {
                this.removeDialog = true;
                //this.publicDialog = true;
                this.removeHash = id;
            },

            disableDialogPost(id) {
                this.publicDialog = true;
                this.hashId = id;
            },

            disableDialogUnPost(id) {
                this.unpublicDialog = true;
                this.hashId = id;
            },

            disableRecommendation(id) {
                this.startLoading();

                axios.delete(`/api/recommendations/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();
                    this.getRecommendations();
                    this.removeDialog = false;
                    this.removeHash = null;

                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "La recomendación se elimino correctamente"
                    });

                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
            errorReco(data){
                var show = false;
                if (data.errorAction!==null) show = true;
                if (data.errorAnio!==null) show = true;
                if (data.errorAuthority!==null) show = true;
                if (data.errorComment!==null) show = true;
                if (data.errorEntity!==null) show = true;
                if (data.errorOds!==null) show = true;
                if (data.errorOrdenGob!==null) show = true;
                if (data.errorPop!==null) show = true;
                if (data.errorPower!==null) show = true;
                if (data.errorRecommendation!==null) show = true;
                if (data.errorRights!==null) show = true;
                if (data.errorRightslll!==null) show = true;
                if (data.errorTopics!==null) show = true;
                if (data.errorDocs!==null) show = true;
                return show;
            },
            cargaMasiva(){
                this.$refs.upload.uploadFiles=[];
                this.dialogVisible = true;
            },
            downloadExcel() {
                let params = {
                    responseType: 'blob',
                };

                axios.get(`/api/recommendations/download/Excel`, {params, responseType: 'blob'}).then(response => {
                    const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = linkUrl;
                    link.setAttribute('download', 'Prueba.xlsx');
                    document.body.appendChild(link);
                    link.click();
                }).catch(error => {
                    this.$notify({
                        title: 'Mensaje',
                        text: 'No fue posible realizar la descarga, inténtelo nuevamente.',
                        type: 'warning'
                    });
                });
            },
        },
    }
</script>


<style scoped>
    .errors {
        margin-bottom: 20px;
        text-align: center;
        background-color: #F56C6C;
        color: white; padding: 10px;
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

    .filters-enter-active {
        animation-duration: 0.5s;
        animation-name: fadeInRight;
    }

    .filters-leave-active {
        animation-duration: 0.5s;
        animation-name: fadeOutRight;
    }

    .close-button {
        color: #fff !important;
    }

    .close-button:hover {
        opacity: 0.75;
    }
    .el-divider--horizontal {
        display: block;
        height: 4px;
        width: 100%;
        margin: 24px 0;
        background-color: #ca8c6f;
    }
    .errorRep{
        margin-top: 10px;
        border-top: 1px solid #cacaca;
        padding: 7px;
    }
</style>



