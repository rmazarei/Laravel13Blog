<script setup>


const props = defineProps({post: Object})
const singlePost = props.post

</script>

<template>
    <h1 class="text-center text-xl">{{ post.title }}</h1>
    <div class="text-center text-sm text-gray-600">
        <bdi>{{ post.persian_date }}</bdi>
    </div>
    <img :src="`/storage/${post.cover}`" alt="" v-if="post.cover" class="w-[400px] h-auto p-3 mx-auto">
    <p class="text-justify text-right">
        {{ post.body}}
    </p>


</template>

<style scoped>

</style>
