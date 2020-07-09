<template>
<div>
    <header-section icon="el-icon-document-add" title="Subseries">
        <template slot="buttons">
            <el-button
                size="small"
                type="danger"
                icon="el-icon-arrow-left"
                @click="$router.push('/administracion/catalogos/')">
                Regresar
            </el-button>
        </template>
    </header-section>

    <el-row :gutter='20'>
        <el-col :span='24' class='animated fadeIn fast'>
            <div style='width:100%; padding: 5px 0px; display:flex; justify-content: flex-end;'>
                <div>
                    <el-button type="primary" icon="el-icon-plus" size="mini" @click="Modal('new',[])"> Nueva subserie</el-button>
                </div>
            </div>
        </el-col>

        <el-col :span='24' class='animated fadeIn fast'>
            <el-table
                size="mini"
                :data="secction"
                style="width: 100%">
                <el-table-column
                    prop="keySection"
                    label="Clave de sección">
                </el-table-column>
                <el-table-column
                    prop="keySerie"
                    label="Clave de serie">
                </el-table-column>
                <el-table-column
                    prop="keySub"
                    label="Clave de la subserie">
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="Nombre">
                </el-table-column>
                <el-table-column
                    prop="date"
                    label="Fecha de creación">
                </el-table-column>
                <el-table-column
                    label="Acciones" header-align="center" align="center">
                    <template slot-scope="scope">
                        <el-button-group>
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Editar"
                                placement="top-start">
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="fas fa-edit">
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Eliminar"
                                placement="top-start">
                                <el-button
                                    type="danger"
                                    size="mini"
                                    icon="el-icon-delete">
                                </el-button>
                            </el-tooltip>
                        </el-button-group>
                    </template>
                </el-table-column>
            </el-table>
        </el-col>
    </el-row>

    <el-dialog :title="titleModal" width="50%;" :visible.sync="showDialog">
        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <el-form ref="ruleForm" :model="ruleForm" :rules="rules">
                    <el-form-item label="Sección:" prop="section"
                                  :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },]">
                        <el-select v-model="ruleForm.section" filterable placeholder="Selecinar" size="mini" style="width: 100%">
                            <el-option
                                v-for="item in listSecction"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <el-form ref="ruleForm" :model="ruleForm" :rules="rules">
                    <el-form-item label="Serie:" prop="serie"
                                  :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },]">
                        <el-select v-model="ruleForm.serie" filterable placeholder="Selecinar" size="mini" style="width: 100%">
                            <el-option
                                v-for="item in listSerie"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <el-form ref="ruleForm" :model="ruleForm" :rules="rules">
                    <el-form-item label="Clave de subserie:" prop="keySub"
                                  :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                        <el-input width="100%;" size="mini" v-model="ruleForm.keySub = 5" disabled></el-input>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <el-form ref="ruleForm" :model="ruleForm" :rules="rules">
                    <el-form-item label="Nombre de la Subserie:" prop="subserie"
                    :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                        <el-input width="100%;" size="mini" v-model="ruleForm.subserie"></el-input>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
        <div slot="footer" class="dialog-footer">
            <el-button-group>
                <el-button @click="showDialog = false" size="mini" >Cancelar</el-button>
                <el-button type="primary" size="mini" @click="Modal('confirmSave','ruleForm')">Guardar</el-button>
            </el-button-group>
        </div>
    </el-dialog>

    <el-dialog :title="titleModal2" width="35%" :visible.sync="showDialog2">
        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast' v-text="msj2">
            </el-col>
        </el-row>
        <div slot="footer" class="dialog-footer">
            <el-button-group>
                <el-button @click="showDialog2 = false" size="mini" >Cancelar</el-button>
                <el-button type="primary" size="mini" @click="saveForm">Guardar</el-button>
            </el-button-group>
        </div>
    </el-dialog>

</div>
</template>

<script>
import HeaderSection from "../layouts/partials/HeaderSection";

export default {
    components: { HeaderSection },

    data(){
        return{
            showDialog:false,
            titleModal: '',
            showDialog2:false,
            titleModal2: '',
            msj2: '',
            ruleForm:{},
            rules:{},
            listSecction:[
                {
                id:1,
                name:'ASUNTOS GENERALES'
                },
                {
                id:2,
                name:'ASUNTOS ADMINISTRATIVOS'
                },
                {
                id:3,
                name:'ASUNTOS DE ESTADO INTERNACIONALES'
                },
            ],
            listSerie:[
                {
                id:1,
                name:'JURISPRUDENCIA'
                },
                {
                id:2,
                name:'DERECHO'
                },
                {
                id:3,
                name:'ACUERDOS'
                },
            ],
            secction:[{
                keySection: '1',
                keySerie: '10',
                keySub: '1',
                name: 'Juárez Caballero, Raúl Alberto',
                date: '2016-05-03',
            }, {
                keySection: '1',
                keySerie: '10',
                keySub: '2',
                name: 'Sánchez Buendia Aurora',
                date: '2016-05-02',
            }, {
                keySection: '1',
                keySerie: '10',
                keySub: '3',
                name: 'Sánchez Buendia Aurora',
                date: '2016-05-04',
            }, {
                keySection: '1',
                keySerie: '10',
                keySub: '4',
                name: 'Sánchez Buendia Aurora',
                date: '2016-05-01',
            }],
        }
    },

    methods: {
        Modal(action,data){
            switch (action) {
                case 'new':
                {
                this.titleModal = "Nuevo";
                this.showDialog = true;
                break;
                }
                case 'confirmSave':
                {
                    this.$refs[data].validate((valid) => {
                        if (valid) {
                            this.titleModal2 = "Guardar";
                            this.msj2 = "¿Estas completamente seguro de guardar este registro?"
                            this.showDialog2 = true;
                        } else {
                            this.$message({
                                message: 'Verifique los campos del formulario.',
                                type: 'warning'
                            });
                            return false;
                        }
                    });
                break;
                }
            }
        },
        saveForm(){
            console.log("Nuevo saveForm catalago...");
        },
        updateCat(row){
            console.log("Actualizar: ",row);
        },
        deleteCat(row){
            console.log("Eliminar: ",row);
        }
    }
}
</script>

<style scoped>
</style>
