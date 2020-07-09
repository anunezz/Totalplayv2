<template>
    <div>
        <header-section icon="el-icon-s-management" title="Reportes">
            <template slot="buttons">
                <el-button
                    align="right"
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/')">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <el-row :gutter='20'>
            <el-col :span="8">
                <el-badge class="item">
                    <a class="links" @click="$router.push( {name:'Record'})">
                        Reportes de Expedientes
                    </a>
                </el-badge>
                <br /><br />
                <span>Reportes de Expedientes</span>
            </el-col>

            <el-col :span="8">
                <el-badge class="item">
                    <a class="links" @click="goTo('LabelIndex', { cat_transaction_type_id: 1, action: 'Ingresa a reportes de etiqueta'})">
                        Etiqueta
                    </a>
                </el-badge>
                <br /><br />
                <span>Etiqueta</span>
            </el-col>

            <el-col :span="8">
                <el-badge class="item">
                    <a class="links" @click="$router.push( {name:'Transfer'})">
                        Formatos de Trasferencia
                    </a>
                </el-badge>
                <br /><br />
                <span>Formatos de Trasferencia</span>
            </el-col>
        </el-row>

    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    export default {
        components: {
            HeaderSection
        },
        methods: {
            goTo(link, data) {

                axios.post("/api/transaction", data).then(response => {
                    this.$router.push({ name: link });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message:
                            "No fue posible completar la acción, intente nuevamente."
                    });
                });
            }
        }
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
