<template>
<div>
    <header-section icon="el-icon-edit" title="Módulo para la edición de multilenguaje SERIDH">
        <template slot="buttons">
            <el-button
                size="small"
                type="success"
                icon="el-icon-plus"
                @click="newlanguage">
                Nuevo
            </el-button>
            <el-button
                size="small"
                type="danger"
                icon="el-icon-arrow-left"
                @click="$router.push('/administracion/')">
                Regresar
            </el-button>
        </template>
    </header-section>

    <el-dialog title="Crear nuevo idioma"
               :center="true"
               :visible.sync="newRegisterDialog"
               width="30%">
        <el-card shadow="never">
        <el-form ref="tabform" :model="tabform" label-width="120px" label-position="top" >
            <el-form-item prop="newTabName"
                          :rules="[ {  required: true, message: 'Este campo es requerido', trigger: 'blur',} ,
                           {  type: 'string', required: false, pattern: /^[a-z]+$/, message: 'el acronimo debe llevar letras minusculas', trigger: 'change'}
                                  ]">
                <el-input :center="true" size="small" style="width : 270px" maxlength="2" show-word-limit placeholder="Escribe el Acronimo del idioma" v-model="tabform.newTabName" ></el-input>
            </el-form-item>

            <el-form-item>
                <el-row type="flex" class="row-bg" justify="end">
                    <el-col :span="15">
                        <el-button
                             type="primary"
                             style="width: 100%"
                             size="small"
                             v-model="tabform.newTabName"
                             @click="addTab(tabform.newTabName)"> Añadir idioma
                        </el-button>
                    </el-col>
                </el-row>
            </el-form-item>
        </el-form>
        </el-card>
    </el-dialog>


    <el-tabs type="border-card" v-model="activeName" @tab-click="getLang(activeName)">
        <el-tab-pane v-for="(lang, index) in langs" :key="index" :label="lang.acronym" :name="lang.acronym" @click="active=lang.acronym" >
            <v-jsoneditor v-model="data" :options="options" height="400px"></v-jsoneditor>

            <p></p>
            <br>
            <el-row :gutter="10">
                <el-col :span="3" >
                    <el-button type="success" style="width: 100%" @click="submitForm(lang.acronym)">Guardar</el-button>
                </el-col>
   <!--             <el-col :span="3" >
                    <el-button type="danger" style="width: 100%" @click="disableLang(lang.acronym)">Eliminar</el-button>
                </el-col>
                <el-col :span="3" >
                    <el-button type="primary" style="width: 100%" @click="rollback()">Recuperar Anterior</el-button>
                </el-col> -->

            </el-row>
        </el-tab-pane>
    </el-tabs>

</div>
</template>

<script>
    import HeaderSection from "../../layouts/partials/HeaderSection";

    export default {
        components: {
            HeaderSection
        },
        data() {
            return {
                data: {},
                newTabName: '',
                langs: [],
                tabIndex: 0,
                activeName: 'es',

                removeHash: null,

                RequestError: false,
                RequestSucces: false,

                tabform: {
                    newTabName: ''
                },

                options: {
                    mode: "code",
                    onEditable: function(node) {
                        //console.log("node", node);
                        return true;
                    }
                },

                newRegisterDialog: false,
                newRegisterName: '',
            }
        },

        created() {
            axios.get('/api/get-langs').then(response => {
                this.langs = response.data.langs;
                this.tabIndex = this.langs.length;
                this.getLang('es');
            }).catch(err => {
                console.log(err);
            });
        },


        methods:
        {
            getLang(value) {
                this.startLoading();
               this.value = value;

                   axios.get("/api/get-lang/" + value).then(response => {
                       this.data = response.data;this.data = response.data;
                       this.stopLoading();
                   }).catch(err => {
                       this.stopLoading();

                       this.$message({
                           type: "warning",
                           message: "No fue posible completar la acción, intente nuevamente."
                       });
                   });

        },

            submitForm(acronym) {
                this.startLoading();

                let data = {
                    'acronym': acronym,
                    'data': this.data
                }

                //this.$refs['tabform'].validate((valid) => {

                    //if (valid) {
                        axios
                            .post('/api/lang/store', data).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se almaceno la información correctamente"
                            });

                        }).catch(error => {
                            this.stopLoading();

                            this.$message({
                                type: "warning",
                                message: "No fue posible completar la acción, intente nuevamente."
                            });
                        })
                   // }
                  //  else {
                    //    this.stopLoading();

                     //   this.$message({
                       //     type: "warning",
                       //     title: 'Error',
                       //     message: "Complete correctamente el campo"
                     //   });
                   // }
           // });

            },

            getPlus(value) {
                this.value = value;
                this.data = {};
            },

            addTab(tabName) {
                this.$refs['tabform'].validate((valid) => {
                    if (valid) {

                        let newTabName = ++this.tabIndex + '';
                        this.langs.push({
                            acronym: tabName
                        });

                        this.newTabName = '';
                        this.newRegisterDialog = false;

                    }

                    else {
                        this.stopLoading();

                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });



            },

            removeTab(targetName) {
                let tabs = this.langs;
                let activeName = this.activeName;
                if (activeName === targetName) {
                    tabs.forEach((tab, index) => {
                        if (tab.name === targetName) {
                            let nextTab = tabs[index + 1] || tabs[index - 1];
                            if (nextTab) {
                                activeName = nextTab.name;
                            }
                        }
                    });
                }

                this.activeName = activeName;
                this.langs = tabs.filter(tab => tab.name !== targetName);
            },

            disableLang(acronym) {
                this.startLoading();

                axios.delete(`/api/lang-deleted/${acronym}`).then(response => {
                    this.stopLoading();
                    this.getLang();
                    //this.removeDialog = false;

                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "El lenguaje se elimino correctamente"
                    });

                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            rollback() {
                axios
                    .post("/api/lang-rollback/" + this.value)
                    .then(response => {
                        this.data = response.data;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            newlanguage(){
                this.newRegisterName = '';
                this.newRegisterDialog = true;
            },

            }

        }

</script>

<style scoped>

</style>
