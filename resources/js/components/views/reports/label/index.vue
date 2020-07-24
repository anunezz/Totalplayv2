<template>
    <div>
        <header-section icon="el-icon-collection-tag" title="Etiqueta">
            <template slot="buttons">
                <el-button
                    align="right"
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/reportes')">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <div style='width:100%; padding: 5px 0px; display:flex; justify-content: space-between;'>
                    <h3>
                        Generar Etiqueta
                    </h3>
                    <hr>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter='20' class='animated fadeIn fast'>
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm">
                <el-col :span='12'>
                    <el-form-item label="Búsqueda General" prop="section">
                            <el-select
                            size="mini"
                            style="width: 100%;"
                            v-model="ruleForm.section"
                            placeholder="Seleccione una opción">
                                <el-option
                                label="Seleccione una opción"
                                value="">
                                </el-option>
                                <el-option
                                v-for="item in section"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                                </el-option>
                            </el-select>
                    </el-form-item>
                </el-col>

                <el-col :span='12' class='animated fadeIn fast'>
                    <el-form-item label="Expedientes" prop="classification">
                        <el-input size="mini" placeholder="Número de expedientes" v-model="ruleForm.classification"></el-input>
                    </el-form-item>
                </el-col>

                <el-col :span='12'>
                    <el-form-item label="Unidad" prop="serie">
                            <el-select
                            size="mini"
                            style="width: 100%;"
                            v-model="ruleForm.serie"
                            placeholder="Seleccione una opción">
                                <el-option
                                label="Seleccione una opción"
                                value="">
                                </el-option>
                                <el-option
                                v-for="item in serie"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                                </el-option>
                            </el-select>
                    </el-form-item>
                </el-col>

                <el-col :span='12'>
                    <el-form-item label="Caja" prop="record">
                        <el-input size="mini" placeholder="Caja" v-model="ruleForm.record"></el-input>
                    </el-form-item>
                </el-col>

                <el-col :span='12'>
                    <el-form-item label="Fechas apertura" prop="subserie">
                        <br>
                        <el-date-picker
                            v-model="ruleForm.subserie"
                            type="date"
                            placeholder="Pick a day">
                        </el-date-picker>
                    </el-form-item>
                </el-col>

                <el-col :span='12'>
                    <el-form-item label="Valor documental" prop="year">
                        <el-select
                            size="mini"
                            style="width: 100%;"
                            v-model="ruleForm.year"
                            placeholder="Seleccione una opción">
                            <el-option
                                label="Seleccione una opción"
                                value="">
                            </el-option>
                            <el-option
                                v-for="item in year"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>

                <el-col :span='12'>
                    <el-form-item label="Fechas cierre" prop="description">
                        <br>
                        <el-date-picker
                            v-model="ruleForm.picker"
                            type="date"
                            placeholder="Pick a day">
                        </el-date-picker>
                    </el-form-item>
                </el-col>

                <el-col :span='12' class='animated fadeIn fast'>
                    <el-form-item label="Archivo de trámite (AT)" prop="classification">
                        <el-input size="mini" placeholder="AT" v-model="ruleForm.classification"></el-input>
                    </el-form-item>
                </el-col>

                <el-col :offset="12" :span='12' class='animated fadeIn fast'>
                    <el-form-item label="Archivo de concentración (AC)" prop="classification">
                        <el-input size="mini" placeholder="AC" v-model="ruleForm.classification"></el-input>
                    </el-form-item>
                </el-col>
            </el-form>
        </el-row>
        <el-row type="flex" justify="end" :gutter="12">
            <el-col :span="5">
                <el-button
                    size="mini"
                    type="success"
                    @click="ExcelLabel"
                    style="width: 100%">
                    Generar
                </el-button>
            </el-col>
            <el-col :span="5">
                <el-button
                    size="mini"
                    type="danger"
                    @click="labelBox"
                    style="width: 100%">
                    Cancelar
                </el-button>
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
        data(){
            return {
                //Catalogs
                section:[],
                serie:[],
                subserie:[],
                year:[],
                //Formulario
                ruleForm:{
                    //section:[]
                },
                rules:{}
            }
        },
        methods:{
            ExcelLabel(){
                axios({ responseType: 'blob',
                        method: 'POST',
                        url: '/api/report/label',
                        data: 'hola' }).then(response => {
                            this.loading = true;
                        setTimeout(()=>{
                            const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = linkUrl;
                            link.setAttribute('download', 'Etiquetas.xlsx');
                            document.body.appendChild(link);
                            link.click();
                            this.loading = false;
                        },500)

                    }).catch(error => {
                        this.$notify({
                            title: 'Mensaje',
                            text: 'No fue posible realizar la descarga, inténtelo nuevamente.',
                            type: 'warning'
                        });
                    });

            },
            labelBox(){
                axios({ responseType: 'blob',
                        method: 'POST',
                        url: '/api/report/labelBox',
                        data: 'hola' }).then(response => {
                            this.loading = true;
                        setTimeout(()=>{
                            const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = linkUrl;
                            link.setAttribute('download', 'Etiquetas_de_caja.xlsx');
                            document.body.appendChild(link);
                            link.click();
                            this.loading = false;
                        },500)

                    }).catch(error => {
                        this.$notify({
                            title: 'Mensaje',
                            text: 'No fue posible realizar la descarga, inténtelo nuevamente.',
                            type: 'warning'
                        });
                    });
            }
        }

    }
</script>

