<template>
<div class="container">
    <div class="row">
        <el-dialog
            :visible.sync="modal"
            :width="mediaWidth"
            class="formDialog"
            :show-close="true"
            :close-on-click-modal="false"
            :close-on-press-escape="false">
            <div class="text-light">
                <el-row :gutter='20'>
                    <el-col :span='24'>
                        <div style='width:100%; padding: 5px 0px; display:flex; justify-content: flex-start;'>
                            <div style="width:50%">
                        <div style="width: 100%; display:flex; justify-content: center;">
                            <div>
                            <strong style="font-family: Arial, sans-serif;
                                            font-size: 15pt; font-style: negrita;
                                            color: #A7D8F8;">Vive la experiencia!</strong> &nbsp; &nbsp;
                            <img src="img/publico/logo-totalplay-n.svg" alt="" class="tp-popup-logoo">
                            </div>
                        </div>
                                <div style="padding-bottom: 13px;">
                                    <h3 class="text-center" style="color:rgb(109, 92, 150);">¡No te quedes sin internet veloz!</h3>
                                    <h4 class="text-center" style="color: #d2a545;">Deja tus datos
                                    Y te llamamos en segundos <br>
                                    ¡Sin esperas!</h4>
                                </div>
                                <form-component v-if="modal" class="px-5" :modal="true" :promotion_id="promotion_id" @closeModalForm="closeModalForm" />
                            </div>
                        </div>
                    </el-col>
                </el-row>
            </div>
        </el-dialog>

        <div class="col-md-12" v-if="items.page === 'home'">
            <div class="col-md-12">
                <div class="row d-flex justify-content-center">
                    <!-- <div  style="100%;">
                        <el-button-group>
                            <div style="width: 50%;">
                                <el-button style="width: 100%;" plain circle type="primary">Triple Play</el-button>
                            </div>
                            <div style="width: 50%;">
                                <el-button style="width: 100%;" plain circle type="primary">Triple Play</el-button>
                            </div>
                        </el-button-group>
                    </div> -->
                    <div class="col-xs-12 col-sm-12 col-md-4 button-spacing">
                        <el-button style="width: 100%;" type="primary" plain round  @click="btn_double_triple = true,setPacks(true)"> Triple Play </el-button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <el-button style="width: 100%;" type="primary" plain round @click="btn_double_triple = false,setPacks(false)">Doble Play</el-button>
                    </div>
                    <!-- <div class="col-xs-12 col-sm-12 col-md-4 button-spacing">
                        <button class="btn button-primary" @click="btn_double_triple = true,setPacks(true)"> Triple Play </button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <button class="btn button-primary" @click="btn_double_triple = false,setPacks(false)">Doble Play</button>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-md-12" v-else>
            <img style="height: 150px; width: 100%; display:block; margin: 0px auto;"  :src="items.img.triple" :alt="items.img.triple">
        </div>

        <div class="col-md-12 py-3" v-if="items.page === 'home'">
            <img v-if="btn_double_triple === true"  style="width: 100%; height: 180px; display:block; margin: 0px auto;"  :src="items.img.triple" :alt="items.img.triple">
            <img v-if="btn_double_triple === false" style="width: 100%; height: 180px; display:block; margin: 0px auto;"  :src="items.img.double" :alt="items.img.double">
        </div>

        <div class="d-flex justify-content-center flex-wrap" v-if="items.page === 'home'">
            <div class="animatedd fast fadeInn col-xs-12 col-sm-12 col-md-6 col-lg-4 py-3 px-4" v-for="(item,index) in items.catPromotion" :key="index">
                <div class="card card-shadow" style="width: 100%;">
                    <img class="card-img-top" :src="item.imgpromotion.fileNameHash" :alt="item.name" />
                    <div class="card-body card-click text-center"
                        :style="'cursor:pointer; background:'+item.color+';'">
                        <div class="card-clickk">
                            <el-button plain @click="clickPromotion(item)" type="primary" style="width: 100%;" round >Contrata ya</el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center flex-wrap" v-if="items.page !== 'home'">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 py-3 px-4" v-for="(item,index) in items.catPromotion" :key="index">
                <div class="card card-shadow" style="width: 100%;">

                    <img class="card-img-top" :src="item.imgpromotion.fileNameHash" alt="--------">
                    <div class="card-body card-click text-center"
                    :style="'cursor:pointer; background:'+item.color+';'">
                        <div class="card-clickk">
                            <el-button plain @click="clickPromotion(item)" type="primary" style="width: 100%;" round >Contrata ya</el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 container" v-if="items.page !== 'home'">
            <img style="height: 150px; width: 100%; display:block; margin: 0px auto;" :src="items.img.double" :alt="items.img.double">
        </div>

        <div class="d-flex justify-content-center flex-wrap" v-if="items.page !== 'home'">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 py-3 px-4" v-for="(item,index) in catDouble" :key="index">
                <div class="card card-shadow" style="width: 100%;">
                    <pre>
                        {{ imgPromotion(items.catPromotion[0].imgpromotion.fileNameHash) }}
                    </pre>
                    <img class="card-img-top" :src="items.catPromotion[(index-1)].imgpromotion.fileNameHash" :alt="items.catPromotion[0].imgpromotion.fileNameHash">
                    <div class="card-body card-click text-center"
                    :style="'cursor:pointer; background:'+item.color+';'">
                        <div class="card-clickk">
                            <el-button plain @click="clickPromotion(item)" type="primary" style="width: 100%;" round >Contrata ya</el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</template>

