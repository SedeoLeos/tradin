<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import SectionListing from '@/Components/SectionListing.vue'
import TextInput from '@/Components/TextInput.vue'
import Header from '@/Components/Header.vue'
import { onMounted } from 'vue'

import { useArticles } from '@/Composables/useArticles'

const props = defineProps<{
    canLogin?: boolean
    canRegister?: boolean
}>()
const {
    categoriesData,
    localFilters,
    search,
    cleanFetch,
    selectCategory,
    fetchArticles,
    fetchCategories
} = useArticles()

onMounted(() => {
    fetchArticles('/api/articles')  // Fetch articles on mount
    fetchCategories()               // Fetch categories on mount
})
</script>

<template>

    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50">
        <div class="relative flex min-h-screen flex-col items-center">
            <div class="relative min-h-screen w-full flex flex-col">
                <Header :can-login="canLogin" :can-register="canRegister" />

                <main class="mt-6 flex p-5 flex-1">
                    <div class="min-w-[350px] flex flex-col max-w-[350px]">
                        <div>
                            <form @submit.prevent="search">
                                <TextInput v-model="localFilters.search" type="text"
                                    class="!rounded-none !outline-none !ring-0 border-none !border-b-2 !border-b-lime-950" />
                                <button class="bg-lime-950 py-2 text-white px-5">
                                    Search
                                </button>
                            </form>
                        </div>
                        <div class="flex flex-wrap gap-2 p-5">
                            <div v-if="categoriesData" v-for="category in categoriesData.data" :key="category.id"
                                class="bg-gray-500 text-[12px] min-w-[50px] text-center cursor-pointer text-white rounded-md p-2"
                                @click="selectCategory(category.name)">
                                {{ category.name }}
                            </div>
                            <div v-if="localFilters"
                                class="bg-red-500 text-[12px] min-w-[50px] text-center cursor-pointer text-white rounded-md p-2"
                                @click="cleanFetch()">
                                Clean
                            </div>
                        </div>
                    </div>
                    <SectionListing 
                        :v-model="localFilters" />
                </main>

                <footer class="py-8 text-center text-sm text-black dark:text-white/70">
                    Tradin sur Test By Slaega
                </footer>
            </div>
        </div>
    </div>
</template>
