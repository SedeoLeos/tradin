<script lang="ts" setup>
import Badge from '@/Components/Badge.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps<{
    article: any
}>()
</script>
<template>
    <div
        class="min-w-[330px] max-w-[330px] flex flex-col bg-white p-3 gap-4 shadow-sm hover:shadow-lg transition-all ease-in"
    >
        <Link
            class="font-semibold max-h-[calc(1.5rem*2)] overflow-hidden line-clamp-2"
            :href="route('article.show', { slug: article.slug })"
            v-html="article.title"
        ></Link>
        <div class="max-h-[calc(1.5rem*6)] overflow-hidden line-clamp-6">
            <div v-html="article.content"></div>
        </div>
        <div class="flex gap-3 flex-wrap">
            <Badge v-for="category in article.categories.slice(0, 3)" :key="category.id">{{
                category.name
            }}</Badge>
        </div>
    </div>
</template>
