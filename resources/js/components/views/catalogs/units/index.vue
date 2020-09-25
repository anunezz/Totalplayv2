<template>
    <div>
        <header-section icon="el-icon-document" title="Determinantes">
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
                        placeholder="Buscar por nombre ó determinante"
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
                        prop="determinant"
                        label="Determinante">
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="Nombre">
                    </el-table-column>
<!--                    <el-table-column-->
<!--                        prop="type"-->
<!--                        label="Secciones"-->
<!--                        width="600">-->
<!--                        <template slot-scope="scope">-->
<!--                            {{nameSections(scope.row.section_all)}}-->
<!--                        </template>-->
<!--                    </el-table-column>-->
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
                        <span  class="title">Nuevo Registro</span>
                    </div>
            <el-form ref="catalogForm" :model="catalogForm" label-width="120px" label-position="top">
                <el-row :gutter="10">
                    <el-col :span="12">
                        <el-form-item label="Determinante"
                                      prop="determinant"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="newRegisterDialog"
                                placeholder="Determinante"
                                v-model="catalogForm.determinant"
                                maxlength="100"
                                clearable>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Tipo de adscripción"
                                      prop="cat_type_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select @change="typeUnits(catalogForm.cat_type_id)"
                                       style="width: 100%;"
                                       size="medium"
                                       v-model="catalogForm.cat_type_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(type , index) in types"
                                    :key="index"
                                    :label="type.name"
                                    :value="type.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
