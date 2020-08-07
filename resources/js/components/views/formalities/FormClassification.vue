<template>
    <div>
        <el-row class="body-form">
            <el-row style="padding: 15px">
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Sección:" prop="section_id"
                                      :rules="[
                    { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-select v-model="formFormalities.section_id" clearable filterable @change="getSeries"
                                       placeholder="Seleccionar" style="width: 100%" :disabled="formFormalities.hash !== undefined">
                                <el-option
                                    v-for="section in sections"
                                    :key="section.id"
                                    :label="section.name"
                                    :value="section.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Serie:" prop="serie_id"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-select v-model="formFormalities.serie_id" filterable placeholder="Seleccionar"
                                       @change="getSubSeries"
                                       :disabled="series.length === 0 || formFormalities.hash !== undefined"
                                       style="width: 100%">
                                <el-option
                                    v-for="serie in series"
                                    :key="serie.id"
                                    :label="serie.name"
                                    :value="serie.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Subserie:" prop="subserie_id" v-if="subSeries.length > 0"
                                      :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-select v-model="formFormalities.subserie_id" clearable filterable @change="calSortCodeSubSerie"
                                       placeholder="Seleccionar" :disabled="formFormalities.hash !== undefined" style="width: 100%">
                                <el-option
                                    v-for="subSerie in subSeries"
                                    :key="subSerie.id"
                                    :label="subSerie.name"
                                    :value="subSerie.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Fecha de apertura: " prop="opening_date" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-date-picker
                                v-model="formFormalities.opening_date"
                                type="date"
                                format="dd/MM/yyyy"
                                value-format="yyyy-MM-dd"
                                :disabled="formFormalities.hash !== undefined"
                                @change="calSortCodeOpenDate"
                                style="width: 100%">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Fecha de cierre: " prop="close_date" :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur','change'] }]">
                            <el-date-picker
                                v-model="formFormalities.close_date"
                                type="date"
                                format="dd/MM/yyyy"
                                value-format="yyyy-MM-dd"
                                @change="calSortCodeCloseDate"
                                :disabled="formFormalities.hash !== undefined"
                                :picker-options="pickerOptionsEnd"
                                style="width: 100%">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Consecutivo: " prop="consecutive">
                            <el-input-number v-model="formFormalities.consecutive" controls-position="right" :min="0" disabled
                                             style="width: 100%"></el-input-number>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Legajo:" prop="legajo">
                            <el-input-number v-model="formFormalities.legajo" controls-position="right"
                                             style="width: 100%"></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item label="Código de clasificaión:" prop="sort_code">
                            <el-input v-model="formFormalities.sort_code" disabled style="width: 100%"></el-input>
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
        data(){
            return{
                options:[{
                    value:1,
                    label:'opcion1'
                }],
                sections:[],
                series:[],
                subSeries:[],
                pickerOptionsEnd: {
                    disabledDate: this.delimtDays
                },
            }
        },
        mounted() {
            this.getSections();
            if (this.formFormalities.hash !== undefined) this.editRegisterTap();
        },
        methods:{
            getSections(){
                this.startLoading();
                axios.get('/api/all/section').then(response => {
                    this.sections = response.data.sections;
                    this.stopLoading();
                }).catch(error => {
                    this.stopLoading();
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
            getSeries(){
                if (this.formFormalities.hash === undefined){
                    this.formFormalities.serie_id = null;
                    this.formFormalities.subserie_id = null;
                    this.formFormalities.sort_code = '';
                    this.formFormalities.scope_and_content = '';
                }

                let params = {
                    id:this.formFormalities.section_id
                }
                if (this.formFormalities.section_id){
                    this.startLoading();
                    axios.get('/api/all/series',{params}).then(response => {
                        this.series = response.data.series;
                        this.stopLoading();
                    }).catch(error => {
                        this.stopLoading();
                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    });
                }else {
                    this.series = [];
                    this.subSeries = [];
                }
            },
            getSubSeries(){


                if (this.formFormalities.hash === undefined) {
                    this.formFormalities.sort_code = '';
                    this.formFormalities.primariValues = [];
                }
                let params = {
                    id:this.formFormalities.serie_id
                }
                if (this.formFormalities.serie_id){
                    this.startLoading();
                    this.calcuVSE();
                    axios.get('/api/all/subSeries',{params}).then(response => {
                        this.subSeries = response.data.subSeries;
                        this.stopLoading();
                        if (this.subSeries.length === 0 && this.formFormalities.hash === undefined) this.calSortCodeSerie();
                        if (this.formFormalities.hash === undefined) this.formFormalities.subserie_id = null;

                    }).catch(error => {
                        this.stopLoading();
                        console.log(error)
                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    });
                }
            },
            calSortCodeSerie(){
                 const result = this.series.filter(serie => serie.id === this.formFormalities.serie_id);

                this.formFormalities.scope_and_content = result[0].descriptions[0].description;
                this.formFormalities.primariValues = result[0].primarivalues;
                this.formFormalities.auxSort_code = 'SRE.' + result[0].code + '-';
                this.calSortCodeGeneral();
            },
            calSortCodeSubSerie(){
                 const result = this.subSeries.filter(subSerie => subSerie.id === this.formFormalities.subserie_id);
                this.formFormalities.scope_and_content = result[0].descrip[0].description;
                this.formFormalities.auxSort_code = 'SRE.' + result[0].code + '-';
                this.calSortCodeGeneral();
            },
            calSortCodeOpenDate(){
                this.formFormalities.auxOpening_date = '';
                this.formFormalities.close_date = null;
                this.formFormalities.auxClose_date = '';

                if (this.formFormalities.opening_date){
                    let aux = this.formFormalities.opening_date.split('-');
                    this.formFormalities.auxOpening_date = aux[0] + '-';

                }
                this.calSortCodeGeneral();
            },
            calSortCodeCloseDate(){
                this.formFormalities.auxClose_date = '';
                if (this.formFormalities.close_date){
                    let aux = this.formFormalities.close_date.split('-');
                    this.formFormalities.auxClose_date = aux[0] + '/';
                }
                this.calSortCodeGeneral();
            },
            calSortCodeGeneral(){
                let aux = this.formFormalities.auxSort_code + this.formFormalities.auxOpening_date + this.formFormalities.auxClose_date;

                let params = {
                    code: aux
                }
                this.formFormalities.sort_code = aux;
                axios.post('/api/sort-code', params).then(response => {
                    this.formFormalities.sort_code = aux + (response.data.total + 1);
                    this.formFormalities.consecutive = (response.data.total + 1);
                    this.stopLoading();

                }).catch(error => {
                    this.stopLoading();
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });

            },
            delimtDays(date) {
                return date < new Date(this.formFormalities.opening_date);
            },
            editRegisterTap(){
                this.getSeries();
                this.getSubSeries();
                // let _this = this;
                // setTimeout(function () {
                //     _this.calcuVSE();
                // }, 2000);
            },
            calcuVSE(){
                if (this.series.length>0){
                    const result = this.series.filter(serie => serie.id === this.formFormalities.serie_id);
                    this.formFormalities.serie = result;
                    console.log('imprimiendddddddddddddoo',this.series)
                }
            }
        }
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
