<template>
    <div>
        <header-section icon="el-icon-document" title="Serie documental">
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
                        placeholder="Buscar por serie documental o código"
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
                        width="600">
                        <template slot-scope="scope">
                            {{nameUnits(scope.row.administrative)}}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="section.name"
                        label="Sección documental">
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="Serie documental">
                    </el-table-column>
                    <el-table-column
                        prop="code"
                        label="Código"
                        width="90">
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
<!--            <pre>{{catalogForm.newCode}}</pre>-->
            <el-form  ref="catalogForm" :model="catalogForm" label-width="120px" label-position="top">
                <el-row :gutter="10">
                    <el-col  :span="24">
                        <el-form-item label="Unidad administrativa"
                                      prop="cat_administrative_unit_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-select v-model="catalogForm.cat_administrative_unit_id"
                                       clearable
                                       filterable placeholder="Seleccionar"
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
                    <el-col :span="12">
                        <el-form-item label="Sección documental"
                                      prop="cat_section_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select @change="determinante(catalogForm.cat_section_id)"
                                       style="width: 100%;"
                                       size="medium"
                                       v-model="catalogForm.cat_section_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(section , index) in sections"
                                    :key="index"
                                    :label="section.name"
                                    :value="section.id">
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
                                <template slot="prepend">{{codeSection}}</template>
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
                    <el-col :span="12">
                        <el-form-item label="Archivo de trámite"
                                      prop="AT"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'number', required: false, pattern: /^[0-9.\s]+$/, message: 'El campo no puede llevar letras ni caracteres especiales', trigger: 'change'}
                                    ]">
                            <el-input-number
                                v-model="catalogForm.AT"
                                style="width: 100%"
                                controls-position="right"
                                @change="handleChange"
                                :min="1"
                                :max="100">
                            </el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Archivo de concentración"
                                      prop="AC"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'number', required: false, pattern: /^[0-9.\s]+$/, message: 'El campo no puede llevar letras ni caracteres especiales', trigger: 'change'}
                                    ]">
                            <el-input-number
                                v-model="catalogForm.AC"
                                style="width: 100%"
                                controls-position="right"
                                @change="handleChange"
                                :min="1"
                                :max="100">
                            </el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Técnicas de selección"
                                      prop="cat_selection_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select style="width: 100%;"
                                       size="medium"
                                       v-model="catalogForm.cat_selection_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(selection , index) in selections"
                                    :key="index"
                                    :label="selection.name"
                                    :value="selection.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Valores primarios"
                                      prop="cat_primary_value_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-select v-model="catalogForm.cat_primary_value_id"
                                       filterable placeholder="Seleccionar"
                                       remove-tag="remove-tag"
                                       multiple
                                       style="width: 100%">
                                <el-option
                                    v-for="(value , index) in values"
                                    :key="index"
                                    :label="value.name"
                                    :value="value.id">
                                </el-option>
                            </el-select>
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
                    <el-col  :span="24">
                        <el-form-item label="Unidad administrativa"
                                      prop="administrative"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-select v-if="editRegisterDialog"
                                       v-model="catalogEditForm.administrative"
                                       clearable
                                       filterable placeholder="Seleccionar"
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
                    <el-col :span="12">
                        <el-form-item label="Sección documental"
                                      prop="cat_section_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select v-if="editRegisterDialog"
                                       @change="determinante(catalogEditForm.cat_section_id)"
                                       style="width: 100%;"
                                       size="medium"
                                       v-model="catalogEditForm.cat_section_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(section , index) in sections"
                                    :key="index"
                                    :label="section.name"
                                    :value="section.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Codigo"
                                      prop="codeSeries"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[0-9.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales ni letras', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="editRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogEditForm.codeSeries"
                                maxlength="3"
                                show-word-limit
                                clearable>
                                <template slot="prepend">{{codeEditSection}}</template>
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
                    <el-col :span="12">
                        <el-form-item label="Archivo de trámite"
                                      prop="AT"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'number', required: false, pattern: /^[0-9.\s]+$/, message: 'El campo no puede llevar letras ni caracteres especiales', trigger: 'change'}
                                    ]">
                            <el-input-number
                                v-if="editRegisterDialog"
                                v-model="catalogEditForm.AT"
                                style="width: 100%"
                                controls-position="right"
                                @change="handleChange"
                                :min="1"
                                :max="100">
                            </el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Archivo de concentración"
                                      prop="AC"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'number', required: false, pattern: /^[0-9.\s]+$/, message: 'El campo no puede llevar letras ni caracteres especiales', trigger: 'change'}
                                    ]">
                            <el-input-number
                                v-if="editRegisterDialog"
                                v-model="catalogEditForm.AC"
                                style="width: 100%"
                                controls-position="right"
                                @change="handleChange"
                                :min="1"
                                :max="100">
                            </el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Técnicas de selección"
                                      prop="cat_selection_id"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    ]">
                            <el-select v-if="editRegisterDialog"
                                       style="width: 100%;"
                                       size="medium"
                                       v-model="catalogEditForm.cat_selection_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(selection , index) in selections"
                                    :key="index"
                                    :label="selection.name"
                                    :value="selection.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Valores primarios"
                                      prop="primarivalues"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-select v-if="editRegisterDialog"
                                       v-model="catalogEditForm.primarivalues"
                                       filterable placeholder="Seleccionar"
                                       remove-tag="remove-tag"
                                       multiple
                                       style="width: 100%">
                                <el-option
                                    v-for="(value , index) in values"
                                    :key="index"
                                    :label="value.name"
                                    :value="value.id">
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
                units: [],
                values: [],
                newCodeComplete: '',
                codeSection: '',
                codeEditSection: '',
                sections: [],
                selections: [],
                elements: [],

                search: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                catalogForm: {
                    newRegisterName: '',
                    cat_section_id: [],
                    newCode: '',
                    AT: '',
                    AC: '',
                    cat_selection_id: [],
                    cat_primary_value_id: [],
                    cat_administrative_unit_id: []
                },
                catalogEditForm:{
                    administrative: [],
                    name: '',
                    cat_section_id: [],
                    codeSeries: '',
                    AT: '',
                    AC: '',
                    cat_selection_id: [],
                    primarivalues: []
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
                this.sections = response.data.sections;
                this.selections = response.data.selections;
                this.units = response.data.units;
                this.values = response.data.values;
                this.stopLoading();
            })
        },

        watch:{
            search(neew,old){
                return this.search = this.Search(neew);
            }
        },


        methods: {

            handleChange(value) {

            },

            // codes(data){
            //     console.log('data', data);
            //     this.catalogForm.newCode = this.codeSection + data;
            //     console.log('resultadooooooooooo', this.catalogForm.newCode);
            // },

            determinante(data){

                console.log('wwwwwwwwww', data);
                let sections = [];
     //           console.log('secciones', this.sections);
     //           this.catalogForm.newCode = '';
                const result = this.sections.filter(section => section.id === data);
                console.log('result', result);
                this.codeSection = result[0].code + '.';
                this.codeEditSection = result[0].code + '.';

            },

            Search(search){
                let re = new RegExp(/((&lt;\/script|\<|\>|script&gt;|&lt;script|script|<script|&lt;xml|<xml)|(\?&gt;|\?>|&lt;\?xml|(&lt;\?php|\<php|&lt;php|&lt;\?)|java|xss|htaccess)|(["&/=¨´%$¿?|#!¡+_{}^*'`\[\]]))/,'igm');
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
                        cat: 3}
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

                this.newCodeComplete = this.codeSection + this.catalogForm.newCode;
                this.catalogForm.total = this.catalogForm.AT + this.catalogForm.AC;

                let data = {
                    cat: 3,
                    name: this.catalogForm.newRegisterName,
                    codeSeries: this.catalogForm.newCode,
                    code: this.newCodeComplete,
                    cat_section_id: this.catalogForm.cat_section_id,
                    AT: this.catalogForm.AT,
                    AC: this.catalogForm.AC,
                    total: this.catalogForm.total,
                    cat_selection_id: this.catalogForm.cat_selection_id,
                    cat_primary_value_id: this.catalogForm.cat_primary_value_id,
                    cat_administrative_unit_id: this.catalogForm.cat_administrative_unit_id
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
                                this.catalogForm.newCode = '';
                                this.catalogForm.cat_section_id = [];
                                this.catalogForm.AT = '';
                                this.catalogForm.AC = '';
                                this.catalogForm.total = '';
                                this.catalogForm.cat_selection_id = [];
                                this.catalogForm.cat_primary_value_id = [];

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

                let section = [];
                const result = row.section.code;
                this.codeEditSection = result + '.';

                let administrative = [];
                row.administrative.forEach(element => administrative.push(element.id));
                let primarivalues = [];
                row.primarivalues.forEach(element => primarivalues.push(element.id));
                this.catalogEditForm = {
                    id:row.hash,
                    name:row.name,
                    cat_section_id: row.cat_section_id,
                    codeSeries: row.codeSeries,
                    AT: row.AT,
                    AC: row.AC,
                    cat_selection_id: row.cat_selection_id,
                    primarivalues: primarivalues,
                    administrative: administrative,

                };
                this.editRegisterDialog = true;
            },

            editRegister() {
                this.startLoading();

                this.newCodeComplete = this.codeEditSection + this.catalogEditForm.codeSeries;
                this.catalogEditForm.total = this.catalogEditForm.AT + this.catalogEditForm.AC;

                let data = {
                    id: this.catalogEditForm.id,
                    cat: 3,
                    name: this.catalogEditForm.name,
                    codeSeries: this.catalogEditForm.codeSeries,
                    code: this.newCodeComplete,
                    cat_section_id: this.catalogEditForm.cat_section_id,
                    AT: this.catalogEditForm.AT,
                    AC: this.catalogEditForm.AC,
                    total: this.catalogEditForm.total,
                    cat_selection_id: this.catalogEditForm.cat_selection_id,
                    cat_primary_value_id: this.catalogEditForm.primarivalues,
                    cat_administrative_unit_id: this.catalogEditForm.administrative
                };

                // let data = {id: this.catalogEditForm.id, cat: 4, name: this.catalogEditForm.name};

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
                this.codeSection = '';
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

                let data ={id: id, cat: 3};

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

                let data ={id: id, cat: 3};

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
        },
    }
</script>

