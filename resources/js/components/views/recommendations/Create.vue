<template>
    <div style="width:90%; margin:0px auto;">



        <el-row :gutter='22' style="padding-bottom: 5px;">
          <el-col :span='24'>
          <div style="width:100%; padding-bottom:10px; display:flex; justify-content:flex-end;">
               <div>
                 <el-button-group>
                     <el-button
                         size="mini"
                         type="danger"
                         icon="el-icon-arrow-left"
                         @click="$router.push({name: 'RecommendationsIndex' })">
                         Regresar
                     </el-button>
                 </el-button-group>
               </div>
          </div>
          </el-col>
        </el-row>

        <el-row :gutter='20'>
        <el-col :span='24'>
            <div style="color:#9D2449; font-size: 27px; padding-bottom: 15px;">
            REPORTE DE LOS 13 CONSULADOS DE M&Eacute;XICO E LA FRONTERA DEL NORTE
            </div>
        </el-col>

        <el-col :span='24'>
            <div style="color:#67C23A; font-size: 17px; padding-bottom:15px;">
            ASEGURAMIENTOS Y OPERATIVOS DEL CONTROL DEARMAS
            </div>
        </el-col>


        <el-col :span='24'>
            <div>

                <!-- Formulario Consulados -->
                <el-row :gutter='20'>
                    <el-col :span='12'>
                        <div style="width: 100%; padding: 5px 0px;">
                            <el-select :disabled="true" style="width: 100%;" size="mini" v-model="ruleForm.consulate" placeholder="Consulado">
                                <el-option
                                    v-for="(consulate , index) in consulates"
                                    :key="index"
                                    :label="consulate.name"
                                    :value="consulate.id">
                                </el-option>
                            </el-select>
                        </div>
                    </el-col>

                    <!-- <pre>
                        {{ruleForm.date}}
                    </pre> -->

                    <el-col :span='12'>
                        <div style="width:100%; padding: 3px 0px; text-align: center;">
                                <!-- <el-date-picker size="mini"
                                placeholder="Semana"
                                type="week"
                                format="WW/yyyy"
                                v-model="ruleForm.date"
                                style="width: 100%;"></el-date-picker> -->

                                    <strong><b> {{ mesAnio }} </b></strong>

                        </div>
                    </el-col>

                    <el-col :span='24' style="padding-top: 30px;">
                        <div style="width:100%;  display:flex; justify-content:flex-end;">
                             <el-button
                                        size="mini"
                                        type="primary"
                                        icon="fa fa-file"
                                        @click="showFormOperative = !showFormOperative">
                                        Nuevo operativo
                            </el-button>
                        </div>
                    </el-col>

                </el-row>
                <!-- Terminando el formulario consulados -->
            </div>
        </el-col>

        <!-- formulario sin ventana modal -->
        <el-col :span="24">
            <el-form :model="formOperative" :rules="ruleOperative" ref="formOperative">
                <el-row :gutter='20'>
                    <el-col :span="24">
                        <div style="width: 100%; padding: 7px 0px">
                            <h3> Nuevo operativo </h3>
                            <hr>
                        </div>
                    </el-col>



                    <el-col :span="8">
                        <div style="width: 100%; padding: 5px 0px;">
                            <el-form-item
                                    label="País"
                                    prop="country"
                                    :rules="{
                                    required: true, message: 'Este campo es requerido', trigger: ['blur','change']
                                    }">
                                        <el-select @change="changeCountry(formOperative.country)" size="mini" style="width: 100%;" v-model="formOperative.country" filterable placeholder="Selecciona un País">
                                            <el-option
                                            v-for="(item , index) in dataCountry"
                                            :key="index"
                                            :label="item.name"
                                            :value="item.id">
                                            </el-option>
                                        </el-select>
                             </el-form-item>
                        </div>
                    </el-col>

                    <el-col :span="8">
                        <div style="width: 100%; padding: 5px 0px;">
                            <el-form-item
                                    label="Estado"
                                    prop="state"
                                    :rules="{
                                    required: true, message: 'Este campo es requerido', trigger: ['blur','change']
                                    }">
                                        <el-select size="mini" style="width: 100%;" v-model="formOperative.state" filterable placeholder="Selecciona un Estado">
                                            <el-option
                                            v-for="(item , index) in dataEstate"
                                            :key="index"
                                            :label="item.name"
                                            :value="item.id">
                                            </el-option>
                                        </el-select>
                             </el-form-item>
                        </div>
                    </el-col>


                    <el-col :span="8">
                        <div style="width: 100%; padding: 5px 0px;">
                            <el-form-item
                                    label="Localidad"
                                    prop="localidad"
                                    :rules="{
                                    required: true, message: 'Este campo es requerido', trigger: ['blur','change']
                                    }">
                                        <el-input size="mini" style="width: 100%;" v-model="formOperative.localidad" placeholder="Localidad"></el-input>
                             </el-form-item>
                        </div>
                    </el-col>

                    <el-col :span="24">
                        <div style="width: 100%; padding: 5px 0px;">
                            <strong><b>Georeferencia</b></strong>
                        </div>
                    </el-col>

                    <el-col :span="12">
                        <div style="width: 100%; padding: 5px 0px;">
                            <el-form-item
                                    label="Longitud"
                                    prop="longitud">
                                        <el-input size="mini" style="width: 100%;" v-model="formOperative.longitud" placeholder="Longitud"></el-input>
                             </el-form-item>
                        </div>
                    </el-col>

                    <el-col :span="12">
                        <div style="width: 100%; padding: 5px 0px;">
                            <el-form-item
                                    label="Latitud"
                                    prop="latitud">
                                        <el-input size="mini" style="width: 100%;" v-model="formOperative.latitud" placeholder="Latitud"></el-input>
                             </el-form-item>
                        </div>
                    </el-col>


                    <el-col :span="24">
                        <div style="width: 100%; padding: 5px 0px">
                            <strong><b>Aseguramiento de armas</b></strong><br>
                            <strong><b>Ingresa el numero de armas aseguradas</b></strong>
                        </div>
                    </el-col>

                    <!-- inicio de operativos -->
                    <el-col :span="24" v-for="(domain, index) in formOperative.domains" :key="domain.key">
                        <el-row :gutter='20'>

                            <el-col :span='6'>
                                <el-form-item
                                    :label="domain.name"
                                    :prop="'domains.' + index + '.value'"
                                    :rules="{
                                    required: true, message: 'Este campo es requerido', trigger: ['blur','change']
                                    }">
                                    <el-input-number size="mini"
                                            style="width:100%;"
                                    :placeholder="domain.name"
                                controls-position="right"
                                    :min="0" :max="100000"
                                        v-model="domain.value"
                                        clearable></el-input-number>
                                </el-form-item>
                            </el-col>


                            <el-col :span='18'>
                                <div style="width: 100%; padding: 10px: 0px;">
                                    <el-form-item
                                    :label="domain.name2"
                                    :prop="'domains.' + index + '.value2'"
                                    :rules="[]">
                                        <el-input :placeholder="domain.name2"
                                                        size="mini"
                                                        style="width:100%;"
                                                        type="textarea"
                                                        maxlength="254"
                                                        show-word-limit
                                                        v-model="domain.value2"></el-input>
                                    </el-form-item>
                                </div>
                            </el-col>

                        </el-row>
                    </el-col>

                    <el-col :span="24">
                    <div style="width:100%; padding-bottom: 5px;">
                        <strong><b>Informaci&oacute;n de los detenidos</b></strong> <br>
                         <strong><b>Nacionalidad de traficantes</b></strong>
                    </div>
                    </el-col>

                    <el-col :span='8'>
                        <el-form-item
                            label="Mexicanos detenidos"
                            prop="mexicans"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger: ['blur','change']}]">
                            <el-input-number size="mini"
                                        style="width:100%;"
                                placeholder="Mexicanos detenidos"
                            controls-position="right"
                                :min="0" :max="10"
                                    v-model="formOperative.mexicans"
                                    clearable></el-input-number>
                        </el-form-item>
                    </el-col>

                    <el-col :span='8'>
                        <el-form-item
                            label="Estadounidenses detenidos"
                            prop="americans"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger: ['blur','change']}]">
                            <el-input-number size="mini"
                                        style="width:100%;"
                                placeholder="Estadounidenses detenidos"
                            controls-position="right"
                                :min="0" :max="10"
                                    v-model="formOperative.americans"
                                    clearable></el-input-number>
                        </el-form-item>
                    </el-col>

                    <el-col :span='8'>
                        <el-form-item
                            label="Otros"
                            prop="others"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger: ['blur','change']}]">
                            <el-input-number size="mini"
                                        style="width:100%;"
                                placeholder="Otros"
                            controls-position="right"
                                :min="0" :max="10"
                                    v-model="formOperative.others"
                                    clearable></el-input-number>
                        </el-form-item>
                    </el-col>

                    <el-col :span='24'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                            label="Tipo de operativo y observaciones generales"
                            prop="typeOfOperative"
                            :rules="[{ required: true, message: 'Este campo es requerido', trigger:['blur','change'] }]">
                                <el-input placeholder="Tipo de operativo y observaciones generales"
                                                size="mini"
                                                style="width:100%;"
                                                type="textarea"
                                                minlength="50"
                                                maxlength="60"
                                                show-word-limit
                                                v-model="formOperative.typeOfOperative"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>

                    <el-col :span='24'>
                        <div style="width: 100%; padding: 10px: 0px;">
                            <el-form-item
                            label="Link de evidencia"
                            prop="link">
                                <el-input placeholder="https://ejemplo.com"
                                                size="mini"
                                                style="width:100%;"
                                                v-model="formOperative.link"></el-input>
                            </el-form-item>
                        </div>
                    </el-col>
                    <!-- fin de catalogo de Operativos -->

                    <el-col :span="24">
                        <div style="width: 100%; display:flex; justify-content: flex-end">
                            <div style="padding-right: 5px;">
                                <el-button size="mini" type="danger" @click="clearFields">Cerrar</el-button>
                            </div >
                            <div style="padding-right: 5px;">
                                <el-button size="mini" type="primary" @click="addOperative" >Guardar</el-button>
                            </div>
                            <div>
                                <el-button size="mini" type="success" @click="addOperative" >Registrar</el-button>
                            </div>
                        </div>
                    </el-col>

                </el-row>
            </el-form>
        </el-col>
        <!-- fin de formulario de ventana modal -->


        </el-row>

        <el-row :gutter='20'>
            <el-col :span='24'>
                <div class=''>

       <el-row :gutter='20'>
            <el-col :span='24'>

                <div style="width: 100%;  padding: 8px 0px;">
                    <el-tabs >

                        <el-tab-pane label="Registrados">
                            <el-row :gutter='20'>
                                <el-col :span='24'>
                                    <div style="width: 100%; padding 5px 0px;">


                                        <el-col :span="24" v-show="sqlOperativeSave.length > 0">
                                            <div style="width: 100%; padding: 7px 0px;">

                                                <el-collapse v-model="activeNames" @change="handleChange">
                                                    <el-collapse-item v-for="(item,index) in sqlOperativeSave" :key="index"
                                                    :title="numOperativo(index)" :name="String(index)">
                                                        <div style="width: 100%; padding: 5px; display:flex; justify-content: speace-around;">

                                                                <div style="width: 100%; padding: 5px; display:flex; justify-content: space-between; text-align: center;">
                                                                    <div>
                                                                            <strong><b>N&uacute;mero de aseguramientos:</b></strong> <br> {{ item.short_arms + item.long_weapons + item.long_weapons + item.barret + item.chargers + item.explosives + item.rocket_launcher + item.parts_accessories }}
                                                                    </div>
                                                                    <div>
                                                                            <strong><b>Mexicanos:</b></strong>  <br>{{ item.mexicans }}
                                                                    </div>
                                                                    <div>
                                                                             <strong> <b>Estadounidenses: </b> </strong>  <br> {{ item.americans }}
                                                                    </div>
                                                                    <div>
                                                                            <strong> <b>Otros: </b> </strong>  <br> {{ item.others }}
                                                                    </div>
                                                                </div>

                                                        </div>
                                                    </el-collapse-item>
                                                </el-collapse>

                                            </div>
                                        </el-col>








                                    </div>
                                </el-col>
                            </el-row>
                        </el-tab-pane>

                        <el-tab-pane label="Editar">
                            <el-row :gutter='20'>
                                <el-col :span='24'>
                                    <div style="width: 100%; padding 5px 0px;">

                                        <el-col :span="24" v-show="sqlOperative.length > 0">
                                            <div style="width: 100%; padding: 7px 0px;">

                                                <el-collapse v-model="activeNames" @change="handleChange">
                                                    <el-collapse-item v-for="(item,index) in sqlOperative" :key="index"
                                                    :title="numOperativo(index)" :name="String(index)">
                                                        <div style="width: 100%; padding: 5px; display:flex; justify-content: speace-around;">
                                                               <div style="width: 100%; padding: 5px; display:flex; justify-content: space-between; text-align: center;">
                                                                    <div>
                                                                            <strong><b>N&uacute;mero de aseguramientos:</b></strong> <br> {{ item.short_arms + item.long_weapons + item.long_weapons + item.barret + item.chargers + item.explosives + item.rocket_launcher + item.parts_accessories }}
                                                                    </div>
                                                                    <div>
                                                                            <strong><b>Mexicanos:</b></strong>  <br>{{ item.mexicans }}
                                                                    </div>
                                                                    <div>
                                                                             <strong> <b>Estadounidenses: </b> </strong>  <br> {{ item.americans }}
                                                                    </div>
                                                                    <div>
                                                                            <strong> <b>Otros: </b> </strong>  <br> {{ item.others }}
                                                                    </div>



                                                                    <div>

                                                                            <center>
                                                                                <br>
                                                                                <el-button-group>
                                                                                    <el-tooltip
                                                                                        class="item"
                                                                                        effect="dark"
                                                                                        content="Editar operativo"
                                                                                        placement="top-start">
                                                                                        <el-button
                                                                                            type="primary"
                                                                                            size="mini"
                                                                                            icon="fa fa-sticky-note">
                                                                                        </el-button>
                                                                                    </el-tooltip>
                                                                                    <el-tooltip
                                                                                        class="item"
                                                                                        effect="dark"
                                                                                        content="Eliminar operativo"
                                                                                        placement="top-start">
                                                                                        <el-button
                                                                                            type="danger"
                                                                                            size="mini"
                                                                                            icon="fa fa-trash-alt">
                                                                                        </el-button>
                                                                                    </el-tooltip>
                                                                                </el-button-group>
                                                                            </center>


                                                                    </div>
                                                                </div>



                                                        </div>
                                                    </el-collapse-item>
                                                </el-collapse>

                                            </div>
                                        </el-col>

                                        <el-col :span="24" v-show="sqlOperative.length > 0">
                                            <div style="width: 100%; display:flex; justify-content: flex-end;">

                                            <div>
                                                <el-button
                                                        size="mini"
                                                        type="primary"
                                                        icon="fas fa-edit"
                                                        @click="openModal(1,[])">
                                                        Guardar Operativos
                                                </el-button>
                                            </div>
                                            </div>
                                        </el-col>

                                    </div>
                                </el-col>
                            </el-row>
                        </el-tab-pane>

                    </el-tabs>
                </div>

            </el-col>
        </el-row>

        <el-row :gutter='20'>
            <el-col :span='24'>
                <div style="width: 100%; padding: 5px;">

                    <p>
                        <strong><b> Total de operativos: </b></strong> {{ operativos }}
                    </p>

                    <p>
                        <strong><b> Total de aseguramientos: </b></strong> {{ armas }}
                    </p>

                </div>
            </el-col>
        </el-row>



                </div>
            </el-col>
        </el-row>


        <!-- ventana modal -->


        <el-dialog
        :title="titleModal"
        :visible.sync="dialogActive"
        width="40%">
        <span>¿Estas completamente seguro de guardar los operativos?</span>
        <span slot="footer" class="dialog-footer">
            <el-button size="mini" tupe="danger" @click="dialogActive = false">Cancelar</el-button>
            <el-button size="mini" type="success" @click="saveOperative">Registrar</el-button>
        </span>
        </el-dialog>



        <!-- fin de ventana modal -->








    </div>
