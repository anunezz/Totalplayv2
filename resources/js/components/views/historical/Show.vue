<template>
    <div v-if="formality !== null">
        <header-section icon="fa-eye" title="Consulta de expediente">
            <template slot="buttons">
                <el-button
                    size="medium"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push({name: 'HistoricalIndex' })">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <el-row class="border-form">
            <el-row style="border-bottom: 1px solid #b3b9c8">
                <el-col :span="24">
                    <h3> <i class="fas fa-file-signature"></i>
                        Información, Expediente
                    </h3>
                </el-col>
            </el-row>
            <el-row :gutter="24" style="margin-top: 25px">
                <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8" style="border-left: 5px solid #b3b9c8">
                    <el-row class="information">
                        <el-row><span style="font-weight: bold;">Determinante de la unidad:</span> {{ formality.key_units }}</el-row>
                        <br>
                        <el-row><span style="font-weight: bold;">Clasificación:</span> {{ formality.i_topograf }}</el-row>
                        <br>
                        <el-row><span style="font-weight: bold;">Sección:</span> {{ formality.key_section }}  {{formality.section.name}}</el-row>
                        <br>
                        <el-row><span style="font-weight: bold;">Serie:</span> {{ formality.key_serie }}  {{formality.serie.name}}</el-row>
                        <br>
                        <el-row><span style="font-weight: bold;">Subserie:</span> {{ formality.key_subserie }} {{formality.subserie.name}}</el-row>
                    </el-row>
                </el-col>
                <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8" style="border-left: 5px solid #b3b9c8">
                    <el-row class="information">
                        <el-row><span style="font-weight: bold;">Número de Expediente:</span> {{formality.case_file}}</el-row>
                        <br>
                        <el-row><span style="font-weight: bold;">Año:</span> {{ formality.date}}</el-row>
                        <br>
                        <el-row><span style="font-weight: bold;">Fecha apertura:</span> {{ formality.open }}</el-row>
                        <br>
                        <el-row><span style="font-weight: bold;">Valor documental:</span>
                            <span v-if="formality.documentary !== null">{{ formality.documentary.name}}</span>
                        </el-row>
                    </el-row>
                </el-col>
                <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8" style="border-left: 5px solid #b3b9c8">
                    <el-row class="information">
                        <el-row><span style="font-weight: bold;">Tradición documental:</span>
                            <span v-if="formality.documentation !== null">{{formality.documentation.name}}</span>
                        </el-row>
                        <br>
                        <el-row><span style="font-weight: bold;">Carácter de la información:</span>
                            <span v-if="formality.term !== null">{{formality.term.name}}</span>
                        </el-row>
                        <br>
                        <el-row><span style="font-weight: bold;">Creado por:</span> {{formality.user.name}}</el-row>
                    </el-row>
                </el-col>
            </el-row>
            <el-divider></el-divider>
            <el-row style="margin-top: 25px;">
                <el-col :span="24">
                    <span style="font-weight: bold;">Asunto:</span>
                    <p>{{formality.affair}}</p>
                </el-col>
            </el-row>
            <el-divider></el-divider>
            <el-row style="margin-top: 25px;">
                <el-col :span="24">
                    <span style="font-weight: bold;">Descripción:</span>
                    <p>{{formality.description}}</p>
                </el-col>
            </el-row>
        </el-row>
        <el-row class="border-form">
            <el-row style="border-bottom: 1px solid #b3b9c8;margin-bottom: 20px">
                <h3><i class="fas fa-folder-plus"></i>
                    Información, Adicional.
                </h3>
            </el-row>
            <el-row :gutter="24">
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12" style="margin-bottom: 20px">
                    <el-card>
                        <div slot="header" >
                            <span style="font-weight: bold;">Ubicación.</span>
                        </div>
                        <el-row>
                            <el-row><span style="font-weight: bold;">Mueble:</span> {{ formality.fitment }}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Nivel:</span> {{ formality.level }}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Pasillo:</span> {{ formality.aisle }}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Caja:</span> {{ formality.box }}</el-row>
                        </el-row>
                    </el-card>
                </el-col>
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                    <el-card>
                        <div slot="header" >
                            <span style="font-weight: bold;">Plazos de Conservación.</span>
                        </div>
                        <el-row>
                            <el-row><span style="font-weight: bold;">Archivo de trámite (AT):</span> {{ formality.AT }}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Archivo de concentración (AC):</span> {{ formality.AC }}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Vigencia:</span> {{ formality.validity }}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Destino Final :</span>
                                <span v-if="formality.inventory !== null">{{formality.inventory.name}}</span>
                            </el-row>
                        </el-row>
                    </el-card>
                </el-col>
            </el-row>
            <el-row :gutter="24" style="margin-top: 20px">
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12" style="margin-bottom: 20px">
                    <el-card>
                        <div slot="header" >
                            <span style="font-weight: bold;">Condiciones de acceso.</span>
                        </div>
                        <el-row>
                            <el-row><span style="font-weight: bold;">Fundamento Legal:</span> {{ formality.legal_foundation}}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Ampliación de periodo de reserva:</span> {{ formality.extension }}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Fecha de clasificación:</span> {{ formality.classification }}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Fecha de desclasificación:</span> {{ formality.declassification}}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Periodo de reserva:</span> {{ formality.period}}</el-row>
                        </el-row>
                    </el-card>
                </el-col>
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                    <el-card>
                        <div slot="header" >
                            <span style="font-weight: bold;">Otros.</span>
                        </div>
                        <el-row>
                            <el-row><span style="font-weight: bold;">Fecha cierre:</span> {{ formality.close }}</el-row>
                            <br>
                            <el-row><span style="font-weight: bold;">Fojas:</span> {{ formality.fojas }}</el-row>
                        </el-row>
                    </el-card>
                </el-col>
            </el-row>
            <el-divider></el-divider>
            <el-row style="margin-top: 25px;">
                <el-col :span="24">
                    <span style="font-weight: bold;">Soporte:</span>
                    <p v-if="formality.soport !== null">{{formality.soport.name}}</p>
                </el-col>
            </el-row>
            <el-row style="margin-top: 25px;" type="flex" justify="end">
                <el-button
                    size="medium"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push({name: 'HistoricalIndex' })">
                    Regresar
                </el-button>
            </el-row>
        </el-row>
    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";

    export default {
        components: {
            HeaderSection
        },

        data() {
            return {
                formality:null
            }
        },
        created() {
            if (this.$route.params.id !== undefined) this.showRegister(this.$route.params.id);
        },
        methods: {
            showRegister(id){
                this.startLoading();
                axios.get(`/api/formalitiesSicar/${id}`).then(response => {
                    this.formality = response.data.formalitySicar;
                    this.stopLoading();
                }).catch(error => {
                    this.stopLoading();
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            }
        },
    }
</script>

<style scoped>
.border-form{
    padding: 25px;
    border: 1px solid #c7cbd4;
    border-radius: 5px;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
}
.information{
    padding: 5px;
}
</style>
