<template>
    <div>
<!--        <el-row style="border-left: 1px solid #b3b9c8; border-bottom: 1px solid #b3b9c8; border-right: 1px solid #b3b9c8; border-radius: 5px; padding: 20px">-->
        <el-row class="header">
            <el-row class="body-form">
                <span class="title-form">Clasificación</span>
            </el-row>
            <el-row style="padding: 15px">
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Sección:" prop="section_id"
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
                        <el-form-item label="Serie:" prop="serie_id"
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
                        <el-form-item label="Subserie:" prop="subserie_id"
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
                        <el-form-item label="Fecha de apertura: " prop="opening_date" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-date-picker
                                v-model="formFormalities.opening_date"
                                type="date"
                                format="dd/MM/yyyy"
                                style="width: 100%">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Fecha de cierre: " prop="opening_date" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-date-picker
                                v-model="formFormalities.close_date"
                                type="date"
                                format="dd/MM/yyyy"
                                style="width: 100%">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Consecutivo: " prop="opening_date">
                            <el-input-number v-model="formFormalities.consecutive" controls-position="right" :min="0"
                                             style="width: 100%"></el-input-number>
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
                        <el-form-item label="Código de clasificaión:" prop="title" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-input v-model="formFormalities.sort_code" disabled style="width: 100%"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-row>
        </el-row>

        <el-row class="header">
            <el-row class="body-form">
                <span class="title-form">Descripción</span>
            </el-row>
            <el-row style="padding: 15px">
                <el-row :gutter="20">
                    <el-col :span="24">
                        <el-form-item label="Asunto/Título:" prop="title" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                            <el-input
                                v-model="formFormalities.title">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="24">
                        <el-form-item label="Alcance y contenido:" prop="description" :rules="[
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                            <el-input
                                type="textarea"
                                :rows="10"
                                v-model="formFormalities.scope_and_content"
                                :disabled="true">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-row>
        </el-row>
        <!--        </el-row>-->
    </div>
</template>

<script>
    export default {
        props:['formFormalities'],
        data(){
            return{
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
