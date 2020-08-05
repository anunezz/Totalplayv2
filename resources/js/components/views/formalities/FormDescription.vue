<template>
    <div>
        <el-row class="body-form">
            <el-row style="padding: 15px">
                <el-row :gutter="20">
                    <el-col :span="24">
                        <el-form-item label="Asunto/Título:" prop="title" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                            <el-input
                                v-model="formFormalities.title">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="24">
                        <el-form-item label="Alcance y contenido:" prop="scope_and_content">
                            <el-input
                                type="textarea"
                                :rows="10"
                                v-model="formFormalities.scope_and_content"
                                :disabled="true">
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
