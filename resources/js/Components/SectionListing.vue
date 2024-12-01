<template>
    <div v-if="articleStore.articlesData">
        <div class="grid grid-cols-3 gap-5 justify-center">
            <ArticleItem
                v-if="articleStore.articlesData"
                v-for="article in articleStore.articlesData.data"
                :key="article.id"
                :article="article"
            />
        </div>
        <div class="flex gap-2 justify-center mt-4">
            <button
                v-if="articleStore.articlesData.links.prev"
                @click="fetchPage(articleStore.articlesData.links.prev)"
                class="px-4 py-2 bg-gray-300 rounded"
            >
                Prev
            </button>

            <button
                v-if="articleStore.articlesData.links.next"
                @click="fetchPage(articleStore.articlesData.links.next)"
                class="px-4 py-2 bg-gray-300 rounded"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import ArticleItem from '@/Components/ArticleItem.vue'
import { useArticleStore } from '@/stores/articles'

const articleStore = useArticleStore()
const filters = defineModel<{
    search: string
    category: string
}>()

const fetchPage = async (url: string) => {
    try {
        // Envoyer une requête GET à l'URL spécifiée
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })

        if (!response.ok) {
            throw new Error(`Erreur lors de la récupération des articles : ${response.status}`)
        }

        const data = await response.json()
        articleStore.setArticles(data) // Supposons que l'API retourne les articles dans `data`
        console.log('Page chargée :')
    } catch (err) {
        console.error('Erreur :', err)
    }
}
</script>
