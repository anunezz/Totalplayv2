<template xmlns:el-col="http://www.w3.org/1999/html" xmlns:el-colc="http://www.w3.org/1999/html">
    <div>
        <el-row>
            <el-form :model="formFormalities" label-position="top" label-width="120px" size="small">
                <el-row class="header">
                    <el-row class="body-form">
                        <span class="title-form">Volumen y soporte</span>
                    </el-row>
                    <el-row style="padding: 15px">
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Formato:" prop="section_id"
                                              :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                                    <el-select v-model="formFormalities.section_id" clearable filterable
                                               placeholder="Seleccionar" style="width: 100%">
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
                                <el-form-item label="Tradición documental:" prop="serie_id"
                                              :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                                    <el-select v-model="formFormalities.serie_id" filterable placeholder="Seleccionar"
                                               style="width: 100%">
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
                                <el-form-item label="Legajo:" prop="title">
                                    <el-input-number v-model="formFormalities.legajo" controls-position="right"
                                                     style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Folio inicial:" prop="title">
                                    <el-input-number v-model="formFormalities.legajo" controls-position="right"
                                                     style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Folio final:" prop="title">
                                    <el-input-number v-model="formFormalities.legajo" controls-position="right"
                                                     style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Total de fojas:" prop="title">
                                    <el-input v-model="formFormalities.sort_code" disabled style="width: 100%"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-row>
                </el-row>
                <el-row class="header">
                    <el-row class="body-form">
                        <span class="title-form">Valoración, selección y eliminación</span>
                    </el-row>
                    <el-row style="padding: 15px">
                        <h4>Valores primarios</h4>
                        <h4>Vigencias documentales</h4>
                        <h4>Técnicas de selección</h4>
                    </el-row>
                </el-row>
                <el-row class="header" style="padding: 15px">
                    <el-row style="margin-bottom: 10px">
                        <el-col :span="19">
                            <span style="font-weight: bold;">¿El expediente fue objeto de una solicitud de acceso a la información?</span>
                        </el-col>
                        <el-col :span="5">
                            <el-radio-group v-model="formFormalities.resource" size="medium">
                                <el-radio border label="Sí"></el-radio>
                                <el-radio border label="No"></el-radio>
                            </el-radio-group>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="19">
                            <span style="font-weight: bold;">¿El expediente fue clasificado como confidencial o reservado?</span>
                        </el-col>
                        <el-col :span="5">
                            <el-radio-group v-model="formFormalities.resource" size="medium">
                                <el-radio border label="Sí"></el-radio>
                                <el-radio border label="No"></el-radio>
                            </el-radio-group>
                        </el-col>
                    </el-row>
                </el-row>
                <el-row class="header">
                    <el-row class="body-form">
                        <span class="title-form">Condiciones de acceso</span>
                    </el-row>
                    <el-row style="padding: 15px">
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Resolución del comité de transparencia:" prop="section_id"
                                              :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                                    <el-select v-model="formFormalities.section_id" clearable filterable
                                               placeholder="Seleccionar" style="width: 100%">
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
                                <el-form-item label="Carácter de la información:" prop="serie_id"
                                              :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                                    <el-select v-model="formFormalities.serie_id" filterable placeholder="Seleccionar"
                                               style="width: 100%">
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
                                <el-form-item label="Razón de clasificación:" prop="subserie_id"
                                              :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                                    <el-select v-model="formFormalities.subserie_id" clearable filterable
                                               placeholder="Seleccionar" style="width: 100%">
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
                                <el-form-item label="Fecha de clasificación: " prop="opening_date" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                                    <el-date-picker
                                        v-model="formFormalities.opening_date"
                                        type="date"
                                        style="width: 100%">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-form-item label="Nombre y firma del titular de la unidad administrativa:" prop="title"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                                <el-input
                                    v-model="formFormalities.title">
                                </el-input>
                            </el-form-item>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Acta del comité de transparencia:" prop="title"
                                              :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                                    <el-input
                                        v-model="formFormalities.title">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Partes restringidas (folios):" prop="title"
                                              :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                                    <el-input
                                        v-model="formFormalities.title">
                                    </el-input>
                                </el-form-item>
                            </el-col>

                        </el-row>
                        <el-row>
                            <el-form-item label="Fundamento legal:" prop="title"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                                <el-input
                                    v-model="formFormalities.title">
                                </el-input>
                            </el-form-item>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="6">
                                <el-form-item label="Periodo de reserva (años):" prop="title">
                                    <el-input-number v-model="formFormalities.legajo" controls-position="right"
                                                     style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                            <el-col :span="6">
                                    <el-form-item label="Ampliación del plazo (años):" prop="title">
                                        <el-input-number v-model="formFormalities.legajo" controls-position="right"
                                                         style="width: 100%"></el-input-number>
                                    </el-form-item>

                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Número de acta/oficio:" prop="title"
                                              :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                                    <el-input
                                        v-model="formFormalities.title">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-row>
                </el-row>
            </el-form>
        </el-row>
    </div>
</template>

<script>
    export default {
        props:['formFormalities'],
        data(){
            return{
                num:0,
                input:'',
                value1:'',
                textarea:'',
            }
        }
    }
</script>

<style scoped>
    .header {
        margin-left: 20px;
        margin-bottom: 15px;
        border: 1px solid #b3b9c8;
        border-radius: 5px;
    }

    .body-form {
        background: #f0f1f5;
        padding: 10px;
        border-bottom: 1px solid #b3b9c8;
    }

    .title-form {
        font-weight: bold;
        font-size: 15px;
        margin-left: 5px;
    }
</style>
