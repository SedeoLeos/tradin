<template>
    <div>
        <div class="grid grid-cols-3 gap-5 justify-center">
            <ArticleItem
                v-for="article in articles.data"
                :key="article.id"
                :article="article"
            />
        </div>
        <div class="flex gap-2 justify-center mt-4">
            <button
                v-if="articles.prev_page_url"
                @click="fetchPage(articles.prev_page_url)"
                class="px-4 py-2 bg-gray-300 rounded"
            >
                Prev
            </button>

            <button
                v-if="articles.next_page_url"
                @click="fetchPage(articles.next_page_url)"
                class="px-4 py-2 bg-gray-300 rounded"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import ArticleItem from '@/Components/ArticleItem.vue'
import { Article, Paginated } from '@/types'
import { router } from '@inertiajs/vue3'
defineProps<{
    articles: Paginated<Article[]>
}>()
const filters = defineModel<{
    search: string
    category: string
}>()
const fetchPage = (url: string) => {
    router.get(url, filters.value, { preserveState: true })
}
</script>

<style scoped></style>
