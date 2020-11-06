<template>
    <div>
        <el-row class="body-form">
            <el-row style="padding: 15px">
                <el-row :gutter="20">
                    <el-col :md="12">
                        <el-form-item label="Formato:" prop="format_id"
                                      :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-select v-model="formFormalities.format_id" clearable filterable
                                       placeholder="Seleccionar" style="width: 100%" :disabled="$store.state.user.profile !== 1 && formFormalities.hash !== undefined">
                                <el-option
                                    v-for="doc in typeDocs"
                                    :key="doc.id"
                                    :label="doc.name"
                                    :value="doc.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :md="12">
                        <el-form-item label="Tradición documental:" prop="documentary_tradition_id"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-select v-model="formFormalities.documentary_tradition_id" filterable placeholder="Seleccionar"
                                       style="width: 100%" :disabled="$store.state.user.profile !== 1 && formFormalities.hash !== undefined">
                                <el-option
                                    v-for="traditional in traditionDocs"
                                    :key="traditional.id"
                                    :label="traditional.name"
                                    :value="traditional.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                    <el-col :md="12">
                        <el-form-item label="Legajo:" prop="legajos">
                            <el-input-number v-model="formFormalities.legajos" controls-position="right" :disabled="$store.state.user.profile !== 1 && formFormalities.hash !== undefined"
                                             style="width: 100%"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :md="12">
                        <el-form-item label="Folio inicial:" prop="initial_folio">
                            <el-input-number v-model="formFormalities.initial_folio" controls-position="right" :disabled="$store.state.user.profile !== 1 && formFormalities.hash !== undefined"
                                             style="width: 100%"></el-input-number>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                    <el-col :md="12">
                        <el-form-item label="Folio final:" prop="end_folio">
                            <el-input-number v-model="formFormalities.end_folio" controls-position="right" :min="formFormalities.initial_folio" :disabled="$store.state.user.profile !== 1 && formFormalities.hash !== undefined"
                                             style="width: 100%"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :md="12">
                        <el-form-item label="Total de fojas:" prop="fojas">
                            <el-input v-model="formFormalities.total_fojas" disabled style="width: 100%"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[0-9]+$/, message:'Este campo soloadmite números.'}]">

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
                typeDocs:[
                    {
                        id:1,
                        name:'Electrónico'
                    },
                    {
                        id:2,
                        name:'Físico'
                    }
                ],
                traditionDocs:[
                    {
                        id:1,
                        name:'Copia'
                    },
                    {
                        id:2,
                        name:'Original'
                    },
                    {
                        id:3,
                        name:'Original y copia'
                    },

                ],
            }
        },
        watch:{
            'formFormalities.initial_folio' (){
                this.formFormalities.end_folio = this.formFormalities.initial_folio;
            },
            'formFormalities.end_folio' (){
                this.formFormalities.total_fojas = this.formFormalities.end_folio;
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
