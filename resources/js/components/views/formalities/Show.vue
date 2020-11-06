<template>
    <div>
        <header-section icon="fas fa-file-signature" title="Consulta de trámite">
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

        }
    },
    created() {
        if (this.$route.params.id !== undefined) this.showRegister(this.$route.params.id);
    },
    methods:{
        showRegister(id){
            axios.get(`/api/formalities/${id}`).then(response => {

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

</style>
