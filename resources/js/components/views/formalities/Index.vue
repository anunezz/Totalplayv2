<template>
    <div>
        <header-section icon="fas fa-copy" title="Listado de expedientes">
            <template slot="buttons">
                <el-button
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/')">
                    Regresar
                </el-button>
                <el-button-group>
                    <el-button
                        v-if="$store.state.user.profile === 1"
                        size="small"
                        type="success"
                        icon="fas fa-edit"
                        @click="$router.push({name: 'NewFormalities' })">
                        Nuevo
                    </el-button>
                </el-button-group>
            </template>
        </header-section>
        <el-row type="flex" justify="end">
            <el-col :span="5">
                <el-button
                    size="small"
                    icon="fas fa-search"
                    style="width: 100%"
                    @click="showFilters = true">
                    Filtros
                </el-button>
            </el-col>
        </el-row>
        <el-drawer
            :visible.sync="showFilters"
            direction="ltr"
            size="50%"
            ref="drawer">
            <el-row style="margin-bottom: 20px">
                <el-col :span="21" :offset="1" class="border-form">
                    <h4>Agregar Campos</h4>
                </el-col>
            </el-row>
            <el-row :gutter="20" type="flex" justify="center">
                <el-col :span="5">
                    <el-button
                        size="small"
                        icon="fas fa-eraser"
                        style="width: 100%">
                        Limpiar
                    </el-button>
                </el-col>
                <el-col :span="5">
                    <el-button
                        size="small"
                        icon="fas fa-filter"
                        type="primary"
                        style="width: 100%">
                        Buscar
                    </el-button>
                </el-col>
            </el-row>
        </el-drawer>
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
                showFilters: false
            }
        }

    }
</script>

<style scoped>
    .border-form{
        padding: 20px;
        border: 1px solid #DCDFE6;
        border-radius: 5px;
    }
</style>
