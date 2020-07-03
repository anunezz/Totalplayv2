<template>
    <div>
        <header-section icon="fa-user-plus" title="Nuevo usuario">
            <template slot="buttons">
                <el-button
                    size="medium"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/administracion/usuarios')">
                    Regresar
                </el-button>
            </template>
        </header-section>
        <el-form ref="userForm" :model="userForm" label-width="120px" label-position="top">
            <el-row :gutter="10">
                <el-col :span="12">
                    <el-form-item label="Usuario">
                        <el-input v-model="userForm.username" maxlength="100">
                            <el-button slot="append" icon="el-icon-search"></el-button>
                        </el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="12">
                    <el-form-item label="Perfl">
                        <el-select v-model="userForm.cat_profile_id"
                                   filterable placeholder="Seleccionar"
                                   :disabled="isDisabled"
                                   style="width: 100%">
                            <el-option
                                v-for="(profile , index) in profiles"
                                :key="index"
                                :label="profile.name"
                                :value="profile.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row :gutter="10">
                <el-col :span="8">
                    <el-form-item label="Nombre">
                        <el-input v-model="userForm.name" maxlength="100" :disabled="isDisabled"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="Apellido Paterno">
                        <el-input v-model="userForm.firstName" maxlength="100" :disabled="isDisabled"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="Apellido Materno">
                        <el-input v-model="userForm.secondName" maxlength="100" :disabled="isDisabled"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row :gutter="10">
                <el-col :span="5" :offset="14">
                    <el-button type="primary" style="width: 100%" @click="cleanAll()">Limpiar</el-button>
                </el-col>
                <el-col :span="5">
                    <el-button type="success" :disabled="isDisabled" style="width: 100%" @click="submitForm">
                        Guardar
                    </el-button>
                </el-col>
            </el-row>
        </el-form>
    </div>
</template>

<script>
    import HeaderSection from "../../layouts/partials/HeaderSection";

    export default {
        components: {
            HeaderSection
        },

        watch:{
            'userForm.username': function (value){
                this.userForm.username = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },
            'userForm.name': function (value){
                this.userForm.name = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },
            'userForm.firstName': function (value){
                this.userForm.firstName = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },
            'userForm.secondName': function (value){
                this.userForm.secondName = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },
        },

        data() {
            return {
                profiles: [],
                userForm: {
                    username: '',
                    cat_profile_id: null,
                    name: '',
                    firstName: '',
                    secondName: ''
                },
                isDisabled: true,
            }
        },

        methods: {
            startLoading() {
                this.$store.dispatch(
                    'loading/spinner', {msg: 'Cargando Datos...', status: true}, {root: true});
            },

            stopLoading() {
                this.$store.dispatch('loading/spinner', {}, {root: true});
            },

            cleanAll()
            {
                this.userForm.username = '';
                this.userForm.cat_profile_id = null;
                this.userForm.name = '';
                this.userForm.firstName = '';
                this.userForm.secondName = '';
            },

            submitForm() {
                this.startLoading();

                this.$refs['userFom'].validate((valid) => {
                    if (valid) {

                        axios.post('/api/users', this.userFom).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se almaceno la información correctamente"
                            });

                            this.$router.push('/administracion/usuarios');
                        }).catch(error => {
                            this.stopLoading();

                            this.$message({
                                type: "warning",
                                message: "No fue posible completar la acción, intente nuevamente."
                            });
                        })
                    }
                    else {
                        this.stopLoading();
                    }
                });
            }
        },
    }
</script>

<style scoped>

</style>
