import { ref } from 'vue'

import { Category, Paginated } from '@/types'
import { useArticleStore } from '@/stores/articles'

export function useArticles() {
    const articleStore = useArticleStore()
    const categoriesData = ref<Paginated<Category[]>>()
    const localFilters = ref<{ search: string; category: string }>({
        search: '',
        category: ''
    })

    const fetchArticles = async (url: string) => {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            })

            if (!response.ok) {
                throw new Error(`Error fetching articles: ${response.status}`)
            }

            const data = await response.json()
            articleStore.setArticles(data) // Updates the articles
        } catch (err) {
            console.error('Error:', err)
        }
    }

    const fetchCategories = async () => {
        try {
            const response = await fetch('/api/categories')

            if (!response.ok) {
                throw new Error(`Error fetching categories: ${response.status}`)
            }

            const data = await response.json()
            categoriesData.value = data
        } catch (err) {
            console.error('Error:', err)
        }
    }

    const search = async () => {
        const queryParams = new URLSearchParams(localFilters.value)
        const url = `/api/articles?${queryParams.toString()}`
        
        // Updates the URL without reloading the page
        window.history.pushState({}, '', `?${queryParams.toString()}`)
        
        await fetchArticles(url) // Uses the generic fetch function
    }

    const cleanFetch = async () => {
        // Resets the filters
        localFilters.value = { search: '', category: '' }
        
        // Cleans the URL
        window.history.pushState({}, '', window.location.pathname)

        await fetchArticles('/api/articles') // Uses the generic fetch function
    }

    const selectCategory = async (name: string) => {
        localFilters.value = {
            ...localFilters.value,
            ...(name && { category: name }), // Adds category if a name is provided
        }

        const queryParams = new URLSearchParams(localFilters.value)
        const url = `/api/articles?${queryParams.toString()}`
        
        window.history.pushState({}, '', `?${queryParams.toString()}`)

        await fetchArticles(url) // Uses the generic fetch function
    }

    return {
        categoriesData,
        localFilters,
        search,
        cleanFetch,
        selectCategory,
        fetchArticles,
        fetchCategories
    }
}
