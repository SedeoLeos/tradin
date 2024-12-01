<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import Badge from '@/Components/Badge.vue'
import { Article } from '@/types'
import { onMounted, ref } from 'vue';

defineProps<{
    canLogin?: boolean
    canRegister?: boolean
}>()

const articleData = ref<Article>()

const fetchArticle = async (slug: string) => {
    try {
        const response = await fetch(`/api/articles/${slug}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })

        if (!response.ok) {
            throw new Error(`Error retrieving the article: ${response.status}`)
        }

        const data = await response.json()
        articleData.value = data.data  // Update the article with the fetched data
    } catch (err) {
        console.error('Error:', err)
    }
}

// Retrieve the slug from the URL and call fetchArticle on mount
onMounted(() => {
    const path = window.location.pathname  // Get the URL path
    const slug = path.split('/').pop()  // Extract the last segment of the URL

    if (slug) {
        fetchArticle(slug)  // Pass the slug to the fetchArticle function
    }
})
</script>

<template>

    <Head v-if="articleData" :title="articleData.title" />
    <div v-if="articleData" class="bg-gray-50 text-black/50">
        <div class="relative flex min-h-screen flex-col items-center">
            <div class="relative min-h-screen w-full flex flex-col">
                <Header :can-login="canLogin" :can-register="canRegister" />

                <main class="mt-6 max-w-screen-lg mx-auto gap-10">
                    <div class="flex justify-center flex-col max-w-screen-lg mx-auto gap-10">
                        <div>
                            <Link href="/" class="bg-black p-4 text-white">Back</Link>
                        </div>

                        <!-- Article Title -->
                        <h1 class="font-bold text-3xl" v-html="articleData.title"></h1>

                        <!-- Categories -->
                        <div class="min-w-[200px] flex gap-3">
                            <Badge v-for="category in articleData.categories" :key="category.id"
                            :class="{ ' border-blue-500 border': category.name === articleData.primaryCategory.name }"
                            >
                                {{ category.name }}
                            </Badge>
                        </div>

                        <!-- Article Content -->
                        <div v-html="articleData.content" class="flex flex-col gap-4 items-center"></div>

                        <!-- Tags Section -->
                        <div v-if="articleData.tags.length" class="mt-4">
                            <h3 class="font-bold text-lg">Tags:</h3>
                            <div class="flex gap-2 flex-wrap justify-start">
                                <span v-for="tag in articleData.tags" :key="tag.id" class="bg-blue-100 p-2 rounded text-nowrap">
                                    {{ tag.name }}
                                </span>
                            </div>
                        </div>

                        <!-- Media Section (Images) -->
                        <div v-if="articleData.media.length" class="mt-4">
                            <h3 class="font-bold text-lg">Media:</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                <div v-for="item in articleData.media" :key="item.id">
                                    <img :src="item.url" alt="Media" class="w-full h-auto rounded" />
                                </div>
                            </div>
                        </div>

                        <!-- Social Links Section -->
                        <div v-if="articleData.socialLinks.length" class="mt-4">
                            <h3 class="font-bold text-lg">Social Links:</h3>
                            <div class="flex gap-4 items-start justify-start flex-wrap">
                                <a v-for="social in articleData.socialLinks" :key="social.id" :href="social.link" target="_blank"
                                    class="text-blue-500">
                                    {{ social.platform }}
                                </a>
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-8 text-center text-sm text-black dark:text-white/70">
                    Tradin sur Test By Slaega
                </footer>
            </div>
        </div>
    </div>
</template>
