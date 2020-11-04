
export const validateText = {
    data: function () {
        return {
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
        }
    }
};
