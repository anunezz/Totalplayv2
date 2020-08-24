<template>
    <div>
        <header-section icon="el-icon-s-management" title="Reportes">
            <template slot="buttons">
                <el-button
                    align="right"
                    size="mini"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/')">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <!-- <el-row :gutter='20'>
            <el-col :span="8">
                <el-badge class="item">
                    <a class="links" @click="$router.push( {name:'Record'})">
                        Reportes de Expedientes ffff
                    </a>
                </el-badge>
                <br /><br />
                <span>Reportes de Expedientes</span>
            </el-col>

            <el-col :span="8">
                <el-badge class="item">
                    <a class="links" @click="goTo('LabelIndex', { cat_transaction_type_id: 1, action: 'Ingresa a reportes de etiqueta'})">
                        Etiqueta
                    </a>
                </el-badge>
                <br /><br />
                <span>Etiqueta</span>
            </el-col>

            <el-col :span="8">
                <el-badge class="item">
                    <a class="links" @click="$router.push( {name:'Transfer'})">
                        Formatos de Trasferencia
                    </a>
                </el-badge>
                <br /><br />
                <span>Formatos de Trasferencia</span>
            </el-col>
        </el-row> -->

        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <div style='width:100%; padding: 5px 0px; display:flex; justify-content:flex-end;'>
                    <el-button-group>
                        <el-button
                            icon="far fa-file-excel"
                            size="mini"
                            @click="labelBox"
                            type="success">
                            Etiqueta de caja
                        </el-button>
                        <el-button
                            icon="far fa-file-excel"
                            size="mini"
                            type="success">
                            Baja documental
                        </el-button>
                        <el-button
                            icon="far fa-file-excel"
                            size="mini"
                            type="primary">
                            Baja contable
                        </el-button>
                        <el-button
                            icon="far fa-file-excel"
                            size="mini"
                            type="default">
                            Transferencia primaria
                        </el-button>
                        <el-button
                            icon="far fa-file-excel"
                            size="mini"
                            type="warning">
                            Transferencia secundaria
                        </el-button>
                    </el-button-group>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <div style='width:100%; padding: 5px 0px; display:flex; justify-content: flex-end;'>
                    <div>
                        <el-button
                            type="default"
                            size="mini"
                            icon="fas fa-search"
                            @click="filters.show = true">
                                    Filtros avanzados
                        </el-button>
                    </div>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <el-pagination
                    :page-size="parseInt(pagination.perPage)"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    layout="total"
                    :total="pagination.total"
                    :current-page.sync="pagination.currentPage">
                </el-pagination>
            </el-col>
        </el-row>

        <el-row :gutter="20">
            <el-col :span="24">
                <el-table
                    size="mini"
                    :data="dataTable"
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
                    <!-- <el-table-column
                        label="Acciones" header-align="left" align="center">
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
                                <el-tooltip
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
                                </el-tooltip>
                            </el-button-group>
                        </template>
                    </el-table-column> -->
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

        <show-filters :items="filters" @search="getFormalities"/>

    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import ShowFilters from "../formalities/FormFiltros";
    export default {
        components: {
            HeaderSection,
            ShowFilters
        },
        data(){
            return{
                dataTable: [],
                filters:{
                    show: false,
                    determinant:'',
                    classification:'',
                    year:null,
                    user:''
                },
                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },
            }
        },
        created(){
            this.getFormalities();
            console.log("Estas aqui");
        },
        methods: {
            goTo(link, data) {
                axios.post("/api/transaction", data).then(response => {
                    this.$router.push({ name: link });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message:
                            "No fue posible completar la acción, intente nuevamente."
                    });
                });
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
                    this.dataTable = response.data.formalities.data;
                    console.log("this.formalitiesTable", this.dataTable)

                    this.pagination.total = response.data.formalities.total;
                    this.stopLoading();
                }).catch(error => {
                    this.stopLoading();
                    //console.log(error)
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
            formatDate(date){
                return new Date(date)
            },
            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getFormalities();
            },
            handleCurrentChange(currentPage) {
                this.getFormalities(currentPage);
            },
            labelBox(){
                axios({ responseType: 'blob',
                        method: 'POST',
                        url: '/api/report/labelBox',
                        data: 'hola' }).then(response => {
                            this.loading = true;
                        setTimeout(()=>{
                            const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = linkUrl;
                            link.setAttribute('download', 'Etiquetas_de_caja.xlsx');
                            document.body.appendChild(link);
                            link.click();
                            this.loading = false;
                        },500)

                    }).catch(error => {
                        this.$notify({
                            title: 'Mensaje',
                            text: 'No fue posible realizar la descarga, inténtelo nuevamente.',
                            type: 'warning'
                        });
                    });
            }
        }
    }
</script>

<style scoped>
.links {
    font-size: 25px;
    color: #9d2449;
    cursor: pointer;
    text-decoration: underline;
}
</style>
