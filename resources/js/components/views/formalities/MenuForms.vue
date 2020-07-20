<template>
    <div>
        <header-section icon="fas fa-file-signature" title="Archivo de trámite">
            <template slot="buttons">
                <el-button
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push({name: 'ListFormalities' })">
                    Regresar
                </el-button>
            </template>
        </header-section>
        <el-row>
            <el-form :model="formFormalities" ref="formFormalities" label-position="top" label-width="120px" size="small">
            <el-col :span="21" :offset="1" class="border-form">
                <h3 class="form-title">SECRETARÍA DE RELACIONES EXTERIORES</h3>
                <el-tabs type="card" ref="menuTaps" @tab-click="chageTapClick">
                    <el-tab-pane label="Clasificación" style="padding: 10px">
                        <form-classification :formFormalities="formFormalities"></form-classification>
                    </el-tab-pane>
                    <el-tab-pane label="Descripción" style="padding: 10px" :disabled="tapTwo">
                        <form-description :formFormalities="formFormalities" v-if="tapTwo === false"></form-description>
                    </el-tab-pane>
                    <el-tab-pane label="Volumen y soporte" style="padding: 10px" :disabled="tapThree">
                        <form-volume-support :formFormalities="formFormalities" v-if="tapThree === false"></form-volume-support>
                    </el-tab-pane>
                    <el-tab-pane label="Valoración, selección y eliminación" style="padding: 10px" :disabled="tapFour">
                        <form-v-s-e :formFormalities="formFormalities" v-if="tapFour === false"></form-v-s-e>
                    </el-tab-pane>
                    <el-tab-pane label="Condiciones de acceso" style="padding: 10px" v-if="formFormalities.question_two === 'Sí'">
                        <Form-access-conditions :formFormalities="formFormalities" v-if="currentTap === 4"></Form-access-conditions>
                    </el-tab-pane>
                </el-tabs>
                <el-row type="flex" class="row-bg" justify="end" :gutter="20">

                    <el-button
                        v-if="currentTap !== 0"
                        size="small"
                        type="danger"
                        @click="changeTap(-1)">
                        <i class="fas fa-arrow-left"></i>
                        Anterior
                    </el-button>
                    <el-button
                        v-if="formFormalities.question_two !== 'Sí' && currentTap === 3 "
                        size="small"
                        type="success"
                        @click="submitForm()">
                        Guardar
                    </el-button>
                    <el-button
                        v-else-if="formFormalities.question_two === 'Sí' && currentTap === 4 "
                        size="small"
                        type="success"
                        @click="submitForm()">
                        Guardar
                    </el-button>
                    <el-button
                        v-else
                        size="small"
                        type="primary"
                        @click="changeTap(1)">
                        Siguiente
                        <i class="fas fa-arrow-right"></i>
                    </el-button>

                </el-row>
                <!--<el-row type="flex" class="row-bg" justify="end" :gutter="20">
                    <el-col :span="3">
                        <el-button
                            size="small"
                            type="danger"
                            style="width: 100%"
                            @click="$router.push({name: 'ListFormalities' })">
                            Cancelar
                        </el-button>
                    </el-col>
                    <el-col :span="3">
                        <el-button
                            size="small"
                            type="success"
                            style="width: 100%"
                            @click="submitForm()">
                            Guardar
                        </el-button>
                    </el-col>
                </el-row>-->
            </el-col>
            </el-form>
        </el-row>
    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import FormClassification from "./FormClassification";
    import FormDescription from "./FormDescription";
    import FormVolumeSupport from "./FormVolumeSupport";
    import FormVSE from "./FormVSE";
    import FormAccessConditions from "./FormAccessConditions";
    export default {
        components: {
            HeaderSection,
            FormClassification,
            FormDescription,
            FormVolumeSupport,
            FormVSE,
            FormAccessConditions
        },
        data(){
            return{
                currentTap:0,
                tapTwo:true,
                tapThree:true,
                tapFour:true,
                formFormalities:{
                    section_id: null,
                    serie_id: null,
                    subserie_id: null,
                    opening_date: null,
                    close_date: null,
                    consecutive: 0,
                    legajo: 0,
                    sort_code: '',
                    title: '',
                    scope_and_content: '',
                    format_id: null,
                    documentary_tradition_id: null,
                    legajos:0,
                    initial_folio: null,
                    end_folio: null,
                    total_fojas: null,
                    question_one: null,
                    question_two: null,
                    transparency_esolution_id: null,
                    nature_information_id: null,
                    classification_reason_id: null,
                    classification_date: null,
                    name_titular: '',
                    transparency_proceedings: '',
                    restricted_parts: '',
                    legal_basis: '',
                    reservation_period: 0,
                    deadline_extension: 0,
                    Record_official_number: '',
                    declassification_date: null,
                    public_server: '',

                },

            }
        },
        watch:{
          'formFormalities.question_one'(value){
              this.cleanControlAcces();
          },
        },
        methods:{
            submitForm(){
                this.$refs['formFormalities'].validate((valid) => {
                    if (valid) {
                        this.startLoading();
                        let _this = this;
                        setTimeout(function(){
                            _this.stopLoading();
                            _this.$router.push('/tramites');
                            _this.$message({
                                message:"El trámite se registro exitosamente.",
                                type: "success"
                            });
                        }, 1000);
                    } else {
                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });

            },
            cleanControlAcces(){
                this.formFormalities.question_two = null;
                this.formFormalities.transparency_esolution_id = null;
                this.formFormalities.nature_information_id = null;
                this.formFormalities.classification_reason_id = null;
                this.formFormalities.classification_date = null;
                this.formFormalities.name_titular = '';
                this.formFormalities.transparency_proceedings = '';
                this.formFormalities.restricted_parts = '';
                this.formFormalities.legal_basis = '';
                this.formFormalities.reservation_period = 0;
                this.formFormalities.deadline_extension = 0;
                this.formFormalities.Record_official_number = '';
                this.formFormalities.declassification_date = null;
                this.formFormalities.public_server = '';
            },
            validForm(){
                let aux = false
                this.$refs['formFormalities'].validate((valid) => {
                    if (valid) {
                        aux = true;
                    }else {
                        aux = false;
                    }
                });

                return aux;
            },
            positionTap(tap){
                let aux;
                console.log('hola cambio',this.currentTap,tap)
                this.currentTap += tap;
                aux = this.currentTap.toString();

                if (this.currentTap === 1) this.tapTwo = false;
                if (this.currentTap === 2) this.tapThree = false;
                if (this.currentTap === 3) this.tapFour = false;
                this.$refs['menuTaps'].currentName = aux;
            },
            changeTap(tap){
                let _this = this;

                if (_this.currentTap === 0 && _this.tapTwo === false) _this.positionTap(tap);
                else if (_this.currentTap === 1 && _this.tapThree === false) _this.positionTap(tap);
                else if (_this.currentTap === 2 && _this.tapFour === false) _this.positionTap(tap);

                else if (tap === 1){
                    if (_this.validForm()){
                        _this.positionTap(tap);
                    }
                }else {
                    _this.positionTap(tap)
                }
            },
            chageTapClick(){
                this.currentTap = parseInt(this.$refs['menuTaps'].currentName);
            }
        }
    }
</script>

<style scoped>
    .border-form{
        padding: 20px;
        border: 1px solid #b3b9c8;
        border-radius: 5px;
        box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    }
    .form-title{
        color:#67C23A;
        border-bottom: 1px solid #b3b9c8;
        padding: 10px;
    }
</style>
