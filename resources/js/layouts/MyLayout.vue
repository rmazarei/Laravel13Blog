<script setup lang="ts">
import { Link } from "@inertiajs/vue3"
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();

const user = computed(() => page.props.auth.user);
</script>

<template>
    <main>
        <header class="flex flex-row-reverse justify-center gap-4 bg-gray-400 p-2">
            <Link href="/">صفحه اصلی</Link>
            <Link href="#">درباره</Link>
            <Link href="#">تماس</Link>
            <Link href="/posts" v-if="user">پست‌ها</Link>
            <Link href="/login" v-else>ورود</Link>
            <form class="flex flex-row-reverse gap-2 items-middle" method="get" action="/">
                <input type="text" name="query" class="border border-gray-300 rounded">
                <button type="submit">جستجو</button>
            </form>
        </header>
        <article class="p-5">
            <slot />
        </article>
    </main>
</template>

<style scoped>

</style>
