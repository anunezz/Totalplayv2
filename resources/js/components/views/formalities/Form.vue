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
            <el-col :span="21" :offset="1" class="border-form">
                <el-tabs type="card">
                    <el-tab-pane label="Datos Generales" style="padding: 10px">
                        <el-row style="border-left: 1px solid #b3b9c8; border-bottom: 1px solid #b3b9c8; border-right: 1px solid #b3b9c8; border-radius: 5px; padding: 20px">
                            <el-form :model="formFormalities" ref="formFormalities" label-position="top" label-width="120px" size="small">
                                <el-row :gutter="20">
                                    <el-col :span="12">
                                        <el-form-item label="Sección:" prop="name">
                                            <el-select v-model="formFormalities.name" clearable filterable placeholder="Seleccionar" style="width: 100%">
                                                <el-option
                                                    v-for="item in options"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Serie:" prop="name">
                                            <el-select v-model="formFormalities.name" filterable placeholder="Seleccionar" style="width: 100%">
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
                                    <el-col :span="12">
                                        <el-form-item label="Subserie:" prop="name">
                                            <el-select v-model="formFormalities.name" clearable filterable placeholder="Seleccionar" style="width: 100%">
                                                <el-option
                                                    v-for="item in options"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Año:" prop="name">
                                            <el-date-picker
                                                v-model="formFormalities.anio"
                                                type="year"
                                                style="width: 100%">
                                            </el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <el-row :gutter="20">
                                    <el-col :span="7">
                                        <el-form-item label="Clasificación: TIN:" prop="name">
                                            <el-input
                                                v-model="input"
                                                :disabled="true">
                                            </el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="7">
                                        <el-form-item label="Número de Expediente:" prop="name">
                                            <el-input
                                                v-model="input"
                                                :disabled="true">
                                            </el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="10">
                                        <el-form-item label="Asunto/Título:" prop="name">
                                            <el-input
                                                v-model="input">
                                            </el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <el-row :gutter="20">
                                    <el-col :span="12">
                                        <el-form-item label="Fecha de apertura: " prop="name">
                                            <el-date-picker
                                                v-model="value1"
                                                type="date"
                                                style="width: 100%">
                                            </el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Valor documental:" prop="name">
                                            <el-select v-model="formFormalities.name" filterable placeholder="Seleccionar" style="width: 100%">
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
                                    <el-col :span="12">
                                        <el-form-item label="Carácter de la información:" prop="name">
                                            <el-select v-model="formFormalities.name" clearable filterable placeholder="Seleccionar" style="width: 100%">
                                                <el-option
                                                    v-for="item in options"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Tradición documental:" prop="name">
                                            <el-select v-model="formFormalities.name" filterable placeholder="Seleccionar" style="width: 100%">
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
                                <el-row>
                                    <el-col :span="24">
                                        <el-form-item label="Descripción:" prop="name">
                                            <el-input
                                                type="textarea"
                                                :rows="10"
                                                v-model="textarea"
                                                maxlength="500"
                                                show-word-limit
                                            >
                                            </el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                            </el-form>
                        </el-row>
                    </el-tab-pane>
                    <el-tab-pane label=" Información adicional">
                        <el-row>
                            <el-form label-position="top" label-width="120px" size="small">
                                <el-row style="margin-left: 20px; margin-bottom: 15px; border: 1px solid #b3b9c8; border-radius: 5px;">
                                    <el-row style="background:#f0f1f5; padding: 10px; border-bottom: 1px solid #b3b9c8;">
                                        <span style="font-weight: bold; font-size:15px; margin-left: 5px;">Ubicación</span>
                                    </el-row>
                                    <el-row style="padding: 15px">
                                        <el-row :gutter="20">
                                            <el-col :span="12">
                                                <el-form-item label="Mueble:" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="12">
                                                <el-form-item label="Nivel:" prop="name">
                                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                        <el-row :gutter="20">
                                            <el-col :span="12">
                                                <el-form-item label="Pasillo:" prop="name">
                                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="12">
                                                <el-form-item label="Caja:" prop="name">
                                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                    </el-row>
                                </el-row>
                                <el-row style="margin-left: 20px; margin-bottom: 15px; border: 1px solid #b3b9c8; border-radius: 5px">
                                    <el-row style="background:#e4e6ec; padding: 10px; border-bottom: 1px solid #b3b9c8;">
                                        <span style="font-weight: bold; font-size:15px; margin-left: 5px;">Plazos de conservación</span>
                                    </el-row>
                                    <el-row style="padding: 15px">
                                        <el-row :gutter="20">
                                            <el-col :span="12">
                                                <el-form-item label="Archivo de trámite (AT):" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="12">
                                                <el-form-item label="Archivo de concentración (AC):" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                        <el-row :gutter="20">
                                            <el-col :span="12">
                                                <el-form-item label="Vigencia:" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="12">
                                                <el-form-item label="Destino Final:" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                    </el-row>
                                </el-row>
                                <el-row style="margin-left: 20px; margin-bottom: 15px; border: 1px solid #b3b9c8; border-radius: 5px">
                                    <el-row style="background:#e4e6ec; padding: 10px; border-bottom: 1px solid #b3b9c8;">
                                        <span style="font-weight: bold; font-size:15px; margin-left: 5px;">Condiciones de acceso</span>
                                    </el-row>
                                    <el-row style="padding: 15px">
                                        <el-row :gutter="20">
                                            <el-col :span="12">
                                                <el-form-item label="Fundamento legal:" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="12">
                                                <el-form-item label="Periodo de reserva:" prop="name">
                                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                        <el-row :gutter="20">
                                            <el-col :span="8">
                                                <el-form-item label="Fecha de clasificación:" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="8">
                                                <el-form-item label="Fecha de desclasificación:" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="8">
                                                <el-form-item label="Ampliación de periodo de reserva:" prop="name">
                                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                    </el-row>
                                </el-row>
                                <el-row style="margin-left: 20px; margin-bottom: 15px; border: 1px solid #b3b9c8; border-radius: 5px">
                                    <el-row style="background:#e4e6ec; padding: 10px; border-bottom: 1px solid #b3b9c8;">
                                        <span style="font-weight: bold; font-size:15px; margin-left: 5px;">Otros</span>
                                    </el-row>
                                    <el-row style="padding: 15px">
                                        <el-row :gutter="20">
                                            <el-col :span="12">
                                                <el-form-item label="Fecha de cierre:" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="12">
                                                <el-form-item label="Fojas:" prop="name">
                                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                        <el-row :gutter="20">
                                            <el-col :span="12">
                                                <el-form-item label="Soporte:" prop="name">
                                                    <el-input
                                                        v-model="input">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                    </el-row>
                                </el-row>
                            </el-form>
                        </el-row>
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
                            @click="$router.push({name: 'ListFormalities' })">
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

    export default {
        components: {
            HeaderSection,
        },
        data(){
            return{
                formFormalities:{
                    name:'',
                    anio:''
                },
                num:0,
                input:'',
                value1:'',
                textarea:'',
                options: [{
                    value: 'Option1',
                    label: 'Option1'
                }, {
                    value: 'Option2',
                    label: 'Option2'
                }, {
                    value: 'Option3',
                    label: 'Option3'
                }, {
                    value: 'Option4',
                    label: 'Option4'
                }, {
                    value: 'Option5',
                    label: 'Option5'
                }],
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
