<template>
    <div>
        <el-row :gutter="20">
            <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8">
                <el-form-item label="Tipo de indicador"
                              prop="typeIndicator">
                    <el-select v-model="items.typeIndicator" clearable placeholder="Seleccionar" style="width: 100%;">
                        <el-option
                            v-for="item in typeIndicator"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8">
                <el-form-item label="Nivel de atención"
                              prop="levelAttention">
                    <el-select @change="reset($event)" v-model="items.levelAttention" clearable placeholder="Seleccionar" style="width: 100%;">
                        <el-option
                            v-for="item in levelAttention"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="8" :md="12" :lg="8" :xl="8">
                <el-form-item label="Clasificación">
                    <el-select v-model="items.attentionClassification" :disabled="showSelect" clearable placeholder="Seleccionar" style="width: 100%;">
                        <el-option
                            v-for="item in classification"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        props:['items'],
        data(){
            return{
                showSelect:true,
                typeIndicator: [],
                levelAttention: [],
                classification: [],
            }
        },
        created() {
            axios.get('/api/typeIndicator').then(response => {
                this.typeIndicator = response.data.data;
            });
            axios.get('/api/levelAttention').then(response => {
                this.levelAttention = response.data.data;
            });
            if (this.items.levelAttention===2 || this.items.levelAttention===3){
                let  params = {
                    id: this.items.levelAttention
                };
                axios.get('/api/attentionClassification',{params}).then(response => {
                    this.classification = response.data.data;
                });
                this.showSelect = false;
            }else{
                this.showSelect = true;
            }
        },
        methods:{
            reset(data){
                this.classification = [];
                this.items.attentionClassification = null;
                if (data===2 || data===3  ){
                  let  params = {
                        id: data
                    };

                    axios.get('/api/attentionClassification',{params}).then(response => {
                        this.classification = response.data.data;
                    });
                    this.showSelect = false;
                }else{
                    this.showSelect = true;
                }
            }
        }
    }
</script>

<style scoped>

</style>
