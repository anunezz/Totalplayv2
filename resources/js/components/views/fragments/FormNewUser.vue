<template>
<div class="animatedd fadeInn fastt">
    <el-form :model="ruleForm" ref="ruleForm">
        <el-row :gutter='20'>
            <el-col :span='12'>
                <el-form-item label="Usuario" prop="username" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input :disabled="items.type" v-model="ruleForm.username" placeholder="Usuario" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Perfil" prop="profile">
                    <el-select v-model="ruleForm.profile" placeholder="Selecciona un perfil" size="mini" style="width: 100%;">
                        <el-option
                        v-for="item in profiles"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Nombre" prop="name" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input v-model="ruleForm.name" placeholder="Nombre" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Apellido paterno" prop="firstName" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input v-model="ruleForm.firstName" placeholder="Apellido paterno" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Apellido Materno" prop="secondName" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input v-model="ruleForm.secondName" placeholder="Apellido Materno" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Email" prop="email" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: email, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input :disabled="items.type" v-model="ruleForm.email" placeholder="Email" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                Asignar codigo de promoción:
                <br><br>
                <el-switch
                    style="display: block width:100%;"
                    v-model="switchCode"
                    @change="generateUUID(items.type,( items.type? items.data.code:null))"
                    active-color="#13ce66"
                    inactive-color="#ff4949"
                    active-text="Activar"
                    inactive-text="Desactivar">
                </el-switch>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Codigo de promoción" prop="code" :rules="[{ required: switchCode, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input :disabled="true" v-model="ruleForm.code" placeholder="Codigo de promoción" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='24' v-if="items.type">
                Actualizar Password:
                <br><br>
                <el-switch
                    v-model="showPassword"
                    active-text="Actualizar"
                    inactive-text="No actualizar">
                </el-switch>
            </el-col>
            <el-col :span='12' v-if="disablePassword">
                <el-form-item label="Password" prop="password" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input type="password" v-model="ruleForm.password" placeholder="Password" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='12' v-if="disablePassword">
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
                            <button type="button" @click="closeModal" class="btn btn-danger btn-sm"> <i class="el-icon-close"></i> Cerrar</button>
                            <button v-if="!items.type" type="button" @click="clearForm" class="btn btn-primary btn-sm"> <i class="el-icon-delete"></i> Limpiar</button>
                            <button v-if="!items.type" type="button" @click="newUser" class="btn btn-success btn-sm"> <i class="el-icon-check"></i> Guardar</button>
                            <button v-if="items.type" type="button" @click="editUser" class="btn btn-success btn-sm"> <i class="el-icon-check"></i> Actualizar</button>
                        </div>
                    </div>
                </div>
            </el-col>
        </el-row>
    </el-form>
</div>
</template>

<script>
import { Globals } from "../../../mixins/Globals";
export default {
    mixins:[Globals],
    props: { 'items': Object },
    data(){
        return {
            ruleForm:{
                name:null,
                firstName:null,
                secondName:null,
                email:null,
                code:null,
                profile:null,
                username:null,
                password:null,
                Rpassword:null,
            },
            user_id:null,
            profiles:[],
            showPassword:false,
            switchCode:false
        }
    },
    created(){
        if(this.items.type){
            this.getEdit(this.items.data);
        }
        this.getCats();
    },
    mounted() {
        this.clearForm();
        setTimeout(() => {
            this.$store._modules.root.state.totalplay.loading = false;
        }, 1000);
    },
    computed:{
        disablePassword(){
            let aux = false;
                if(this.items.type){
                    aux = this.showPassword;
                }
                if(this.items.type === false && this.showPassword === false){
                    aux = true;
                }
            return aux;
        }
    },
    methods:{
        generateUUID(active,code){ // Public Domain/MIT
        console.log(this.items.type,code);
        var d = new Date().getTime();
        if (typeof performance !== 'undefined' && typeof performance.now === 'function'){
            d += performance.now(); //use high-precision timer if available
        }
        var newGuid = 'x4-xyxx-xyxx'.replace(/[xy]/g, function (c) {
            var r = (d + Math.random() * 16) % 16 | 0;
            d = Math.floor(d / 16);
            return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });

        if( active ){
            if (code.name) {
                this.ruleForm.code =  code.name;
            }else{
                this.ruleForm.code = this.switchCode? newGuid: null;
            }
            this.ruleForm.code = ( code.name === null?newGuid: code.name );
        }else{
            this.ruleForm.code = this.switchCode? newGuid: null;
        }

        },
        ValidatorPassword(rule, value, callback){
            if(this.ruleForm.password === value){
                callback();
            }else{
                return callback(new Error("Las credenciales no coinciden verifique sus campos."));
            }
        },
        editUser(){
            //this.$store._modules.root.state.totalplay.loading = true;
            this.$refs['ruleForm'].validate((valid) => {
            if (valid) {
                this.ruleForm.switchCode = this.switchCode;
                let data = {
                    updatePassword: this.showPassword,
                    data: this.ruleForm,
                    userid: this.user_id
                };
                axios.post('/api/updateUser', data ).then(response => {
                    if(response.data.success){
                        this.$message({
                            message: 'El usuario fue actualizado exitosamente.',
                            type: 'success'
                        });
                        this.$emit('responseUser',true);
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
        },
        getEdit(user){
            setTimeout(() => {
                this.switchCode = (user.code.isActive === 1? true: false);
                this.ruleForm.code = user.code.name;
                this.user_id = user.hash;
                this.ruleForm.name = user.name;
                this.ruleForm.firstName = user.firstName;
                this.ruleForm.secondName = user.secondName;
                this.ruleForm.email = user.email;
                this.ruleForm.profile = user.profile.id;
                this.ruleForm.username = user.username;
                this.ruleForm.password = null;
                this.ruleForm.Rpassword = null;
            }, 1000);
        },
        closeModal(){
            this.clearForm();
            this.$emit('responseUser',true);
        },
        newUser(){
            //this.$store._modules.root.state.totalplay.loading = true;
            this.$refs['ruleForm'].validate((valid) => {
            if (valid) {
                let data = this.ruleForm;
                    data.switchCode = this.switchCode;
                axios.post('/api/createUser',data).then(response => {
                    if(response.data.success){
                        if( response.data.lResults ){
                            this.$message({
                                message: 'El usuario fue creado exitosamente.',
                                type: 'success'
                            });
                            this.$emit('responseUser',response.data.lResults);
                        }else{
                            this.$store._modules.root.state.totalplay.loading = false;
                            this.$message({
                                message: 'El usuario o email ya existe ingresa otro usuario diferente.',
                                type: 'warning'
                            });
                        }
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
        },
        clearForm(){
            this.user_id = null;
            this.switchCode = false;
            this.ruleForm={
                name:null,
                firstName:null,
                secondName:null,
                email:null,
                code:null,
                profile:null,
                username:null,
                password:null,
                Rpassword:null,
            };
            this.$refs['ruleForm'].resetFields();
        },
        getCats(){
            axios.get('/api/getCatsUser').then(response => {
                if(response.data.success){
                    this.profiles = response.data.lResults.profiles;
                }
            }).catch(error => {
                console.error(error);
            });
        }
    }
}
</script>
