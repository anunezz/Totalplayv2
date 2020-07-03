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
      <!--          <el-col v-if="userForm.cat_profile_id !== 1"
                        :span="userForm.cat_profile_id !== 3 ? 8 : 12">
                    <el-form-item v-if="userForm.cat_profile_id === 2 || userForm.cat_profile_id === 4"
                                  label="Misión"
                                  prop="cat_mission_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.cat_mission_id"
                                   filterable placeholder="Seleccionar"
                                   @change="getOrganisms(userForm.cat_mission_id)"
                                   style="width: 100%">
                            <el-option
                                v-for="(mission , index) in missions"
                                :key="index"
                                :label="mission.name"
                                :value="mission.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item v-if="userForm.cat_profile_id === 3"
                                  label="Consulado"
                                  prop="cat_consulate_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.cat_consulate_id"
                                   filterable placeholder="Seleccionar"
                                   style="width: 100%">
                            <el-option
                                v-for="(consulate , index) in consulates"
                                :key="index"
                                :label="consulate.name"
                                :value="consulate.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>   -->
         <!--       <el-col v-if="userForm.cat_profile_id !== 3 && userForm.cat_profile_id !== 1 && userForm.cat_profile_id !== 5" :span="8">
                    <el-form-item label="Organismo"
                                  prop="cat_organism_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.cat_organism_id"
                                   filterable placeholder="Seleccionar"
                                   style="width: 100%">
                            <el-option
                                v-for="(organism , index) in organisms"
                                :key="index"
                                :label="organism.name"
                                :value="organism.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>  -->
                <el-col :span="userForm.cat_profile_id === 1 || userForm.cat_profile_id === 5 ? 24 : userForm.cat_profile_id !== 1 ? 12 : 12">
                    <el-form-item label="Perfl"
                                  prop="cat_profile_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.cat_profile_id"
                                   filterable placeholder="Seleccionar"
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
                <el-col v-if="userForm.cat_profile_id !== 1" :span="12">
                    <el-form-item label="Consulado"
                                  prop="cat_consulate_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.cat_consulate_id"
                                   filterable placeholder="Seleccionar"
                                   multiple
                                   style="width: 100%">
                            <el-option
                                v-for="(consulate , index) in consulates"
                                :key="index"
                                :label="consulate.name"
                                :value="consulate.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row :gutter="10">
                <el-col :span="8">
                    <el-form-item label="Nombre"
                                  prop="name"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-input v-model="userForm.name" maxlength="100"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="Apellido Paterno"
                                  prop="firstName"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-input v-model="userForm.firstName" maxlength="100"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="Apellido Materno">
                        <el-input v-model="userForm.secondName" maxlength="100"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
   <!--         <el-row :gutter="10" v-if="userForm.cat_profile_id !== 1 && userForm.cat_profile_id !== 5">
                <el-col :span="24">
                    <el-form-item label="Temas"
                                  prop="topics"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select v-model="userForm.topics"
                                   multiple filterable placeholder="Seleccionar"
                                   style="width: 100%">
                            <el-option
                                v-for="(topic , index) in topics"
                                :key="index"
                                :label="topic.name"
                                :value="topic.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row> -->
            <el-row :gutter="10">
                <!--<el-col :span="5" :offset="14">
                    <el-button type="primary" style="width: 100%" @click="cleanAll()">Limpiar</el-button>
                </el-col>-->
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
                consulates: [],
                missions: [],
                organisms: [],
                topics: [],
                userForm: {
                    cat_profile_id: null,
                    cat_consulate_id: null,
                    cat_mission_id: null,
                    cat_organism_id: null,
                    topics: [],
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
                this.consulates = response.data.consulates;
                this.missions = response.data.missions;
                this.organisms = response.data.organisms;
                this.topics = response.data.topics;
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
