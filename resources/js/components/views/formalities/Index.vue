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
                <el-button-group>
                    <el-button
                        v-if="$store.state.user.profile === 1"
                        size="small"
                        type="success"
                        icon="fas fa-edit"
                        @click="$router.push({name: 'NewFormalities' })">
                        Nuevo
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
                                        icon="fas fa-eye">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Editar"
                                    placement="top-start">
                                    <el-button
                                        type="primary"
                                        size="mini"
                                        icon="fas fa-edit">
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
                                        icon="el-icon-delete">
                                    </el-button>
                                </el-tooltip>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
                <br>
            </el-col>
        </el-row>

<!--        Mostrar filtros-->
        <show-filters :items="filters" @search="SearchData"/>
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
                    user:''
                },
                tableData: [{
                    number: '1',
                    determinant: 'SSRE',
                    classification: 'SRE.08C24-2020-2021/1 ',
                    year: '2004',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '2',
                    determinant: 'TIN',
                    classification: 'SRE.08C24-2020-2021/2 ',
                    year: '2016',
                    user: 'Juárez Caballero, Raúl Alberto',
                    date: '2020-06-26 12:46:57',
                }, {
                    number: '3',
                    determinant: 'SSRE',
                    classification: 'SRE.08C24-2020-2021/3',
                    year: '2008',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '4',
                    determinant: 'SSRE',
                    classification: 'SRE.08C24-2020-2020/4',
                    year: '2013',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '5',
                    determinant: 'DDH',
                    classification: 'SRE.08C24-2020-2020/5',
                    year: '2001',
                    user: 'Cruces Monroy, Joel',
                    date: '2017-02-28 01:06:57',
                }, {
                    number: '6',
                    determinant: 'DDH',
                    classification: 'SRE.08C24-2020-2020/6',
                    year: '2007',
                    user: 'Cruces Monroy, Joel',
                    date: '2017-02-28 01:06:57',
                }]
            }
        },
        methods:{
            SearchData(){
                this.startLoading();
                let _this = this;
                setTimeout(function(){
                    _this.filters.show = false;
                    _this.stopLoading();
                    }, 3000);
            }
        }

    }
</script>

<style scoped>

</style>
