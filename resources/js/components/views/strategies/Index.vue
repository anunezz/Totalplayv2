<template>
    <div>
        <header-section icon="fas fa-copy" title="Bandeja de entrada de informe de estrategia">
            <template slot="buttons">
                <el-button
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/')">
                    Regresar
                </el-button>
                <el-button-group>
                    <el-button
                        size="small"
                        type="primary"
                        icon="fas fa-file-excel"
                        :disabled="downloading">
                        {{ downloadText }}
                    </el-button>
                    <el-button
                        v-if="$store.state.user.profile === 1 || 2"
                        size="small"
                        type="success"
                        icon="fas fa-edit"
                        @click="$router.push({name: 'StrategiesCreate' })">
                        + Informativo
                    </el-button>
                </el-button-group>
            </template>
        </header-section>
        <el-row>
            <el-col :span="6" :offset="18">
                <el-button
                    size="medium"
                    icon="fas fa-search"
                    style="width: 100%">
                    Filtros
                </el-button>
            </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="6">
                <el-pagination
                    :page-size="parseInt(pagination.perPage)"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    layout="total"
                    :current-page.sync="pagination.currentPage"
                    :total="pagination.total">
                </el-pagination>
            </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="24">
                <!-- atributo para seleccionar varios registros de la tabla  @selection-change="handleSelectionChange"-->
                <el-table
                    size="mini"
                    border
                    ref="elTableStrategies"
                    :data="strategies"
                    style="width: 100%">
                    <!-- <el-table-column
                        type="selection"
                        width="55">
                    </el-table-column>
                    <el-table-column
                        prop="invoice"
                        sortable
                        label="Folio"
                        width="150">
                    </el-table-column>  -->
                    <el-table-column
                        prop="period"
                        sortable
                        width="150"
                        label="Periodo">
                    </el-table-column>
                    <el-table-column
                        prop="date"
                        sortable
                        label="Fecha"
                        width="250">
                    </el-table-column>
                    <el-table-column
                        prop="consulate.name"
                        sortable
                        label="Consulado"
                        width="300">
                    </el-table-column>
                    <el-table-column
                        prop="user.full_name"
                        sortable
                        label="Nombre"
                        width="300">
                    </el-table-column>
                    <el-table-column
                        prop="isPublished"
                        sortable
                        label="Estatus"
                        width="250"
                        :filters="[{ text: 'Prublicado', value: 1 }, { text: 'Sin publicar', value: 0 }]"
                        :filter-method="filterEstatus">
                        <template slot-scope="scope">
                            {{ scope.row.isPublished ? 'Publicado' : 'Sin publicar' }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Acciones" header-align="left" align="center" width="200">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-tooltip
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
                                    v-if="! scope.row.isPublished"
                                    class="item"
                                    effect="dark"
                                    content="Publicar"
                                    placement="top-start">
                                    <el-button
                                        type="success"
                                        size="mini"
                                        icon="fas fa-upload"
                                        @click="disableDialogPost(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    v-else
                                    class="item"
                                    effect="dark"
                                    content="No Publicar"
                                    placement="top-start">
                                    <el-button
                                        type="info"
                                        size="mini"
                                        icon="fas fa-download"
                                        @click="disableDialogUnPost(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    v-if="(scope.row.is_creator || $store.state.user.profile === 1) && scope.row.isActive"
                                    class="item"
                                    effect="dark"
                                    content="Eliminar"
                                    placement="top-start">
                                    <el-button
                                        size="mini"
                                        type="danger"
                                        icon="fas fa-trash"
                                        @click="disableDialog(scope.row.hash)">
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

  <!--      <el-dialog
            v-if="removeDialog"
            :visible.sync="removeDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere eliminar esta recomendación?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="removeDialog = false">Cancelar</el-button>
                <el-button type="success" @click="disableRecommendation(removeHash)">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog
            v-if="trashRecomendation"
            :visible.sync="trashRecomendation"
            width="40%" style="text-align: center">
            <h3>¿Estás completamente seguro de eliminar las recomendaciones seleccionadas?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="trashRecomendation = false">Cancelar</el-button>
                <el-button type="danger" @click="advancedFiltersRecomendation()">Eliminar</el-button>
            </span>
        </el-dialog>

        <el-dialog
            v-if="publicDialog"
            :visible.sync="publicDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere publicar esta recomendación?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="publicDialog = false">Cancelar</el-button>
                <el-button type="success" @click="publishRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog
            v-if="unpublicDialog"
            :visible.sync="unpublicDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere dejar de publicar esta recomendación?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="unpublicDialog = false">Cancelar</el-button>
                <el-button type="success" @click="unpublishRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        -->
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
                strategies: [],


                // Filtros
                trashRecomendation: false,
                selectRecomendation: [],

                showFiltersRecommendations: false,

                // Fin de filtros

                show: false,
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
           this.getStrategyReport();
        },
        computed: {
            ...mapGetters("bulkLoading", [
                "errorsBulk"
            ])
        },


        methods: {

            ...mapActions("bulkLoading", ['addRows', 'indexRow']),

            changeDates(){
                this.showFilters = true;
            },

            filterEstatus(value, row) {
                return row.isPublished === value;
            },

            handleSelectionChange(val) {
                this.selectRecomendation = [];
                for (let i = 0; i < val.length; i++) {
                    this.selectRecomendation.push(val[i].id);
                }

                console.log("Elementos seleccionados: ",this.selectRecomendation);
            },

            getStrategyReport(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                    }
                };

                axios.get('/api/strategies', data).then(response => {
                    if (response.data.success) {
                        this.strategies = response.data.strategies.data;
                        this.pagination.total = response.data.strategies.total;
                        this.pagination.currentPage = response.data.strategies.current_page;
                        this.pagination.perPage = response.data.strategies.per_page;
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



