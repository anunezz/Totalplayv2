<template>
    <div>
        <header-section icon="el-icon-s-management" title="Búsqueda de Expediente">
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
                        Busca el Expediente para generar un reporte.
                    </h3>
                    <hr>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter='20' class='animated fadeIn fast'>
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm">
                <el-col :span='12'>
                    <el-form-item label="Sección" prop="section">
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
                    <el-form-item label="Clasificación" prop="classification">
                        <el-input size="mini" placeholder="Clasificación" v-model="ruleForm.classification"></el-input>
                    </el-form-item>
                </el-col>

                <el-col :span='12'>
                    <el-form-item label="Serie" prop="serie">
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
                    <el-form-item label="Número de expediente" prop="record">
                        <el-input size="mini" placeholder="Número de expediente" v-model="ruleForm.record"></el-input>
                    </el-form-item>
                </el-col>

                <el-col :span='12'>
                    <el-row :gutter='20'>
                        <el-col :span='24'>
                            <el-form-item label="Subserie" prop="subserie">
                                    <el-select
                                    size="mini"
                                    style="width: 100%;"
                                    v-model="ruleForm.subserie"
                                    placeholder="Seleccione una opción">
                                        <el-option
                                        label="Seleccione una opción"
                                        value="">
                                        </el-option>
                                        <el-option
                                        v-for="item in subserie"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                        </el-option>
                                    </el-select>
                            </el-form-item>
                        </el-col>

                        <el-col :span='24'>
                            <el-form-item label="Año" prop="year">
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
                    </el-row>
                </el-col>

                <el-col :span='12'>
                    <el-form-item label="Descripción" prop="description">
                        <el-input
                        :rows="6"
                        type="textarea"
                        placeholder="Escribe palabras clave en la descripción"
                        v-model="ruleForm.description"
                        maxlength="100"
                        show-word-limit></el-input>
                    </el-form-item>
                </el-col>

                <el-col :span='24' class='animated fadeIn fast'>
                    <div style='width:100%; padding: 5px 0px; display:flex; justify-content: flex-end;'>
                        <div>
                            <el-button
                            icon="el-icon-search"
                            size="mini"
                            @click="excelExpediente"
                            type="success">
                            Buscar</el-button>
                        </div>
                    </div>
                </el-col>

            </el-form>
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
            excelExpediente(){
                console.log("hhhhh");

            axios({ responseType: 'blob',
                method: 'POST',
                url: '/api/report/proceedings',
                data: 'hola' }).then(response => {
                    this.loading = true;
                setTimeout(()=>{
                    const linkUrl = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = linkUrl;
                    link.setAttribute('download', 'Expediente.xlsx');
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

