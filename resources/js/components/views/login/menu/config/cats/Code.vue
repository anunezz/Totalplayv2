<template>
<div class="row">

    <el-dialog
    :close-on-click-modal="false"
    :close-on-press-escape="false"
    :show-close="false"
    :title="titleModal"
    class="modalUser"
    :visible.sync="modalVisible"
    width="45%">
        <span v-if="titleModal === 'Deshabilitar codigo de promoción' || titleModal ==='Activar codigo de promoción'" v-text="messageModal"></span>

        <span slot="footer" class="dialog-footer" v-if="titleModal === 'Deshabilitar codigo de promoción' || titleModal ==='Activar codigo de promoción'">
            <el-button-group>
                <el-button size="mini" @click="modalVisible = false">Cancelar</el-button>
                <el-button v-if="titleModal === 'Deshabilitar codigo de promoción'" size="mini" type="danger" @click="activePromotion()">Deshabilitar</el-button>
                <el-button v-if="titleModal === 'Activar codigo de promoción'" size="mini" type="success" @click="activePromotion()"> Activar</el-button>
            </el-button-group>
        </span>
        <new-code-component
        v-if="titleModal === 'Nuevo codigo de promoción' || titleModal === 'Actualizar codigo de promoción'"
        :items="promotion"
        @responseCode="responseCode" />
    </el-dialog>


    <div class="col-md-12 py-2">
        <div class="row justify-content-md-between flex-wrap">
            <div class="col-md-6">
                <h4>Bandeja de entrada codigos de promoción Totalplay.</h4>
            </div>
            <div class="col-md-6">
                <router-link to="/login/configuracion">
                    <button class="btn btn-danger btn-sm float-right"> <i class="el-icon-arrow-left"></i> Regresar</button>
                </router-link>
            </div>
        </div>
    </div>
    <div class="col-md-12 py-2">
        <div class="text-left float-left">
            <strong>Total:</strong> {{ pagination.total }}
        </div>
        <div class="btn-group float-right">
            <button class="btn btn-secondary btn-sm"> <i class="el-icon-search"></i> Búsqueda avanzada</button>
            <button class="btn btn-primary btn-sm" @click="modal(['new',[]])"> <i class="el-icon-plus"></i> Nuevo codigo de promoción</button>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Usuario</th>
                <th scope="col">Paquete</th>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo</th>
                <th scope="col">Codigo de promoción</th>
                <th scope="col">Estatus</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item,index) in promotions" :key="index">
                <th scope="row" v-text="item.idx"></th>
                <td v-text="item.user.username"></td>
                <td v-text="item.pack.namepack.name"></td>
                <td v-text="item.pack.name"></td>
                <td v-text="(item.pack.type === 1 ? 'Triple play' : 'Doble play'  )"></td>
                <td v-text="item.promotion_code"></td>
                <td v-text="(item.isActive === 1?'Activo':'Desactivado')"></td>
                <td>
                    <div class="btn-group float-center">
                        <button :disabled="$store.state.user.profile === 1?false:true" v-if="item.isActive === 1" class="btn btn-danger btn-sm" @click="modal(['active',[item,false]])"> <i class="el-icon-close"></i></button>
                        <button :disabled="$store.state.user.profile === 1?false:true" v-else class="btn btn-warning btn-sm" @click="modal(['active',[item,true]])"> <i class="el-icon-check"></i></button>
                        <!-- <button :disabled="$store.state.user.profile === 1?false:true" class="btn btn-success btn-sm" @click="modal(['edit',item])" > <i class="el-icon-edit"></i></button> -->
                    </div>
                </td>
            </tr>
        </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <div class="" style="width:100%; padding: 5px 0px;">
            <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page.sync="pagination.currentPage"
                :page-sizes="[10, 20, 30, 40]"
                :page-size="parseInt(pagination.perPage)"
                layout="sizes, ->, prev, pager, next"
                :total="pagination.total">
            </el-pagination>
        </div>
    </div>
</div>
</template>

