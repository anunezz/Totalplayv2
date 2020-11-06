<template>
    <div>
<!--
<pre>
    {{$store.state.filter.activeFilter}}
</pre>

        <pre>
            {{$store.state.filter.paginate}}
        </pre> -->

        <el-dialog
            title="Búsqueda avanzada de recomendaciones"
            :visible.sync="$store.state.filter.visibleModal"
            width="80%">

            <el-row :gutter="20">
                <el-col :span="24" style="padding-bottom: 10px;">
                    <div class="divContent">
                            <div>
                                <div>
                                    <a style="text-decoration: none;
                                              cursor:pointer;"
                                     @click="clearFields()"> <i class="fa fa-trash"></i> Limpiar campos</a>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <el-radio v-model="$store.state.filter.paginate.filters.published" :label="1">
                                        Publicados
                                    </el-radio>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <el-radio v-model="$store.state.filter.paginate.filters.published" :label="0">
                                        Despublicados
                                    </el-radio>
                                </div>
                            </div>

                            <!-- <div>
                            	<div>
                                    <el-checkbox>
                                    	B&uacute;squeda por exclusi&oacute;n
                                    </el-checkbox>
                                </div>
                            </div> -->

                    </div>
                </el-col>


                <el-col :span="24" style="padding-bottom: 10px;">
                    <div class="divContent2">
                            <div style="width: 74%" >
                                <el-input suffix-icon="el-icon-search"
                                                style="width: 100%;"
                                                 size="mini"
                                          placeholder="Buscar por texto recomendación"
                                              v-model="$store.state.filter.paginate.filters.recommendation"></el-input>
                            </div>

                            <div style="width: 24%;">
                                <el-input suffix-icon="el-icon-search"
                                                style="width: 100%;"
                                                 size="mini"
                                          placeholder="Buscar por folio"
                                              v-model="$store.state.filter.paginate.filters.invoice"></el-input>
                            </div>

                    </div>
                </el-col>

                <el-col :span="6" v-for="(item,index) in tags" :key="index" >
                    <div style="width: 100%; padding: 2px 0px;">
                          <el-button type="info" plain size="mini" style="width: 100%;" @click="actived = index"> {{ item }}  </el-button>
                    </div>
                </el-col>

                <el-col :span="24" style="width: 99%;">

                    <div class="animated fadeIn fast" style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-show="actived === 0" >
                        <el-row style="margin: 10px" :gutter="20">
                            <div style="width: 100%;">
                                    <el-input
                                    style="width: 100%;"
                                    size="mini"
                                    suffix-icon="el-icon-search"
                                    placeholder="Buscar por año"
                                    v-model="searchCatYear">
                                </el-input>
                            </div>
                            <el-checkbox-group v-model="$store.state.filter.paginate.filters.year" class="form-check animated fadeIn fast">
                                    <div style="width: 100%; padding-top: 10px;">
                                        <el-col :span="2"
                                        v-for="(item,index) in
                                         catYears.filter(data => !searchCatYear || data.date.toLowerCase().includes(searchCatYear.toLowerCase()))"
                                        :key="index">
                                                    <el-checkbox :label="item.date"> {{item.date}} </el-checkbox>
                                        </el-col>
                                    </div>
                            </el-checkbox-group>
                        </el-row>
                    </div>

                    <div class="animated fadeIn fast" style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-show="actived === 1" >
                           <el-row style="margin: 10px" :gutter="20">
                                <div style="width: 100%;">
                                        <el-input
                                        style="width: 100%;"
                                        size="mini"
                                        suffix-icon="el-icon-search"
                                        placeholder="Buscar por Entidad Emisora"
                                        v-model="searchCatEntities">
                                    </el-input>
                                </div>
                                <div style="width: 100%; padding-top: 10px;">
                                	<el-checkbox-group v-model="$store.state.filter.paginate.filters.entities" class="form-check animated fadeIn fast">
                                	        <div style="width: 100%;">
                                	            <el-col :span="24" v-for="(item,index) in catEntities.filter(data => !searchCatEntities || data.name.toLowerCase().includes(searchCatEntities.toLowerCase()))" :key="index">
                                	                        <el-checkbox :label="item.id"> {{item.name}} </el-checkbox>
                                	            </el-col>
                                	        </div>
                                	</el-checkbox-group>
                                </div>
                            </el-row>
                    </div>
                    <div class="animated fadeIn fast" style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-if="actived === 2" >
                         <el-row style="margin: 10px" :gutter="20">
                                <div style="width: 100%;">
                                        <el-input
                                        style="width: 100%;"
                                        size="mini"
                                        suffix-icon="el-icon-search"
                                        placeholder="Buscar por Población"
                                        v-model="searchCatPopulations">
                                    </el-input>
                                </div>
                                <div style="width: 100%; padding-top: 10px;">
                                	<el-checkbox-group v-model="$store.state.filter.paginate.filters.populations" class="form-check animated fadeIn fast">
                                	        <div style="width: 100%;">
                                	            <el-col :span="24" v-for="(item,index) in catPopulations.filter(data => !searchCatPopulations || data.name.toLowerCase().includes(searchCatPopulations.toLowerCase()))" :key="index">
                                	                        <el-checkbox :label="item.id"> {{item.name}} </el-checkbox>
                                	            </el-col>
                                	        </div>
                                	</el-checkbox-group>
                                </div>
                            </el-row>
                    </div>
                    <div class="animated fadeIn fast" style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-show="actived === 3" >
                        <el-row style="margin: 10px" :gutter="20">
                            <div style="width: 100%;">
                                <el-input
                                style="width: 100%;"
                                size="mini"
                                suffix-icon="el-icon-search"
                                placeholder="Buscar por Tema"
                                v-model="filterTopics">
                                </el-input>
                            </div>
                            <div style="width: 100%; padding-top: 10px;">
                            <el-tree
                                ref="top"
                                :data="catTopics.tree"
                                show-checkbox
                                :check-strictly="true"
                                node-key="id"
                                :props="defaultPropsTopics"
                                :filter-node-method="filterNodeTopic"
                                @check="TopTree">
                            </el-tree>
                        </div>
                        </el-row >
                    </div>
                    <div class="animated fadeIn fast" style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-show="actived === 4" >
                            <el-row style="margin: 10px" :gutter="20">
                                <div style="width: 100%;">
                                        <el-input
                                        style="width: 100%;"
                                        size="mini"
                                        suffix-icon="el-icon-search"
                                        placeholder="Buscar por Autoridad"
                                        v-model="searchCatAutorities">
                                    </el-input>
                                </div>
                                <div style="width: 100%; padding-top: 10px;">
                                	<el-checkbox-group v-model="$store.state.filter.paginate.filters.authorities" class="form-check animated fadeIn fast">
                                	        <div style="width: 100%;">
                                	            <el-col :span="24" v-for="(item,index) in catAutorities.filter(data => !searchCatAutorities || data.name.toLowerCase().includes(searchCatAutorities.toLowerCase()))" :key="index">
                                	                        <el-checkbox :label="item.id"> {{item.name}} </el-checkbox>
                                	            </el-col>
                                	        </div>
                                	</el-checkbox-group>
                                </div>
                            </el-row>
                    </div>
                    <div class="animated fadeIn fast" style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-show="actived === 5" >
                            <el-row style="margin: 10px" :gutter="20">
                                <div style="width: 100%;">
                                    <el-input
                                    style="width: 100%;"
                                    size="mini"
                                    suffix-icon="el-icon-search"
                                    placeholder="Buscar por Ods"
                                    v-model="filterTextOds">
                                    </el-input>
                                </div>
                                <div style="width: 100%; padding-top: 10px;">
                                    <div style="overflow-x:scroll; padding: 10px; 15px;">
                                        <el-tree
                                            style="width: 5000px;"
                                            ref="Ods"
                                            :data="goalsOds.tree"
                                            show-checkbox
                                            node-key="id"
                                            :props="defaultPropsOds"
                                            :filter-node-method="filterNodeOds"
                                            @check="OdsTree">
                                        </el-tree>
                                    </div>
                                </div>
                            </el-row >
                    </div>
                    <div class="animated fadeIn fast" style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-show="actived === 6" >
                            <el-row style="margin: 10px" :gutter="20">
                                <div style="width: 100%;">
                                     <el-input
                                        placeholder="Buscar por Derechos Humanos"
                                        size="mini"
                                        suffix-icon="el-icon-search"
                                        v-model="filterTextRights">
                                      </el-input>
                                </div>
                                <div style="width: 100%; padding-top: 10px;">
                                        <el-tree
                                            ref="derechosHumanos"
                                            :data="catRights"
                                            show-checkbox
                                            highlight-current
                                            node-key="id"
                                            :props="defaultProps"
                                            class="filter-tree"
                                            :filter-node-method="filterNode"
                                            @check="rightsTree">
                                        </el-tree>
                                </div>
                            </el-row >
                    </div>
                    <div class="animated fadeIn fast" style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-show="actived === 7" >
                            <el-row style="margin: 10px" :gutter="20">
                                <div style="width: 100%;">
                                        <el-input
                                        style="width: 100%;"
                                        size="mini"
                                        suffix-icon="el-icon-search"
                                        placeholder="Buscar por Acción Solicitada"
                                        v-model="searchCatActions">
                                    </el-input>
                                </div>
                                <div style="width: 100%; padding-top: 10px;">
                                	<el-checkbox-group v-model="$store.state.filter.paginate.filters.actions" class="form-check animated fadeIn fast">
                                	        <div style="width: 100%;">
                                	            <el-col :span="24" v-for="(item,index) in catActions.filter(data => !searchCatActions || data.name.toLowerCase().includes(searchCatActions.toLowerCase()))" :key="index">
                                	                        <el-checkbox :label="item.id"> {{item.name}} </el-checkbox>
                                	            </el-col>
                                	        </div>
                                	</el-checkbox-group>
                                </div>
                            </el-row>
                    </div>
                </el-col>
            </el-row>





            <span slot="footer" class="dialog-footer">
                <el-button size="mini" icon="fa fa-times-circle"  type="danger" @click="closeModal"> Cancelar</el-button>
                <el-button size="mini" icon="fa fa-filter" type="success" @click="searchFilters" > Buscar</el-button>
            </span>
        </el-dialog>




    </div>
