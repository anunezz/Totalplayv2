<template>
    <div>
        <el-row class="body-form">
            <el-row style="padding: 15px">
                <el-row style="padding-left: 10px; border-left: 8px solid #b3b9c8; margin-bottom: 10px" v-if="formFormalities.quality">
                    <h4>Cualidad:</h4><span v-html="formFormalities.quality"></span>
                </el-row>
                <el-row style="margin-bottom: 10px;margin-top: 50px" v-if="qualityShow && formFormalities.quality">
                    <el-form-item prop="haveQuality"
                                  :rules="[
                    { required: true, message: 'La pregunta es obligatoria', trigger: ['blur','change'] }]">
                        <el-col :span="19">
                            <span style="color: red">*</span>
                            <span style="font-weight: bold;">¿El expediente cuenta con alguna cualidad?</span>
                        </el-col>
                        <el-col :span="5">
                            <el-radio-group v-model="formFormalities.haveQuality" size="medium" :disabled="$store.state.user.profile !== 1 && formFormalities.hash !== undefined">
                                <el-radio border label="Sí"></el-radio>
                                <el-radio border label="No"></el-radio>
                            </el-radio-group>
                        </el-col>
                    </el-form-item>
                </el-row>
                <el-row :gutter="20">
                    <el-col :span="24">
                        <el-form-item label="Asunto/Título:" prop="title" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                            <el-input
                                type="textarea"
                                :rows="3"
                                :maxlength="250"
                                show-word-limit
                                :disabled="$store.state.user.profile !== 1 && formFormalities.hash !== undefined"
                                v-model="formFormalities.title">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="24">
                        <el-form-item label="Alcance y contenido:" prop="scope_and_content" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-input
                                type="textarea"
                                :rows="10"
                                v-model="formFormalities.scope_and_content"
                                :disabled="true">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="24">
                        <el-form-item label="Información adicional:" prop="additional_information">
                            <el-input
                                type="textarea"
                                :rows="3"
                                :maxlength="250"
                                show-word-limit
                                :disabled="$store.state.user.profile !== 1 && formFormalities.hash !== undefined"
                                v-model="formFormalities.additional_information">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-row>
        </el-row>
    </div>
</template>

<script>
    export default {
        props:['formFormalities'],
        data(){
            return{
                qualityShow:false,
            }
        },
        mounted() {
            this.haveQuality();
            if (this.$route.params.id !== undefined) {
                this.formFormalities.haveQuality = this.formFormalities.haveQuality === 1 ? 'Sí' : this.formFormalities.haveQuality === 0 ? 'No' : null;
            }
        },
        methods:{
            haveQuality(){
                let aux = this.formFormalities.serie[0] !== undefined ? this.formFormalities.serie[0] : this.formFormalities.serie;
                console.log('calculando la cualidad',aux)
                if (aux.cat_selection_id === 3) this.qualityShow = true;
            }
        }
    }
</script>

<style scoped>
    .body-form {
        border-left: 1px solid #b3b9c8;
        border-bottom: 1px solid #b3b9c8;
        border-right: 1px solid #b3b9c8;
        border-radius: 5px;
        padding: 20px;
    }
</style>
