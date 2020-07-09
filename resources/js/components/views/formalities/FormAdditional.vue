<template>
    <div>
        <el-row>
            <el-form :model="formFormalities" label-position="top" label-width="120px" size="small">
                <el-row class="header">
                    <el-row class="body-form">
                        <span class="title-form">Ubicación</span>
                    </el-row>
                    <el-row style="padding: 15px">
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Mueble:" prop="furniture" :rules="[
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'}]">
                                    <el-input
                                        v-model="formFormalities.furniture">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Nivel:" prop="name">
                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Pasillo:" prop="name">
                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Caja:" prop="name">
                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-row>
                </el-row>
                <el-row class="header">
                    <el-row class="body-form">
                        <span class="title-form">Plazos de conservación</span>
                    </el-row>
                    <el-row style="padding: 15px">
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Archivo de trámite (AT):" prop="name">
                                    <el-input
                                        v-model="input">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Archivo de concentración (AC):" prop="name">
                                    <el-input
                                        v-model="input">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Vigencia:" prop="name">
                                    <el-input
                                        v-model="input">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Destino Final:" prop="name">
                                    <el-input
                                        v-model="input">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-row>
                </el-row>
                <el-row class="header">
                    <el-row class="body-form">
                        <span class="title-form">Condiciones de acceso</span>
                    </el-row>
                    <el-row style="padding: 15px">
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Fundamento legal:" prop="name">
                                    <el-input
                                        v-model="input">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Periodo de reserva:" prop="name">
                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="8">
                                <el-form-item label="Fecha de clasificación:" prop="name">
                                    <el-input
                                        v-model="input">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="8">
                                <el-form-item label="Fecha de desclasificación:" prop="name">
                                    <el-input
                                        v-model="input">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="8">
                                <el-form-item label="Ampliación de periodo de reserva:" prop="name">
                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-row>
                </el-row>
                <el-row class="header">
                    <el-row class="body-form">
                        <span class="title-form">Otros</span>
                    </el-row>
                    <el-row style="padding: 15px">
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Fecha de cierre:" prop="name">
                                    <el-input
                                        v-model="input">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Fojas:" prop="name">
                                    <el-input-number v-model="num" controls-position="right" style="width: 100%"></el-input-number>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item label="Soporte:" prop="name">
                                    <el-input
                                        v-model="input">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-row>
                </el-row>
            </el-form>
        </el-row>
    </div>
</template>

<script>
    export default {
        props:['formFormalities'],
        data(){
            return{
                num:0,
                input:'',
                value1:'',
                textarea:'',
            }
        }
    }
</script>

<style scoped>
.header{
    margin-left: 20px;
    margin-bottom: 15px;
    border: 1px solid #b3b9c8;
    border-radius: 5px;
}
    .body-form{
        background:#f0f1f5;
        padding: 10px;
        border-bottom: 1px solid #b3b9c8;
    }
    .title-form{
        font-weight: bold;
        font-size:15px;
        margin-left: 5px;
    }
</style>
