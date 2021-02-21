<template>
<div>
    <promotions-component :items="objectItems" />
</div>
</template>

<script>
import Promotions from '../fragments/Promotions';
export default {
    components:{
        'promotions-component': Promotions,
    },
    computed:{
        objectItems(){
            return {
                page: 'amazon',
                img: {
                    triple: 'img/publico/promociones/amazon/title/Titulo_amazon_triple.svg',
                    double: 'img/publico/promociones/amazon/title/Titulo_amazon_double.svg'
                },
                catPromotion: this.$store._modules.root.state.totalplay.catAmazon
            };
        }
    },
    data() {
        return {
        }
    },
}
</script>
