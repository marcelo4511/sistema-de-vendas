<template>
    <div class="main contentcontainer-fluid">
    <router-view></router-view>
    <router-link to="/login" v-show="isMenuVisible"></router-link>
    </div>
</template>

<script>
import {mapState} from 'vuex'
export default {
    computed:mapState(['isMenuVisible'])

}
</script>

<style>
    .main {
        grid-area: main;
        background-color: #fff;
        padding: 20px;
        overflow:auto;
    }
</style>