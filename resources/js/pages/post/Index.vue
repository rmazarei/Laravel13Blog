<script setup>
import { Link } from "@inertiajs/vue3"
import { SquarePen } from "@lucide/vue"
import Pagination from "@/components/Pagination.vue";
const props = defineProps({posts: Object})
</script>

<template>
    <h1 class="text-right">لیست پست‌ها</h1>
    <Link href="/posts/create" class="border rounded p-2 bg-blue-600 hover:bg-blue-400 flex my-4 w-[200px] justify-center ml-auto">
        پست جدید

        <SquarePen class="ml-3" />
    </Link>
    <table class="table table-auto border dir-rtl list-table">
        <thead>
            <tr>
                <td>ردیف</td>
                <td>عنوان</td>
                <td>تاریخ</td>
                <td>عملیات</td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="post in posts.data">
                <td>{{ post.id }}</td>
                <td>{{ post.title }}</td>
                <td>{{ post.persian_date }}</td>
                <td>
                    <Link :href="`/posts/${post.id}/edit`">
                    ویرایش
                    </Link>
                    |
                    <Link :href="`/posts/${post.id}`" method="delete" as="button" @click.prevent="confirm('آیا از حذف پست اطمینان دارید؟')">
                    حذف
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>
    <Pagination :links="posts.links" />
</template>

<style scoped>

</style>
