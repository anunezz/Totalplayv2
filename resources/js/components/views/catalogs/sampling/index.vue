<template>
    <div>
        <header-section icon="el-icon-document" title="CDD">
            <template slot="buttons">
                <el-col :span="5" :offset="5">
                    <el-button type="success" @click="newCatalog" style="width: 100%">
                        Nuevo registro
                    </el-button>
                </el-col>
                <el-col :span="13" :offset="1">
                    <el-input
                        clearable
                        suffix-icon="fas fa-search"
                        placeholder="Buscar por cualidad y código de clasificación"
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
<!--        <pre>{{results}}</pre>-->

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
                        prop="cat_series_id"
                        label="Documental">
                        <template slot-scope="scope">
                            {{ scope.row.cat_series_id ? 'Serie documental' : 'Subserie documental' }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="quality"
                        label="Cualidad">
                        <template slot-scope="scope">
                            <span v-html="scope.row.format_rec"></span>
                        </template>
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
<!--                    <pre>{{this.catalogForm.newRegisterName}}</pre>-->
            <el-form ref="catalogForm" :model="catalogForm" label-width="120px" label-position="top">
                <el-row :gutter="10">
                    <el-col :span="12">
                        <el-form-item label="Documental" prop="type_documentary" :rules="[
                                                { required: true, message: 'Este campo es requerido', trigger: ['blur','change']},
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
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change']},
                                    ]">
                            <el-select style="width: 100%;"
                                       size="medium"
                                       v-model="catalogForm.cat_series_id"
                                       placeholder="Seleccionar">
                                <el-option
                                    v-for="(serie , index) in results"
                                    :key="index"
                                    :label="serie.full_name"
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
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change']},
                                  ]">
                            <el-select v-model="catalogForm.cat_subserie_id"
                                       filterable placeholder="Seleccionar"
                                       remove-tag="remove-tag"
                                       multiple
                                       style="width: 100%">
                                <el-option
                                    v-for="(sub , index) in lresults"
                                    :key="index"
                                    :label="sub.full_name"
                                    :value="sub.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>

<!--                    <el-col :span="24">-->
<!--                        <el-form-item label="Cualidad"-->
<!--                                      prop="newRegisterName"-->
<!--                                      :rules="[-->
<!--                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},-->
<!--                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}-->
<!--                                  ]">-->
<!--                            <el-input-->
<!--                                v-if="newRegisterDialog"-->
<!--                                type="textarea"-->
<!--                                :rows="6"-->
<!--                                placeholder="Cualidad"-->
<!--                                v-model="catalogForm.newRegisterName"-->
<!--                                maxlength="100"-->
<!--                                clearable>-->
<!--                            </el-input>-->
<!--                        </el-form-item>-->
<!--                    </el-col>-->

                    <el-col :span="24" style="padding: 11px">
                        <el-form-item label="Cualidad"
                                      prop="newRegisterName"
                                      :rules="[{ validator: description, trigger: ['blur','change'] }]">
                            <tinymce id="d1" v-model="newRegisterName" :other_options="tinyOptions"></tinymce>
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
<!--                    <pre>{{this.catalogEditForm.quality}}</pre>-->
                    <el-form ref="catalogEditForm" :model="catalogEditForm" label-width="120px" label-position="top">
                        <el-row :gutter="10">
                            <el-col :span="12">
                                <el-form-item label="Documental" prop="type_documentary" :rules="[
                                                { required: true, message: 'Este campo es requerido', trigger: ['blur','change']},
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
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change']},
                                    ]">
                                    <el-select v-if="editRegisterDialog"
                                               style="width: 100%;"
                                               size="medium"
                                               v-model="catalogEditForm.cat_series_id"
                                               placeholder="Seleccionar">
                                        <el-option
                                            v-for="(serie , index) in series"
                                            :key="index"
                                            :label="serie.full_name"
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
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change']},
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
                                            :label="sub.full_name"
                                            :value="sub.id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
