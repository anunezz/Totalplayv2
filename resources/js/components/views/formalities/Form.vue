<template>
    <div>
        <header-section icon="fa-edit" title="Archivo de trámite">
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
                    <el-tab-pane label="Datos Generales">
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
                                    <el-form-item label="Sección:" prop="name">
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

                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane label=" Información adicional">
                    </el-tab-pane>
                    <el-tab-pane label="Archivos">
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
                    name:''
                },
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
        border: 1px solid #DCDFE6;
        border-radius: 5px;
        box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    }
</style>
