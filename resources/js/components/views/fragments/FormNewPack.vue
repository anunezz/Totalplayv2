<template>
<div class="animatedd fadeInn fastt">
    <el-form :model="ruleForm" ref="ruleForm">
        <el-row :gutter='20'>
            <el-col :span='12'>
                <el-form-item label="Selecciona un paquete" prop="pack_id"
                :rules="[{ required: true, message: message.ruleForm.required, trigger: ['blur','change']}]">
                    <el-select v-model="ruleForm.pack_id" placeholder="Selecciona un paquete" size="mini" style="width: 100%;">
                        <el-option
                        v-for="item in packs"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Nombre del paquete" prop="name" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input v-model="ruleForm.name" placeholder="Nombre del paquete" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Residencia" prop="frontier"
                    :rules="[{ required: true, message: message.ruleForm.required, trigger: ['blur','change']}]">
                    <el-select v-model="ruleForm.frontier" placeholder="Selecciona una residencia" size="mini" style="width: 100%;">
                        <el-option
                        v-for="item in frontiers"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Estatus" prop="isActive"
                :rules="[{ required: true, message: message.ruleForm.required, trigger: ['blur','change']}]">
                    <el-select v-model="ruleForm.isActive" placeholder="Selecciona un estatus" size="mini" style="width: 100%;">
                        <el-option
                        v-for="item in actives"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>

            <el-col :span="12">
                <el-form-item prop="files"
                :rules="[{ type:'file', value:files, validator: ValidatorImg, trigger: ['blur','change']}]">
                <el-upload
                    style="width: 100%;"
                    class="upload-demo"
                    :limit="1"
                    list-type="picture"
                    action="/api/filePromotion"
                    accept=".jpg, .png, .jpeg"
                    name="document"
                    :file-list="files"
                    :auto-upload="true"
                    :before-upload="beforeUploadFile"
                    :headers="{Authorization: apiToken}"
                    :on-remove="removeFile"
                    :on-success="uploadedFile"
                    :on-error="onError">
                    <button type="button" class="btn btn-primary btn-sm btn-block" :disabled="files.length > 0"><i class="el-icon-picture-outline"></i> Subir imagen de paquete de promoción</button>
                    <div slot="tip" class="el-upload__tip">Solo imagenes jpg/jpeg/png con un tamaño menor de 500kb</div>
                </el-upload>
                </el-form-item>
            </el-col>

            <el-col :span="12">
                <el-form-item prop="files"
                :rules="[{ type:'file', value:filesModal, validator: ValidatorImg, trigger: ['blur','change']}]">
                <el-upload
                    style="width: 100%;"
                    class="upload-demo"
                    :limit="1"
                    list-type="picture"
                    action="/api/filePromotionModal"
                    accept=".jpg, .png, .jpeg"
                    name="document"
                    :file-list="filesModal"
                    :auto-upload="true"
                    :before-upload="beforeUploadFile"
                    :headers="{Authorization: apiToken}"
                    :on-remove="removeFileModal"
                    :on-success="uploadedFileModal"
                    :on-error="onError">
                    <button type="button" class="btn btn-primary btn-sm btn-block" :disabled="filesModal.length > 0"><i class="el-icon-picture-outline"></i> Subir imagen de ventana modal de promoción</button>
                    <div slot="tip" class="el-upload__tip">Solo imagenes jpg/jpeg/png con un tamaño menor de 500kb</div>
                </el-upload>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Selecciona un tipo de promoción" prop="triple_double"
                    :rules="[{ required: true, message: message.ruleForm.required, trigger: ['blur','change']}]">
                    <el-select v-model="ruleForm.triple_double" placeholder="Selecciona una residencia" size="mini" style="width: 100%;">
                        <el-option
                        v-for="item in tripleDouble"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span='12'>
                <el-form-item label="Selecciona un color" prop="color" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: color, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 7, message: message.ruleForm.max_characters+' 7.', trigger: ['blur','change'] }]">
                        <br>
                        <el-color-picker v-model="ruleForm.color"></el-color-picker>
                </el-form-item>
            </el-col>
            <el-col :span='24'>
                <el-form-item label="Descripción" prop="description" :rules="[{ required: true, message: message.ruleForm.required },
                                    { pattern: alphanumeric, message: message.ruleForm.special_characters, trigger: ['blur','change']},
                                    { max: 100, message: message.ruleForm.max_characters+' 100.', trigger: ['blur','change'] }]">
                    <el-input type="textarea" v-model="ruleForm.description" placeholder="Descripción" size="mini" style="width: 100%;"></el-input>
                </el-form-item>
            </el-col>
            <el-col :span='24'>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group float-right">
                            <button type="button" @click="closeModal" class="btn btn-danger btn-sm"> <i class="el-icon-close"></i> Cerrar</button>
                            <button v-if="!items.type" type="button" @click="clearForm" class="btn btn-primary btn-sm"> <i class="el-icon-delete"></i> Limpiar</button>
                            <button v-if="!items.type" type="button" @click="newPromotion" class="btn btn-success btn-sm"> <i class="el-icon-check"></i> Guardar</button>
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
                pack_id:null,
                name:null,
                frontier:null,
                triple_double:null,
                description:null,
                isActive:null,
                color:null
            },
            paquete_id:null,
            packs:[],
            frontiers:[],
            tripleDouble:[],
            actives:[],
            apiToken: "Bearer " + sessionStorage.getItem("access_token"),
            files:[],
            deleteFiles:[],
            filesModal:[],
            deleteFilesModal:[],
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
    },
    methods:{
        ValidatorImg(rule, value, callback){
            if(rule.value.length > 0 ){
                callback();
            }else{
                return callback(new Error("Este campo es requerido."));
            }
        },
        editUser(){
            //this.$store._modules.root.state.totalplay.loading = true;
            this.$refs['ruleForm'].validate((valid) => {
            if (valid) {
                let data = {
                    data: this.ruleForm,
                    userid: this.paquete_id
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
        getEdit(pack){
            console.log("paquete actualizar: ",pack);
            setTimeout(() => {
                this.paquete_id = null;
                this.ruleForm={
                    pack_id: pack.type,
                    name: pack.name,
                    frontier: pack.frontier,
                    triple_double: pack.triple_double,
                    description: pack.description,
                    isActive: pack.isActive,
                    color: pack.color
                };
                this.files = [{ id: pack.imgpromotion.id, name: pack.imgpromotion.fileName ,url: pack.imgpromotion.fileNameHash }];
                this.deleteFiles = [];
                this.filesModal = [{ id: pack.imgpromotionmodal.id, name: pack.imgpromotionmodal.fileName ,url: pack.imgpromotionmodal.fileNameHash }];
                this.deleteFilesModal = [];
            }, 1000);
        },
        closeModal(){
            this.clearForm();
            this.$emit('responsePack',true);
        },
        newPromotion(){
            this.$store._modules.root.state.totalplay.loading = true;
            this.$refs['ruleForm'].validate((valid) => {
            if (valid) {

                let data = this.ruleForm;
                data.file = this.files;
                data.filesModal =  this.filesModal;

                axios.post('/api/createPromotion',data).then(response => {
                    if(response.data.success){
                            this.$message({
                                message: 'El paquete fue creado exitosamente.',
                                type: 'success'
                            });
                            this.$emit('responsePack',true);
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
            this.paquete_id = null;
            this.ruleForm={
                pack_id:null,
                name:null,
                frontier:null,
                triple_double:null,
                description:null,
                isActive:null,
                color:null
            };
            this.files = [];
            this.deleteFiles = [];
            this.filesModal = [];
            this.deleteFilesModal = [];
            this.$refs['ruleForm'].resetFields();
        },
        getCats(){
            axios.get('/api/getCatsPacksForm').then(response => {
                if(response.data.success){
                        this.packs = response.data.lResults.packNames;
                        this.frontiers = response.data.lResults.frontiers;
                        this.actives = response.data.lResults.actives;
                        this.tripleDouble = response.data.lResults.triple_double;
                }
            }).catch(error => {
                console.error(error);
            });
        },
        beforeUploadFile(file) {
            if (file.size / 1024 / 1024 > 6) {
                this.$message.error(
                    "El archivo seleccionado excede el limite permitido"
                );
                return false;
            }

            if (
                file.type !== "image/jpeg" &&
                file.type !== "image/jpg" &&
                file.type !== "image/png"
            ) {
                this.$message.error("Tipo de Archivo no permitido");
                return false;
            }

            return true;
        },
        uploadedFile(data) {
            if (data.success) this.files.push(data.documentId);
            else this.$message.error("Archivo no permitido");
        },
        uploadedFileModal(data) {
            if (data.success) this.filesModal.push(data.documentId);
            else this.$message.error("Archivo no permitido");
        },
        onError(err, file, fileList) {
            this.$message({
                type: "warning",
                message: "No fue posible leer el archivo, inténtelo nuevamente."
            });
        },
        removeFile(file,filelist) {
            console.log("imagen: ",file,filelist);

            for (let i = 0; i < this.files.length; i++) {
                if (this.files[i].id === file.id) {
                    this.deleteFiles.push(this.files[i]);
                    this.files.splice(i, 1);
                }
            }
        },
        removeFileModal(file,filelist) {
            for (let i = 0; i < this.filesModal.length; i++) {
                if (this.filesModal[i].id === file.id) {
                    this.deleteFilesModal.push(this.filesModal[i]);
                    this.filesModal.splice(i, 1);
                }
            }
        },
    }
}
</script>
