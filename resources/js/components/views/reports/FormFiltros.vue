<template>
    <div>
        <el-drawer
            :visible.sync="items.show"
            direction="ltr"
            size="50%"
            ref="drawer">
            <el-row style="background: rgb(157, 36, 56);margin-bottom: 20px">
                <h3 style="color: white;margin-left: 30px">Filtros</h3>
            </el-row>

            <el-row :gutter='20'>
                <el-col :span='24' class='animated fadeIn fast'>
                    <pre>
                        {{ items }}
                    </pre>
                </el-col>
            </el-row>

            <el-row style="margin-bottom: 20px">
                <el-col :span="21" :offset="1" class="border-form">
                    <el-form ref="form" :model="items" label-width="120px" label-position="top" size="mini">
                        <el-row :gutter="20">

                            <el-col :span='24' class='animated fadeIn fast'>
                                <el-form-item label="Buscar por">
                                    <el-radio-group v-model="items.reports" size="mini">
                                        <el-radio-button :label="1">Baja documental</el-radio-button>
                                        <el-radio-button :label="2" v-if="$store.state.user.cat_unit_id === 5">Baja contable</el-radio-button>
                                        <el-radio-button :label="3">Transferencia primaria</el-radio-button>
                                        <el-radio-button :label="4">Transferencia secundaria</el-radio-button>
                                    </el-radio-group>
                                </el-form-item>
                            </el-col>

                            <el-col :span="12">
                                <el-form-item label="Serie documental">
                                    <el-select v-model="items.serie_id" filterable clearable placeholder="Selecciona" style="width: 100%">
                                        <el-option
                                            v-for="item in series" :key="item.id"
                                            :label="item.name"
                                            :value="item.id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="Año de cierre">
                                    <el-date-picker
                                        v-model="items.year"
                                        type="year"
                                        value-format="yyyy"
                                        placeholder="Selecciona año"
                                        style="width: 100%">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </el-col>
            </el-row>
            <el-row :gutter="20" type="flex" justify="center">
                <el-col :span="5">
                    <el-button
                        size="small"
                        icon="fas fa-eraser"
                        @click="cleanitems()"
                        style="width: 100%">
                        Limpiar
                    </el-button>
                </el-col>
                <el-col :span="5">
                    <el-button
                        :disabled="disabledSearch"
                        size="small"
                        icon="fas fa-filter"
                        type="primary"
                        @click="searchitems()"
                        style="width: 100%">
                        Buscar
                    </el-button>
                </el-col>
            </el-row>
        </el-drawer>
    </div>
</template>

<script>
    export default {
        props:['items'],
        data(){
            return{
                users:[],
                series:[],
                reports: null,
            }
        },
        created() {
            this.getCats();
            this.getUsers();
        },
        computed:{
            disabledSearch(){
                let aux = true;
                let sum = this.items.reports === null ? 0 : 1;
                    //sum = sum + (this.items.year === null && this.items.serie_id === null ? 0 : 1  );
                if( sum > 0){
                    aux = false;
                }
                console.log("sum: ",sum);
                return aux;
               // (items.reports === null)? true: false && (items.year === null && items.serie_id === null)? true: false
            }
        },
        methods:{
            getCats(){
                axios.get('/api/report/getCats').then(response => {
                    if(response.data.success){
                        this.series = response.data.lResults.series;
                        console.log('axios.get -> ', this.series);
                    }
                }).catch(error => {
                    console.error(error);
                });
            },
            getUsers(){
                axios.get('/api/all/user/unit').then(response => {
                    this.users = response.data.users;
                }).catch(error => {
                    console.log(error)
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
            cleanitems(){
                this.items.show = true;
                this.items.year = null;
                this.items.serie_id = null;
                this.items.reports = null;
                this.$emit('search');
            },
            searchitems(){
                this.$emit('search')
            }
        }
    }
</script>

<style scoped>
    .border-form{
        padding: 20px;
        border: 1px solid #DCDFE6;
        border-radius: 5px;
    }
</style>
