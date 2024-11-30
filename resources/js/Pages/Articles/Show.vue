<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import Badge from '@/Components/Badge.vue'
import { Article, Category, Media, SocialLink, Tag } from '@/types'

defineProps<{
    canLogin?: boolean
    canRegister?: boolean
    article: Article
    categories: Category[] // Pass categories
    tags: Tag[] // Pass tags
    media: Media[] // Pass media
    socialLinks: SocialLink[] // Pass socialLinks
}>()
</script>

<template>
    <Head :title="article.title" />
    <div class="bg-gray-50 text-black/50">
        <div class="relative flex min-h-screen flex-col items-center">
            <div class="relative min-h-screen w-full flex flex-col">
                <Header :can-login="canLogin" :can-register="canRegister" />

                <main class="mt-6 max-w-screen-lg mx-auto gap-10">
                    <div class="flex justify-center flex-col max-w-screen-lg mx-auto gap-10">
                        <div>
                            <Link href="/" class="bg-black p-4 text-white">Back</Link>
                        </div>

                        <!-- Article Title -->
                        <h1 class="font-bold text-3xl" v-html="article.title"></h1>

                        <!-- Categories -->
                        <div class="min-w-[200px] flex">
                            <Badge v-for="category in article.categories" :key="category.id">
                                {{ category.name }}
                            </Badge>
                        </div>

                        <!-- Article Content -->
                        <div
                            v-html="article.content"
                            class="flex flex-col gap-4 items-center"
                        ></div>

                        <!-- Tags Section -->
                        <div v-if="tags.length" class="mt-4">
                            <h3 class="font-bold text-lg">Tags:</h3>
                            <div class="flex gap-2 flex-wrap justify-start">
                                <span
                                    v-for="tag in tags"
                                    :key="tag.id"
                                    class="bg-blue-100 p-2 rounded text-nowrap"
                                >
                                    {{ tag.name }}
                                </span>
                            </div>
                        </div>

                        <!-- Media Section (Images) -->
                        <div v-if="media.length" class="mt-4">
                            <h3 class="font-bold text-lg">Media:</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                <div v-for="item in media" :key="item.id">
                                    <img
                                        :src="item.url"
                                        alt="Media"
                                        class="w-full h-auto rounded"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Social Links Section -->
                        <div v-if="socialLinks.length" class="mt-4">
                            <h3 class="font-bold text-lg">Social Links:</h3>
                            <div class="flex gap-4 items-start justify-start flex-wrap">
                                <a
                                    v-for="social in socialLinks"
                                    :key="social.id"
                                    :href="social.link"
                                    target="_blank"
                                    class="text-blue-500"
                                >
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
