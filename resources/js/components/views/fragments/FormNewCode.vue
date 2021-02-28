<template>
<div class="animatedd fadeInn fastt">
    <el-form :model="ruleForm" ref="ruleForm">
        <el-row :gutter='20'>
            <el-col :span='24'>
                <el-form-item label="Selecciona un usuario" prop="user_id"
                            :rules="[{ required: true, message: message.ruleForm.required }]">
                    <el-select v-model="ruleForm.user_id" placeholder="Selecciona un usuario" size="mini" style="width: 100%;">
                        <el-option
                        v-for="item in users"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span='24'>
                <el-form-item label="Codigo de promoción" prop="code" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input :disabled="true" v-model="ruleForm.code" placeholder="Codigo de promoción" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='24'>
                <el-form-item label="Selecciona una paquete" prop="pack_id"
                        :rules="[{ required: true, message: message.ruleForm.required }]">
                    <el-select v-model="ruleForm.pack_id" placeholder="Selecciona un paquete" size="mini" style="width: 100%;">
                        <el-option
                        v-for="item in packs"
                        :key="item.id"
                        :label="item.namepack.name+' | '+item.name+' | '+(item.triple_double === 1?'Triple play' : 'Doble play' )"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span='24'>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group float-right">
                            <button type="button" @click="closeModal" class="btn btn-danger btn-sm"> <i class="el-icon-close"></i> Cerrar</button>
                            <button v-if="!items.type" type="button" @click="clearForm" class="btn btn-primary btn-sm"> <i class="el-icon-delete"></i> Limpiar</button>
                            <button v-if="!items.type" type="button" @click="newPromotion" class="btn btn-success btn-sm"> <i class="el-icon-check"></i> Guardar</button>
                            <button v-if="items.type" type="button" @click="updatePromotion" class="btn btn-success btn-sm"> <i class="el-icon-check"></i> Actualizar</button>
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
                user_id:null,
                code:null,
                pack_id:null
            },
            user_id:null,
            users:[],
            packs:[],
            GUID:null
        }
    },
    created(){
    },
    mounted() {
        this.clearForm();
        this.getCats();
        if(this.items.type){
            this.getEdit(this.items.data);
        }else{
            this.ruleForm.code = String(this.generateUUID());
        }


        setTimeout(() => {
            this.$store._modules.root.state.totalplay.loading = false;
        }, 1000);
    },
    computed:{
    },
    methods:{
        generateUUID(){ // Public Domain/MIT
        var d = new Date().getTime();
        if (typeof performance !== 'undefined' && typeof performance.now === 'function'){
            d += performance.now(); //use high-precision timer if available
        }
        var newGuid = 'x4-xyxx-xyxx'.replace(/[xy]/g, function (c) {
            var r = (d + Math.random() * 16) % 16 | 0;
            d = Math.floor(d / 16);
            return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });

        return newGuid;
        },
        ValidatorPassword(rule, value, callback){
            if(this.ruleForm.password === value){
                callback();
            }else{
                return callback(new Error("Las credenciales no coinciden verifique sus campos."));
            }
        },
        updatePromotion(){
            //this.$store._modules.root.state.totalplay.loading = true;
            this.$refs['ruleForm'].validate((valid) => {
            if (valid) {
                axios.post('/api/updatePromotion', this.ruleForm ).then(response => {
                    if(response.data.success){
                        this.$message({
                            message: 'El codigo de promoción fue actualizado exitosamente.',
                            type: 'success'
                        });
                        this.$emit('responseCode',true);
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
        getEdit(promotion){
            setTimeout(() => {
                this.user_id = promotion.user_id;
                this.ruleForm.code = promotion.code;
                this.ruleForm.pack_id = promotion.pack_id;
            }, 1000);
        },
        closeModal(){
            this.clearForm();
            this.$emit('responseCode',true);
        },
        newPromotion(){
            //this.$store._modules.root.state.totalplay.loading = true;
            this.$refs['ruleForm'].validate((valid) => {
            if (valid) {
                console.log("form: ",this.ruleForm);
                axios.post('/api/createCodePromotion',this.ruleForm).then(response => {
                    if(response.data.success){
                        if( response.data.lResults.exist === false ){
                            this.$message({
                                message: 'El codigo de promoción fue creado exitosamente.',
                                type: 'success'
                            });
                            this.$emit('responseCode',true);
                        }else{
                            this.$store._modules.root.state.totalplay.loading = false;
                            this.$message({
                                message: 'El codigo de promoción ya existe intente nuevamente.',
                                type: 'warning'
                            });
                            this.$emit('responseCode',true);
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
            this.ruleForm={
                user_id:null,
                code:null,
                pack_id:null
            };
            this.$refs['ruleForm'].resetFields();
        },
        getCats(){
            axios.get('/api/getCatsPromotion').then(response => {
                if(response.data.success){
                    this.users = response.data.lResults.users;
                    this.packs = response.data.lResults.packs;
                }
            }).catch(error => {
                console.error(error);
            });
        }
    }
}
</script>
