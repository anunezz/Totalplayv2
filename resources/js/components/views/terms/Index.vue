<template>
<div class="container animatedd fadeInn fastt">
    <div class="row">
        <el-tabs v-model="activeName">
            <el-tab-pane label="Términos y Condiciones Naional" name="first" class="animated fadeIn">
                <national-component ></national-component>
            </el-tab-pane>
            <el-tab-pane label="Términos y condiciones Frontera" name="second" class="animated fadeIn">
                <frontier-component ></frontier-component>
            </el-tab-pane>
        </el-tabs>
    </div>
</div>
</template>

<script>
import national from './National';
import frontier from './Frontier';
export default {
    components:{
        'national-component': national,
        'frontier-component': frontier
    },
    data(){
        return {
            activeName: 'second'
        }
    },
    mounted() {
        setTimeout(() => {
            this.$store._modules.root.state.totalplay.loading = false;
        }, 1000);
    },
}
</script>
