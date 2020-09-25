<template>
    <div>
        <header-section icon="el-icon-s-management" title="Inventarios">
            <template slot="buttons">
                <el-button
                    align="right"
                    size="mini"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/')">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <el-tabs type="border-card">
                    <el-tab-pane v-for="(item , index) in dataComponent" :key="index" :label='item.name'>
                        <!-- <ReportComponent :items="item" @search="getFormalities" /> -->
                        <ReportComponent :items="item" />
                    </el-tab-pane>
                </el-tabs>
            </el-col>
        </el-row>


        <!-- <el-row :gutter='20'>
            <el-col :span='24' class='animated fadeIn fast'>
                <div style='width:100%; padding: 5px 0px; display:flex; justify-content: flex-end;'>
                    <div>
                        <el-button
                            type="default"
                            size="mini"
                            icon="fas fa-search"
                            @click="filters.show = true">
                                    Filtros avanzados
                        </el-button>
                    </div>
                </div>
            </el-col>
        </el-row> -->


        <!-- <show-filters :items="filters" @search="getFormalities"/> -->

    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    // import ShowFilters from "./FormFiltros";
    import ReportComponent from "./Report_component";
    export default {
        components: {
            HeaderSection,
            //ShowFilters,
            ReportComponent
        },
        data(){
            return{
                dataTable: [],
                filters:{
                    show: false,
                    year:null,
                    user:'',
                    serie_id: null,
                    reports: null
                },
                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },
                LowDocumentary:[], //Baja documental,
                dataComponent: []
            }
        },
        created(){
            let data = [ { name: 'Baja documental', url: 'lowDocumentary'  },
                        { name: 'Baja contable', url: 'lowAccounting' },
                        { name: 'Transferencia primaria', url: 'PrimaryTransfer' },
                        { name: 'Transferencia secundariaa', url: 'TransferSecondary' }];

            for (let i = 0; i < data.length; i++) {
                if( ( this.$store.state.user.profile !== 1 && this.$store.state.user.cat_unit_id === 5 && data[i].name === 'Baja contable' ) ||
                    ( this.$store.state.user.profile === 1 && data[i].name === 'Baja contable') ){
                    this.dataComponent.push( data[i] );
                }


                if( data[i].name !== 'Baja contable' ){
                    this.dataComponent.push( data[i] );
                }
            }

        },
        methods: {
            goTo(link, data) {
                axios.post("/api/transaction", data).then(response => {
                    this.$router.push({ name: link });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message:
                            "No fue posible completar la acción, intente nuevamente."
                    });
                });
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

.animated {
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}

.fast {
    -webkit-animation-duration: 0.4s;
    animation-duration: 0.4s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}
@keyframes fadeIn {
from {
opacity: 0;
}

to {
opacity: 1;
}
}

.fadeIn {
animation-name: fadeIn;
}

</style>
