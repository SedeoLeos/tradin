import { defineStore } from 'pinia'
import { ref } from 'vue'
import { Article, Paginated } from '@/types'

export const useArticleStore = defineStore('article', () => {
  // Define a reactive state for articles
  const articlesData = ref<Paginated<Article[]>>()

  // Function to update the articles
  const setArticles = (data: Paginated<Article[]>) => {
    articlesData.value = data
  }

  return {
    articlesData,
    setArticles,
  }
})
