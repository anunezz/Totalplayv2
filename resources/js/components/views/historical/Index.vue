<template>
    <div>
        <header-section icon="fas fa-copy" title="Consulta de expediente">
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
                        icon="fas fa-file-excel">
                        Descargar Excel
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
                    :data="formalitiesSicarTable"
                    style="width: 100%">
                    <el-table-column
                        label="Determinante">
                        <template slot-scope="scope">
                            {{scope.row.key_units}}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="i_topograf"
                        label="Clasificación">
                    </el-table-column>
                    <el-table-column
                        prop="date"
                        label="Año">
                    </el-table-column>
                    <el-table-column
                        label="Creado por:">
                        <template slot-scope="scope">
                            {{scope.row.user.name}}
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
                                    class="item"
                                    effect="dark"
                                    content="Consultar"
                                    placement="top-start">
                                    <el-button
                                        type="warning"
                                        size="mini"
                                        icon="fas fa-eye"
                                        @click="$router.push( {name:'HistoricalShow'})">
                                    </el-button>
                                </el-tooltip>
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
                formalitiesSicarTable:[],
            }
        },

        created() {
            this.getFormalitiesSicar();
        },

        methods: {
            getFormalitiesSicar(currentPage =  1){
                this.startLoading();
                let data = { params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        filters: this.filters}
                };
                axios.get('/api/formalitiesSicar',data).then(response => {
                    this.formalitiesSicarTable = response.data.formalitiesSicar.data;
                    this.pagination.total = response.data.formalitiesSicar.total;
                    this.stopLoading();
                }).catch(error => {
                    console.log(error)
                    this.stopLoading();
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getFormalitiesSicar();
            },
            handleCurrentChange(currentPage) {
                this.getFormalitiesSicar(currentPage);
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



