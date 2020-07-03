<template>
<div>
    <header-section icon="el-icon-document-add" title="Catálogos">
        <template slot="buttons">
            <el-button
                size="small"
                type="danger"
                icon="el-icon-arrow-left"
                @click="$router.push('/administracion/')">
                Regresar
            </el-button>
        </template>
    </header-section>

    <el-row :gutter="10">
        <el-col :span="24">
            <el-select v-model="selectedCat"
                       placeholder="Seleccione un catálogo"
                       style="width: 100%">
                <el-option
                    v-for="(cat, index) in cats"
                    :key="index"
                    :label="cat.name"
                    :value="cat.id">
                </el-option>
            </el-select>
        </el-col>
    </el-row>
    <br>
<!--    <entities v-if="selectedCat === 1"/>-->



</div>
</template>

<script>

    import HeaderSection from "../layouts/partials/HeaderSection";
    // import Entities from "../catalogs/entity/index";

    export default {
        components: {
            HeaderSection,
        },

        data(){
            return{
                selectedCat: null,
                cats: [
                    {id:6,  name: 'Acción Solicitada'},
                ],
            }
        },

        methods: {
            goTo(link, data) {
                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: link
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            }
        }
    }
</script>

<style scoped>
    .links {
        font-size: 25px;
        color: #9D2449;
        cursor: pointer;
        text-decoration: underline;
    }
</style>
