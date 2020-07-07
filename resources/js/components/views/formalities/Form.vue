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
