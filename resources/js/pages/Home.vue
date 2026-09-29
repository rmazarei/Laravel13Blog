<script setup>
import {Link} from"@inertiajs/vue3"
const props = defineProps({posts: Object})
const postsCollection = props.posts.data

</script>

<template>
    <div class="w-3/4 mx-auto">
        <h1 class="text-center text-xl">صفحه اصلی</h1>

        <div v-if="postsCollection.length > 0" v-for="post in postsCollection" class="border border-gray-200 rounded my-2 p-5">
            <h2 class="text-right text-blue-300">
                <Link :href="`/posts/${post.id}`">
                    {{ post.title }}
                </Link>
            </h2>
            <p class="text-justify text-right">{{ post.excerpt }}</p>
            <span class="text-sm text-gray-600">
                <bdi>{{ post.persian_date }}</bdi>
            </span>
        </div>
        <div v-else>
            <p class="text-center">پستی یافت نشد</p>
        </div>
    </div>
</template>

<style scoped>

</style>
