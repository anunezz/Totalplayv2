<template>
    <div>
        <header-section icon="fa-users" title="Usuarios">
            <template slot="buttons">
                <el-button
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/administracion')">
                    Regresar
                </el-button>
            </template>
        </header-section>
        <el-row :gutter="20">
            <el-col :span="6">
                <el-pagination
                    @size-change="handleSizeChange"
                    :current-page.sync="pagination.currentPage"
                    :page-sizes="[10, 20, 50, 100]"
                    :page-size="parseInt(pagination.perPage)"
                    layout="sizes">
                </el-pagination>
            </el-col>
            <el-col :span="6" :offset="12">
                <el-input
                    clearable
                    suffix-icon="fas fa-search"
                    placeholder="Buscar"
                    v-model="search"
                    @change="getUsers(search)">
                </el-input>
            </el-col>
        </el-row>
        <br>
        <el-row :gutter="20">
            <el-col :span="24">
                <el-table
                    :data="users"
                    size="mini"
                    border
                    :row-class-name="notAssignedUser"
                    style="width: 100%">
                    <el-table-column
                        prop="full_name"
                        label="Nombre">
                    </el-table-column>
                    <el-table-column
                        prop="username"
                        label="Usuario">
                    </el-table-column>
                    <el-table-column
                        prop="office"
                        label="Puesto">
                    </el-table-column>
<!--                    <el-table-column-->
<!--                        prop="consulate.name"-->
<!--                        label="Consulado">-->
<!--                        <template slot-scope="scope">-->
<!--                            {{scope.row.consulate ? scope.row.consulate.name : 'Sin asignar'}}-->
<!--                        </template>-->
<!--                    </el-table-column>-->
                    <el-table-column
                        prop="profile.name"
                        label="Perfil">
                    </el-table-column>
                    <el-table-column
                        label="Acciones" header-align="left" align="center" width="90">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Editar"
                                    placement="right-start">
                                    <el-button
                                        type="info"
                                        size="mini"
                                        icon="fas fa-edit"
                                        @click="editRegister(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
                <br>
                <el-pagination
                    :page-size="parseInt(pagination.perPage)"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    layout="total, ->, prev, pager, next"
                    :current-page.sync="pagination.currentPage"
                    :total="pagination.total">
                </el-pagination>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import HeaderSection from "../../layouts/partials/HeaderSection";

    export default {
        components: {
            HeaderSection
        },

        data() {
            return {
                users: [],
                search: '',
                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                downloadText: 'Descargar Excel',
                downloading: false,
            }
        },

        created() {
            this.getUsers();
        },

        methods: {
            notAssignedUser({row}) {

                if (row.profile.id === 5) {
                    return 'danger-row';
                }
            },

            addRegister() {
                let data = {cat_transaction_type_id : 1, action: 'Agregar Usuario'};

                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: 'UsersCreate'
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            getUsers(currentPage =  1) {
                this.startLoading();

                let data = { params: {
                    page: currentPage,
                    perPage: this.pagination.perPage,
                    search: this.search}
                };

                axios.get('/api/users', data).then(response => {

                    this.users = response.data.users.data;
                    this.pagination.total = response.data.users.total;
                    this.pagination.currentPage = response.data.users.current_page;
                    this.pagination.perPage = response.data.users.per_page;

                    this.stopLoading();

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
                this.getUsers(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getUsers();
            },

            editRegister(id) {
                let data = {cat_transaction_type_id : 1, action: 'Editar Usuario'};

                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: 'UsersEdit',
                        params: {id: id}
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

        },
    }
</script>