<!--                    <el-col :span="12">-->
<!--                        <el-form-item label="Tipo de consulado"-->
<!--                                      prop="cat_type_id"-->
<!--                                      :rules="[-->
<!--                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},-->
<!--                                    ]">-->
<!--                            <el-select v-if="catalogForm.cat_type_id === 5" -->
<!--                                       @change="typeUnits(catalogForm.cat_type_id)"-->
<!--                                       style="width: 100%;"-->
<!--                                       size="medium"-->
<!--                                       v-model="catalogForm.cat_type_id"-->
<!--                                       placeholder="Seleccionar">-->
<!--                                <el-option-->
<!--                                    v-for="(type , index) in types"-->
<!--                                    :key="index"-->
<!--                                    :label="type.name"-->
<!--                                    :value="type.id">-->
<!--                                </el-option>-->
<!--                            </el-select>-->
<!--                        </el-form-item>-->
<!--                    </el-col>-->
                    <el-col :span="24">
                        <el-form-item label="Nombre"
                                      prop="newRegisterName"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    { type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.,\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="newRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogForm.newRegisterName"
                                maxlength="100"
                                clearable>
                                <template v-if="catalogForm.cat_type_id === 2 || catalogForm.cat_type_id === 3"
                                    slot="prepend">{{nameUnit}}</template>
                                <template v-if="catalogForm.cat_type_id === 4 || catalogForm.cat_type_id === 6"
                                    slot="append">{{nameUnit}}</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Responsable de unidad"
                                      prop="cat_responsible_id"
                                      :rules="[
                                    { required: false, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select style="width: 100%;"
                                       size="medium"
                                       v-model="catalogForm.cat_responsible_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(user , index) in users"
                                    :key="index"
                                    :label="user.full_name"
                                    :value="user.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Usuario"
                                      prop="cat_user_id"
                                      :rules="[
                                    { required: false, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select style="width: 100%;"
                                       size="medium"
                                       v-model="catalogForm.cat_user_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(user , index) in users"
                                    :key="index"
                                    :label="user.full_name"
                                    :value="user.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
                    <br> <p></p>
                    <el-row>
                        <div align="right">
                            <el-button type="danger" @click="getTitles(), resetForm()">Cancelar</el-button>
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
                        <el-form-item label="Determinante"
                                      prop="determinant"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="editRegisterDialog"
                                placeholder="Determinante"
                                v-model="catalogEditForm.determinant"
                                maxlength="100"
                                clearable>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Tipo de adscripción"
                                      prop="cat_type_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select v-if="editRegisterDialog"
                                       @change="typeEditUnits(catalogEditForm.cat_type_id)"
                                       style="width: 100%;"
                                       size="medium"
                                       v-model="catalogEditForm.cat_type_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(type , index) in types"
                                    :key="index"
                                    :label="type.name"
                                    :value="type.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item v-if="catalogEditForm.cat_type_id === 1 || catalogEditForm.cat_type_id === 5 || catalogEditForm.cat_type_id === 7 || catalogEditForm.cat_type_id === 8 || catalogEditForm.cat_type_id === 9"
                                      label="Nombre"
                                      prop="name"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    { type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.,\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="editRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogEditForm.name"
                                maxlength="100"
                                clearable>
                                <template v-if="catalogEditForm.cat_type_id === 2 || catalogEditForm.cat_type_id === 3"
                                          slot="prepend">{{nameUnit}}</template>
                                <template v-if="catalogEditForm.cat_type_id === 4 || catalogEditForm.cat_type_id === 6"
                                          slot="append">{{nameUnit}}</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item v-if="catalogEditForm.cat_type_id === 2 || catalogEditForm.cat_type_id === 3|| catalogEditForm.cat_type_id === 4 || catalogEditForm.cat_type_id === 6"
                                      label="Nombre"
                                      prop="specialName"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    { type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.,\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="editRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogEditForm.specialName"
                                maxlength="100"
                                clearable>
                                <template v-if="catalogEditForm.cat_type_id === 2 || catalogEditForm.cat_type_id === 3"
                                          slot="prepend">{{nameUnit}}</template>
                                <template v-if="catalogEditForm.cat_type_id === 4 || catalogEditForm.cat_type_id === 6"
                                          slot="append">{{nameUnit}}</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Responsable de unidad"
                                      prop="cat_responsible_id"
                                      :rules="[
                                    { required: false, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select v-if="editRegisterDialog"
                                       style="width: 100%;"
                                       size="medium"
                                       v-model="catalogEditForm.cat_responsible_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(user , index) in users"
                                    :key="index"
                                    :label="user.full_name"
                                    :value="user.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Usuario"
                                      prop="cat_user_id"
                                      :rules="[
                                    { required: false, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select v-if="editRegisterDialog"
                                       style="width: 100%;"
                                       size="medium"
                                       v-model="catalogEditForm.cat_user_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(user , index) in users"
                                    :key="index"
                                    :label="user.full_name"
                                    :value="user.id">
                                </el-option>
                            </el-select>
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

                nameUnit: '',
                elements: [],

                search: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                catalogForm: {
                    newRegisterName: '',
                    determinant: '',
                    cat_type_id: [],
                    cat_responsible_id: null,
                    cat_user_id: null
                },
                catalogEditForm:{
                    name: '',
                    determinant: '',
                    cat_type_id: [],
                    specialName: '',
                    cat_responsible_id: null,
                    cat_user_id: null
                },
                types:[],
                sections:[],
                users:[],
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
            this.getSections();
            axios.get('/api/cats/create').then(response => {
                this.sections = response.data.sections;
                this.types = response.data.types;
                this.users = response.data.users;
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
                        cat: 1}
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
                this.specialName = null;

                if (this.catalogForm.cat_type_id === 4 || this.catalogForm.cat_type_id === 6)
                {
                    this.specialName = this.catalogForm.newRegisterName;
                    this.catalogForm.newRegisterName = this.catalogForm.newRegisterName + ', ' + this.nameUnit;
                }

                if (this.catalogForm.cat_type_id === 2 ||this.catalogForm.cat_type_id === 3)
                {
                    this.specialName = this.catalogForm.newRegisterName;
                    this.catalogForm.newRegisterName = this.nameUnit + ' ' + this.catalogForm.newRegisterName;
                }

                let data = {
                    cat: 1,
                    name: this.catalogForm.newRegisterName,
                    specialName: this.specialName,
                    determinant: this.catalogForm.determinant,
                    cat_type_id: this.catalogForm.cat_type_id,
                    cat_responsible_id: this.catalogForm.cat_responsible_id,
                    cat_user_id: this.catalogForm.cat_user_id
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

                if (row.cat_type_id === 2 || row.cat_type_id === 3){
                    this.nameUnit = 'Delegación'
                }
                if (row.cat_type_id === 4){
                    this.nameUnit = 'Embajada'
                }
                if (row.cat_type_id === 6){
                    this.nameUnit = 'Delegación permanente'
                }

                this.catalogEditForm = {
                    id:row.hash,
                    name:row.name,
                    determinant: row.determinant,
                    specialName: row.specialName,
                    cat_type_id: row.cat_type_id,
                    cat_responsible_id: row.cat_responsible_id,
                    cat_user_id: row.cat_user_id
                };
                this.editRegisterDialog = true;
            },

            editRegister() {
                this.startLoading();

                if (this.catalogEditForm.specialName == null){
                    this.name = this.catalogEditForm.name
                }
                if (this.catalogEditForm.specialName != null){
                    console.log('specialName va lleno')
                    if (this.catalogEditForm.cat_type_id === 4 || this.catalogEditForm.cat_type_id === 6)
                    {
                        // this.specialName = this.catalogEditForm.specialName;
                        this.catalogEditForm.name = this.catalogEditForm.specialName + ', ' + this.nameUnit;
                    }

                    if (this.catalogEditForm.cat_type_id === 2 ||this.catalogEditForm.cat_type_id === 3)
                    {
                        // this.specialName = this.catalogForm.newRegisterName;
                        this.catalogEditForm.name = this.nameUnit + ' ' + this.catalogEditForm.specialName;
                    }

                }

                let data = {
                    id: this.catalogEditForm.id,
                    cat: 1,
                    name: this.catalogEditForm.name,
                    specialName: this.catalogEditForm.specialName,
                    determinant: this.catalogEditForm.determinant,
                    cat_type_id: this.catalogEditForm.cat_type_id,
                    cat_responsible_id: this.catalogEditForm.cat_responsible_id,
                    cat_user_id: this.catalogEditForm.cat_user_id
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

                let data ={id: id, cat: 1};

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

                let data ={id: id, cat: 1};

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
            getSections() {
                let data = { params: {
                        allSections:true,
                        cat: 2}
                };
                axios.get('/api/cats/get-cat', data).then(response => {
                    this.cats.section_all = response.data;
                }).catch(error => {

                });
            },
            nameSections(data){
                let section_all = [];
                data.forEach(element => section_all.push(' '+element.name));
                let aux = section_all.toString();
                return aux;
            },
            typeUnits(data){

                if (data === 2 || data === 3){
                    this.nameUnit = 'Delegación'
                }
                if (data === 4){
                    this.nameUnit = 'Embajada'
                }
                if (data === 6){
                    this.nameUnit = 'Delegación permanente'
                }
            },

            typeEditUnits(data){

                if (data === 2 || data === 3){
                    this.nameUnit = 'Delegación';
                    this.catalogEditForm.name = null;
                }
                if (data === 4){
                    this.nameUnit = 'Embajada';
                    this.catalogEditForm.name = null;
                }
                if (data === 6){
                    this.nameUnit = 'Delegación permanente';
                    this.catalogEditForm.name = null;
                }
                else{
                    this.catalogEditForm.specialName = null;
                    this.catalogEditForm.name = null;
                }
            },
        },
    }
</script>

