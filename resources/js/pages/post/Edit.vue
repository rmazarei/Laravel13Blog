<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({post: Object})

const form = useForm({
    title: props.post.title,
    cover: null,
    body: props.post.body,
})

function submit(){
    form.put("/posts/" + props.post.id)
}
</script>

<template>
    <h1>به روز رسانی</h1>
    <form @submit.prevent="submit">
        <div class="flex flex-col">
            <label for="title">عنوان</label>
            <input type="text" v-model="form.title" id="title" class="border rounded p-2 border-gray-200" />
            <div v-if="form.errors.title" class="text-red-600">{{ form.errors.title }}</div>
        </div>
        <div class="flex flex-col">
            <label for="cover">تصویر</label>
            <small>در صورت نیاز به تغییر تصویر، فایل را انتخاب کنید</small>
            <input type="file" id="title" @input="form.cover = $event.target.files[0]" class="border rounded p-2 border-gray-200" />
            <div v-if="form.errors.cover" class="text-red-600">{{ form.errors.cover }}</div>
            <img :src="`/storage/${post.cover}`" alt="" v-if="post.cover" class="w-[200px] h-auto">
        </div>
        <div class="flex flex-col">
            <label for="body">متن</label>
            <textarea name="body" id="body" v-model="form.body" class="border rounded p-2 border-gray-200"></textarea>
            <div v-if="form.errors.body" class="text-red-600">{{ form.errors.body }}</div>
        </div>
        <div class="flex flex-col">
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}
            </progress>
            <button type="submit">به روز رسانی</button>
        </div>
    </form>
</template>

<style scoped>

</style>
