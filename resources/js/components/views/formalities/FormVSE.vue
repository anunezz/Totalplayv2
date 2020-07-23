<template>
    <div>
        <el-row class="body-form">
            <el-row style="margin-bottom: 10px">
                <el-form-item prop="question_one"
                              :rules="[
                    { required: true, message: 'La pregunta es obligatoria', trigger: ['blur','change'] }]">
                    <el-col :span="19">
                        <span style="color: red">*</span>
                        <span style="font-weight: bold;">¿El expediente fue objeto de una solicitud de acceso a la información?</span style="font-weight: bold;">
                    </el-col>
                    <el-col :span="5">
                        <el-radio-group v-model="formFormalities.question_one" size="medium">
                            <el-radio border label="Sí"></el-radio>
                            <el-radio border label="No"></el-radio>
                        </el-radio-group>
                    </el-col>
                </el-form-item>
            </el-row>
            <el-row v-if="formFormalities.question_one === 'Sí'">
                <el-form-item prop="question_two"
                              :rules="[
                    { required: true, message: 'La pregunta es obligatoria', trigger: ['blur','change'] }]">
                    <el-col :span="19">
                        <span style="color: red">*</span>
                        <span style="font-weight: bold;">¿El expediente fue clasificado como confidencial o reservado?</span>
                    </el-col>
                    <el-col :span="5">
                        <el-radio-group v-model="formFormalities.question_two" size="medium">
                            <el-radio border label="Sí"></el-radio>
                            <el-radio border label="No"></el-radio>
                        </el-radio-group>
                    </el-col>
                </el-form-item>
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
