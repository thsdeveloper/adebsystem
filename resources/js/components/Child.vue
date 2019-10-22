<template>
    <transition name="page" :enter-active-class="'animate '+this.animateIn">
        <slot>
            <router-view />
        </slot>
    </transition>
</template>

<script>
    export default {
        props:['animateIn'],
        name: 'Child'
    }
</script>
