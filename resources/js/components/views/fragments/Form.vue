<template>
    <div style="width: 80%; margin: 0px auto;">
        <el-row :gutter='20'>
            <el-col :span='24'>
                <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="top" >
                    <el-row :gutter='20'>
                        <el-col :span='24'>
                            <el-form-item prop="name"
                            :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                                <el-input size="mini" style="width: 100%;" placeholder="Nombre"
                                v-model="ruleForm.name"></el-input>
                            </el-form-item>
                        </el-col>
                        <!-- <el-col :span='24'>
                            <el-form-item prop="zip_code"
                                :rules="[{ required: true, message: message.ruleForm.required },
                                    { min: 5, max: 5, message: message.ruleForm.max_characters+' 5.', trigger: ['blur','change'] },
                                    { pattern: zip_code, message: message.ruleForm.special_characters, trigger: ['blur','change']}]">
                                <el-input size="mini" style="width: 100%;" placeholder="Codigo postal"
                                v-model="ruleForm.zip_code"></el-input>
                            </el-form-item>
                        </el-col> -->
                        <!-- <el-col :span='24'>
                            <el-form-item prop="email" :autocomplete="false"
                                :rules="[{ required: false, message: message.ruleForm.required },
                                    { pattern: email, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                                <el-input size="mini" style="width: 100%;" placeholder="Correo electronico"
                                v-model="ruleForm.email"></el-input>
                            </el-form-item>
                        </el-col> -->
                        <el-col :span='24'>
                            <el-form-item prop="phone" :rules="[
                                    { validator: validatorPhone, trigger: ['blur','change'] },
                                    { min:10 ,max: 10, message: message.ruleForm.max_characters_phone , trigger: ['blur','change'] }]">
                                <el-input size="mini" style="width: 100%;" placeholder="Número telefonico"
                                v-model="ruleForm.phone"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span='24'>
                            <el-form-item prop="promotion_code" :autocomplete="false"
                                :rules="[{ required: false, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                                <el-input size="mini" style="width: 100%;" placeholder="Codigo de promoción"
                                v-model="ruleForm.promotion_code"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col v-if="modal" :span='24'>
                            <div style='width:100%; display:flex; justify-content: center;'>
                                <div style="width: 55%;">
                                    <el-button style="width: 100%;" type="default" @click="SubmitForm" icon="el-icon-phone-outline" size="small">Solicitar llamada</el-button>
                                </div>
                            </div>
                        </el-col>
                        <el-col v-else :span='24'>
                            <el-form-item>
                                <!-- <el-button class="chicle" type="info" @click="SubmitForm" icon="el-icon-phone-outline" style="width: 100%;" size="mini">Solicitar llamada</el-button> -->
                                <el-button type="default" @click="SubmitForm" icon="el-icon-phone-outline" style="width: 100%;" size="small">Solicitar llamada</el-button>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

<script>
import {Globals} from "../../../mixins/Globals";

export default {
    mixins:[Globals],
    props: {
        promotion_id: Number,
        modal: Boolean
    },
    data() {
        return {
            ruleForm: {
                name: null,
                city_id: null,
                //zip_code: null,
                //email: null,
                phone: null,
                promotion_code: null
            },
            rules:{}
        }
    },
    computed:{
        clearModal(){
            //this.clearInputs();
            return this.$store._modules.root.state.totalplay.modalForm;
        }
    },
    methods:{
        validatorPhone(rule, value, callback){
            this.ruleForm.phone = value ? value.match(/(\d+)/g): null;
            this.ruleForm.phone = ( this.ruleForm.phone !== null )? this.ruleForm.phone.join(''): '';
            this.ruleForm.phone = this.ruleForm.phone.length > 10? this.ruleForm.phone.slice(0,10 ) : this.ruleForm.phone;

            if (this.ruleForm.phone) {
                callback();
            } else {
                callback(new Error( this.message.ruleForm.required ));
            }
        },
        clearInputs(){
                this.$emit('closeModalForm',false);
                this.ruleForm.name  =null;
                this.ruleForm.city_id  =null;
                //this.ruleForm.zip_code = null;
                //this.ruleForm.email = null;
                this.ruleForm.phone = null;
                this.ruleForm.promotion_code = null;
                this.$store._modules.root.state.totalplay.promotion_id = null;
                this.$refs['ruleForm'].resetFields();
        },
        SubmitForm(){
            this.$refs['ruleForm'].validate((valid) => {
                this.$store._modules.root.state.totalplay.loading = true;
                if (valid) {
                    axios.post('/api/setContact',{
                        name : this.ruleForm.name,
                        city_id : ( parseInt( localStorage.getItem('selectCity') )? localStorage.getItem('selectCity') : 9),
                        promotion_id: this.promotion_id,
                        //zip_code : parseInt(this.ruleForm.zip_code),
                        //email : this.ruleForm.email,
                        phone : parseInt(this.ruleForm.phone),
                        promotion_code : this.ruleForm.promotion_code
                    },{
                                        headers:
                                            {
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'Accept': 'application/json',
                                                'Accept-C': window.acceptC
                                            }
                    }).then(response => {
                        if(response.data.success){
                            setTimeout(() => {
                                this.$message({ type: 'success', message: this.message.ruleForm.find_contact_succes });
                                this.clearInputs();
                                this.$store._modules.root.state.totalplay.loading = false;
                            }, 2000);
                        }
                    }).catch(error => {
                        this.$store._modules.root.state.totalplay.loading = false;
                        this.$message({ type: "warning", message: this.message.ruleForm.submit_error });
                    });

                } else {
                    setTimeout(() => {
                        this.$store._modules.root.state.totalplay.loading = false;
                        this.$message({ type: "warning", message: this.message.ruleForm.submit_error });
                    }, 800);
                }
            });
        },
    }
}
</script>

