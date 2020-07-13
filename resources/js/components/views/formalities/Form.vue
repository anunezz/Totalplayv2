<template>
    <div>
        <el-row>
            <el-col :span="21" :offset="1" class="border-form">
                <el-tabs type="card">
                    <el-tab-pane label=" Información adicional">

                    </el-tab-pane>
                    <el-tab-pane label="Archivos">

                    </el-tab-pane>
                </el-tabs>
                <el-row type="flex" class="row-bg" justify="end" :gutter="20">
                    <el-col :span="3">
                        <el-button
                            size="small"
                            type="danger"
                            style="width: 100%"
                            @click="$router.push({name: 'ListFormalities' })">
                            Cancelar
                        </el-button>
                    </el-col>
                    <el-col :span="3">
                        <el-button
                            size="small"
                            type="success"
                            style="width: 100%"
                            @click="$router.push({name: 'ListFormalities' })">
                            Guardar
                        </el-button>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>
    </div>
</template>

<script>


    export default {
        data(){
            return{
                formFormalities:{
                    name:'',
                    anio:'',
                    format_id:'',
                    documentary_tradition:'',
                    initial_folio: 0,
                    end_folio: 0,
                    fojas: 2,
                    classification_date:'',
                },
                num:0,
                input:'',
                value1:'',
                textarea:'',
                options: [{
                    value: 'Option1',
                    label: 'Option1'
                }, {
                    value: 'Option2',
                    label: 'Option2'
                }, {
                    value: 'Option3',
                    label: 'Option3'
                }, {
                    value: 'Option4',
                    label: 'Option4'
                }, {
                    value: 'Option5',
                    label: 'Option5'
                }],
            }
        }
    }
</script>

<style scoped>

</style>
