
export const Globals = {
    data: function () {
        return {
            alphanumeric: /^[A-Za-z0-9\.,\-\"\()ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/,
            email: /^(([^<>()\[\]\.,;:\s@\”]+(\.[^<>()\[\]\.,;:\s@\”]+)*)|(\”.+\”))@(([^<>()[\]\.,;:\s@\”]+\.)+[^<>()[\]\.,;:\s@\”]{2,})$/,
            phone: /^[0-9]{2}(-)[0-9]{4}(-)[0-9]{4}$/,
            zip_code:/([0-9]{5})/gi,
            //zip_code:/([0-9]{2})(-)([0-9]{4})(-)([0-9]{4})/gi,
            message: {
                ruleForm:{
                    required: 'Este campo es requerido.',
                    special_characters: 'Este campo no admite caracteres especiales.',
                    special_characters_email: 'Ingrese un correo eléctronico valido.',
                    max_characters:'Este campo solo adminite maximo',
                    max_characters_phone:'Este campo debe contener 10 numeros.',
                    submit_error: 'Revise los campos del formulario.',
                    find_contact_succes: 'Sus datos han sido enviados exitosamenrte.',
                    find_contact_fail: 'Este contacto ya fue registrado, intente con otro datos diferentes.',
                },
                axios:{
                    error: 'Error en la acción.'
                }
            },
            headers: { headers:
                    {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Accept-C': window.acceptC,
                        'Authorization': 'Bearer ' + sessionStorage.getItem('access_token')
                    }
            }
        }
    },
    methods:{
        validT(rule, value, callback){
            if (value){
                value = value.trim();
                let exp = new RegExp(/(<\\xml|<\/script|<\/|<\\script|<script|<xml|<\\|\?>|<\?xml|(<\?php|<\?|\?\>)|java|xss|htaccess)/,'igm');
                if (exp.test(value)) {
                    return callback(new Error('Formato incorrecto'));
                } else {
                    return callback();
                }
            }else {
                return callback();
            }
        },
        getCats(){
            axios.get('/api/getCats', this.headers ).then(response => {
                if(response.data.success){
                    this.$store._modules.root.state.totalplay.catCities = response.data.lResults;
                }
            }).catch(error => {
                console.error(error);
            });
        },
        setPacks(type = true){
            this.$store._modules.root.state.totalplay.loading = true;
            let selectCity = parseInt(localStorage.getItem('selectCity'));
            axios.post('/api/setPacks',{
                city: selectCity ? selectCity: 9,
                typePack: type
            },this.headers).then(response => {
                if(response.data.success){
                    this.$store._modules.root.state.totalplay.catHome = response.data.lResults.catHome;
                    this.$store._modules.root.state.totalplay.catAmazon = response.data.lResults.catAmazon;
                    this.$store._modules.root.state.totalplay.catNetflix = response.data.lResults.catNetflix;
                    setTimeout(() => {
                        this.$store._modules.root.state.totalplay.loading = false;
                    }, 1000);
                }
            }).catch(error => {
                setTimeout(() => {
                    this.$store._modules.root.state.totalplay.loading = false;
                }, 1000);
                console.error(error);
            });
        },
    }
};
