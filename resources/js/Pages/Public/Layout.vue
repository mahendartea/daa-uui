<template>
    <Navbar></Navbar>
    <div>
        <slot></slot>
    </div>
</template>

<script setup>
import Navbar from './Components/Navbar.vue';
</script>