</template>

<script>
    export default {
        components: {
        },

        data() {

        var link = (rule, value, callback) => {
            value = value.trim();
            let exp = new RegExp(/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/,'i');
                if(!value) {
                     return callback(new Error('Este campo es requerido'));
                }else{
                    if( exp.test(value) ){
                      return callback();
                    } else {
                      return callback(new Error('Formato incorrecto'));
                    }
                }
            };

            return {
                     dataCountry:[
                         {id:0, name: "Seleccione una opción"},
                         {id:1, name:'México'},
                         {id:2, name:"Estados Unidos"}
                         ],
                     dataEstate:[{id:0, name: "Seleccione una opción"}],
                     dataMexico:[
                         {id:0, name: "Seleccione una opción"},
                         {id:1, name:'Ciudad de México'},
                         {id:2, name:"Toluca"}
                         ],
                     dataEEUU:[
                         {id:0, name: "Seleccione una opción"},
                         {id:1, name:'Nuevo México'},
                         {id:2, name:"Texas"}
                         ],
                    sqlOperative: [],
                    sqlOperativeSave:[],
                        ruleForm: {
                            consulate: 1,
                                 date: new Date()
                        },
                      consulates: [{ id:1 , name:'Nuevo Mexico' }],
                   formOperative:{
                    domains: [{
                         key: 1,
                       value: '',
                        name:'Armas Cortas',
                        key2: 2,
                      value2: '',
                       name2:'Descripción armas cortas'
                    },{
                         key: 3,
                       value: '',
                        name:'Armas largas',
                        key2: 4,
                      value2: '',
                       name2:'Descripción armas largas'
                    },{
                         key: 5,
                       value: '',
                        name:'Barret',
                        key2: 6,
                      value2: '',
                       name2:'Descripción Barret'
                    },{
                         key: 7,
                       value: '',
                        name:'Cargadores',
                        key2: 8,
                      value2: '',
                       name2:'Descripción cargadores'
                    },{
                         key: 9,
                       value: '',
                        name:'Explosivos',
                        key2: 10,
                      value2: '',
                       name2:'Descripción explosivos'
                    },{
                         key: 11,
                       value: '',
                        name:'Lanzacohetes',
                        key2: 12,
                      value2: '',
                       name2:'Descripción lanzacohetes'
                    },{
                         key: 13,
                       value: '',
                        name:'Partes complementos',
                        key2: 14,
                      value2: '',
                       name2:'Descripción partes complementos'
                    }],
                    mexicans:0,
                    americans:0,
                    others:0,
           typeOfOperative:'',
                      link:'',
                     photo:'',
                    country: 0,
                      state: 0,
                  localidad:'',
                   longitud:'',
                    latitud:'',

                },
                ruleOperative: {
                    link: [
                        { validator: link, trigger: ['blur','change'] }
                    ]
                 },
                rules:{},
                activeNames:[],//solo strings,
                dialogActive:false,
                showFormOperative: false,
                titleModal:'',
                armas:0,
                operativos:0,
                mesAnio: ''
            }
        },

        created() {
           // this.startLoading();

           this.getOperatives();


            Date.prototype.getWeekNumber = function () {
                var d = new Date(+this);  //Creamos un nuevo Date con la fecha de "this".
                d.setHours(0, 0, 0, 0);   //Nos aseguramos de limpiar la hora.
                d.setDate(d.getDate() + 4 - (d.getDay() || 7)); // Recorremos los días para asegurarnos de estar "dentro de la semana"
                //Finalmente, calculamos redondeando y ajustando por la naturaleza de los números en JS:
                return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
            };
           // var fecha = new Date();
            var ano = new Date(). getFullYear();

            let month = new Date(2017, 2, 4).getWeekNumber();


            var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            var f=new Date();
           // document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

            this.mesAnio ='Periodo: semana '+month+' de ' + meses[f.getMonth()]+  ' del '+ano;




           setTimeout(()=>{
                this.calculosOperativos();
           },2000);

        },
        computed: {
        },


        methods: {
            calculosOperativos(){
                    this.armas = 0;
                    this.operativos = 0;

                    let data = this.sqlOperativeSave;

                    this.operativos = data.length;

                    for (let i = 0; i < data.length; i++) {
                      this.armas = this.armas +  data[i].short_arms  + data[i].long_weapons + data[i].barret + data[i].chargers + data[i].explosives + data[i].rocket_launcher + data[i].parts_accessories;
                    }
            },
            getOperatives(){

                axios.get('/api/guncontrol/getOperatives').then(response => {


                this.sqlOperativeSave = response.data.lResults;

                }).catch(error => {

                });

            },
            changeCountry( val ){
                console.log(val);
                switch (val) {
                    case 0:
                    {
                        this.dataEstate = [{id:0, name: "Seleccione una opción"}];
                        break;
                    }
                    case 1:
                    {
                        this.dataEstate = this.dataMexico;
                        break;
                    }
                    case 2:
                    {
                        this.dataEstate = this.dataEEUU;
                        break;
                    }
                }
            },
            saveOperative(){
                        axios.post('/api/guncontrol/registerGunControl',this.sqlOperative).then(response => {
                            if(response.data.success === true){
                                if(response.data.lResults === 'ok'){



                                    setTimeout(() => {
                                   //     this.$router.push({name: 'RecommendationsIndex' });
                                         this.getOperatives();
                                         this.calculosOperativos();
                                         this.dialogActive  = false;
                                         this.sqlOperative = [];

                                    }, 2000);

                                }
                            }

                        }).catch(error => {
                        console.error("addOperative -> error", error)

                        });
            },
            numOperativo(idx){
                    idx = idx + 1;
                return 'Operativo '+idx;
            },
            openModal(action,data=[]){
               this.dialogActive = true;
               switch (action) {
                   case 0:
                   {
                       this.titleModal = "Nuevo Operativo";
                        setTimeout(() => {
                             this.$refs['formOperative'].clearValidate([]);
                        }, 500);
                    break;
                   }
                   case 1:
                   {
                       this.titleModal = "Registrar Operativos";

                    break;
                   }
               }
            },
             handleChange(val) {
                 this.activeNames = val;
                 console.log(val);
            },
            clearFields(){
                    this.formOperative = {
                        domains: [{
                            key: 1,
                        value: '',
                            name:'Armas Cortas',
                            key2: 2,
                        value2: '',
                        name2:'Descripción armas cortas'
                        },{
                            key: 3,
                        value: '',
                            name:'Armas largas',
                            key2: 4,
                        value2: '',
                        name2:'Descripción armas largas'
                        },{
                            key: 5,
                        value: '',
                            name:'Barret',
                            key2: 6,
                        value2: '',
                        name2:'Descripción Barret'
                        },{
                            key: 7,
                        value: '',
                            name:'Cargadores',
                            key2: 8,
                        value2: '',
                        name2:'Descripción cargadores'
                        },{
                            key: 9,
                        value: '',
                            name:'Explosivos',
                            key2: 10,
                        value2: '',
                        name2:'Descripción explosivos'
                        },{
                            key: 11,
                        value: '',
                            name:'Lanzacohetes',
                            key2: 12,
                        value2: '',
                        name2:'Descripción lanzacohetes'
                        },{
                            key: 13,
                        value: '',
                            name:'Partes complementos',
                            key2: 14,
                        value2: '',
                        name2:'Descripción partes complementos'
                        }],
                        mexicans:0,
                        americans:0,
                        others:0,
            typeOfOperative:'',
                        link:'',
                        photo:'',
                    country: 0,
                      state: 0,
                  localidad:'',
                   longitud:'',
                    latitud:'',

                    };
                 // this.showFormOperative = false;
                 setTimeout(() => {
                             this.$refs['formOperative'].clearValidate([]);
                 }, 500);

            },
            addOperative(){

                this.$refs['formOperative'].validate((valid) => {
                if (valid) {

                        this.sqlOperative.push({
                                'user_id': 1,
                                'consulatee_id': this.ruleForm.consulate,
                                'short_arms_description':this.formOperative.domains[0].value2,
                                'short_arms':this.formOperative.domains[0].value,
                                'long_weapons_description':this.formOperative.domains[1].value2,
                                'long_weapons':this.formOperative.domains[1].value,
                                'barret_description':this.formOperative.domains[2].value2,
                                'barret':this.formOperative.domains[2].value,
                                'description_chargers':this.formOperative.domains[3].value2,
                                'chargers':this.formOperative.domains[3].value,
                                'explosives_description':this.formOperative.domains[4].value2,
                                'explosives':this.formOperative.domains[4].value,
                                'rocket_launcher_description':this.formOperative.domains[5].value2,
                                'rocket_launcher':this.formOperative.domains[5].value,
                                'parts_accessories_description':this.formOperative.domains[6].value2,
                                'parts_accessories':this.formOperative.domains[6].value,
                                'mexicans':this.formOperative.mexicans,
                                'americans':this.formOperative.americans,
                                'others':this.formOperative.others,
                                'type_of_operative': this.formOperative.typeOfOperative,
                                'link':this.formOperative.link,
                                'country': this.formOperative.country,
                                'state':this.formOperative.state,
                                'localidad':this.formOperative.localidad,
                                'longitud':this.formOperative.longitud,
                                'latitud':this.formOperative.latitud,
                        });

                this.clearFields();
                // this.dialogActive = false; //Cerrar ventana modal


                } else {
                    console.error("Error formulario");
                    return false;
                }
                });

            },

        },
    }
</script>


<style scoped>

</style>