</template>

<script>
    export default {
        props: [],
        data(){
            return{
                tags:['Fecha','Entidad Emisora','Población','Temas','Autoridad','ODS','Derechos Humanos','Acción Solicitada'],
                actived:0,
                catYears:[],
                catEntities:[],
                catPopulations:[],
                catTopics:[],
                catAutorities:[],
                catActions:[],
                catRights:[],
                filterCatYear:'',
                searchCatYear:'',
                filterCatEntities:'',
                searchCatEntities:'',
                filterCatPopulations:'',
                searchCatPopulations:'',
                searchCatAutorities:'',
                filterCatAutorities:'',
                searchCatActions:'',
                filterCatActions:'',
                searchTopics:'',
                filterTopics:'',
                defaultPropsTopics: {
                    children: 'children',
                    label: 'name'
                },
                defaultPropsOds: {
                    children: 'children',
                    label: 'label'
                },
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                filterTextRights: '',
                goalsOds:[],
                filterTextOds:''

            }
        },
        created() {
        },
        computed:{
        },
        mounted() {
            this.getCats();
        },
         watch: {
            filterCatYear(val){
              this.searchCatYear = val.trim();
            },
            filterCatEntities(val){
              this.searchCatEntities = val.trim();
            },
            filterCatAutorities(val){
              this.searchCatAutorities = val.trim();
            },
            filterCatActions(val){
              this.searchCatActions = val.trim();
            },
            filterTopics(val){
               this.$refs.top.filter(val);
            },
            filterTextOds(val) {
               this.$refs.Ods.filter(val);
            },
            filterTextRights(val) {
                this.$refs.derechosHumanos.filter(val);
            },
        },
        methods:{
            rightsTree() {
                let data = this.$refs.derechosHumanos.getCheckedNodes();
                let rigths = [];
                for (let i = 0; i < data.length; i++) {
                    rigths.push({
                            right_id: data[i].right_id,
                            subcategory_id: data[i].subcategory_id,
                            subrights_id: data[i].subrights_id,
                    });
                }
                this.$store.state.filter.paginate.filters.rights = rigths;
            },
            OdsTree(){
                let data = this.$refs.Ods.getCheckedNodes();
                let dataOds = [];
                for (let i = 0; i < data.length; i++) {
                    if(  !Object.prototype.hasOwnProperty.call(data[i], 'children')  ) {
                    dataOds.push({ "ods_id":data[i].ods_id,"cat_goal_id":data[i].cat_goal_id});
                    }
                }
                this.$store.state.filter.paginate.filters.ods = dataOds;
            },
            filterNodeOds(value, data) {
                if (!value) return true;
                return data.label.indexOf(value) !== -1;
            },
            filterNodeTopic(value, data) {
                if (!value) return true;
                return data.name.indexOf(value) !== -1;
            },
            filterNode(value, data) {
                if (!value) return true;
                return data.label.indexOf(value) !== -1;
            },
            TopTree() {
                let data = this.$refs.top.getCheckedNodes();
                let parent = [];
                let children = [];

                for (let i = 0; i < data.length; i++) {
                    if(  Object.prototype.hasOwnProperty.call(data[i], 'children')  ) {
                        parent.push(data[i].topic_id);
                    }else if( !Object.prototype.hasOwnProperty.call(data[i], 'children') ){
                        children.push(data[i].cat_subtopic_id);
                    }

                }

                this.$store.state.filter.paginate.filters.topics = [{ "cat_topic_id": parent, "cat_subtopic_id": children }];

           },
            clearFields(){

                this.startLoading();
                setTimeout(()=>{
                        this.$refs.Ods.setCheckedKeys([]);
                        this.$refs.top.setCheckedKeys([]);
                        this.$refs.derechosHumanos.setCheckedKeys([]);
                        this.$store.state.filter.activeFilter = false;
                        this.$store.state.filter.paginate =
                        {
                            page: 1,
                        perPage: 10,
                        filters: {
                                    year: [],
                                    entities: [],
                                    populations: [],
                                    authorities: [],
                                    rights: [],
                                    topics: [{
                                        "cat_topic_id": [],
                                        "cat_subtopic_id": []
                                        }],
                                    ods: [],
                                    actions:[],
                                    published: '',
                                    recommendation:'',
                                    invoice:''
                                }
                        };

                    this.stopLoading();
                },200);
            },
            closeModal(){
                this.$store.state.filter.visibleModal = false;
            },
            searchFilters(){
                let { year,entities,populations,authorities,rights,topics,ods,actions,published,recommendation,invoice } = this.$store.state.filter.paginate.filters;
                let d = [];
                d.push( ( year.length > 0 )? 1:0 );
                d.push( ( entities.length > 0 )? 1:0 );
                d.push( ( populations.length > 0 )? 1:0 );
                d.push( ( authorities.length > 0 )? 1:0 );
                d.push( ( rights.length > 0 )? 1:0 );
                d.push( ( topics[0].cat_topic_id.length > 0 || topics[0].cat_subtopic_id.length > 0 )? 1:0 );
                d.push( ( ods.length > 0 )? 1:0 );
                d.push( ( actions.length > 0 )? 1:0 );
                d.push( ( published !== '' )? 1:0 );
                d.push( ( recommendation !== '' )? 1:0 );
                d.push( ( invoice !== '' )? 1:0 );
                this.$store.state.filter.activeFilter = ( d.find(item => item === 1) === undefined )?false : true;

                this.$emit('responseFilter','ok');
            },
            getCats(){
                axios.get('/api/public/index-public/recommendations').then(response => {
                    if(response.data.success === true){
                            this.catYears = _.orderBy(response.data.catYears, ['date'], ['asc']);
                            this.catEntities = _.orderBy(response.data.catEntities, ['name'], ['asc']);
                            this.catPopulations = _.orderBy(response.data.catPopulations, ['name'], ['asc']);
                            this.catTopics = response.data.catTopics;
                            this.goalsOds = response.data.goalsOds;
                            this.catAutorities = _.orderBy(response.data.catAutorities, ['name'], ['asc']);
                            this.catActions = _.orderBy(response.data.catActions, ['name'], ['asc']);
                            this.catRights = response.data.catRights;
                    }
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            }
        },
    }
</script>

<style scoped>
.divContent, .divContent2{
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.divContent div{
   width: 33%;
}

.divContent div div{
   width: 65%;
   margin: 0px auto;
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
