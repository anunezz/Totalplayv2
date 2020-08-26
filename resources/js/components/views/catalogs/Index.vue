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
        <units v-if="selectedCat === 1"/>
        <sections v-if="selectedCat === 2"/>
        <series v-if="selectedCat === 3"/>
        <subserie v-if="selectedCat === 4"/>
        <descriptions v-if="selectedCat ===5"/>
        <sampling v-if="selectedCat ===6"/>

    </div>
</template>

<script>

    import HeaderSection from "../layouts/partials/HeaderSection";
    import Units from "./units/index";
    import Sections from "./sections/index";
    import Series from "./series/index";
    import Subserie from "./subseries/index";
    import Descriptions from "./descriptions/index";
    import Sampling from "./sampling/index";

    export default {
        components: {
            HeaderSection,
            Units,
            Sections,
            Series,
            Subserie,
            Descriptions,
            Sampling
        },

        data(){
            return{
                selectedCat: null,
                cats: [
                    {id:1,  name: 'Determinantes'},
                    {id:2,  name: 'Seccion documental'},
                    {id:3,  name: 'Serie documental'},
                    {id:4,  name: 'Subserie documental'},
                    {id:5,  name: 'CGCA'},
                    {id:6,  name: 'CDD'}
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
