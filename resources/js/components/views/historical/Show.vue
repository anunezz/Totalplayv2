<template>
    <div>
        <header-section icon="fa-eye" title="Consulta de expediente">
            <template slot="buttons">
                <el-button
                    size="medium"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/notices/multilaterales')">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <el-row :gutter="10">
            <el-col :span="24">
                <el-card shadow="never">
                    <h3 class="el-icon-info"> <b>Información, Expediente</b></h3> <br>
                    <strong>Determinante de la unidad: </strong> SSRE <br>
                    <strong>Clasificación: </strong> 10-01-1 <br>
                    <strong>Sección: </strong> 0 ASUNTOS GENERALES <br>
                    <strong>Serie: </strong> 10 JURISPRUDENCIA <br>
                    <strong>Subserie: </strong> 1 LEYES FEDERALES Y DECRETOS DEL EJECUTIVO <br>
                    <br>
                    <strong>Descripción:</strong> <br> <p></p>
                    <h4><b>Leyes Federales Copia de diferentes disposiciones jurídicas publicadas en el Diario Oficial de la Federación</b></h4>
                    <br> <el-divider></el-divider>
                    <h3 class="el-icon-circle-plus"> <b>Información, Adicional </b></h3> <br>
                    <strong>Ubicación </strong> <br> <p></p>
                    <strong>Mueble: </strong>  <br>
                    <strong>Nivel: </strong>  <br>
                    <strong>Pasillo: </strong>  <br>
                    <strong>Caja: </strong> <br> <p></p>
                    <strong>Otros </strong> <br> <p></p>
                    <strong>Fecha cierre: </strong>  <br>
                    <strong>Fojas: </strong>  <br> <p></p>
                    <strong>Soporte: </strong>  <br>

                    <p></p> <el-divider></el-divider>
                    <span>
                        <strong>Archivos:</strong>
                        <ul class="fa-ul">
                            <li class="li-style">
                                <i class="fa-li fas fa-file"></i>
                                <span  style="cursor: pointer">
                                    <h4><b>Nombre de documentos adjunto 1</b></h4>
                                </span>
                            </li>
                            <li class="li-style">
                                <i class="fa-li fas fa-file"></i>
                                <span  style="cursor: pointer">
                                    <h4><b>Nombre de documentos adjunto 2</b></h4>
                                </span>
                            </li>
                            <li class="li-style">
                                <i class="fa-li fas fa-file"></i>
                                <span  style="cursor: pointer">
                                    <h4><b>Nombre de documentos adjunto 3</b></h4>
                                </span>
                            </li>
                        </ul>
                    </span>
                </el-card>
                <el-divider><i class="el-icon-files"></i></el-divider>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";

    export default {
        components: {
            HeaderSection
        },

        data() {
            return {
                documentUrl: null,
                transfer: false,
                apiToken: 'Bearer ' + sessionStorage.getItem('notice_token'),

                noticeAnswerForm: {
                    noticeId: this.$route.params.id,
                    title: '',
                    answer: '',
                    files: []
                },
                commentDialog: false,
                date: new Date(),
                notice: {
                    mission: {name: ''},
                    organism: {name: ''},
                    type: {name: ''},
                    user: {full_name: ''},
                    files: []
                },
                answer: '',
                tinyOptions: {
                    language_url: '/js/tiny_es_MX.js',
                    indent_use_margin: true,
                    forced_root_block_attrs: {
                        "style": "font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal"
                    },
                    content_css: '/css/word.css',
                    menubar: '',
                    statusbar: false,
                    branding: false,
                    min_height: 150,
                    browser_spellcheck: true,
                    font_formats: 'Montserrat=Montserrat;Soberana Sans=Soberana Sans;Arial=arial,helvetica,sans-serif;Times New Roman=Times New Roman, Times, serif;',
                    setup: function (ed) {
                        ed.settings.paste_postprocess = function (pl, o) {
                            ed.dom.setAttrib(ed.dom.select('li', o.node), 'style', 'font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal');
                            ed.dom.setAttrib(ed.dom.select('p', o.node), 'style', 'font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal');
                        }
                    },
                    paste_as_text: true,
                    paste_text_sticky: true,
                    paste_text_sticky_default: true,
                    toolbar1: 'bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  ',
                    toolbar2: "",
                    plugins: [
                        'paste'
                    ]
                },

                answers: [],
            }
        },

        created() {

        },

        watch: {
            $route(to, from) {
                this.getNotice();
            }
        },

        methods: {
            getNotice() {
                this.startLoading();

                axios.get(`/api/notices/${this.$route.params.id}`).then(response => {

                    this.notice = response.data.notice;
                    this.answers = response.data.notice.answers;

                    this.stopLoading();

                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            submitForm() {
                this.startLoading();

                this.$refs['noticeAnswerForm'].validate((valid) => {
                    if (valid) {

                        axios.post('/api/notices/send/answer', this.noticeAnswerForm).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se almaceno la información correctamente"
                            });

                            this.$router.push('/notices/multilaterales');
                        }).catch(error => {
                            this.stopLoading();

                            this.$message({
                                type: "warning",
                                message: "No fue posible completar la acción, intente nuevamente."
                            });
                        })
                    } else {
                        this.stopLoading();
                    }
                });
            },

            countViews(index) {
                if (index !== '') {
                    this.startLoading();

                    axios.post('/api/notices/send/answer/view', this.answers[index]).then(response => {
                        this.stopLoading();
                        this.getNotice();
                    }).catch(error => {
                        this.stopLoading();

                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    })
                }
            },

            beforeUploadFile(file) {

                if (file.size/1024/1024 > 6) {
                    this.$message.error('El archivo seleccionado excede el limite permitido');

                    return false;
                }

                if (file.type !== 'application/pdf' && file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png') {
                    this.$message.error('Tipo de Archivo no permitido');

                    return false;
                }

                return true;
            },

            uploadedFile(data){
                this.noticeAnswerForm.files.push(data.documentId);
            },

            removeFile(file){
                if( file.response !== undefined ) {
                    for( let i = this.noticeAnswerForm.files.length - 1; i >= 0; i--) {
                        if(this.noticeAnswerForm.files[i] === file.response.documentId) {
                            this.noticeAnswerForm.files.splice(i, 1);
                        }
                    }
                }
            },

            onError(err, file, fileList){
                this.$message({
                    type: 'warning',
                    message: 'No fue posible leer el archivo, inténtelo nuevamente.',
                });
            },

            downloadPdf(id, type) {

                this.transfer = true;
                let url = '';

                type === 1 ? url = 'notices' : url = 'answers';

                axios.get(`/api/${url}/get/file/${id}`, {responseType: 'blob'}).then(response => {
                        this.transfer = false;
                        let disposition = response.headers['content-disposition'];
                        var filename = '';
                        if (disposition && disposition.indexOf('inline') !== -1) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches != null && matches[1]) {
                                filename = matches[1].replace(/['"]/g, '');
                            }
                        }

                        let blob = new Blob([response.data]);
                        const linkUrl = window.URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = linkUrl;

                        link.setAttribute('download', filename);
                        document.body.appendChild(link);
                        link.click();
                    })
                    .catch(error => {
                        this.transfer = false;
                        console.log("error", error);
                    });

            },
        },
    }
</script>

<style scoped>

</style>