<!--                            <el-col :span="24">-->
<!--                                <el-form-item label="Descripción"-->
<!--                                              prop="quality"-->
<!--                                              :rules="[-->
<!--                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},-->
<!--                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}-->
<!--                                  ]">-->
<!--                                    <el-input-->
<!--                                        v-if="editRegisterDialog"-->
<!--                                        type="textarea"-->
<!--                                        :rows="8"-->
<!--                                        placeholder="Descripción"-->
<!--                                        v-model="catalogEditForm.quality"-->
<!--                                        maxlength="100"-->
<!--                                        clearable>-->
<!--                                    </el-input>-->
<!--                                </el-form-item>-->
<!--                            </el-col>-->

                            <el-col :span="24" style="padding: 11px">
                                <el-form-item label="Cualidad"
                                              prop="quality"
                                              :rules="[{ validator: editDescription, trigger: ['blur','change'] }]">
                                    <tinymce id="d2" v-model="quality" :other_options="tinyOptions"></tinymce>
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
           //     activeReset:false,
                validMessage:true,
                serie: false,
                subserie: false,
                results: [],
                lresults: [],
                series: [],
                subseries: [],
                elements: [],

                search: '',
                newRegisterName: '',
                quality: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                catalogForm: {
                    newRegisterName: '',
                    cat_series_id: null,
                    cat_subserie_id: null,
                    type_documentary: null,
                },
                catalogEditForm:{
                    quality: '',
                    cat_series_id: null,
                    subserie: null,
                    type_documentary: null,
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

                tinyOptions: {
                    language_url: '/js/tiny_es_MX.js',
                    indent_use_margin: true,
                    forced_root_block_attrs: {
                        "style": "font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal"
                    },
                    menubar: '',
                    statusbar: false,
                    branding: false,
                    min_height: 150,
                    browser_spellcheck: true,
                    font_formats: 'Montserrat=Montserrat;Soberana Sans=Soberana Sans;Arial=arial,helvetica,sans-serif;Times New Roman=Times New Roman, Times, serif;',
                    setup: function (ed) {
                        ed.settings.paste_postprocess = function (pl, o) {
                            ed.dom.setAttrib(ed.dom.select('li', o.node), 'style', 'font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal');
                            ed.dom.setAttrib(ed.dom.select('p', o.node), 'style', 'font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal');
                        }
                    },
                    paste_as_text: true,
                    paste_text_sticky: true,
                    paste_text_sticky_default: true,
                    toolbar1: 'bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  ',
                    toolbar2: "",
                    plugins: [
                        'paste'
                    ]
                },
            }
        },

        created() {
            this.getTitles();
            axios.get('/api/cats/create').then(response => {
                this.series = response.data.series;
                this.subseries = response.data.subseries;
                this.results = response.data.results;
                this.lresults = response.data.lresults;
                this.stopLoading();
            })
        },
        mounted() {
          //  this.editRegisterDialog = false;
        },

        watch:{
            search(neew,old){
                return this.search = this.Search(neew);
            },
            newRegisterName(text){
                this.catalogForm.newRegisterName = text;
                return this.description()
            },
            quality(text){
                this.catalogEditForm.quality = text;
                return this.editDescription()
            }
        },


        methods: {
            description(rule, value, callback){

                if(rule === undefined){
                    this.$refs['catalogForm'].validate(() => {});
                }
                else {
                    value = value.trim();
                    let exp = new RegExp(/((<script|<xml|\?>|<\?xml|(<\?php|<\?)|java|xss|htaccess|&lt;)|([%$¿?|#!¡+_{}^*'`\[\]]))/,'igm');

                    if(!value) {
                        this.validMessage = false;
                        return callback(new Error('Este campo es requerido'));
                    }else{
                        if( exp.test(value) ){
                            this.validMessage = false;
                            return callback(new Error('Este campo no puede contener caracteres especiales'));
                        } else {
                            this.validMessage = true;
                            return callback();

                        }
                    }
                }

            },

            editDescription(rule, value, callback){

                if(rule === undefined){
                    this.$refs['catalogEditForm'].validate(() => {});
                }
                else {
                    value = value.trim();
                    let exp = new RegExp(/((<script|<xml|\?>|<\?xml|(<\?php|<\?)|java|xss|htaccess|&lt;)|([%$¿?|#!¡+_{}^*'`\[\]]))/,'igm');

                    if(!value) {
                        this.validMessage = false;
                        return callback(new Error('Este campo es requerido'));
                    }else{
                        if( exp.test(value) ){
                            this.validMessage = false;
                            return callback(new Error('Este campo no puede contener caracteres especiales'));
                        } else {
                            this.validMessage = true;
                            return callback();

                        }
                    }
                }

            },

            Search(search){
                let re = new RegExp(/((&lt;\/script|\<|\>|script&gt;|&lt;script|script|<script|&lt;xml|<xml)|(\?&gt;|\?>|&lt;\?xml|(&lt;\?php|\<php|&lt;php|&lt;\?)|java|xss|htaccess)|(["&=¨´%$¿?|#!¡+_{}^*'`\[\]]))/,'igm');
                if(re.test(search)){
                    return search.replace(re, '');
                }else{
                    return search;
                }
            },

            getSeries() {
                axios.get('/api/cats/create').then(response => {
                    this.series = response.data.series;
                    this.results = response.data.results;
                    this.stopLoading();
                })
            },


            getTitles(currentPage =  1) {
                this.startLoading();

                let data = { params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        search: this.search,
                        cat: 6}
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

                let data = {
                    cat: 6,
                    quality: this.catalogForm.newRegisterName,
                    cat_series_id: this.catalogForm.cat_series_id,
                    cat_subserie_id: this.catalogForm.cat_subserie_id,
                    aux: 1
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
                                this.catalogForm.type_documentary = null;
                                this.catalogForm.cat_series_id = null;
                                this.catalogForm.cat_subserie_id = null;
                                this.serie = null;
                                this.subserie = null;
                                this.newRegisterDialog = false;
                                this.getTitles();
                                this.getSeries();
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
           //     this.activeReset = true;
                this.serie = true
                this.subserie = false
                if (row.cat_series_id == null){
                    this.subserie = true
                    this.serie = false
                }
                let subserie = []
                row.subserie.forEach(element => subserie.push(element.id));
                this.quality = row.quality
                this.catalogEditForm = {
                    id:row.hash,
                    cat_series_id:row.cat_series_id,
                    quality:this.quality,
                    subserie: subserie,
                    type_documentary: 1
                };
                this.editRegisterDialog = true;
            },

            editRegister() {
                this.startLoading();

                let data = {
                    id: this.catalogEditForm.id,
                    cat: 6,
                    quality: this.catalogEditForm.quality,
                    cat_series_id: this.catalogEditForm.cat_series_id,
                    cat_subserie_id: this.catalogEditForm.subserie,
                    aux: 1
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

                let data ={id: id, cat: 6};

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

                let data ={id: id, cat: 6};

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
              //  if (this.activeReset)
                this.$refs['catalogEditForm'].resetFields();
            },
            typeDocumentary(type){
                if (!this.serie && !this.subserie){
                    this.catalogForm.type_documentary = null;
                    this.catalogForm.cat_series_id = null;
                    this.catalogForm.cat_subserie_id = null;
                }
                if (type===2 && this.subserie===true){
                    this.serie = false;
                    this.catalogForm.cat_series_id = null;
                    this.catalogForm.type_documentary = type;
                }
                if (type === 1 && this.serie===true){
                    this.subserie = false;
                    this.catalogForm.cat_subserie_id = null;
                    this.catalogForm.type_documentary = type;
                }
            },
            typeEditDocumentary(type){
                if (!this.serie && !this.subserie){
                    this.catalogEditForm.type_documentary = null;
                    this.catalogEditForm.cat_series_id = null;
                    this.catalogEditForm.subserie = null;
                }
                if (type===2 && this.subserie===true){
                    this.serie = false;
                    this.catalogEditForm.cat_series_id = null;
                    this.catalogEditForm.type_documentary = type;
                }
                if (type === 1 && this.serie===true){
                    this.subserie = false;
                    this.catalogEditForm.subserie = null;
                    this.catalogEditForm.type_documentary = type;
                }
            },
        },
    }
</script>

