<template>
<div>
    <header-section icon="el-icon-document-add" title="Sección">
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
                    <el-button type="primary" icon="el-icon-plus" size="mini" @click="Modal('new',[])"> Nueva sección</el-button>
                </div>
            </div>
        </el-col>

        <el-col :span='24' class='animated fadeIn fast'>
            <el-table
                :data="secction"
                size="mini"
                empty-text="Sin datos"
                class="animated fadeIn fast"
                stripe
                style="width: 100%">
                <el-table-column
                prop="date"
                label="Clave">
                </el-table-column>
                <el-table-column
                prop="name"
                label="Nombre">
                </el-table-column>
                <el-table-column
                prop="address"
                label="Fecha creación">
                </el-table-column>
                <el-table-column
                label="Acciones">
                    <template slot-scope="scope">
                        <el-button-group>
                            <el-tooltip class="item" effect="dark" content="Actualizar" placement="top-start">
                                <el-button @click="updateCat(scope.row)" icon="fa fa-edit" size="mini"></el-button>
                            </el-tooltip>
                            <el-tooltip class="item" effect="dark" content="Eliminar" placement="top-start">
                                <el-button @click="deleteCat(scope.row)" icon="fa fa-delete" size="small"></el-button>
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
                    <el-form-item label="Nombre de la sección" prop="secction"
                    :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] },
                    { pattern: /^[A-Za-z0-9\.,ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/, message:'Este campo no admite caracteres especiales.'} ]">
                        <el-input width="100%;" size="mini" v-model="ruleForm.name"></el-input>
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
            secction:[],
            showDialog:false,
            titleModal: '',
            showDialog2:false,
            titleModal2: '',
            msj2: '',
            ruleForm:{},
            rules:{}
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
