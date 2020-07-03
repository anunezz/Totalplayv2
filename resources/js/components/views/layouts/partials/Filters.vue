<template>
    <div>
        <pre>{{goals}}--->{{pagination}}---->{{cat}}</pre>
        <el-row>
            <el-col :span="12" align="right">
                <el-input
                    style="width: 100%;"
                    size="small"
                    clearable
                    prefix-icon="el-icon-search"
                    placeholder="Buscar en Localidades"
                    v-model="search">
                </el-input>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        props:['goals','pagination','cat'],
        data(){
            return{
                search:''
            }
        },
        watch:{
            'search'(){
                this.searchGoals();
            }
        },
        methods:{
            searchGoals(){
                let data = {
                    filters: this.search,
                    page: 1,
                    perPage: this.pagination.perPage,
                    search: this.search,
                    cat:this.cat
                };

                axios.get('/api/filter-catalogs', {params: data}).then(response => {
                    if (response.data.success) {

                        console.log("RESPONSE INDEX: ",response);
                        this.recommendations = response.data.recommendations.data;
                        this.pagination.total = response.data.recommendations.total;
                        this.pagination.currentPage = response.data.recommendations.current_page;
                        this.pagination.perPage = response.data.recommendations.per_page;
                    }
                });
                this.show = false;
            },
        }
    }
</script>

<style scoped>

</style>
