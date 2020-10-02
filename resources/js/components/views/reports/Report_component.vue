<template>
    <div>
        <el-row :gutter='20'>

            <!-- <el-col :span='24' class='animated fadeIn fast'>
                <div style='width:100%; padding: 5px 0px; display:flex; justify-content: space-between;'>
                    <div>
                        <pre>
                            {{ filters }}
                        </pre>
                    </div>
                </div>
            </el-col> -->

            <el-col :span='24' class='animated fadeIn fast'>
                <div style='width:100%; padding: 5px 0px; display:flex; justify-content:flex-end;'>
                    <el-button-group>
                        <el-button
                            :disabled="dataTable.length > 0 ? false:true"
                            @click="DownloadExcel"
                            icon="far fa-file-excel"
                            size="mini"
                            type="success">
                            {{ items.name }}
                        </el-button>
                        <el-button
                            type="default"
                            size="mini"
                            icon="fas fa-search"
                            @click="filters.show = true">
                            Filtros avanzados
                        </el-button>
                    </el-button-group>
                </div>
            </el-col>


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

            <el-col :span='24' class='animated fadeIn fast'>
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
                </el-table>
            </el-col>
            <el-col :span='24' class='animated fadeIn fast'>
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

        <show-filters :items="filters" @search="getFormalities"/>

    </div>
</template>

<script>
    import ShowFilters from "./FormFiltros";

    export default {
        components: { ShowFilters },
        props:['items'],
        data(){
            return{
                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10},
                dataTable:[],
                filters:{
                    show: false,
                    year:null,
                    user:'',
                    serie_id: null,
                    //reports: null
                },
            }
        },
        created() {
            this.getFormalities();
        },
        computed:{
        },
        methods:{
            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getFormalities();
            },
            handleCurrentChange(currentPage) {
                this.getFormalities(currentPage);
            },
            DownloadExcel(){
                axios({ responseType: 'blob',
                        method: 'post',
                        url: '/api/report/'+this.items.url,
                        data: { documentType:this.items.url } }).then(response => {
                            this.loading = true;
                        setTimeout(()=>{
                            const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = linkUrl;
                            link.setAttribute('download', this.items.name+'.xlsx');

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
            },
            getFormalities(currentPage =  1) {
                this.filters.show = false;
                this.startLoading();

                console.log("----------------: ",this.items.url);

                axios.post('/api/report/fileFilter',{
                        page: currentPage,
                        perPage: this.pagination.perPage,
                   documentType: this.items.url,
                        filters: this.filters
                }).then(response => {
                    console.log("Response: ",response);
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
        }
    }
</script>

<style scoped>
</style>
