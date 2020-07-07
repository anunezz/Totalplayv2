<template>
    <div>
        <el-backtop :visibility-height="500"/>
        <header-section icon="fa-edit" title="Editar recomendación">
            <template slot="buttons">
                <el-button
                    size="medium"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/recomendaciones')">
                    Regresar
                </el-button>
            </template>
        </header-section>
        <el-tabs ref="activeTabs" type="border-card">
            <el-tab-pane label="Recomendación">
                <el-form ref="recommendationForm" :model="recommendationForm" label-width="120px" label-position="top" >
                    <el-row type="flex" class="row-bg" justify="end">
                        <strong class="folio"><b>Folio: {{recommendationForm.invoice}}</b></strong>
                    </el-row>
                    <el-row :gutter="10">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-form-item label="Texto de recomendación"
                                          prop="recommendation"
                                          :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                  ]">
                                <tinymce
                                    id="recomendations"
                                    :other_options="tinyOptions"
                                    v-model="recommendationForm.recommendation"/>
                            </el-form-item>
                        </el-col>

                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8">
                            <el-form-item label="Año de registro"
                                          prop="date"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-date-picker
                                    v-model="recommendationForm.date"
                                    type="year"
                                    style="width: 100%"
                                    value-format="yyyy"
                                    placeholder="Seleccione año">
                                </el-date-picker>

                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8">
                            <el-form-item label="¿La recomendación esta vigente?"
                                          prop="validity"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select v-model="recommendationForm.validity" clearable placeholder="Seleccionar" style="width: 100%">
                                    <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>

                        <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8">
                            <el-form-item label="¿Es dirigida al Estado Mexicano?"
                                          prop="directed"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select v-model="recommendationForm.directed" clearable placeholder="Seleccionar" style="width: 100%">
                                    <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                            <el-form-item label="Entidad Emisora"
                                          prop="cat_entity_id"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_entity_id"
                                    filterable
                                    placeholder="Seleccionar"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(entitie, index) in entities"
                                        :key="index"
                                        :label="entitie.name"
                                        :value="entitie.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                            <el-form-item label="Poder de Gobierno"
                                          prop="cat_gob_power_id"
                                          :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                  ]">
                                <el-select
                                    v-model="recommendationForm.cat_gob_power_id"
                                    filterable
                                    multiple
                                    placeholder="Seleccionar"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(power, index) in powers"
                                        :key="index"
                                        :label="power.name"
                                        :value="power.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-form-item label="Autoridadad"
                                          prop="cat_attendig_id"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_attendig_id"
                                    filterable
                                    multiple
                                    :multiple-limit="5"
                                    placeholder="Seleccionar"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(attending, index) in attendings"
                                        :key="index"
                                        :label="attending.name"
                                        :value="attending.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-form-item label="Acción Solicitada"
                                          prop="cat_solidarity_action_id"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_solidarity_action_id"
                                    filterable
                                    multiple
                                    placeholder="Seleccionar"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(action, index) in actions"
                                        :key="index"
                                        :label="action.name"
                                        :value="action.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                            <el-form-item label="Personas o Grupos Específicos"
                                          prop="cat_population_id"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_population_id"
                                    filterable
                                    multiple
                                    placeholder="Seleccionar"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(population, index) in populations"
                                        :key="index"
                                        :label="population.name"
                                        :value="population.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                            <el-form-item label="Orden de Gobierno"
                                          prop="cat_gob_order_id"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_gob_order_id"
                                    filterable
                                    multiple
                                    placeholder="Seleccionar"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(order, index) in orders"
                                        :key="index"
                                        :label="order.name"
                                        :value="order.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-divider></el-divider>
                    <el-row>
                        <el-tabs tab-position="left" style="padding: 25px">
                            <el-tab-pane label="Derechos">
                                <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                                    <el-input
                                        prefix-icon="el-icon-search"
                                        placeholder="Buscar"
                                        size="medium"
                                        v-model="filterRights">
                                    </el-input>
                                    <el-form-item prop="listRights" :rules="[
                                        { required: true, message: 'Debes seleccionar al menos un derecho', trigger:'blur'},
                                      ]">
                                        <el-tree
                                            id="rightsE"
                                            ref="rights"
                                            :data="rights"
                                            show-checkbox
                                            node-key="id"
                                            :props="defaultProps"
                                            :filter-node-method="filterNode"
                                            :default-checked-keys="showIds"
                                            @check="rightsTree">
                                        </el-tree>
                                    </el-form-item>
                                </el-col>
                            </el-tab-pane>
                            <el-tab-pane label="Temas">
                                <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                                    <el-input
                                        prefix-icon="el-icon-search"
                                        placeholder="Buscar"
                                        size="medium"
                                        v-model="filterTopics">
                                    </el-input>
                                    <el-form-item prop="listThemes">
                                        <el-tree
                                            id="topicsE"
                                            ref="tree"
                                            :data="topics"
                                            show-checkbox
                                            :check-strictly="true"
                                            node-key="id"
                                            :props="defaultTopics"
                                            :filter-node-method="filterTopic"
                                            :default-checked-keys="showIde"
                                            @check="themesTree">
                                        </el-tree>
                                    </el-form-item>
                                </el-col>
                            </el-tab-pane>
                            <el-tab-pane label="ODS">
                                <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                                    <el-input
                                        prefix-icon="el-icon-search"
                                        placeholder="Buscar"
                                        size="medium"
                                        v-model="filterGoalsOds">
                                    </el-input>
                                    <el-form-item prop="listGoalsOds" :rules="[
                                        { required: true, message: 'Debes seleccionar al menos un ODS', trigger:'blur'},
                                      ]">
                                        <el-tree
                                            id="goalsOds"
                                            ref="goalsOds"
                                            :data="goalsOds"
                                            show-checkbox
                                            node-key="id"
                                            :props="defaultProps"
                                            :filter-node-method="filterNode"
                                            :default-checked-keys="showOdsIds"
                                            @check="goalsOdsTree">
                                        </el-tree>
                                    </el-form-item>
                                </el-col>
                            </el-tab-pane>
                        </el-tabs>
                    </el-row>
                    <br>
                    <el-divider></el-divider>
                    <el-row style="margin-bottom: 10px">
                        <strong><b>Documentos</b></strong>
                    </el-row>
                    <transfer-document v-if="showTransfer" :items="recommendationForm"/>
                    <el-divider></el-divider>
                    <el-row :gutter="10">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-form-item label="Nombre oficial del reporte"
                                          prop="comments"
                                          :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                  ]">
                                <tinymce id="comments" :other_options="tinyOptions" v-model="recommendationForm.comments"/>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
                <el-row type="flex" class="row-bg" justify="end">
                    <el-col :xs="24" :sm="3" :md="3" :lg="3" :xl="3">
                        <el-button type="primary" @click="validForm('1')">
                            Siguiente
                            <i class="el-icon-arrow-right"/>
                        </el-button>
                    </el-col>
                </el-row>
            </el-tab-pane>
            <el-tab-pane label="Acciones reportadas">
                <el-button style="margin-top: 20px;" type="primary" icon="fas fa-plus-circle" @click="newReport(1)"> Agregar</el-button>
                <reported-action :items="reportedAction" :typeAction="editReport" @addReport="addReport"/>
                <el-form style="margin-top: 50px" label-width="120px" label-position="top" >
                    <el-divider content-position="left">
                        <strong :class="{acction : reportedAct.length>0  }" style=" background: #fc0203; color: white;padding: 2px; border-radius: 5px">
                            <b>{{reportedAct.length}}</b>
                        </strong> Acciones agregadas</el-divider>
                    <el-row style="margin-top: 50px">
                        <el-table
                            :data="reportedAct"
                            border
                            style="width: 100%"
                            v-if="reportedAct.length>0">
                            <el-table-column
                                prop="invoice"
                                label="Folio"
                                width="250">
                            </el-table-column>
                            <el-table-column
                                label="Tipo de acción reportada">
                                <template slot-scope="scope">
                                    <div v-for="action in typeAcction(scope.row.cat_solidarity_action_id)">
                                        <span class="badge">{{action}}</span>
                                    </div>
                                </template>
                            </el-table-column>
                            <el-table-column
                                label="Autoridad encargada de atender">
                                <template slot-scope="scope">
                                    <div v-for="attending in typeAttendings(scope.row.cat_attendig_id)">
                                        <span class="badge">{{attending}}</span>
                                    </div>
                                </template>
                            </el-table-column>
                            <el-table-column
                                label="Acciones" width="200">
                                <template slot-scope="scope">
                                    <el-button
                                        size="mini"
                                        @click="handleEdit(scope.$index, scope.row)">
                                        Editar
                                    </el-button>
                                    <el-button
                                        size="mini"
                                        type="danger"
                                        @click="deleteReportedAction(scope.row.id)">
                                        Eliminar
                                    </el-button>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-row>
                </el-form>
                <el-row style="margin-top: 50px" type="flex" class="row-bg" justify="end">
                    <el-col :xs="24" :sm="3" :md="3" :lg="3" :xl="3">
                        <el-button type="primary" @click="validForm('2')">
                            Siguiente
                            <i class="el-icon-arrow-right"/>
                        </el-button>
                    </el-col>
                </el-row>
            </el-tab-pane>
            <el-tab-pane label="Control de datos">
                <el-form ref="evaluationAct" :model="recommendationForm" label-width="120px" label-position="top" >
                    <action-evaluation v-if="showEvaluation" :items="recommendationForm.dataControl"/>
                </el-form>
                <el-row :gutter="5" type="flex" class="row-bg" justify="end">
                    <el-col :xs="24" :sm="3" :md="3" :lg="2" :xl="2">
                        <el-button size="medium" type="danger" style="width: 100%" @click="$router.push('/recomendaciones')">Cancelar</el-button>
                    </el-col>
                    <el-col :xs="24" :sm="3" :md="3" :lg="2" :xl="2">
                        <el-button size="medium" type="primary" style="width: 100%" @click="submitForm(false)">Guardar </el-button>
                    </el-col>
                    <el-col :xs="24" :sm="3" :md="3" :lg="2" :xl="2">
                        <el-button size="medium" type="success" style="width: 100%" @click="submitForm(true)">Publicar</el-button>
                    </el-col>
                </el-row>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import actionEvaluation from "./DataControl";

    export default {
        components: {
            HeaderSection,
            actionEvaluation,
        },

        data() {
            return {
                showTransfer:false,
                filterGoalsOds:'',
                filterTopics:'',
                filterRights:'',
                options: [{
                    value: 1,
                    label: 'Si'
                }, {
                    value: 0,
                    label: 'No'
                }],
                showEvaluation:false,
                idReporte:null,
                editReport:null,
                reportedAct:[],
                showIds:[],
                showIde:[],
                showOdsIds:[],

                tree: [],
                // tree: null,
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                defaultTopics: {
                    children: 'children',
                    label: 'name'
                },


                entities: [],
                orders: [],
                powers: [],
                attendings: [],
                rights: [],
                populations: [],
                actions: [],
                reviews: [],
                topics: [],
                goalsOds:[],
                //   subtopics: [],
                dates: [],


                props: {
                    label: 'name',
                    children: 'zones'
                },

                recommendationId: this.$route.params.id,
                apiToken: 'Bearer ' + sessionStorage.getItem('SICAR_token'),

                recommendationForm: {},
                reportedAction:{
                    date:'',
                    cat_solidarity_action_id:null,
                    authority:'',
                    description:'',
                    population:'',
                },

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
            this.startLoading();
            let recommendationId = this.$route.params.id;

            axios.get(`/api/recommendations/${recommendationId}/edit`).then(response => {
                this.entities = response.data.entities;
                this.orders = response.data.orders;
                this.powers = response.data.powers;
                this.attendings = response.data.attendings;
                this.rights = response.data.rights;
                this.populations = response.data.populations;
                this.actions = response.data.actions;
                this.reviews = response.data.reviews;
                this.topics = response.data.topics;
                this.goalsOds = response.data.goalsOds;
                //       this.subtopics = response.data.subtopics;
                this.dates = response.data.dates;
                this.tree = response.data.tree;
                this.recommendationForm = response.data.recommendationForm;
                this.recommendationForm.files = [];
                this.showIds = response.data.showIds;
                this.showIde = response.data.showIde;
                this.showOdsIds = response.data.showOdsIds;
                this.getReportedActions();
                this.showEvaluation=true;
                this.stopLoading();
                this.showTransfer = true;
            }).catch(error => {
                this.stopLoading();

                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });
            this.editReport = 2;
            this.newReport(2);
        },
        watch: {
            filterGoalsOds(val) {
                this.$refs.goalsOds.filter(val);
            },
            filterRights(val) {
                this.$refs.rights.filter(val);
            },
            filterTopics(val) {
                this.$refs.tree.filter(val);
            }
        },
        methods: {
            themesTree(){
                let ide = this.$refs.tree.getCheckedNodes();
                this.recommendationForm.listThemes=[];
                this.recommendationForm.idsTopics=[];
                if (ide.length!==0){
                    let $this = this;
                    ide.forEach(function(el){
                        if(el.cat_topic_id!==undefined){
                            $this.recommendationForm.listThemes.push(el);
                        }
                        if(el.topic_id!==undefined){
                            $this.recommendationForm.idsTopics.push(el.topic_id);
                        }
                    });
                }
            },
            goalsOdsTree(){
                let ide = this.$refs.goalsOds.getCheckedNodes();
                this.recommendationForm.listGoalsOds=[];
                if (ide.length!==0){
                    let $this = this;
                    ide.forEach(function(el){
                        if(el.ods_id!==undefined){
                            $this.recommendationForm.listGoalsOds.push(el);
                        }
                    });
                }
            },
            rightsTree(){
                let ids = this.$refs.rights.getCheckedNodes();
                this.recommendationForm.listRights=[];
                if (ids.length!==0){
                    let $this = this;
                    ids.forEach(function(el) {
                        if (el.add===1){
                            $this.recommendationForm.listRights.push(el);
                        }
                    });
                }
            },
            submitForm(type) {
                this.startLoading();
                let recommendationId = this.$route.params.id;
                this.recommendationForm.recommendation_like = this.recommendationForm.recommendation.replace(/<\/?[^>]+(>|$)|(<([^>]+)>)/ig, "");
                this.$refs['recommendationForm'].validate((valid) => {
                    if (valid) {
                        if (type) this.recommendationForm.isPublished = true;
                        axios.put(`/api/recommendations/${recommendationId}`, this.recommendationForm).then(response => {
                            this.stopLoading();
                            let mensaje = '';
                            if(type){
                                mensaje = "Se actualizo y se publico la información correctamente"
                            }else {
                                mensaje = "Se actualizo la información correctamente"
                            }
                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: mensaje
                            });
                             this.$router.push('/recomendaciones');
                        }).catch(error => {
                            this.stopLoading();

                            this.$message({
                                type: "warning",
                                message: "No fue posible completar la acción, intente nuevamente."
                            });
                        })
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
            newReport(data){
                if (data===1){
                    this.editReport = 200;
                }
                this.reportedAction = {};
                this.reportedAction = {
                    invoice:null,
                    recommendation_id:null,
                    invoiceRe:null,
                    cat_solidarity_action_id:null,
                    cat_population_id:null,
                    date:'',
                    cat_attendig_id:'',
                    description:'',
                    action:1,
                    checked:true,
                };
            },
            addReport(){
                if(this.reportedAction.action===1){
                    var copy = Object.assign({}, this.reportedAction);
                    copy.invoiceRe = this.recommendationForm.invoice;
                    copy.recommendation_id = this.$route.params.id;
                    axios.post('/api/reportedActions', copy).then(response => {
                        this.getReportedActions();
                        this.$message({
                            type: "success",
                            title: 'Éxito',
                            message: "Se almaceno la Acción Reportada con Folio: "+ response.data.folio
                        });
                        this.reportedAction = {};
                    }).catch(error => {
                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    })
                }else {
                    var editReport = Object.assign({}, this.reportedAction);
                    axios.put(`/api/reportedActions/${this.idReporte }`, editReport).then(response => {
                        this.getReportedActions();
                        this.$message({
                            type: "success",
                            title: 'Éxito',
                            message: "Se actualizo y se Publico la información correctamente"
                        });
                        this.reportedAction = {};
                    }).catch(error => {
                        this.stopLoading();

                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    })
                }

            },
            typeAcction(e){
                var listAcction = [];
                let $this = this;
                e.forEach(function(item){
                    var result = $this.actions.filter(action => action.id === item);
                    listAcction.push(result[0].name);
                });
                return listAcction;
            },
            typeAttendings(e){
                var listAttendings = [];
                let $this = this;
                e.forEach(function(item){
                    var result = $this.attendings.filter(attending => attending.id === item);
                    listAttendings .push(result[0].name);
                });
                return listAttendings;
            },
            handleEdit(index, row) {
                this.editReport = 200;
                this.idReporte = row.id;
                this.reportedAction = {
                    invoice:row.invoice,
                    recommendation_id:this.$route.params.id,
                    invoiceRe : this.recommendationForm.invoice,
                    cat_solidarity_action_id:row.cat_solidarity_action_id,
                    cat_population_id:row.cat_population_id,
                    date:row.date,
                    cat_attendig_id:row.cat_attendig_id,
                    description:row.description,
                    action:2,
                    index: index,
                    checked:true
                };
            },
            getReportedActions(){
                axios.get('/api/reportedActions/'+ this.$route.params.id ).then(response => {
                    this.reportedAct = response.data.reportedActions;
                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
            deleteReportedAction(id) {
                this.$confirm('¿Está seguro que quiere eliminar esta acción reportada?',{
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    type: 'warning'
                }).then(() => {
                    axios.delete(`/api/reportedActions/${id}`).then(response => {
                        this.getReportedActions();
                        this.$message({
                            type: "success",
                            title: 'Éxito',
                            message: "Se elimino la acción reportada"
                        });
                        this.reportedAction = {};
                    }).catch(error => {
                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Eliminación cancelada'
                    });
                });
            },
            filterNode(value, data) {
                if (!value) return true;
                return data.label.indexOf(value) !== -1;
            },
            filterTopic(value, data) {
                if (!value) return true;
                return data.name.indexOf(value) !== -1;
            },
            validForm(data){
                if(data === '1'){
                    this.$refs['recommendationForm'].validate((valid) => {
                        if (valid){
                            this.$refs.activeTabs.currentName='1';
                        }
                        else{
                            this.$message({
                                type: "warning",
                                title: 'Error',
                                message: "Complete los campos para continuar"
                            });
                        }
                    });
                }
                if(data==='2'){
                    this.$refs.activeTabs.currentName='2';
                }
            }
        },
    }

</script>

<style>
    .el-upload-dragger { width: 100% !important}
    .el-upload { width: 100% !important;}
    .folio {
        box-shadow: 5px 5px 5px #566573 ;
        padding: 10px;
        background: #F8F9F9;
    }
    .badge {
        background-color: #eeeeef;
        border-radius: 10px;
        padding: 3px;
        color: #909399;
    }
    #goalsOds div > div> div> .el-tree-node__content{
        height: 35px;
        white-space: normal;
        line-height: 17px;
    }

    #goalsOds div > div> div> div> .el-tree-node__content{
        height: 78px;
        white-space: initial;
    }
    #rightsE div > div> div> div> div> div> .el-tree-node__content{
        height: 35px;
        white-space: initial;
        line-height: 17px;
    }
    #topicsE div > div> div> div> .el-tree-node__content{
        height: 34px;
        white-space: initial;
        line-height: 17px;
    }
</style>
