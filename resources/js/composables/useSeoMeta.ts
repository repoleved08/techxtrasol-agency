import { usePage } from '@inertiajs/vue3'
import { inject, onMounted } from 'vue'

interface SeoMetaOptions {
  title?: string
  description?: string
  keywords?: string
  structuredData?: Record<string, any>
  openGraph?: {
    title?: string
    description?: string
    image?: string
    url?: string
    type?: string
  }
}

export function useSeoMeta(options: SeoMetaOptions = {}) {
  const page = usePage()

  // Get the head manager if available (for Inertia)
  const head = inject('head', null)

  onMounted(() => {
    // Set page title
    if (options.title) {
      document.title = options.title
    }

    // Handle structured data
    if (options.structuredData) {
      // Remove any existing JSON-LD scripts
      const existingScripts = document.querySelectorAll('script[type="application/ld+json"]')
      existingScripts.forEach(script => script.remove())

      // Add new JSON-LD script
      const script = document.createElement('script')
      script.type = 'application/ld+json'
      script.textContent = JSON.stringify(options.structuredData)
      document.head.appendChild(script)
    }

    // Set meta description
    if (options.description) {
      let metaDescription = document.querySelector('meta[name="description"]')
      if (!metaDescription) {
        metaDescription = document.createElement('meta')
        metaDescription.setAttribute('name', 'description')
        document.head.appendChild(metaDescription)
      }
      metaDescription.setAttribute('content', options.description)
    }

    // Set meta keywords
    if (options.keywords) {
      let metaKeywords = document.querySelector('meta[name="keywords"]')
      if (!metaKeywords) {
        metaKeywords = document.createElement('meta')
        metaKeywords.setAttribute('name', 'keywords')
        document.head.appendChild(metaKeywords)
      }
      metaKeywords.setAttribute('content', options.keywords)
    }

    // Handle Open Graph tags
    if (options.openGraph) {
      const og = options.openGraph

      const ogTags = [
        { property: 'og:title', content: og.title || options.title },
        { property: 'og:description', content: og.description || options.description },
        { property: 'og:image', content: og.image },
        { property: 'og:url', content: og.url },
        { property: 'og:type', content: og.type || 'website' }
      ]

      ogTags.forEach(tag => {
        if (tag.content) {
          let metaTag = document.querySelector(`meta[property="${tag.property}"]`)
          if (!metaTag) {
            metaTag = document.createElement('meta')
            metaTag.setAttribute('property', tag.property)
            document.head.appendChild(metaTag)
          }
          metaTag.setAttribute('content', tag.content)
        }
      })
    }
  })
}
