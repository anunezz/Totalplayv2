<template>
    <div>
        <header-section icon="el-icon-document" title="Subserie documental">
            <template slot="buttons">
                <el-col :span="5" :offset="7">
                    <el-button type="success" @click="newCatalog" style="width: 100%">
                        Nuevo registro
                    </el-button>
                </el-col>
                <el-col :span="10" :offset="1">
                    <el-input
                        clearable
                        suffix-icon="fas fa-search"
                        placeholder="Buscar por subserie documental o código"
                        v-model="search"
                        @change="getTitles(search)">
                    </el-input>
                </el-col>
            </template>
        </header-section>

        <el-row :gutter="20">
            <el-col :span="6">
                <p>Archivos agregados</p>
                <p></p>
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

        <p></p>
        <br>
        <el-row :gutter="20">
            <el-col :span="24">
                <el-table
                    :data="elements"
                    size="mini"
                    border
                    style="width: 100%">
                    <el-table-column
                        prop="serie.name"
                        label="Serie documental">
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="Subserie documental">
                    </el-table-column>
                    <el-table-column
                        prop="code"
                        label="Código">
                    </el-table-column>
                    <el-table-column
                        label="Acciones" header-align="left" align="center" width="250">
                        <template slot-scope="scope">
                            <!--                            <pre>{{scope.row.formalities}}</pre>-->
                            <el-button-group size="mini">
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Editar"
                                    placement="right-start">
                                    <el-button
                                        type="info"
                                        size="mini"
                                        icon="fas fa-edit"
                                        @click="editForm(scope.row)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip v-if="scope.row.formalities !== null" placement="right-start">
                                    <div slot="content">
                                        Este elemento no se puede eliminar dado que
                                        <br/>
                                        esta siendo utilizado por un registro
                                    </div>
                                    <span>
                                        <el-button
                                            type="danger"
                                            size="mini"
                                            icon="fas fa-trash"
                                            disabled>
                                        </el-button>
                                    </span>
                                </el-tooltip>
                                <el-tooltip
                                    v-if="scope.row.formalities === null && scope.row.isActive"
                                    class="item"
                                    effect="dark"
                                    content="Deshabilitar"
                                    placement="right-start">
                                    <el-button
                                        type="danger"
                                        size="mini"
                                        icon="fas fa-trash"
                                        @click="disableDialog(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    v-if=" scope.row.formalities === null && ! scope.row.isActive"
                                    class="item"
                                    effect="dark"
                                    content="Habilitar"
                                    placement="right-start">
                                    <el-button
                                        type="success"
                                        size="mini"
                                        icon="fas fa-check"
                                        @click="enableRegister(scope.row.hash)">
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

        <el-dialog :visible.sync="newRegisterDialog"
                   :before-close="handleClose"
                   @close="resetForm"
                   width="55%">
            <el-main style="border-left: 16px solid #E9EEF3 ">
                <el-card shadow="never">
                    <div slot="header">
                        <span  class="title">Nuevo registro</span>
                    </div>
            <el-form ref="catalogForm" :model="catalogForm" label-width="120px" label-position="top">
                <el-row :gutter="10">
                    <el-col :span="12">
                        <el-form-item label="Serie documental"
                                      prop="cat_series_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change']},
                                    ]">
                            <el-select @change="determinante(catalogForm.cat_series_id)"
                                       style="width: 100%;"
                                       size="medium"
                                       v-model="catalogForm.cat_series_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(serie , index) in series"
                                    :key="index"
                                    :label="serie.name"
                                    :value="serie.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Codigo"
                                      prop="newCode"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[0-9.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales ni letras', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="newRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogForm.newCode"
                                maxlength="3"
                                show-word-limit
                                clearable>
                                <template slot="prepend">{{codeSeries}}</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item label="Nombre"
                                      prop="newRegisterName"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.;:,()-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="newRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogForm.newRegisterName"
                                maxlength="100"
                                clearable>
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
                    <br> <p></p>
                    <el-row>
                        <div align="right">
                            <el-button type="danger" @click="resetForm">Cancelar</el-button>
                            <el-button
                                v-if="newRegisterDialog"
                                type="primary"
                                @click="newRegister">
                                Aceptar
                            </el-button>
                        </div>
                    </el-row>
                </el-card>
            </el-main>
        </el-dialog>

        <el-dialog :visible.sync="editRegisterDialog"
                   :before-close="handleClose"
                   @close="resetEditForm"
                   width="55%">
            <el-main style="border-left: 16px solid #E9EEF3 ">
                <el-card shadow="never">
                    <div slot="header">
                        <span  class="title">Editar Registro</span>
                    </div>

            <el-form ref="catalogEditForm" :model="catalogEditForm" label-width="120px" label-position="top">
                <el-row :gutter="10">
                    <el-col :span="12">
                        <el-form-item label="Serie documental"
                                      prop="cat_series_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change']},
                                    ]">
                            <el-select v-if="editRegisterDialog"
                                       @change="determinante(catalogEditForm.cat_series_id)"
                                       style="width: 100%;"
                                       size="medium"
                                       v-model="catalogEditForm.cat_series_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(serie , index) in series"
                                    :key="index"
                                    :label="serie.name"
                                    :value="serie.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Codigo"
                                      prop="codeSubseries"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[0-9.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales ni letras', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="editRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogEditForm.codeSubseries"
                                maxlength="3"
                                show-word-limit
                                clearable>
                                <template slot="prepend">{{codeEditSerie}}</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item label="Nombre"
                                      prop="name"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.;:,()-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                        <el-input
                                v-if="editRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogEditForm.name"
                                maxlength="100"
                                clearable>
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
                    <br> <p></p>
                    <el-row>
                        <div align="right">
                            <el-button type="danger" @click="getTitles(), resetEditForm()">Cancelar</el-button>
                            <el-button
                                v-if="editRegisterDialog"
                                type="primary"
                                @click="editRegister">
                                Aceptar
                            </el-button>
                        </div>
                    </el-row>
                </el-card>
            </el-main>
        </el-dialog>

        <el-dialog
            v-if="removeDialog"
            :visible.sync="removeDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere deshabilitar este registo?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="removeDialog = false">Cancelar</el-button>
                <el-button type="success" @click="disableRegister(removeHash)">Aceptar</el-button>
            </span>
        </el-dialog>
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

                series: [],
                codeSeries: '',
                elements: [],

                search: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                catalogForm: {
                    newRegisterName: '',
                    cat_series_id: null,
                    newCode: '',
                },
                catalogEditForm:{
                    name: '',
                    cat_series_id: null,
                    codeSubseries: ''
                },
                hashRegister: null,
                nameRegister: null,

                newRegisterDialog: false,
                editRegisterDialog: false,

                removeDialog: false,
                publicDialog: false,
                unpublicDialog: false,
                removeHash: null,
                hashId: null,

                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
            }
        },

        created() {
            this.getTitles();
            axios.get('/api/cats/create').then(response => {
                this.series = response.data.series;
                this.stopLoading();
            })
        },

        watch:{
            search(neew,old){
                return this.search = this.Search(neew);
            }
        },


        methods: {

            determinante(data){


                let series = [];
                //           console.log('secciones', this.sections);
                //           this.catalogForm.newCode = '';
                const result = this.series.filter(serie => serie.id === data);
                this.codeSeries = result[0].code + '.';
                this.codeEditSerie = result[0].code + '.';

            },

            Search(search){
                let re = new RegExp(/((&lt;\/script|\<|\>|script&gt;|&lt;script|script|<script|&lt;xml|<xml)|(\?&gt;|\?>|&lt;\?xml|(&lt;\?php|\<php|&lt;php|&lt;\?)|java|xss|htaccess)|(["&/=¨;:´%$¿?|#!¡+_{}()^*'`\[\]]))/,'igm');
                if(re.test(search)){
                    return search.replace(re, '');
                }else{
                    return search;
                }
            },


            getTitles(currentPage =  1) {
                this.startLoading();

                let data = { params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        search: this.search,
                        cat: 4}
                };

                axios.get('/api/cats/get-cat', data).then(response => {

                    this.elements = response.data.elements.data;
                    this.pagination.total = response.data.elements.total;
                    this.pagination.currentPage = response.data.elements.current_page;
                    this.pagination.perPage = response.data.elements.per_page;

                    this.stopLoading();

                }).catch(error => {
                    this.stopLoading();

                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            handleCurrentChange(currentPage) {
                this.pagination.currentPage = currentPage;
                this.getTitles(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getTitles();
            },

            newRegister() {
                this.startLoading();

                this.newCodeComplete = this.codeSeries + this.catalogForm.newCode;

                let data = {
                    cat: 4,
                    name: this.catalogForm.newRegisterName,
                    codeSubseries: this.catalogForm.newCode,
                    code: this.newCodeComplete,
                    cat_series_id: this.catalogForm.cat_series_id,
                };

                this.$refs['catalogForm'].validate((valid) => {
                    if (valid) {
                        axios.post('/api/cats/new-register', data).then(response => {

                            if (response.data.success) {
                                this.$notify({
                                    type: "success",
                                    message: "El registro se creó con éxito."
                                });

                                this.catalogForm.newRegisterName = '';
                                this.newRegisterDialog = false;
                                this.getTitles();
                            } else {
                                this.$notify({
                                    type: "warning",
                                    message: response.data.message
                                });
                            }

                            this.stopLoading();
                        }).catch(error => {
                            this.stopLoading();

                            this.$notify({
                                type: "warning",
                                message: "No fue posible completar la acción, intente nuevamente."
                            });
                        });

                    }else {
                        this.stopLoading();
                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });
            },

            editForm(row){
                const result = row.serie.code;
                this.codeEditSerie = result + '.';
                this.catalogEditForm = {
                    id:row.hash,
                    name:row.name,
                    cat_series_id: row.cat_series_id,
                    codeSubseries: row.codeSubseries,
                };
                this.editRegisterDialog = true;
            },

            editRegister() {
                this.startLoading();

                this.editCodeComplete = this.codeEditSerie + this.catalogEditForm.codeSubseries;

                let data = {
                    id: this.catalogEditForm.id,
                    cat: 4,
                    name: this.catalogEditForm.name,
                    codeSubseries: this.catalogEditForm.codeSubseries,
                    code: this.editCodeComplete,
                    cat_series_id: this.catalogEditForm.cat_series_id,
                };

                this.$refs['catalogEditForm'].validate((valid) => {
                    if (valid) {
                        axios.put('/api/cats/update/register', data).then(response => {

                            if (response.data.success) {
                                this.$notify({
                                    type: "success",
                                    message: "El registro se actualizó con éxito."
                                });

                                this.editRegisterDialog = false;
                                this.getTitles();
                            } else {

                                this.$notify({
                                    type: "warning",
                                    message: response.data.message
                                });
                            }

                            this.stopLoading();
                        }).catch(error => {
                            this.stopLoading();

                            this.$notify({
                                type: "warning",
                                message: "No fue posible completar la acción, intente nuevamente."
                            });
                        });

                    }else {
                        this.stopLoading();
                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });
            },

            disableDialog(id) {
                this.removeDialog = true;
                this.removeHash = id;
            },

            newCatalog(){
                this.catalogForm.newRegisterName = '';
                this.codeSeries = '';
                this.newRegisterDialog = true;
            },

            handleClose(done) {
                this.$confirm('¿Seguro que quieres cerrar este cuadro?')
                    .then(_ => {
                        done();
                        this.getTitles();
                        this.$refs['catalogEditForm'].resetFields();
                    })
                    .catch(_ => {});
            },

            disableRegister(id) {
                this.startLoading();

                let data ={id: id, cat: 4};

                axios.post('/api/cats/disable-register', data).then(response => {
                    this.$notify({
                        type: "success",
                        message: "El registro se deshabilito con éxito."
                    });

                    this.getTitles();
                    this.removeDialog = false;
                    this.removeHash = null;
                }).catch(error => {
                    this.stopLoading();

                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            enableRegister(id) {
                this.startLoading();

                let data ={id: id, cat: 4};

                axios.post('/api/cats/enable-register', data).then(response => {
                    this.$notify({
                        type: "success",
                        message: "El registro se habilito con éxito."
                    });

                    this.getTitles();
                }).catch(error => {
                    this.stopLoading();

                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            resetForm(){
                this.newRegisterDialog = false;
                this.$refs['catalogForm'].resetFields();
            },
            resetEditForm(){
                this.editRegisterDialog = false;
                this.$refs['catalogEditForm'].resetFields();
            },
        },
    }
</script>

