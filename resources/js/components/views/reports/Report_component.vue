<template>
    <div>
        <el-row :gutter='20'>

            <el-col :span='24' class='animated fadeIn fast'>
                <div style='width:100%; padding: 5px 0px; display:flex; justify-content:flex-end;'>
                    <el-button
                        icon="far fa-file-excel"
                        size="mini"
                        type="success">
                        Baja documental
                    </el-button>
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
    </div>
</template>

<script>
    export default {
        props:['items'],
        data(){
            return{
                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10},
                dataTable:[]
            }
        },
        created() {
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
        }
    }
</script>

<style scoped>
</style>
