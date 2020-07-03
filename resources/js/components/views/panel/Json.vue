    <template>
    <div style="padding:100px;">
    <Header></Header>
    <div style="padding:10px;"></div>


    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="padding:10px; 0px; 0px; 0px;">
                <h5>Módulo para la edición de multilenguaje SERIDH.</h5>
                <div v-if="RequestError === true" class="alert alert-danger alert-dismissible">
                    <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                    @click="resetMessage"
                    >
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Atención!</strong> No se puedo ralizar la acción.
                </div>

                <div v-if="RequestSucces === true" class="alert alert-success alert-dismissible">
                    <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                    @click="resetMessage"
                    >
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Atención!</strong> Los datos se guardaron corractamente.
                </div>

                 <ul class="nav nav-tabs">

                     <li v-for="(item, index) in dataLang" :key="`item-${index}`">
                         <a data-toggle="tab" href="#tab-01" @click="getLang(item.acronym)">
                            {{ item.acronym }}
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab-100" @click="getPlus('add')">
                            +
                        </a>
                    </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                            <div class="tab-pane active" id="tab-01">
                              <v-jsoneditor v-model="data" :options="options" height="400px"></v-jsoneditor>
                            </div>

                            <div class="tab-pane" id="tab-100">
                                <form @submit.prevent="handleSubmit">
                                    <div style="padding:0px 0px 50px 0px">
                                        <div class="form-group col-md-6">
                                            <label class="col-sm-6 control-label display:inline">{{ $t('Acronimo') }} *:</label>
                                                <div class="col-sm-6">
                                                    <input
                                                    type="text"
                                                    class="form-control"
                                                    autocomplete="off"
                                                    aria-required="true"
                                                    aria-disabled="false"
                                                    aria-readonly="false"
                                                    name="acronym"
                                                    v-validate="'required|max:4'"
                                                    v-model="fillData.acronym"
                                                    :placeholder="$t('Acronimo')"
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="validations.has('acronym') "
                                                        v-text="validations.first('acronym')"
                                                    ></span>
                                                </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                                <label class="col-sm-6 control-label display:inline">{{ $t('Descripción') }} *:</label>
                                                <div class="col-sm-6">
                                                    <input
                                                    type="text"
                                                    class="form-control"
                                                    autocomplete="off"
                                                    aria-required="true"
                                                    aria-disabled="false"
                                                    aria-readonly="false"
                                                    name="description"
                                                    v-validate="'required|max:20'"
                                                    v-model="fillData.description"
                                                    :placeholder="$t('Descripción')"
                                                    />

                                                    <span
                                                        class="text-danger"
                                                        v-if="validations.has('description') "
                                                        v-text="validations.first('description')"
                                                    ></span>
                                                </div>
                                        </div>

                                        <button
                                            class="btn btn-primary float-right"
                                            style="float: right;"
                                        >Guardar</button>

                                </div>
                                </form>

                            </div>
                            <br>
                            <div v-if="value!='add'">
                            <button type="button" @click="saveLang()" class="btn btn-primary">
                                <font >Guardar</font>
                            </button>

                            <button type="button" @click="deleteLang()" class="btn btn-danger">
                                <font >Eliminar</font>
                            </button>

                            <button type="button" @click="rollback()" class="btn btn-primary">
                                <font >Recuperar Anterior</font>
                            </button>
                            </div>
                    </div>
            </div>
        </div>
      </div>
    </div>
   </div>
</template>

<script>
import Header from "@/components/views/panel/Header";
import VJsoneditor from "v-jsoneditor";

export default {
  components: {
    Header,
    VJsoneditor
  },

  data() {
    return {
      data: {},
      lang: "es",
      RequestError: false,
      RequestSucces: false,
      fillData: {
        acronym: "",
        description: ""
      },
      dataLang: "",
      options: {
        mode: "code",
        onEditable: function(node) {
          //console.log("node", node);
          return true;
        }
      }
    };
  },
  created() {
    this.getLang(this.lang);
    this.getCatLang();
  },
  methods: {
    saveLang() {
      axios
        .post("/api/lang/" + this.value, this.data)
        .then(response => {
          this.RequestSucces = true;
        })
        .catch(err => {
          console.log(err);
          this.RequestError = true;
          this.RequestSucces = false;
        });
    },
    handleSubmit(e) {
      this.$validator.validate().then(valid => {
        if (valid) {
          axios
            .post("/api/newLang/" + this.value, this.fillData)
            .then(response => {
              this.RequestSucces = true;
              this.getCatLang();
              this.fillData = {};
              this.$validator.reset();
            })
            .catch(err => {
              console.log(err);
              this.RequestError = true;
              this.RequestSucces = false;
            });
        } else {
          this.incompleteForm = true;
        }
      });
    },

    deleteLang() {
      axios
        .post("/api/lang-deleted/" + this.value, this.data)
        .then(response => {
          this.RequestSucces = true;
          this.getCatLang();
        })
        .catch(err => {
          console.log(err);
          this.RequestError = true;
          this.RequestSucces = false;
        });
    },
    getCatLang() {
      axios
        .get("/api/get-cat-lang")
        .then(response => {
          this.dataLang = response.data.lang;
        })
        .catch(err => {
          console.log(err);
        });
    },
    getLang(value) {
      this.value = value;
      axios
        .post("/api/get-lang/" + value)
        .then(response => {
          this.data = response.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    getPlus(value) {
      this.value = value;
      this.data = {};
    },

    rollback() {
      axios
        .post("/api/lang-rollback/" + this.value)
        .then(response => {
          this.data = response.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    resetMessage() {
      this.RequestError = false;
      this.RequestSucces = false;
    }
  },

  mounted() {}
};
</script>

<style scoped>
.panel-default > .panel-heading {
  color: #333;
  background-color: #ffffff;
  border-color: #ddd;
}
</style>
