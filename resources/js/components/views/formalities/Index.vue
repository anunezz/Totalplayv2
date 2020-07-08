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
                    @click="showFilters = true">
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
        <el-drawer
            :visible.sync="showFilters"
            direction="ltr"
            size="50%"
            ref="drawer">
            <el-row style="margin-bottom: 20px">
                <el-col :span="21" :offset="1" class="border-form">
                    <h4>Agregar Campos</h4>
                </el-col>
            </el-row>
            <el-row :gutter="20" type="flex" justify="center">
                <el-col :span="5">
                    <el-button
                        size="small"
                        icon="fas fa-eraser"
                        style="width: 100%">
                        Limpiar
                    </el-button>
                </el-col>
                <el-col :span="5">
                    <el-button
                        size="small"
                        icon="fas fa-filter"
                        type="primary"
                        style="width: 100%">
                        Buscar
                    </el-button>
                </el-col>
            </el-row>
        </el-drawer>
    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";

    export default {
        components: {
            HeaderSection,
        },
        data(){
            return{
                showFilters: false,

                tableData: [{
                    number: '3',
                    determinant: 'SSRE',
                    classification: '10-01-1',
                    year: '2004',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '4',
                    determinant: 'TIN',
                    classification: '590-27-1',
                    year: '2016',
                    user: 'Juárez Caballero, Raúl Alberto',
                    date: '2020-06-26 12:46:57',
                }, {
                    number: '5',
                    determinant: 'SSRE',
                    classification: '421-02-1',
                    year: '2008',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '6',
                    determinant: 'SSRE',
                    classification: '312-09-9',
                    year: '2013',
                    user: 'Sánchez Buendia Aurora',
                    date: '2017-02-27 06:22:17',
                }, {
                    number: '7',
                    determinant: 'DDH',
                    classification: '410-01-207',
                    year: '2001',
                    user: 'Cruces Monroy, Joel',
                    date: '2017-02-28 01:06:57',
                }, {
                    number: '8',
                    determinant: 'DDH',
                    classification: '510-06-1',
                    year: '2007',
                    user: 'Cruces Monroy, Joel',
                    date: '2017-02-28 01:06:57',
                }]
            }
        }

    }
</script>

<style scoped>
    .border-form{
        padding: 20px;
        border: 1px solid #DCDFE6;
        border-radius: 5px;
    }
</style>
