<template>
    <div>
        <el-row class="body-form">
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
                        <el-form-item label="Fecha de cierre: " prop="close_date" :rules="[
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
                        <el-form-item label="Consecutivo: " prop="consecutive">
                            <el-input-number v-model="formFormalities.consecutive" controls-position="right" :min="0"
                                             style="width: 100%"></el-input-number>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Legajo:" prop="legajo">
                            <el-input-number v-model="formFormalities.legajo" controls-position="right"
                                             style="width: 100%"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Código de clasificaión:" prop="sort_code">
                            <el-input v-model="formFormalities.sort_code" disabled style="width: 100%"></el-input>
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