<script>
import {Globals} from "../../../mixins/Globals";
import Form from '../fragments/Form';
export default {
    mixins:[Globals],
    props: { items: Object },
    components:{
        'form-component': Form
    },
    data() {
        return {
            btn_double_triple: true,
            modal: false,
            promotion_id: null
        }
    },
    computed: {
        catTriple(){
            let data = [];
                if(this.items.page !== 'home' ){
                    for (let i = 0; i < this.items.catPromotion.length; i++) {
                        if(this.items.catPromotion[i].triple_double === 1){
                            data.push(this.items.catPromotion[i]);
                        }
                    }
                }
                console.log(data);
            return data;
        },
        catDouble(){
            let data = [];
                if(this.items.page !== 'home' ){
                    for (let i = 0; i < this.items.catPromotion.length; i++) {
                        if(this.items.catPromotion[i].triple_double === 0){
                            data.push(this.items.catPromotion[i]);
                        }
                    }
                }
                console.log("double: ",data);
            return data;
        },
        mediaWidth() {
            let aux = '65%';
            if(this.$screen.width < 950){
                aux = '95%';
            }
            return aux;
        }
    },
    methods:{
        imgPromotion(data){
            console.log("computed img",data);
            return null;
        },
        clickPromotion(data){
            this.modal = true;
            this.$store._modules.root.state.totalplay.modalForm = this.modal;
            this.promotion_id = data.id;
            $(".el-dialog__title").css({"color":"white"});
            $(".formDialog > .el-dialog__header").remove();
            $(".formDialog > div").css({"background":"url("+data.imgpromotionmodal.fileNameHash+")","background-size": "100% 100%"});

        },
        closeModalForm(modal){
            this.modal = modal;
            this.$store._modules.root.state.totalplay.modalForm = this.modal;
            this.promotion_id = null;
        }
    },
    created(){
        this.setPacks();
    },
    // mounted(){
    //     $(".el-dialog__title").css({"color":"white"});
    //     $(".formDialog > .el-dialog__header").remove();
    //     $(".formDialog > div").css(
    //         {"background":"url('img/publico/Ventana_Modal/img-modal.png')",
    //         "background-size": "100% 100%"}
    //     );
    // },
}
</script>

<style scope>

.card-clickk{
     transition: all 150ms ease-in-out;
    font-size: 1.8rem;
    font-weight: 500;
    font-family: "PT Sans", Verdana, sans-seri;
}

.card-clickk:hover{
  animation: heartBeat; /* referring directly to the animation's @keyframe declaration */
  animation-duration: 2s; /* don't forget to set a duration! */
}

img[src*=".svg"].tp-popup-logo, img.tp-popup-logo {
    max-width: 170px;
    width: 100%;
    vertical-align: middle;
}

.card-shadow{
-webkit-box-shadow: 5px 5px 47px 5px rgba(0,0,0,0.91);
box-shadow: 5px 5px 47px 5px rgba(0,0,0,0.91);
}

.button-primary {
    box-sizing: border-box;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: #154360;
    /*border: 2px solid #e74c3c;*/
    border-radius: 0.4em;
    border-color: #146296;
    color: #fff;
    box-shadow: 0 0 40px 40px #3498db inset, 0 0 0 0 #3498db;
    -webkit-transition: all 150ms ease-in-out;
    transition: all 150ms ease-in-out;
    font-size: 1.8rem;
    font-weight: 500;
    font-family: "PT Sans", Verdana, sans-seri;
    line-height: 1;
    margin: 20px;
    padding: 0.7em 2.0em;
    width: 100%;
}

.button-primary:hover {
    color: #fff;
    box-shadow: 0 0 10px 0 #3498db inset, 0 0 10px 4px #3498db;
    background-color:  #085284;
}

.button-default {
    box-sizing: border-box;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: #000000;
    /*border: 2px solid #e74c3c;*/
    border-radius: 0.1em;
    border-color: #ffffff;
    border: 3px solid black;
    color: rgb(3, 3, 3);
    box-shadow: 0 0 40px 40px rgba(255,255,255,1) inset, 0 0 0 0 #3498db;
    -webkit-transition: all 150ms ease-in-out;
    transition: all 350ms ease-in-out;
    font-size: 2.0rem;
    font-weight: 500;
    font-family: "PT Sans", Verdana, sans-seri;
    line-height: 1;
    margin: 9px;
    padding: 0.3em 2.0em;
    width: 100%;
}

.button-default:hover {
    color: #fff;
    box-shadow: 0 0 10px 0 #3498db inset, 0 0 10px 4px #3498db;
    background-color:  #085284;
}

.click img {
    cursor: pointer;
}

.el-select .el-input {
    width: 100% !important;
}

.el-select .el-input {
    width: 180px;
}
.input-with-select .el-input-group__prepend {
    background-color: #fff;
}

@media screen and (min-width: 0px) and (max-width: 640px) {
    .button-primary {
        box-sizing: border-box;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: #154360;
        /*border: 2px solid #e74c3c;*/
        border-radius: 0.4em;
        border-color: #146296;
        color: #fff;
        box-shadow: 0 0 40px 40px #3498db inset, 0 0 0 0 #3498db;
        -webkit-transition: all 150ms ease-in-out;
        transition: all 150ms ease-in-out;
        font-size: 1.8rem;
        font-weight: 500;
        font-family: "PT Sans", Verdana, sans-seri;
        line-height: 1;
        margin: 0px;
        padding: 0.7em 2.0em;
        width: 100%;
    }

    .button-spacing{
        margin-bottom: 10px;
    }

    img[src*=".svg"].tp-popup-logoo, img.tp-popup-logoo {
        max-width: 170px;
        width: 20%;
    }

}

</style>
