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


            <el-row style="margin-bottom: 20px">

                <el-col :span='24' class='animated fadeIn fast'>
                    <div style='width:100%; padding: 5px 0px; display:flex; justify-content: space-between;'>
                        <div>
                            <pre>
                                {{ items }}
                            </pre>
                        </div>
                    </div>
                </el-col>

                <el-col :span="21" :offset="1" class="border-form">
                    <el-form ref="form" :model="items" label-width="120px" label-position="top" size="mini">
                        <el-row :gutter="20">

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
            this.items.unidad = this.$store.state.user.cat_unit_id;
            this.getCats();
            this.getUsers();
        },
        computed:{
        },
        methods:{
            getCats(){
                axios.post('/api/report/getCats',{
                    "unidad": this.$store.state.user.cat_unit_id
                }).then(response => {
                    if(response.data.success){
                        this.series = response.data.lResults.series;
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
