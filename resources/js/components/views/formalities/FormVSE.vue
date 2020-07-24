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
            <el-row style="padding: 15px">
                <h4>Valores primarios</h4>
                <el-row>
                    <el-col :span="15" :offset="3">
                        <el-table
                            :data="tableData"
                            style="width: 100%"
                            border>
                            <el-table-column
                                prop="administrative"
                                align="center"
                                width="150"
                                label="Administrativo">
                                <template slot-scope="scope">
                                    <i class="fas fa-times" v-if="scope.row.administrative"></i>
                                    <i class="fas fa-minus" v-else></i>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="legal"
                                align="center"
                                width="150"
                                label="Legal">
                                <template slot-scope="scope">
                                    <i class="fas fa-times" v-if="scope.row.legal"></i>
                                    <i class="fas fa-minus" v-else></i>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="fiscal"
                                align="center"
                                width="150"
                                label="Fiscal">
                                <template slot-scope="scope">
                                    <i class="fas fa-times" v-if="scope.row.fiscal"></i>
                                    <i class="fas fa-minus" v-else></i>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="accountant"
                                align="center"
                                width="158"
                                label="Contable">
                                <template slot-scope="scope">
                                    <i class="fas fa-times" v-if="scope.row.accountant"></i>
                                    <i class="fas fa-minus" v-else></i>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-col>
                </el-row>
                <h4>Vigencias documentales</h4>
                <el-row>
                    <el-col :span="18" :offset="3">
                        <el-table
                            :data="tableData2"
                            style="width: 100%"
                            border>
                            <el-table-column
                                prop="AT"
                                align="center"
                                width="150"
                                label="Archivo de trámite">
                            </el-table-column>
                            <el-table-column
                                prop="AC"
                                align="center"
                                width="200"
                                label="Archivo de concentración">
                            </el-table-column>
                            <el-table-column
                                prop="requestAccess"
                                align="center"
                                v-if="formFormalities.question_one === 'Sí'"
                                label="Solicitud de acceso a la información"
                                width="270">
                            </el-table-column>
                            <el-table-column
                                prop="total"
                                align="center"
                                label="Total">
                                <template slot-scope="scope">
                                    {{sumTotal()}}
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-col>
                </el-row>
                <h4>Técnicas de selección</h4>
                <el-row>
                    <el-col :span="17" :offset="3">
                        <el-table
                            :data="tableData3"
                            style="width: 100%"
                            border>
                            <el-table-column
                                prop="elimination"
                                align="center"
                                width="150"
                                label="Eliminación">
                                <template slot-scope="scope">
                                    <i class="fas fa-times" v-if="scope.row.elimination"></i>
                                    <i class="fas fa-minus" v-else></i>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="conservation"
                                align="center"
                                width="150"
                                label="Conservación">
                                <template slot-scope="scope">
                                    <i class="fas fa-times" v-if="scope.row.conservation"></i>
                                    <i class="fas fa-minus" v-else></i>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="sampling"
                                align="center"
                                width="150"
                                label="Muestreo">
                                <template slot-scope="scope">
                                    <i class="fas fa-times" v-if="scope.row.sampling"></i>
                                    <i class="fas fa-minus" v-else></i>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="quality"
                                align="center"
                                width="238"
                                label="Cualidad de la muestra">
                                <template slot-scope="scope">
                                    <i class="fas fa-times" v-if="scope.row.quality"></i>
                                    <i class="fas fa-minus" v-else></i>
                                </template>
                            </el-table-column>
                        </el-table>
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
                tableData: [{
                    administrative: false,
                    legal: false,
                    fiscal: false,
                    accountant:false,
                }],
                tableData2: [{
                    AT: 3,
                    AC: 2,
                    requestAccess: 0,
                    total: 0
                }],
                tableData3: [{
                    elimination: false,
                    conservation: false,
                    sampling: false,
                    quality: false,

                }]
            }
        },
        mounted() {
            if (this.formFormalities.hash !== undefined) this.editRegisterVSE();
            else this.calcuPrimariValues();
        },
        watch:{
            'formFormalities.question_one'(){
                this.tableData2[0].requestAccess = this.formFormalities.question_one === 'Sí' ? 2 : 0;

            },
            'formFormalities.primariValues'(){
                this.tableData = [{
                    administrative: false,
                    legal: false,
                    fiscal: false,
                    accountant:false,
                }];
                this.calcuPrimariValues();
            }
        },
        methods:{
            editRegisterVSE(){
                this.formFormalities.question_one = this.formFormalities.question_one === 1 ? 'Sí' : 'No';
                this.formFormalities.question_two = this.formFormalities.question_two === 1 ? 'Sí' : 'No';
                this.calcuPrimariValues();
            },
            sumTotal(){
                return this.tableData2[0].AT + this.tableData2[0].AC +this.tableData2[0].requestAccess;
            },
            calcuPrimariValues(){
                this.formFormalities.primariValues.forEach(function(value) {
                    if(value.id === 1 ) this.tableData[0].administrative = true;
                    if(value.id === 2 ) this.tableData[0].legal = true;
                    if(value.id === 3 ) this.tableData[0].fiscal = true;
                    if(value.id === 4 ) this.tableData[0].accountant = true;
                }, this);
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
