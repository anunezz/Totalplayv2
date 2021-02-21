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
                page: 'netflix',
                img: {
                    triple: 'img/publico/promociones/netflix/title/Titulo_netflix_triple.svg',
                    double: 'img/publico/promociones/netflix/title/Titulo_netflix_double.svg'
                },
                catPromotion: this.$store._modules.root.state.totalplay.catNetflix
            };
        }
    },
    data() {
        return {
        }
    },
}
</script>
