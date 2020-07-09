<template>
    <div>
        <pre>{{formFormalities}}</pre>
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
            <el-col :span="21" :offset="1" class="border-form">
                <el-tabs type="card">

                    <el-tab-pane label="Datos Generales" style="padding: 10px">
                        <el-form :model="formFormalities" ref="formFormalities" label-position="top" label-width="120px" size="small">
                            <form-general :formFormalities="formFormalities"/>
                        </el-form>
                    </el-tab-pane>

                    <el-tab-pane label=" Información adicional">
                        <form-additional :formFormalities="formFormalities"/>
                    </el-tab-pane>

                    <el-tab-pane label="Archivos">
                        <el-row style="text-align: center">
                            <el-upload
                                ref="notFiles"
                                class="upload-demo"
                                drag
                                :show-file-list="false"
                                action="/api/notices/upload/file"
                                accept=".jpg, .pdf, .png, .jpeg"
                                name="document"
                                :auto-upload="true"
                                multiple
                                style="width: 100%">
                                <i class="el-icon-upload"></i>
                                <div class="el-upload__text">
                                    Suelta tu archivo aquí o <em>haz clic para cargar</em>
                                    (Tamaño máximo 10MB)
                                </div>
                            </el-upload>
                        </el-row>
                        <el-divider content-position="left">Archivos agregados <span style="border-radius: 15px;padding: 2px;background: #3a8ee6;color: white">0</span></el-divider>

                    </el-tab-pane>
                </el-tabs>
                <el-row type="flex" class="row-bg" justify="end" :gutter="20">
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
                </el-row>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import FormGeneral from "./FormGeneral";
    import FormAdditional from "./FormAdditional";
    export default {
        components: {
            HeaderSection,
            FormGeneral,
            FormAdditional,
        },
        data(){
            return{
                formFormalities:{
                    section_id: null,
                    serie_id: null,
                    subserie_id: null,
                    anio: null,
                    classification_tin: '',
                    file_number: '',
                    title: '',
                    opening_date: null,
                    documentary_value: null,
                    nature_information: null,
                    documentary_tradition: null,
                    description:'',
                    furniture:'',

                },

            }
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
</style>