<script>
import newCodecomponent from '../../../../fragments/FormNewCode';
export default {
    components:{
        'new-code-component': newCodecomponent,
    },
    data(){
        return {
            promotions:[],
            modalVisible:false,
            titleModal: null,
            messageModal: null,
            promotion:{
                type: false,
                data: {}
            },
            pagination: {
                currentPage: 1,
                total: 0,
                perPage: 10
            },
            from:0,
            to:0
        }
    },
    created(){
        this.getCodePromotion();
    },
    methods: {
        handleSizeChange(sizePerPage) {
            this.pagination.perPage = sizePerPage;
            this.getCodePromotion(this.pagination.currentPage);
        },
        handleCurrentChange(currentPage) {
            this.pagination.currentPage = currentPage;
            this.getCodePromotion(currentPage);
        },
        modal(data){
            $(".el-dialog__title").css({"color":"black"});
            this.messageModa = null;
            switch (data[0]) {
                case 'new':{
                    this.modalVisible = true;
                    this.titleModal = 'Nuevo codigo de promoción';
                    this.promotion = {
                        type:false,
                        data:[]
                    };
                break;
                }
                case 'edit':{
                    this.modalVisible = true;
                    this.titleModal = 'Actualizar codigo de promoción';
                    this.promotion = {
                        type: true,
                        data: data[1]
                    };
                break;
                }
                case 'active':{
                    this.modalVisible = true;
                    this.titleModal = ( data[1][1] )? 'Activar codigo de promoción':'Deshabilitar codigo de promoción';
                    this.messageModal =( data[1][1] )? '¿Estas completamente seguro de activar este codigo de promoción?':'¿Estas completamente seguro de eliminar este codigo de promoción?';
                    this.promotion = {
                        type: true,
                        data: data[1]
                    };
                break;
                }
                default:{
                    this.modalVisible = false;
                    this.titleModal = null;
                    this.promotion = {
                        type: false,
                        data: {}
                    };
                    break;
                }
            }
        },
        responseCode(res){
                if(res){
                    this.modalVisible = false;
                    this.titleModal = '';
                    this.messageModal = null;
                    this.getCodePromotion();
                }
                this.$store._modules.root.state.totalplay.loading = false;
        },
        activePromotion(){
            this.$store._modules.root.state.totalplay.loading = true;
            axios.post('/api/activePromotion',{
                promotionid: this.promotion.data[0].id,
                active: this.promotion.data[1]
            }).then(response => {
                if(response.data.success){
                    this.getCodePromotion();
                    this.modalVisible = false;
                    this.titleModal = '';
                    this.messageModal = null;
                    this.$store._modules.root.state.totalplay.loading = false;
                    this.$message({
                        message: 'El codigo de promoción fue desactivado correctamente.',
                        type: 'success'
                    });
                }
            }).catch(error => {
                this.$store._modules.root.state.totalplay.loading = false;
                this.$message({
                    message: 'No se pudo completar la acción.',
                    type: 'warning'
                });
            });
        },
        getCodePromotion(currentPage = 1){
            this.$store._modules.root.state.totalplay.loading = true;
            axios.post('/api/getCodePromotion',{
                page: currentPage,
                perPage: this.pagination.perPage,
            }).then(response => {
                if(response.data.success){
                    this.promotions = [];
                    let promotions = response.data.lResults.CodePromotion.data;
                    let sum = response.data.lResults.CodePromotion.from;
                    let data = [];
                    for (let i = 0; i < promotions.length; i++) {
                        sum = i === 0 ? sum : (sum + 1);
                        promotions[i].idx = sum;
                        data.push(promotions[i]);
                    }
                    this.promotions = data;
                    this.pagination.currentPage = response.data.lResults.CodePromotion.current_page;
                    this.pagination.perPage = response.data.lResults.CodePromotion.per_page;
                    this.pagination.total = response.data.lResults.CodePromotion.total;
                    this.from = response.data.lResults.CodePromotion.from;
                    this.to = response.data.lResults.CodePromotion.to;
                    this.$store._modules.root.state.totalplay.loading = false;
                }
            }).catch(error => {
                this.$message({
                    message: 'No se pudo completarr la acción.',
                    type: 'warning'
                });
                this.$store._modules.root.state.totalplay.loading = false;
            });
        }
    }
}
</script>

<style scoped>
    .nolink{
        text-decoration: none;
        color: black;
    }
</style>
