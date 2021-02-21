<template>
<div class="animatedd fadeInn fastt">
    <el-form :model="ruleForm" ref="ruleForm">
        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <div>
                    <h4>Editar credenciales</h4>
                </div>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Password" prop="password" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input type="password" v-model="ruleForm.password" placeholder="Password" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Repetir password" prop="Rpassword" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { validator: ValidatorPassword, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input type="password" v-model="ruleForm.Rpassword" placeholder="Repite password" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='24'>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group float-right">
                            <button type="button" @click="updatePassword" class="btn btn-success btn-sm"> <i class="el-icon-check"></i> Actualizark</button>
                        </div>
                    </div>
                </div>
            </el-col>
        </el-row>
    </el-form>
</div>
</template>

<script>
import { Globals } from "../../../../../mixins/Globals";
export default {
    mixins:[Globals],
    data(){
        return {
            ruleForm:{
                password:null,
                Rpassword:null,
            },
        }
    },
    mounted() {
        setTimeout(() => {
            this.$store._modules.root.state.totalplay.loading = false;
        }, 1000);
    },
    methods:{
        ValidatorPassword(rule, value, callback){
            if(this.ruleForm.password === value){
                callback();
            }else{
                return callback(new Error("Las credenciales no coinciden verifique sus campos."));
            }
        },
        updatePassword(){
            this.$store._modules.root.state.totalplay.loading = true;
            this.$refs['ruleForm'].validate((valid) => {
            if (valid) {
                axios.post('/api/updatePassword',this.ruleForm).then(response => {
                    if(response.data.success){
                        this.$message({
                            message: 'Las credenciales fueron actualizadas exitosamente.',
                            type: 'success'
                        });
                        this.$router.push('/login');
                        this.$store._modules.root.state.totalplay.loading = false;
                    }
                }).catch(error => {
                    this.$store._modules.root.state.totalplay.loading = false;
                    this.$message({
                        message: 'No se pudo completar la acción.',
                        type: 'warning'
                    });
                });
            } else {
                this.$store._modules.root.state.totalplay.loading = false;
                this.$message({
                    message: 'Revise los campos del formulario.',
                    type: 'warning'
                });
                return false;
            }
            });
        }
    }
}
</script>
