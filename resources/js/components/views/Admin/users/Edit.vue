<template>
    <div>
        <header-section icon="fa-user-plus" title="Editar usuario">
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
                <el-col :span="8">
                    <el-form-item label="Nombre"
                                  prop="name"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-input disabled v-model="userForm.name" maxlength="100"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="Apellido Paterno"
                                  prop="firstName"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-input disabled v-model="userForm.firstName" maxlength="100"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="Apellido Materno">
                        <el-input disabled v-model="userForm.secondName" maxlength="100"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row :gutter="10">
                <el-col :span="userForm.cat_profile_id === 1 || userForm.cat_profile_id === 5 ? 12 : userForm.cat_profile_id !== 1 ? 8 : 8">
                    <el-form-item label="Perfl"
                                  prop="cat_profile_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.cat_profile_id"
                                   filterable placeholder="Seleccionar"
                                   @change="changeUnit"
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
                <el-col :span="userForm.cat_profile_id === 1 || userForm.cat_profile_id === 5 ? 12 : userForm.cat_profile_id !== 1 ? 8 : 8">
                    <el-form-item label="Determinante"
                                  prop="cat_determinant_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.cat_determinant_id"
                                   filterable placeholder="Seleccionar"
                                   style="width: 100%">
                            <el-option
                                v-for="(determinant , index) in determinants"
                                :key="index"
                                :label="determinant.name"
                                :value="determinant.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item v-if="userForm.cat_profile_id === 2"
                                  label="Unidad administrativa11111111111"
                                  prop="cat_unit_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.cat_unit_id"
                                   clearable
                                   filterable placeholder="Seleccionar"
                                   style="width: 100%">
                            <el-option
                                v-for="(unit , index) in units"
                                :key="index"
                                :label="unit.name"
                                :value="unit.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col  :span="8">
                    <el-form-item v-if="userForm.cat_profile_id === 3"
                                  label="Unidad administrativa"
                                  prop="cat_administrative_unit_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.cat_administrative_unit_id"
                                   clearable
                                   filterable placeholder="Seleccionar"
                                   multiple
                                   style="width: 100%">
                            <el-option
                                v-for="(unit , index) in units"
                                :key="index"
                                :label="unit.name"
                                :value="unit.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row> <br>
            <el-row :gutter="10">
                <el-col :span="5" :offset="19">
                    <el-button type="success" style="width: 100%" @click="submitForm">
                        Actualizar
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
                determinants: [],
                consulates: [],
                missions: [],
                organisms: [],
                units: [],
                userForm: {
                    cat_profile_id: null,
                    cat_determinant_id: null,
                    cat_unit_id: null,
                    cat_administrative_unit_id: [],
                    name: '',
                    firstName: '',
                    secondName: ''
                }
            }
        },

        created() {
            this.startLoading();

            axios.get('/api/users/' + this.$route.params.id + '/edit').then(response => {
                this.profiles = response.data.profiles;
                this.determinants = response.data.determinants;
                this.units = response.data.units;
                this.userForm = response.data.userForm;

                this.stopLoading();
            }).catch(error => {
                this.stopLoading();

                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            })
        },

        methods: {
            cleanAll()
            {
                this.userForm.username = '';
                this.userForm.cat_profile_id = null;
                this.userForm.cat_consulate_id = null;
                this.userForm.cat_mission_id = null;
                this.userForm.cat_organism_id = null;
                this.userForm.topics = [];
                this.userForm.name = '';
                this.userForm.firstName = '';
                this.userForm.secondName = '';
            },

            changeUnit()
            {
                console.log('perfilll', this.userForm.cat_profile_id);
                console.log('muchoss',  this.userForm.cat_administrative_unit_id);
                this.userForm.cat_administrative_unit_id = [];
                this.userForm.cat_unit_id = null;
                // this.startLoading();
                // axios.get('/api/users/' + this.$route.params.id + '/edit').then(response => {
                //     this.stopLoading();
                //     this.units = response.data.units;
                //     this.userForm.cat_administrative_unit_id = null;
                //     this.userForm.cat_unit_id = null;
                //
                // }).catch(error => {
                //     this.stopLoading();
                //
                //     this.$message({
                //         type: "warning",
                //         message: "No fue posible completar la acción, intente nuevamente."
                //     });
                // })
            },

            getOrganisms(id) {
                this.startLoading();

                axios.get(`/api/get-organisms/${id}`).then(response => {
                    this.stopLoading();
                    this.userForm.cat_organism_id = null;
                    this.organisms = response.data.organisms;
                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                })
            },

            changeProfile(profileId) {
                this.startLoading();

                this.userForm.cat_consulate_id = null;
                this.userForm.cat_mission_id = null;
                this.userForm.cat_organism_id = null;
                this.userForm.topics = [];

                axios.get(`/api/get-topics/${btoa(profileId)}`).then(response => {
                    this.stopLoading();
                    this.userForm.topics = [];
                    this.userForm.consulates = [];
                    this.topics = response.data.topics;
                    this.consulates = response.data.consulates;
                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                })
            },

            submitForm() {
                this.startLoading();

                this.$refs['userForm'].validate((valid) => {
                    if (valid) {

                        axios.put(`/api/users/${this.$route.params.id}`, this.userForm).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se actualizo la información correctamente"
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
