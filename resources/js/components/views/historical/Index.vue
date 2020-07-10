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
                        icon="fas fa-file-excel"
                        :disabled="downloading">
                        {{ downloadText }}
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
        <el-row :gutter="20">
            <el-col :span="24">
                <el-table
                    size="mini"
                    :data="tableData"
                    style="width: 100%">
                    <el-table-column
                        prop="number"
                        label="#">
                    </el-table-column>
                    <el-table-column
                        prop="determinant"
                        label="Determinante">
                    </el-table-column>
                    <el-table-column
                        prop="classification"
                        label="Clasificación">
                    </el-table-column>
                    <el-table-column
                        prop="year"
                        label="Año">
                    </el-table-column>
                    <el-table-column
                        prop="user"
                        label="Creado por:">
                    </el-table-column>
                    <el-table-column
                        prop="date"
                        label="Fecha y Hora de  Creación">
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
                tableData: [{
                    number: '1',
                    determinant: 'SSRE',
                    classification: '10-01-1',
                    year: '2004',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '2',
                    determinant: 'TIN',
                    classification: '590-27-1',
                    year: '2016',
                    user: 'Juárez Caballero, Raúl Alberto',
                    date: '2020-06-26 12:46:57',
                }, {
                    number: '3',
                    determinant: 'SSRE',
                    classification: '421-02-1',
                    year: '2008',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '4',
                    determinant: 'SSRE',
                    classification: '312-09-9',
                    year: '2013',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '5',
                    determinant: 'DDH',
                    classification: '410-01-207',
                    year: '2001',
                    user: 'Cruces Monroy, Joel',
                    date: '2017-02-28 01:06:57',
                }, {
                    number: '6',
                    determinant: 'TIN',
                    classification: '590-27-1',
                    year: '2016',
                    user: 'Juárez Caballero, Raúl Alberto',
                    date: '2020-06-26 12:46:57',
                }, {
                    number: '7',
                    determinant: 'SSRE',
                    classification: '421-02-1',
                    year: '2007',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '8',
                    determinant: 'SSRE',
                    classification: '312-09-9',
                    year: '2005',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '9',
                    determinant: 'DDH',
                    classification: '410-01-207',
                    year: '2003',
                    user: 'Cruces Monroy, Joel',
                    date: '2017-02-28 01:06:57',
                }, {
                    number: '10',
                    determinant: 'DDH',
                    classification: '510-06-1',
                    year: '2001',
                    user: 'Cruces Monroy, Joel',
                    date: '2017-02-28 01:06:57',
                }],
                downloading: false,
                downloadText: 'Descargar Excel',
                dialogVisible: false,

                filters: {
                    recommendation: '',
                },

                showFilters: false,
                search: {
                    date: null,
                    recommendation: null,
                    cat_entity_id: null,
                    isPublished: []
                }


            }
        },

        created() {

        },
        computed: {
            ...mapGetters("bulkLoading", [
                "errorsBulk"
            ])
        },


        methods: {

            ...mapActions("bulkLoading", ['addRows', 'indexRow']),

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



