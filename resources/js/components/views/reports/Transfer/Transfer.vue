<template>
    <div>
        <header-section icon="el-icon-s-management" title="Formatos de transferencia">
            <template slot="buttons">
                <el-button
                    align="right"
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push({ name: 'ReportIndex' })">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <el-row :gutter='20'>
            <el-col :span="8">
                <el-badge class="item">
                    <a class="links" @click="$router.push( {name:'Inventory'})">
                        Formato de inventario
                    </a>
                </el-badge>
                <br /><br />
                <span>Formato de inventario</span>
            </el-col>

            <el-col :span="8">
                <el-badge class="item">
                    <a class="links" @click="$router.push( {name:'Datasheet'})">
                        Ficha Técnica
                    </a>
                </el-badge>
                <br /><br />
                <span>Ficha Técnica</span>
            </el-col>

            <el-col :span="8">
                <el-badge class="item">
                    <a class="links" @click="$router.push( {name:'Prevaluation'})">
                        Declaratoria de Prevaloración
                    </a>
                </el-badge>
                <br /><br />
                <span>Declaratoria de Prevaloración</span>
            </el-col>
        </el-row>

    </div>
</template>

<script>
    import HeaderSection from "../../layouts/partials/HeaderSection";
    export default {
        components: {
            HeaderSection
        },
    }
</script>

<style scoped>
.links {
    font-size: 25px;
    color: #9d2449;
    cursor: pointer;
    text-decoration: underline;
}
</style>
