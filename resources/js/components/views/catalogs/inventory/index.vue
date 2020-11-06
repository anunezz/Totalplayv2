<template>
    <div>
        <header-section icon="el-icon-document" title="Inventarios">
            <template slot="buttons">
<!--                <el-col :span="5" :offset="7">-->
<!--                    <el-button type="success" @click="newCatalog" style="width: 100%">-->
<!--                        Nuevo registro-->
<!--                    </el-button>-->
<!--                </el-col>-->
<!--                <el-col :span="10" :offset="1">-->
<!--                    <el-input-->
<!--                        clearable-->
<!--                        suffix-icon="fas fa-search"-->
<!--                        placeholder="Buscar por nombre ó determinante"-->
<!--                        v-model="search"-->
<!--                        @change="getTitles(search)">-->
<!--                    </el-input>-->
<!--                </el-col>-->
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
                        prop="name"
                        label="Inventario">
                    </el-table-column>
                    <el-table-column
                        prop="revised"
                        label="Coordinador">
                    </el-table-column>
                    <el-table-column
                        prop="positionRevised"
                        label="Cargo">
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
<!--                    <el-col :span="24">-->
<!--                        <el-form-item label="Nombre de inventario"-->
<!--                                      prop="name"-->
<!--                                      :rules="[-->
<!--                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},-->
<!--                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}-->
<!--                                  ]">-->
<!--                            <el-input-->
<!--                                v-if="editRegisterDialog"-->
<!--                                placeholder="Nombre"-->
<!--                                v-model="catalogEditForm.name"-->
<!--                                maxlength="100"-->
<!--                                clearable>-->
<!--                            </el-input>-->
<!--                        </el-form-item>-->
<!--                    </el-col>-->
<!--                    <el-col :span="24">-->
<!--                        <el-form-item :label="ela"-->
<!--                                      prop="elaborated"-->
<!--                                      :rules="[-->
<!--                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},-->
<!--                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}-->
<!--                                  ]">-->
<!--                            <el-input-->
<!--                                v-if="editRegisterDialog"-->
<!--                                placeholder="Nombre"-->
<!--                                v-model="catalogEditForm.elaborated"-->
<!--                                maxlength="100"-->
<!--                                clearable>-->
<!--                            </el-input>-->
<!--                        </el-form-item>-->
<!--                    </el-col>-->
<!--                    <el-col :span="24">-->
<!--                        <el-form-item v-if="this.catalogEditForm.viewed !== null"-->
<!--                                      label="Área Productora"-->
<!--                                      prop="viewed"-->
<!--                                      :rules="[-->
<!--                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},-->
<!--                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}-->
<!--                                  ]">-->
<!--                            <el-input-->
<!--                                v-if="editRegisterDialog"-->
<!--                                placeholder="Nombre"-->
<!--                                v-model="catalogEditForm.viewed"-->
<!--                                maxlength="100"-->
<!--                                clearable>-->
<!--                            </el-input>-->
<!--                        </el-form-item>-->
<!--                    </el-col>-->
                    <el-col :span="24">
                        <el-form-item :label="rev"
                                      prop="revised"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.;:,()-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="editRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogEditForm.revised"
                                maxlength="100"
                                clearable>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item :label="porev"
                                      prop="positionRevised"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.;:,()-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="editRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogEditForm.positionRevised"
                                maxlength="100"
                                clearable>
                            </el-input>
                        </el-form-item>
                    </el-col>
