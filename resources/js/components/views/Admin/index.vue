<template>
    <div>
        <header-section icon="el-icon-s-management" title="Administración">
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
        <el-row :gutter="10">
            <el-col :span="8">
                <a class="links"
                   @click="goTo('UsersIndex', {cat_transaction_type_id : 1, action: 'Ingresa a Administración de usuarios'})">
                    Usuarios
                </a>
                <br><br>
                <span>Administración de usuarios</span>
            </el-col>
            <el-col :span="8">
                <a class="links"
                   @click="goTo('CatalogsIndex', {cat_transaction_type_id : 1, action: 'Ingresa a Catálogos'})">
                    Catálogos
                </a>
                <br><br>
                <span>Administración de catálogos</span>
            </el-col>
        </el-row>
        <br><br>
        <el-row :gutter="10">
            <el-col :span="8">
                <a class="links"
                   @click="$router.push('/')">
                    Inicio
                </a>
                <br><br>
                <span>Inicio</span>
            </el-col>
      <!--       <el-col :span="8">
                <a class="links"
                   @click="goTo('PanelIndex', {cat_transaction_type_id : 1, action: 'Ingresa al Panel'})">
                    Panel
                </a>
                <br><br>
                <span>Idiomas</span>
                 <br><br>
            </el-col>
        </el-row>
        <el-row :gutter="10">
            <el-col :span="8">
                <a class="links"
                   @click="goTo('PublicIndex', {cat_transaction_type_id : 1, action: 'Ingresar al Publico'})">
                    Público
                </a>
                <br><br>
                <span>Administrador del portal público</span>
            </el-col>  -->
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
