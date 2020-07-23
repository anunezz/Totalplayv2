<template>
    <div>
        <el-row class="body-form">
            <el-row style="padding: 15px">
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Resolución del comité de transparencia:" prop="transparency_esolution_id"
                                      :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-select v-model="formFormalities.transparency_esolution_id" clearable filterable
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
                        <el-form-item label="Carácter de la información:" prop="nature_information_id"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-select v-model="formFormalities.nature_information_id" filterable placeholder="Seleccionar"
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
                        <el-form-item label="Razón de clasificación:" prop="classification_reason_id"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-select v-model="formFormalities.classification_reason_id" clearable filterable
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
                        <el-form-item label="Fecha de clasificación: " prop="classification_date" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-date-picker
                                v-model="formFormalities.classification_date"
                                type="date"
                                format="dd/MM/yyyy"
                                value-format="dd/MM/yyyy"
                                style="width: 100%">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-form-item label="Nombre y firma del titular de la unidad administrativa:" prop="name_titular"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                        <el-input
                            v-model="formFormalities.name_titular">
                        </el-input>
                    </el-form-item>
                </el-row>
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Acta del comité de transparencia:" prop="transparency_proceedings"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                            <el-input
                                v-model="formFormalities.transparency_proceedings">
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Partes restringidas (folios):" prop="restricted_parts"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                            <el-input
                                v-model="formFormalities.restricted_parts">
                            </el-input>
                        </el-form-item>
                    </el-col>

                </el-row>
                <el-row>
                    <el-form-item label="Fundamento legal:" prop="legal_basis"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                        <el-input
                            v-model="formFormalities.legal_basis">
                        </el-input>
                    </el-form-item>
                </el-row>
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Periodo de reserva (años):" prop="reservation_period">
                            <el-input-number v-model="formFormalities.reservation_period" controls-position="right"
                                             style="width: 100%"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Ampliación del plazo (años):" prop="deadline_extension">
                            <el-input-number v-model="formFormalities.deadline_extension" controls-position="right"
                                             style="width: 100%"></el-input-number>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Número de acta/oficio:" prop="Record_official_number"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                            <el-input
                                v-model="formFormalities.Record_official_number">
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Fecha de desclasificación: " prop="declassification_date" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-date-picker
                                v-model="formFormalities.declassification_date"
                                type="date"
                                format="dd/MM/yyyy"
                                value-format="dd/MM/yyyy"
                                style="width: 100%">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="24">
                        <el-form-item label="Nombre, cargo y firma del servidor público que desclasifica:" prop="public_server"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                            <el-input
                                type="textarea"
                                :rows="3"
                                v-model="formFormalities.public_server">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-row>
        </el-row>
    </div>
</template>

<script>
    export default {
        props:['formFormalities'],
        data(){
            return{
                options:[{
                    value:1,
                    label:'opcion1'
                }]
            }
        }
    }
</script>

<style scoped>
    .body-form {
        border-left: 1px solid #b3b9c8;
        border-bottom: 1px solid #b3b9c8;
        border-right: 1px solid #b3b9c8;
        border-radius: 5px;
        padding: 20px;
    }
</style>
