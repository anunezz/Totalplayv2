<template>
    <div>
        <header-section icon="el-icon-document" title="CGCA">
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
                        placeholder="Buscar por descripcion"
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
                        prop="type"
                        label="Determinantes"
                        width="400">
                        <template slot-scope="scope">
                            {{nameUnits(scope.row.administrative)}}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="cat_series_id"
                        label="Documental">
                        <template slot-scope="scope">
                            {{ scope.row.cat_series_id ? 'Serie documental' : 'Subserie documental' }}
                        </template>
<!--                        <template slot-scope="scope">-->
<!--                            {{scope.row.cat_series_id ? scope.row.cat_series_id != null : 'Sin asignar',-->
<!--                              scope.row.cat_series_id ? scope.row.cat_series_id = null : 'Serie documental'}}-->
<!--                        </template>-->
                    </el-table-column>
<!--                    <el-table-column-->
<!--                        prop="serie.name"-->
<!--                        label="Serie documental"-->
<!--                        width="400">-->
<!--                    </el-table-column>-->
                    <el-table-column
                        prop="description"
                        label="Descripción"
                        width="750">
                    </el-table-column>
                    <el-table-column
                        label="Acciones" header-align="left" align="center" width="250">
                        <template slot-scope="scope">
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
<!--                                <el-tooltip v-if="scope.row.operatives.length > 0 || scope.row.id === 14" placement="right-start">-->
<!--                                    <div slot="content">-->
<!--                                        Este elemento no se puede eliminar dado que-->
<!--                                        <br/>-->
<!--                                        esta siendo utilizado por un registro-->
<!--                                    </div>-->
<!--                                    <span>-->
<!--                                        <el-button-->
<!--                                            type="danger"-->
<!--                                            size="mini"-->
<!--                                            icon="fas fa-trash"-->
<!--                                            disabled>-->
<!--                                        </el-button>-->
<!--                                    </span>-->
<!--                                </el-tooltip>-->
                                <el-tooltip
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
<!--                                <el-tooltip-->
<!--                                    v-if="! scope.row.operatives.length > 0 && ! scope.row.is_used && ! scope.row.isActive"-->
<!--                                    class="item"-->
<!--                                    effect="dark"-->
<!--                                    content="Habilitar"-->
<!--                                    placement="right-start">-->
<!--                                    <el-button-->
<!--                                        type="success"-->
<!--                                        size="mini"-->
<!--                                        icon="fas fa-check"-->
<!--                                        @click="enableRegister(scope.row.hash)">-->
<!--                                    </el-button>-->
<!--                                </el-tooltip>-->
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
                        <el-form-item label="Documental" prop="type_documentary" :rules="[
                                                { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                              ]">
                            <el-row>
                                <el-col :span="4" style="margin-right: 100px">
                                    <el-checkbox v-model="serie" @change="typeDocumentary(1)">Serie</el-checkbox>
                                </el-col>
                                <el-col :span="8">
                                    <el-checkbox v-model="subserie" @change="typeDocumentary(2)">Subserie</el-checkbox>
                                </el-col>
                            </el-row>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :span="24">
                        <el-form-item v-if="this.serie === true"
                                      label="Serie documental"
                                      prop="cat_series_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select style="width: 100%;"
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
                    <el-col :span="24">
                        <el-form-item v-if="this.subserie === true"
                                      label="Subserie documental"
                                      prop="cat_subserie_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-select v-model="catalogForm.cat_subserie_id"
                                       filterable placeholder="Seleccionar"
                                       remove-tag="remove-tag"
                                       multiple
                                       style="width: 100%">
                                <el-option
                                    v-for="(sub , index) in subseries"
                                    :key="index"
                                    :label="sub.name"
                                    :value="sub.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item label="Unidad Administrativa"
                                      prop="cat_unit_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-select v-model="catalogForm.cat_unit_id"
                                       filterable placeholder="Seleccionar"
                                       remove-tag="remove-tag"
                                       multiple
                                       style="width: 100%">
                                <el-option
                                    v-for="(unit , index) in units"
                                    :key="index"
                                    :label="unit.name"
                                    :value="unit.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item label="Descripción"
                                      prop="newRegisterName"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="newRegisterDialog"
                                type="textarea"
                                :rows="8"
                                placeholder="Descripción"
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
                        <span  class="title">Editar registro</span>
                    </div>
                    <el-form ref="catalogEditForm" :model="catalogEditForm" label-width="120px" label-position="top">
                        <el-row :gutter="10">
                            <el-col :span="12">
                                <el-form-item label="Documental" prop="type_documentary" :rules="[
                                                { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                              ]">
                                    <el-row>
                                        <el-col :span="4" style="margin-right: 100px">
                                            <el-checkbox v-if="editRegisterDialog" v-model="serie" @change="typeEditDocumentary(1)">Serie</el-checkbox>
                                        </el-col>
                                        <el-col :span="8">
                                            <el-checkbox v-if="editRegisterDialog" v-model="subserie" @change="typeEditDocumentary(2)">Subserie</el-checkbox>
                                        </el-col>
                                    </el-row>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="10">
                            <el-col :span="24">
                                <el-form-item v-if="this.serie === true"
                                              label="Serie documental"
                                              prop="cat_series_id"
                                              :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                                    <el-select v-if="editRegisterDialog"
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
                            <el-col :span="24">
                                <el-form-item v-if="this.subserie === true"
                                              label="Subserie documental"
                                              prop="subserie"
                                              :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                                    <el-select v-if="editRegisterDialog"
                                               v-model="catalogEditForm.subserie"
                                               filterable placeholder="Seleccionar"
                                               remove-tag="remove-tag"
                                               multiple
                                               style="width: 100%">
                                        <el-option
                                            v-for="(sub , index) in subseries"
                                            :key="index"
                                            :label="sub.name"
                                            :value="sub.id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :span="24">
                                <el-form-item label="Unidad Administrativa"
                                              prop="administrative"
                                              :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                                    <el-select v-if="editRegisterDialog"
                                               v-model="catalogEditForm.administrative"
                                               filterable placeholder="Seleccionar"
                                               remove-tag="remove-tag"
                                               multiple
                                               style="width: 100%">
                                        <el-option
                                            v-for="(unit , index) in units"
                                            :key="index"
                                            :label="unit.name"
                                            :value="unit.id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :span="24">
                                <el-form-item label="Descripción"
                                              prop="description"
                                              :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                                    <el-input
                                        v-if="editRegisterDialog"
                                        type="textarea"
                                        :rows="8"
                                        placeholder="Descripción"
                                        v-model="catalogEditForm.description"
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

                serie: false,
                subserie: false,
                units: [],
                series: [],
                subseries: [],
                elements: [],

                search: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                catalogForm: {
                    newRegisterName: '',
                    type_documentary: null,
                    cat_unit_id: [],
                    cat_series_id: [],
                    cat_subserie_id: [],
                },
                catalogEditForm:{
                    description: '',
                    type_documentary: null,
                    administrative: [],
                    cat_series_id: [],
                    subserie: [],
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
                this.units = response.data.units;
                this.subseries = response.data.subseries;
                this.stopLoading();
            })
        },

        watch:{
            search(neew,old){
                return this.search = this.Search(neew);
            }
        },


        methods: {

            Search(search){
                let re = new RegExp(/((&lt;\/script|\<|\>|script&gt;|&lt;script|script|<script|&lt;xml|<xml)|(\?&gt;|\?>|&lt;\?xml|(&lt;\?php|\<php|&lt;php|&lt;\?)|java|xss|htaccess)|(["&/=¨;:´,.%$¿?|#!¡+_{}()^*'`\[\]]))/,'igm');
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
                        cat: 5}
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

                if (this.serie === true){
                    console.log('entro a serie')
                    this.catalogForm.cat_subserie_id = null;
                    console.log('valor de subserie', this.catalogForm.cat_subserie_id)
                }
                if (this.subserie === true){
                    console.log('entro a subserie')
                    this.catalogForm.cat_series_id = null;
                }

                let data = {
                    cat: 5,
                    description: this.catalogForm.newRegisterName,
                    cat_unit_id: this.catalogForm.cat_unit_id,
                    cat_series_id: this.catalogForm.cat_series_id,
                    cat_subserie_id: this.catalogForm.cat_subserie_id,

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
                this.serie = true
                this.subserie = false
                if (row.cat_series_id == null){
                    this.subserie = true
                    this.serie = false
                }
                let administrative = [];
                row.administrative.forEach(element => administrative.push(element.id));
                let subserie = []
                row.subserie.forEach(element => subserie.push(element.id));

                this.catalogEditForm = {
                    id:row.hash,
                    description:row.description,
                    cat_series_id:row.cat_series_id,
                    administrative: administrative,
                    subserie: subserie,
                    type_documentary: 1
                };
                this.editRegisterDialog = true;
            },

            editRegister() {
                this.startLoading();

                let data = {
                    id: this.catalogEditForm.id,
                    cat: 5,
                    description: this.catalogEditForm.description,
                    cat_unit_id: this.catalogEditForm.administrative,
                    cat_series_id: this.catalogEditForm.cat_series_id,
                    cat_subserie_id: this.catalogEditForm.subserie,
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
                this.catalogForm.type_documentary = null;
                this.catalogForm.cat_unit_id = null;
                this.catalogForm.cat_series_id = null;
                this.catalogForm.cat_subserie_id = null;
                this.serie = null;
                this.subserie = null;
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

                let data ={id: id, cat: 5};

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

                let data ={id: id, cat: 5};

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
            nameUnits(data){
                let administrative = [];
                data.forEach(element => administrative.push(' '+element.name));
                let aux = administrative.toString();
                return aux;
            },
            typeDocumentary(type){

                if (!this.serie && !this.subserie){
                    this.catalogForm.type_documentary = null;
                }
                if (type===2 && this.subserie===true){
                    this.serie = false;
                    this.catalogForm.type_documentary = type;
                }
                if (type === 1 && this.serie===true){
                    this.subserie = false;
                    this.catalogForm.type_documentary = type;
                }
            },
            typeEditDocumentary(type){

                if (!this.serie && !this.subserie){
                    this.catalogEditForm.type_documentary = null;
                }
                if (type===2 && this.subserie===true){
                    this.serie = false;
                    this.catalogEditForm.type_documentary = type;
                }
                if (type === 1 && this.serie===true){
                    this.subserie = false;
                    this.catalogEditForm.type_documentary = type;
                }
            },
        },
    }
</script>

