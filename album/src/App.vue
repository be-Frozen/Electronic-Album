<template>
    <router-view></router-view>
</template>

<script>
import Storage from "@/tools/Storage";

export default {
    name: 'App',
    components: {},
    beforeCreate() {

    },
    mounted() {

    }
}
</script>

<style>
body {
    height: 100%;
    width: 100%;
    position: absolute;
    margin: 0;
    padding: 0;
    background-color: #f1f1f1;
}

.content-container {
    background-color: transparent;
    /*padding: 20px;*/
    /*margin: 20px;*/
    border-radius: 10px;
    min-width: 1200px;
    display: inline-block;
    width: 90%;
}

.input-tip {
    margin: 0 10px;
    line-height: 40px;
}

.input-field {
    margin-right: 40px;
}

.content-row {
    /*margin-bottom: 20px;*/
}

</style>