<!--                    <el-col :span="24">-->
<!--                        <el-form-item :label="aut"-->
<!--                                      prop="authorized"-->
<!--                                      :rules="[-->
<!--                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},-->
<!--                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}-->
<!--                                  ]">-->
<!--                            <el-input-->
<!--                                v-if="editRegisterDialog"-->
<!--                                placeholder="Nombre"-->
<!--                                v-model="catalogEditForm.authorized"-->
<!--                                maxlength="100"-->
<!--                                clearable>-->
<!--                            </el-input>-->
<!--                        </el-form-item>-->
<!--                    </el-col>-->
                    <el-col :span="24">
                        <el-form-item v-if="this.catalogEditForm.received !== null"
                                      :label="rec"
                                      prop="received"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.;:,()-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="editRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogEditForm.received"
                                maxlength="100"
                                clearable>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item v-if="this.catalogEditForm.received !== null"
                                      :label="porec"
                                      prop="positionReceived"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                    {  type: 'string', required: false, pattern: /^[A-Za-z0-9ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ.;:,()-\s]+$/, message: 'El nombre no puede llevar caracteres especiales', trigger: 'change'}
                                  ]">
                            <el-input
                                v-if="editRegisterDialog"
                                placeholder="Nombre"
                                v-model="catalogEditForm.positionReceived"
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

                ela: '',
                rev: '',
                porev: '',
                aut: '',
                rec: '',
                porec: '',
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
                    cat_type_id: []
                },
                catalogEditForm:{
                    name: '',
                    authorized: '',
                    elaborated: '',
                    received: '',
                    positionReceived: '',
                    revised: '',
                    positionRevised: '',
                    viewed: '',
                },
                types:[],
                sections:[],
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
                        cat: 7}
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
                    cat_type_id: this.catalogForm.cat_type_id
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

                if (row.id === 1) {
                    this.ela = 'Responsable del archivo de concentración'
                    this.rev = 'Coordinador de Archivos'
                    this.porev = 'Cargo del coordinador de archivos'
                    this.aut = 'Titular de la Unidad administrativa'
                }
                if (row.id === 2) {
                    this.ela = 'Responsable'
                    this.rev = 'Área Tramitadora'
                    this.porev = 'Cargo del área tramitadora'
                    this.aut = 'Unidad Administrativa Productora'
                }
                if (row.id === 3) {
                    this.ela = 'Responsable del Archivo de Trámite'
                    this.rev = 'Coordinador de Archivos'
                    this.porev = 'Cargo del coordinador de archivos'
                    this.aut = 'Titular de la Unidad Administrativa'
                    this.rec = 'Responsable del Archivo de Concentración'
                    this.porec = 'Cargo del responsable del archivo de concentración'
                }
                if (row.id === 4) {
                    this.ela = 'Responsable del Archivo de Concentración'
                    this.rev = 'Coordinador de Archivos'
                    this.porev = 'Cargo del coordinador de archivos'
                    this.aut = 'Titular de la Unidad Administrativa'
                    this.rec = 'Responsable del Archivo Histórico'
                    this.porec = 'Cargo del responsable del archivo de histórico'
                }

                this.catalogEditForm = {
                    id:row.hash,
                    name:row.name,
                    received: row.received,
                    revised: row.revised,
                    positionRevised: row.positionRevised,
                    positionReceived: row.positionReceived,
                };
                this.editRegisterDialog = true;
            },

            editRegister() {
                this.startLoading();

                let data = {
                    id: this.catalogEditForm.id,
                    cat: 7,
                    name: this.catalogEditForm.name,
                    received: this.catalogEditForm.received,
                    revised: this.catalogEditForm.revised,
                    positionRevised: this.catalogEditForm.positionRevised,
                    positionReceived: this.catalogEditForm.positionReceived
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

            Modal() {
                this.modal = 'hola';
                // switch (action) {
                //     case "resgister": {
                //         if (
                //             this.ruleForm.consulate === 0 || this.selectPeriod === null
                //         ) {
                //             this.$message({
                //                 message: "Verifique los campos del formulario.",
                //                 type: "warning"
                //             });
                //             return;
                //         }
                //
                //         this.showFormOperative = true;
                //         this.titleModal = "Nuevo operativo";
                //         this.clearFields();
                //         break;
                //     }
                //     case "close": {
                //         this.titleModal = "";
                //         this.showFormOperative = false;
                //         this.dialogActive = false;
                //         this.centerDialogVisible = false;
                //         this.clearFields();
                //         break;
                //     }
                //     case "delete": {
                //         this.idEditOperative = data;
                //         this.titleModal = "Eliminar operativo";
                //         this.dialogActive = true;
                //         this.msjModal = '¿Estas completamente seguro de eliminar este operativo?';
                //         break;
                //     }
                //     case "nothingOperative": {
                //         this.titleModal = "Sin operativos";
                //         this.dialogActive = true;
                //         this.msjModal = "";
                //         break;
                //     }
                //     case "editNew": {
                //         this.showFormOperative = true;
                //         this.idEditOperative = data[1];
                //         this.updateOperative(data[0]);
                //         this.activeNames = "1";
                //         this.titleModal = "Actualizar operativo";
                //         break;
                //     }
                //     case "sendToValidate": {
                //         this.dialogActive = true;
                //         this.msjModal = this.$store.state.user.profile === 1?
                //             "¿Estas completamente seguro de publicar todos los operativos?" :
                //             "¿Estas completamente seguro de enviar a validar todos los operativos?";
                //
                //         this.titleModal = this.$store.state.user.profile === 1?
                //             "Publicar operativos" :
                //             "Enviar a validar";
                //
                //         break;
                //     }
                // }
            },
        },
    }
</script>

