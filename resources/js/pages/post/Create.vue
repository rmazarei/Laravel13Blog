<script setup>
import { useForm } from "@inertiajs/vue3";
const form = useForm({
    title: null,
    cover: null,
    body: null,
})

function submit(){
    form.post("/posts")
}
</script>

<template>
    <h1>پست جدید</h1>
    <form @submit.prevent="submit">
        <div class="flex flex-col">
            <label for="title">عنوان</label>
            <input type="text" v-model="form.title" id="title" class="border rounded p-2 border-gray-200" />
            <div v-if="form.errors.title" class="text-red-600">{{ form.errors.title }}</div>
        </div>
        <div class="flex flex-col">
            <label for="cover">تصویر</label>
            <input type="file" id="title" @input="form.cover = $event.target.files[0]" class="border rounded p-2 border-gray-200" />
            <div v-if="form.errors.cover" class="text-red-600">{{ form.errors.cover }}</div>
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
        <button type="submit">افزودن</button>
        </div>
    </form>
</template>

<style scoped>

</style>
