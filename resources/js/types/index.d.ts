import { Config } from 'ziggy-js'

export interface User {
    id: number
    name: string
    email: string
    email_verified_at?: string
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User
    }
    ziggy: Config & { location: string }
}
export interface Article {
    id: string
    title: string
    content: string
    slug: string
    categories: Category[]
    primaryCategory: Category
    tags: Tag[]
    media: Media[]
    socialLinks: SocialLink[]
}
export interface Category {
    id: string
    name: string
}
export interface Paginated<T> {
    data: T
    links: {
        first: string | null
        last: string | null
        prev: string | null
        next: string | null
    }
}

export interface Media {
    id: string
    type: string // Type of media (e.g., image, video)
    url: string // URL of the media
    slug: string // Slug of the media (for unique identification)
}

export interface Tag {
    id: string
    name: string // Name of the tag
    slug: string // Slug for the tag
}

export interface SocialLink {
    id: string
    platform: string // Name of the platform (e.g., Twitter, Facebook)
    link: string // Link to the social media post/page
}
