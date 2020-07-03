<template>
    <div style="width:80%; margin:0px auto;">
        <el-row :gutter='22'>
          <el-col :span='24'>
          <div style="width:100%; padding-bottom:10px; display:flex; justify-content:flex-end;">
               <div>
                 <el-button-group>
                     <el-button
                         size="mini"
                         type="danger"
                         icon="el-icon-arrow-left"
                         @click="$router.push({name: 'StrategiesIndex' })">
                         Regresar
                     </el-button>
                 </el-button-group>
               </div>
          </div>
          </el-col>
        </el-row>

        <el-row :gutter='20'>
        <el-col :span='24'>
            <div style="color:#9D2449; font-size: 27px; padding-bottom: 15px;">
                INFORME ESTRATEGIA CONSULAR CONTRA TRÁFICO DE ARMAS
            </div>
        </el-col>

        <el-col :span='24'>
            <div>
                <el-form :model="strategyForm" ref="strategyForm"  class="demo-ruleForm">

                <el-row :gutter='20'>
                    <el-col :span='12'>
                        <div class=''>
                            <el-form-item label="Consulado" prop="cat_consulate_id" required>
                                <el-select style="width: 100%;" size="mini" v-model="strategyForm.cat_consulate_id" placeholder="Consulado">
                                    <el-option
                                        v-for="(consulate , index) in consulates"
                                        :key="index"
                                        :label="consulate.name"
                                        :value="consulate.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div class=''>
                            <el-form-item label="Fecha" required>
                                <el-form-item prop="date">
                                    <el-date-picker size="mini"
                                    :disabled="true"
                                    type="date"
                                    placeholder="Fecha"
                                    v-model="strategyForm.date"
                                    style="width: 100%;"></el-date-picker>
                                </el-form-item>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Regulación vs armas"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.guns"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Acercamiento a sociedad civil líder/organización/think tank"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.civilSociety"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Acercamiento a legisladores demócratas"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.democrats"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Acercamiento a legisladores republicanos"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.republicans"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Acercamiento a academia"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.academy"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Acercamiento Actores económicos"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.economicActors"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Acercamiento a personalidades /posible champion"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.personalities"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Participación/ invitación a espacios con autoridades locales "
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.localAuthorities"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Posicionamiento en medios escritos, redes sociales, radio"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.media"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Vínculo artículo/entrevista"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.articleLink"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Acciones adicionales"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.additional"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                                label="Observaciones"
                                prop="guns"
                                :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Descripción"
                                          size="mini"
                                          style="width:100%;"
                                          type="textarea"
                                          :rows="8"
                                          maxlength="254"
                                          show-word-limit
                                          v-model="strategyForm.observations"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <p></p>
                    <el-col :span='24'>
                        <div style="width:100%; padding:5px; display:flex; justify-content:flex-end;">
                            <el-button
                                size="mini"
                                type="success"
                                icon="el-icon-check"
                                @click="submitForm">
                                Enviar
                            </el-button>
                        </div>
                    </el-col>
                </el-row>
                </el-form>
            </div>
        </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        components: {
        },

        data() {

            return {
                consulates: [],
                strategyForm:{
                    period: 'S15',
                    cat_consulate_id: null,
                    date: new Date(),
                    guns: '',
                    civilSociety: '',
                    democrats: '',
                    republicans: '',
                    academy: '',
                    economicActors: '',
                    personalities: '',
                    localAuthorities: '',
                    media: '',
                    articleLink: '',
                    additional: '',
                    observations: ''
                },

            }
        },

        created() {
            this.startLoading();
            axios.get('/api/strategies/create').then(response => {
                this.consulates = response.data.consulates;

                this.stopLoading();
            }).catch(error => {
                this.stopLoading();

                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });
        },
        computed: {
        },


        methods: {

            submitForm() {
                this.startLoading();
                let params = {
                    strategy:this.strategyForm,
                };

                axios.post('/api/strategies', params).then(response => {
                    this.stopLoading();
                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "Se almaceno correctamente"
                    });
                    this.strategyForm = {};
                    this.$router.push('/estrategia/');
                }).catch(error => {
                    this.stopLoading();
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                })
            },

        },
    }
</script>


<style scoped>

</style>



