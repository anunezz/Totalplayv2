<template>
    <el-row class="custom-header" type="flex" justify="space-between">
        <el-col :span="8">
            <h3 class="custom-title">
                <i :class="'fas ' + icon"></i>
                {{ title }}
            </h3>
        </el-col>
        <el-col align="end" :span="18">
            <slot name="buttons"></slot>
        </el-col>
    </el-row>
</template>

<script>
    export default {
        props: ['icon','title']
    }
</script>

<style scoped>
    .custom-header {
        border-bottom: 1px solid #eaeefb;
        margin-bottom: 1em;
        padding-bottom: 0.5em;
    }
    .custom-title {
        margin: 0;
        padding-top: 0.25em;
    }
</style>
