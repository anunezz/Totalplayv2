<template>
    <div>
        <header-section icon="el-icon-s-management" title="Generar Ficha Técnica">
            <template slot="buttons">
                <el-button
                    align="right"
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push({ name: 'Transfer' })">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <el-row :gutter='20' class='animated fadeIn fast'>
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm">
                <el-col :span='24'>
                    <el-row :gutter='20'>
                        <el-col :span='6'>
                            <el-form-item label="Búsqueda General" prop="general"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger: ['blur','change']}]">
                                    <el-select
                                    size="mini"
                                    style="width: 100%;"
                                    v-model="ruleForm.general"
                                    placeholder="Seleccione una opción">
                                        <el-option
                                        label="Seleccione una opción"
                                        value="">
                                        </el-option>
                                        <el-option
                                        v-for="item in general"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                        </el-option>
                                    </el-select>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Unidad" prop="unidad"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger: ['blur','change']}]">
                                    <el-select
                                    size="mini"
                                    style="width: 100%;"
                                    v-model="ruleForm.unidad"
                                    placeholder="Seleccione una opción">
                                        <el-option
                                        label="Seleccione una opción"
                                        value="">
                                        </el-option>
                                        <el-option
                                        v-for="item in unidad"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                        </el-option>
                                    </el-select>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Año inicio del reporte" prop="yearStart"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger: ['blur','change']}]">
                                    <el-select
                                    size="mini"
                                    style="width: 100%;"
                                    v-model="ruleForm.yearStart"
                                    placeholder="Seleccione una opción">
                                        <el-option
                                        label="Seleccione una opción"
                                        value="">
                                        </el-option>
                                        <el-option
                                        v-for="item in yearStart"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                        </el-option>
                                    </el-select>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Año final del reporte" prop="yearEnd"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger: ['blur','change']}]">
                                    <el-select
                                    size="mini"
                                    style="width: 100%;"
                                    v-model="ruleForm.yearEnd"
                                    placeholder="Seleccione una opción">
                                        <el-option
                                        label="Seleccione una opción"
                                        value="">
                                        </el-option>
                                        <el-option
                                        v-for="item in yearEnd"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                        </el-option>
                                    </el-select>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Lugar" prop="meters" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Lugar" v-model="ruleForm.place"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Funciones o atribuciones" prop="meters" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Funciones o atribuciones" v-model="ruleForm.attributions"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Carácter de la función o atribución" prop="yearEnd"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger: ['blur','change']}]">
                                    <el-select
                                    size="mini"
                                    style="width: 100%;"
                                    v-model="ruleForm.attributions2"
                                    placeholder="Seleccione una opción">
                                        <el-option
                                        label="Seleccione una opción"
                                        value="">
                                        </el-option>
                                        <el-option
                                        v-for="item in attributions2"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                        </el-option>
                                    </el-select>
                            </el-form-item>
                        </el-col>


                        <!-- <el-col :span='6'>
                            <el-form-item label="Vigencia" prop="validity" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input
                                type="number"
                                :min="1" :max="999"
                                size="mini" placeholder="Vigencia"
                                v-model="ruleForm.validity"></el-input>
                            </el-form-item>
                        </el-col> -->

                        <!-- <el-col :span='6'>
                            <el-form-item label="Archivo de concentración (AC)" prop="validity" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input
                                type="number"
                                :min="1" :max="999"
                                size="mini" placeholder="Archivo de concentración (AC)"
                                v-model="ruleForm.concentration"></el-input>
                            </el-form-item>
                        </el-col> -->

                        <el-col :span='6'>
                            <el-form-item label="Valor Documental" prop="yearEnd"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger: ['blur','change']}]">
                                    <el-select
                                    size="mini"
                                    style="width: 100%;"
                                    v-model="ruleForm.documentary"
                                    placeholder="Seleccione una opción">
                                        <el-option
                                        label="Seleccione una opción"
                                        value="">
                                        </el-option>
                                        <el-option
                                        v-for="item in documentary"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                        </el-option>
                                    </el-select>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Cantidad de cajas" prop="validity" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input
                                type="number"
                                :min="1" :max="999"
                                size="mini" placeholder="Cantidad de cajas"
                                v-model="ruleForm.box"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Peso aproximado" prop="meters" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Peso aproximado" v-model="ruleForm.weight"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Metros lineales" prop="lineal" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Ej. 2.2" v-model="ruleForm.meters"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='6'>
                            <el-form-item label="Estado físico" prop="fisico" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Estado físico" v-model="ruleForm.meters"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='24'>
                            <el-form-item label="Metodología de Valoración" prop="fisico" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input
                                maxlength="200"
                                show-word-limit
                                type="textarea" size="mini" placeholder="Metodología de Valoración" v-model="ruleForm.Methodology"></el-input>
                            </el-form-item>
                        </el-col>

                    </el-row>
                </el-col>

                <el-col :span='24'>
                    <el-row :gutter='20'>
                        <el-col :span='24' class='animated fadeIn fast'>
                            <h4>Formuló</h4>
                            <hr>
                        </el-col>

                        <el-col :span='8'>
                            <el-form-item label="Función" prop="function" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Funcion" v-model="ruleForm.function"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='8'>
                            <el-form-item label="Categoria" prop="category" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Categotia" v-model="ruleForm.category"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='8'>
                            <el-form-item label="Nombre" prop="name" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Nombre" v-model="ruleForm.name"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-col>

                <el-col :span='24'>
                    <el-row :gutter='20'>
                        <el-col :span='24' class='animated fadeIn fast'>
                            <h4>Revisó</h4>
                            <hr>
                        </el-col>

                        <el-col :span='8'>
                            <el-form-item label="Función" prop="functionReview" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Función de quien lo revisó" v-model="ruleForm.functionReview"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='8'>
                            <el-form-item label="Categoria" prop="categoryReview" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Categotia de quien lo revisó" v-model="ruleForm.categoryReview"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='8'>
                            <el-form-item label="Nombre" prop="nameReview" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Nombre de quien lo revisó" v-model="ruleForm.nameReview"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-col>

                <el-col :span='24'>
                    <el-row :gutter='20'>
                        <el-col :span='24' class='animated fadeIn fast'>
                            <h4>Autorizó</h4>
                            <hr>
                        </el-col>

                        <el-col :span='8'>
                            <el-form-item label="Función" prop="functionReview" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Función de quien lo revisó" v-model="ruleForm.functionReview2"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='8'>
                            <el-form-item label="Categoria" prop="categoryReview" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Categotia de quien lo revisó" v-model="ruleForm.categoryReview2"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col :span='8'>
                            <el-form-item label="Nombre" prop="nameReview" :rules="[
                            { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                            { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                                <el-input size="mini" placeholder="Nombre de quien lo revisó" v-model="ruleForm.nameReview2"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-col>

                <el-col :span='24' class='animated fadeIn fast'>
                    <div style='width:100%; padding: 5px 0px; display:flex; justify-content: flex-end;'>
                        <div>
                            <el-button type="success" size="mini" >Generar</el-button>
                        </div>
                    </div>
                </el-col>
            </el-form>
        </el-row>

    </div>
</template>

<script>
import HeaderSection from "../../layouts/partials/HeaderSection";
export default {
    components: {
        HeaderSection
    },
    data(){
        return {
            //Catalogos
            general:[],
            unidad:[],
            secction:[],
            serie:[],
            yearStart:[],
            yearEnd:[],
            documentary:[],
            attributions2:[],
            //Formularios
            ruleForm:{},
            rules:{}
        }
    }

}
</script>

<style scoped>
.links {
    font-size: 25px;
    color: #9d2449;
    cursor: pointer;
    text-decoration: underline;
}
</style>
