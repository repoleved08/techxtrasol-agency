<template>

  <Head :title="post?.title ? `${post.title} | TechXtraSol Blog` : 'Blog Post'">
    <meta name="description" :content="post?.excerpt || ''" />
    <meta property="og:title" :content="post?.title || ''" />
    <meta property="og:description" :content="post?.excerpt || ''" />
    <meta property="og:image" :content="post?.image || ''" />
    <meta property="og:url" :content="`/agency/blog/${post?.slug || ''}`" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="TechXtraSol" />
    <meta property="article:published_time" :content="post?.published_at || ''" />
    <meta property="article:author" :content="post?.user?.name || ''" />
    <meta property="article:section" :content="post?.category?.name || ''" />
    <meta name="twitter:title" :content="post?.title || ''" />
    <meta name="twitter:description" :content="post?.excerpt || ''" />
    <meta name="twitter:image" :content="post?.image || ''" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@techxtrasol" />
  </Head>

  <PublicLayout>
    <!-- Reading Progress Bar -->
    <div class="fixed top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary/20 via-primary/10 to-primary/20 z-50"
      v-show="!isAtTop">
      <div class="h-full bg-gradient-to-r from-primary via-primary/80 to-primary transition-all duration-300 ease-out"
        :style="{ width: `${readingProgress}%` }"></div>
    </div>

    <div class="bg-background min-h-screen">
      <!-- Enhanced Hero Section with Parallax Effect -->
      <div class="relative h-[70vh] md:h-[80vh] lg:h-[90vh] overflow-hidden bg-black" v-if="post?.image">
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out" :style="{
          backgroundImage: `url(${post.image})`,
          transform: `scale(${1 + scrollY * 0.0005}) translateY(${scrollY * 0.3}px)`,
          filter: `blur(${Math.min(scrollY * 0.01, 3)}px)`
        }"></div>

        <!-- Multiple gradient overlays for better text readability -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/50 to-background"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>

        <div class="container relative z-10 h-full flex flex-col justify-end pb-16 px-4 mx-auto" v-motion
          :initial="{ opacity: 0, y: 20 }" :enter="{ opacity: 1, y: 0, transition: { duration: 800 } }">
          <Badge
            class="mb-4 bg-primary/90 hover:bg-primary text-primary-foreground border-none self-start backdrop-blur-sm"
            v-motion :initial="{ opacity: 0, scale: 0.8 }"
            :enter="{ opacity: 1, scale: 1, transition: { delay: 200, duration: 500 } }" v-if="post?.category?.name">
            {{ post.category.name }}
          </Badge>

          <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-6 max-w-4xl drop-shadow-lg" v-motion
            :initial="{ opacity: 0, y: 20 }" :enter="{ opacity: 1, y: 0, transition: { delay: 300, duration: 800 } }">
            {{ post?.title || 'Blog Post' }}
          </h1>

          <div
            class="flex flex-wrap items-center gap-4 text-white/90 backdrop-blur-sm bg-black/10 p-3 rounded-lg self-start"
            v-motion :initial="{ opacity: 0 }" :enter="{ opacity: 1, transition: { delay: 500, duration: 800 } }">
            <div class="flex items-center gap-3" v-if="post?.user">
              <Avatar class="h-10 w-10 border-2 border-primary/30 ring-2 ring-white/20">
                <AvatarImage :src="post.user.profile?.avatar || '/placeholder.svg?height=40&width=40'" />
                <AvatarFallback>{{ getInitials(post.user.name || '') }}</AvatarFallback>
              </Avatar>
              <div>
                <p class="font-medium text-white">{{ post.user.name || 'Author' }}</p>
                <p class="text-xs text-white/70">{{ post.user.profile?.role || '' }}</p>
              </div>
            </div>

            <div class="flex items-center gap-4 text-sm">
              <span class="flex items-center" v-if="post?.published_at">
                <CalendarIcon class="h-4 w-4 mr-1" />
                {{ formatDate(post.published_at) }}
              </span>
              <span class="flex items-center">
                <ClockIcon class="h-4 w-4 mr-1" />
                {{ readingTime }} min read
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="container px-4 mx-auto max-w-7xl">
        <!-- Breadcrumbs -->
        <div class="flex items-center text-sm text-muted-foreground my-6" v-motion :initial="{ opacity: 0 }"
          :enter="{ opacity: 1, transition: { duration: 600 } }">
          <Link href="/agency/blog" class="hover:text-primary transition-colors flex items-center">
          <BookOpenIcon class="h-4 w-4 mr-1" />
          Blog
          </Link>
          <ChevronRightIcon class="h-4 w-4 mx-2" />
          <Link :href="`/agency/blog?category=${post?.category?.slug || ''}`"
            class="hover:text-primary transition-colors" v-if="post?.category?.name">
          {{ post.category.name }}
          </Link>
          <ChevronRightIcon class="h-4 w-4 mx-2" v-if="post?.category?.name" />
          <span class="text-foreground truncate max-w-[200px]">{{ post?.title || 'Blog Post' }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pb-20">
          <!-- Floating Action Bar -->
          <div class="fixed left-0 top-1/2 -translate-y-1/2 z-40 hidden xl:flex flex-col items-center gap-3 ml-4"
            v-show="!isAtTop" v-motion :initial="{ opacity: 0, x: -20 }"
            :enter="{ opacity: 1, x: 0, transition: { delay: 800, duration: 500 } }">
            <TooltipProvider>
              <Tooltip v-for="action in floatingActions" :key="action.name">
                <TooltipTrigger asChild>
                  <Button size="icon" variant="outline"
                    class="h-10 w-10 rounded-full bg-background/80 backdrop-blur-sm border-border/50 hover:bg-primary/10 hover:border-primary/50 transition-all duration-300"
                    @click="action.action">
                    <component :is="action.icon" class="h-5 w-5" />
                    <span class="sr-only">{{ action.name }}</span>
                  </Button>
                </TooltipTrigger>
                <TooltipContent side="right">
                  <p>{{ action.name }}</p>
                </TooltipContent>
              </Tooltip>
            </TooltipProvider>
          </div>

          <!-- Mobile TOC Toggle Button (Fixed Position) -->
          <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <button v-show="!isAtTop && tableOfContents.length > 0 && !showMobileTOC" @click="toggleMobileTOC"
              class="fixed bottom-20 right-8 bg-primary text-primary-foreground rounded-full p-3 shadow-lg hover:bg-primary/90 transition-all z-50 hover:scale-110 lg:hidden"
              aria-label="Show Table of Contents">
              <ListIcon class="h-5 w-5" />
            </button>
          </Transition>

          <!-- Mobile TOC Panel -->
          <Transition enter-active-class="transition duration-500 ease-out"
            enter-from-class="opacity-0 translate-y-full" enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-300 ease-in" leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-full">
            <div v-if="showMobileTOC" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 lg:hidden flex flex-col"
              @click.self="toggleMobileTOC">
              <div class="mt-auto bg-background rounded-t-xl p-4 max-h-[70vh] overflow-auto">
                <div class="flex items-center justify-between mb-4">
                  <h3 class="text-lg font-bold flex items-center">
                    <ListIcon class="h-5 w-5 mr-2" />
                    Table of Contents
                  </h3>
                  <Button variant="ghost" size="icon" @click="toggleMobileTOC">
                    <XIcon class="h-5 w-5" />
                  </Button>
                </div>

                <div class="space-y-1 relative">
                  <!-- Reading Position Indicator -->
                  <div class="absolute left-2 w-0.5 h-full bg-muted-foreground/20 rounded-full">
                    <div class="absolute w-0.5 bg-primary rounded-full transition-all duration-300 ease-out"
                      :style="{ top: `${tocIndicatorPosition}px`, height: `${tocIndicatorHeight}px` }"></div>
                  </div>

                  <div v-for="(item, index) in tableOfContents" :key="index" class="transition-colors"
                    :ref="el => { if (el) tocItemRefs[index] = el }">
                    <a :href="`#${item.id}`"
                      class="block py-2.5 px-2 text-base rounded-md transition-all duration-300 hover:bg-muted" :class="[
                        activeHeading === item.id ? 'bg-primary/10 text-primary font-medium translate-x-1' : 'text-muted-foreground',
                        item.level === 2 ? 'pl-4' : item.level === 3 ? 'pl-6' : 'pl-8'
                      ]" @click="scrollToHeadingMobile(item.id)">
                      {{ item.text }}
                    </a>
                  </div>
                </div>

                <div class="mt-4 pt-4 border-t border-border">
                  <Button class="w-full" @click="toggleMobileTOC">
                    Continue Reading
                  </Button>
                </div>
              </div>
            </div>
          </Transition>

          <!-- Main Content Column -->
          <div class="lg:col-span-8">
            <!-- Main Post Content -->
            <article class="prose prose-lg max-w-none dark:prose-invert article-content" v-motion
              :initial="{ opacity: 0, y: 20 }" :enter="{ opacity: 1, y: 0, transition: { duration: 800, delay: 200 } }">
              <!-- Post Header (if no featured image) -->
              <header class="mb-12" v-if="!post?.image">
                <div class="flex items-center gap-2 mb-4">
                  <Badge variant="outline" class="bg-primary/10 text-primary border-primary/20"
                    v-if="post?.category?.name">
                    {{ post.category.name }}
                  </Badge>
                  <span class="text-sm text-muted-foreground flex items-center" v-if="post?.published_at">
                    <CalendarIcon class="h-4 w-4 mr-1" />
                    {{ formatDate(post.published_at) }}
                  </span>
                  <span class="text-sm text-muted-foreground flex items-center ml-2">
                    <ClockIcon class="h-4 w-4 mr-1" />
                    {{ readingTime }} min read
                  </span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold mb-6">{{ post?.title || 'Blog Post' }}</h1>

                <!-- Author Info -->
                <div class="flex items-center gap-4 mb-8" v-if="post?.user">
                  <Avatar class="h-12 w-12 border-2 border-primary/20">
                    <AvatarImage :src="post.user.profile?.avatar || '/placeholder.svg?height=48&width=48'" />
                    <AvatarFallback>{{ getInitials(post.user.name || '') }}</AvatarFallback>
                  </Avatar>
                  <div>
                    <p class="font-medium">{{ post.user.name || 'Author' }}</p>
                    <p class="text-sm text-muted-foreground" v-if="post.user.profile?.role">
                      {{ post.user.profile.role }}
                    </p>
                  </div>
                </div>
              </header>

              <!-- Post Body with Enhanced Styling -->
              <div ref="postContent" class="prose prose-neutral dark:prose-invert" :class="[
                `reading-mode-${readingMode}`,
                `line-height-${lineHeight}`
              ]" :style="{ fontSize: `${fontSize}%` }" v-html="processedContent"></div>

              <!-- Enhanced Share Buttons -->
              <div class="mt-8 mb-8 border-t border-border pt-8">
                <h3 class="text-lg font-medium mb-4 flex items-center">
                  <ShareIcon class="h-5 w-5 mr-2" />
                  Share this article
                </h3>

                <div class="bg-muted/30 rounded-xl p-6 border border-border/50">
                  <!-- Post Preview for Sharing -->
                  <div
                    class="flex flex-col sm:flex-row gap-4 mb-4 p-3 bg-background rounded-lg border border-border/50">
                    <div class="sm:w-1/3 aspect-video rounded-md overflow-hidden flex-shrink-0">
                      <img :src="post?.image || '/placeholder.svg?height=200&width=300'" :alt="post?.title || ''"
                        class="w-full h-full object-cover" />
                    </div>
                    <div class="flex-1">
                      <h4 class="font-medium text-base mb-1 line-clamp-2">{{ post?.title }}</h4>
                      <p class="text-sm text-muted-foreground line-clamp-2 mb-2">{{ post?.excerpt }}</p>
                      <div class="flex items-center text-xs text-muted-foreground">
                        <span>{{ window.location.origin }}/agency/blog/{{ post?.slug }}</span>
                      </div>
                    </div>
                  </div>

                  <!-- Social Share Buttons -->
                  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <Button v-for="social in socials" :key="social.name" variant="outline"
                      class="w-full flex items-center justify-center gap-2 h-11 hover:bg-primary/10 hover:border-primary/30 transition-all"
                      @click="shareContent(social.name)">
                      <component :is="social.icon" class="h-4 w-4" />
                      <span>{{ social.name }}</span>
                    </Button>
                  </div>

                  <!-- Copy Link Button -->
                  <div class="mt-4 flex items-center gap-2">
                    <Input :value="window.location.href" readonly class="flex-1 bg-background/80" />
                    <Button variant="outline" class="flex-shrink-0" @click="copyPageUrl">
                      <ClipboardIcon class="h-4 w-4 mr-2" />
                      Copy
                    </Button>
                  </div>
                </div>
              </div>

              <!-- Author Bio -->
              <div v-if="post?.user?.profile?.bio"
                class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-xl p-6 mb-8 border border-primary/10"
                v-motion :initial="{ opacity: 0, y: 20 }" :enter="{ opacity: 1, y: 0, transition: { duration: 600 } }"
                :visibleOnce="{ opacity: 1, y: 0 }">
                <div class="flex flex-col sm:flex-row items-start gap-6">
                  <Avatar class="h-20 w-20 border-2 border-primary/20 ring-4 ring-primary/10">
                    <AvatarImage :src="post.user.profile?.avatar || '/placeholder.svg?height=80&width=80'" />
                    <AvatarFallback>{{ getInitials(post.user.name || '') }}</AvatarFallback>
                  </Avatar>
                  <div>
                    <h3 class="font-bold text-xl mb-2">About {{ post.user.name }}</h3>
                    <p class="text-muted-foreground mb-4">{{ post.user.profile.bio }}</p>
                    <div class="flex gap-3">
                      <Button variant="outline" size="sm" class="rounded-full">
                        <UserIcon class="h-4 w-4 mr-2" />
                        View Profile
                      </Button>
                      <Button variant="outline" size="sm" class="rounded-full">
                        <MailIcon class="h-4 w-4 mr-2" />
                        Contact
                      </Button>
                    </div>
                  </div>
                </div>
              </div>
            </article>

            <!-- Comments Section with Animation -->
            <section class="mt-12 pt-8 border-t border-border" v-motion :initial="{ opacity: 0, y: 20 }"
              :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 200 } }"
              :visibleOnce="{ opacity: 1, y: 0 }">
              <h2 class="text-2xl font-bold mb-6 flex items-center">
                <MessageSquareIcon class="h-5 w-5 mr-2" />
                Join the Discussion
              </h2>


            </section>
            <!-- Comments trial-->
            <div class="comments-section mt-12" v-motion :initial="{ opacity: 0, y: 20 }"
              :enter="{ opacity: 1, y: 0, transition: { duration: 600 } }">
              <!-- Comments Header -->
              <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                  <MessageSquareIcon class="h-5 w-5 text-primary" />
                  <h2 class="text-xl font-bold">Comments</h2>
                  <Badge variant="outline" class="ml-2">{{ comments.length }}</Badge>
                </div>
                <Button variant="ghost" size="sm" class="text-muted-foreground hover:text-primary transition-colors"
                  @click="refreshComments">
                  <RefreshCwIcon class="h-4 w-4 mr-1" />
                  Refresh
                </Button>
              </div>

              <!-- Comments List -->
              <div v-if="comments.length" class="space-y-4">
                <div v-for="(comment, index) in comments" :key="comment.id" v-motion :initial="{ opacity: 0, x: -20 }"
                  :enter="{ opacity: 1, x: 0, transition: { duration: 400, delay: 100 + (index * 50) } }">
                  <Card class="border-border/40 hover:border-primary/20 transition-all duration-300">
                    <CardContent class="p-4">
                      <div class="flex gap-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                          <Avatar class="h-10 w-10 ring-2 ring-background shadow-sm">
                            <AvatarImage v-if="comment.user.avatar" :src="comment.user.avatar"
                              :alt="comment.user.name" />
                            <AvatarFallback class="bg-primary/10 text-primary font-medium">
                              {{ getInitials(comment.user.name) }}
                            </AvatarFallback>
                          </Avatar>
                        </div>

                        <!-- Comment Content -->
                        <div class="flex-1 space-y-1.5">
                          <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                              <p class="font-semibold text-sm">{{ comment.user.name }}</p>
                              <Badge v-if="comment.user.id === post.user_id" variant="secondary"
                                class="text-xs font-normal">
                                Author
                              </Badge>
                            </div>
                            <p class="text-xs text-muted-foreground">{{ comment.created_at }}</p>
                          </div>
                          <div class="text-sm text-foreground mt-1">{{ comment.body }}</div>

                          <!-- Comment Actions -->
                          <div class="flex items-center justify-between pt-2">
                            <div class="flex items-center gap-4">
                              <button
                                class="text-xs text-muted-foreground hover:text-primary flex items-center gap-1 transition-colors">
                                <ThumbsUpIcon class="h-3.5 w-3.5" />
                                <span>Like</span>
                              </button>
                              <button
                                class="text-xs text-muted-foreground hover:text-primary flex items-center gap-1 transition-colors">
                                <ReplyIcon class="h-3.5 w-3.5" />
                                <span>Reply</span>
                              </button>
                            </div>

                            <!-- Delete Button - Only shown if current user owns the comment -->
                            <div v-if="auth && auth.user && comment.user.id === auth.user.id"
                            >
                              <Popover>
                                <PopoverTrigger as-child>
                                  <Button variant="ghost" size="sm"
                                    class="text-muted-foreground hover:text-destructive transition-colors h-7 px-2">
                                    <TrashIcon class="h-3.5 w-3.5" />
                                  </Button>
                                </PopoverTrigger>
                                <PopoverContent class="w-60 p-0" side="top">
                                  <div class="p-4 pb-2">
                                    <div class="flex items-center gap-2 mb-2">
                                      <AlertTriangleIcon class="h-4 w-4 text-destructive" />
                                      <h4 class="font-medium text-sm">Delete Comment</h4>
                                    </div>
                                    <p class="text-xs text-muted-foreground">
                                      Are you sure you want to delete this comment? This action cannot be undone.
                                    </p>
                                  </div>
                                  <div class="border-t border-border p-2 flex justify-end gap-2">

                                    <Button variant="destructive" size="sm" @click="deleteComment(comment.id)"
                                      class="group">
                                      <TrashIcon class="h-3.5 w-3.5 mr-1 group-hover:animate-shake" />
                                      Delete
                                    </Button>
                                  </div>
                                </PopoverContent>
                              </Popover>
                            </div>
                          </div>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                </div>
              </div>

              <!-- Empty State -->
              <div v-else class="text-center py-12 border border-dashed border-border rounded-lg" v-motion
                :initial="{ opacity: 0, scale: 0.9 }"
                :enter="{ opacity: 1, scale: 1, transition: { type: 'spring', stiffness: 300, damping: 25 } }">
                <div class="inline-flex p-3 rounded-full bg-primary/10 mb-3">
                  <MessageSquareIcon class="h-6 w-6 text-primary" />
                </div>
                <h3 class="text-lg font-medium mb-1">No comments yet</h3>
                <p class="text-sm text-muted-foreground">Be the first to share your thoughts!</p>
              </div>

              <!-- New Comment Form -->
              <div class="mt-8" v-motion :initial="{ opacity: 0, y: 20 }"
                :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 300 } }">
                <Card class="border-border/40 overflow-hidden">
                  <CardHeader class="pb-3">
                    <CardTitle class="text-lg">Add a comment</CardTitle>
                    <CardDescription>Share your thoughts about this post</CardDescription>
                  </CardHeader>
                  <CardContent>
                    <form @submit.prevent="postComment" class="space-y-4">
                      <div class="space-y-2">
                        <Textarea v-model="form.body" placeholder="Write your comment here..."
                          :class="{ 'border-red-500 focus-visible:ring-red-500': form.errors.body }" rows="3" />
                        <p v-if="form.errors.body" class="text-red-500 text-xs mt-1">{{ form.errors.body }}</p>
                      </div>
                      <div class="flex justify-end">
                        <Button type="submit" :disabled="form.processing" class="relative overflow-hidden group">
                          <span v-if="!form.processing" class="flex items-center">
                            Post Comment
                            <SendIcon
                              class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
                          </span>
                          <span v-else class="flex items-center">
                            <LoaderIcon class="mr-2 h-4 w-4 animate-spin" />
                            Posting...
                          </span>
                          <span
                            class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </Button>
                      </div>
                    </form>
                  </CardContent>
                </Card>
              </div>
            </div>

          </div>

          <!-- Sidebar Column -->
          <div class="lg:col-span-4">
            <div class="lg:sticky lg:top-24 space-y-8" v-motion :initial="{ opacity: 0, x: 20 }"
              :enter="{ opacity: 1, x: 0, transition: { duration: 800, delay: 400 } }">
              <!-- Enhanced Table of Contents with Animation -->
              <Card class="overflow-hidden border-border/40 shadow-sm hover:shadow-md transition-shadow duration-300"
                v-if="tableOfContents.length > 0">
                <CardHeader class="bg-gradient-to-r from-primary/5 to-primary/10 pb-3">
                  <CardTitle class="text-lg flex items-center justify-between">
                    <span class="flex items-center">
                      <ListIcon class="h-5 w-5 mr-2" />
                      Table of Contents
                    </span>
                    <Button variant="ghost" size="sm" class="h-8 w-8 p-0 rounded-full"
                      :class="{ 'rotate-180': tocCollapsed }" @click="toggleTOC">
                      <ChevronUpIcon class="h-5 w-5 transition-transform duration-300" />
                    </Button>
                  </CardTitle>
                </CardHeader>

                <Transition enter-active-class="transition-all duration-300 ease-out"
                  enter-from-class="max-h-0 opacity-0" enter-to-class="max-h-[500px] opacity-100"
                  leave-active-class="transition-all duration-200 ease-in" leave-from-class="max-h-[500px] opacity-100"
                  leave-to-class="max-h-0 opacity-0">
                  <CardContent class="pt-4 relative overflow-hidden" v-show="!tocCollapsed">
                    <!-- Reading Position Indicator -->
                    <div class="absolute left-2 w-0.5 bg-muted-foreground/20 rounded-full"
                      :style="{ height: tocHeight + 'px' }">
                      <div class="absolute w-0.5 bg-primary rounded-full transition-all duration-300 ease-out"
                        :style="{ top: `${tocIndicatorPosition}px`, height: `${tocIndicatorHeight}px` }"></div>
                    </div>

                    <div class="space-y-1">
                      <div v-for="(item, index) in tableOfContents" :key="index" class="transition-colors"
                        :ref="el => { if (el) tocItemRefs[index] = el }">
                        <a :href="`#${item.id}`"
                          class="block py-1.5 px-2 text-sm rounded-md transition-all duration-300 hover:bg-muted"
                          :class="[
                            activeHeading === item.id ? 'bg-primary/10 text-primary font-medium translate-x-1' : 'text-muted-foreground',
                            item.level === 2 ? 'pl-4' : item.level === 3 ? 'pl-6' : 'pl-8'
                          ]" @click.prevent="scrollToHeading(item.id)">
                          {{ item.text }}
                        </a>
                      </div>
                    </div>
                  </CardContent>
                </Transition>
              </Card>

              <!-- Reading Mode Controls -->
              <Card class="overflow-hidden border-border/40 shadow-sm">
                <CardHeader class="bg-gradient-to-r from-primary/5 to-primary/10 pb-3">
                  <CardTitle class="text-lg flex items-center">
                    <BookOpenIcon class="h-5 w-5 mr-2" />
                    Reading Experience
                  </CardTitle>
                </CardHeader>
                <CardContent class="pt-4">
                  <div class="space-y-4">
                    <div>
                      <label class="text-sm font-medium mb-1.5 block">Font Size</label>
                      <div class="flex items-center gap-3">
                        <Button variant="outline" size="icon" class="h-8 w-8" @click="decreaseFontSize">
                          <Minus class="h-4 w-4" />
                        </Button>
                        <div class="flex-1 h-2 bg-muted rounded-full relative">
                          <div class="absolute h-2 bg-primary rounded-full"
                            :style="{ width: `${(fontSize - 80) / 40 * 100}%` }"></div>
                          <div class="absolute w-4 h-4 bg-primary rounded-full -mt-1 -ml-2 cursor-pointer"
                            :style="{ left: `${(fontSize - 80) / 40 * 100}%` }" @mousedown="startDragging"></div>
                        </div>
                        <Button variant="outline" size="icon" class="h-8 w-8" @click="increaseFontSize">
                          <Plus class="h-4 w-4" />
                        </Button>
                      </div>
                    </div>

                    <div>
                      <label class="text-sm font-medium mb-1.5 block">Reading Mode</label>
                      <div class="grid grid-cols-3 gap-2">
                        <Button variant="outline" size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': readingMode === 'default' }"
                          @click="setReadingMode('default')">
                          Default
                        </Button>
                        <Button variant="outline" size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': readingMode === 'sepia' }"
                          @click="setReadingMode('sepia')">
                          Sepia
                        </Button>
                        <Button variant="outline" size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': readingMode === 'focus' }"
                          @click="setReadingMode('focus')">
                          Focus
                        </Button>
                      </div>
                    </div>

                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium">Line Spacing</span>
                      <div class="flex items-center gap-2">
                        <Button variant="outline" size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': lineHeight === 'normal' }"
                          @click="setLineHeight('normal')">
                          Normal
                        </Button>
                        <Button variant="outline" size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': lineHeight === 'relaxed' }"
                          @click="setLineHeight('relaxed')">
                          Relaxed
                        </Button>
                      </div>
                    </div>

                    <Separator />

                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium flex items-center">
                        <BookmarkIcon class="h-4 w-4 mr-1.5" />
                        Save for later
                      </span>
                      <Switch v-model="bookmarked" />
                    </div>

                    <Button class="w-full" variant="outline" @click="printArticle">
                      <PrinterIcon class="h-4 w-4 mr-2" />
                      Print Article
                    </Button>
                  </div>
                </CardContent>
              </Card>

              <!-- Newsletter Signup with Animation -->
              <Card
                class="overflow-hidden border-border/40 shadow-sm bg-gradient-to-br from-primary/5 via-background to-primary/5"
                v-motion :initial="{ opacity: 0, scale: 0.95 }"
                :enter="{ opacity: 1, scale: 1, transition: { duration: 600, delay: 600 } }"
                :visibleOnce="{ opacity: 1, scale: 1 }">
                <CardHeader class="pb-3">
                  <CardTitle class="text-lg flex items-center">
                    <MailIcon class="h-5 w-5 mr-2" />
                    Get Updates
                  </CardTitle>
                </CardHeader>
                <CardContent class="pt-4">
                  <div class="relative mb-6 w-16 h-16 mx-auto">
                    <div class="absolute inset-0 bg-primary/10 rounded-full animate-ping opacity-70"></div>
                    <div class="relative flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full">
                      <MailIcon class="h-8 w-8 text-primary" />
                    </div>
                  </div>

                  <p class="text-sm text-center text-muted-foreground mb-4">
                    Stay updated with our latest articles and insights
                  </p>
                  <form @submit.prevent="subscribeToNewsletter" class="space-y-3">
                    <Input type="email" placeholder="Enter your email" v-model="newsletterEmail" required
                      class="bg-background/80" />
                    <Button type="submit"
                      class="w-full bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary">
                      Subscribe
                      <SendIcon class="ml-2 h-4 w-4" />
                    </Button>
                  </form>
                </CardContent>
              </Card>

              <!-- Related Posts Sidebar with Hover Effects -->
              <Card class="overflow-hidden border-border/40 shadow-sm" v-if="relatedPosts?.length > 0">
                <CardHeader class="bg-gradient-to-r from-primary/5 to-primary/10 pb-3">
                  <CardTitle class="text-lg flex items-center">
                    <BookmarkIcon class="h-5 w-5 mr-2" />
                    Related Articles
                  </CardTitle>
                </CardHeader>
                <CardContent class="pt-4 p-0">
                  <div class="divide-y divide-border">
                    <div v-for="(relatedPost, index) in relatedPosts.slice(0, 3)" :key="relatedPost.id"
                      class="p-4 hover:bg-muted/30 transition-all duration-300 group cursor-pointer" v-motion
                      :initial="{ opacity: 0, y: 10 }"
                      :enter="{ opacity: 1, y: 0, transition: { duration: 400, delay: 200 + (index * 100) } }"
                      :visibleOnce="{ opacity: 1, y: 0 }" @click="navigateToPost(relatedPost.slug)">
                      <div class="flex gap-3">
                        <div class="flex-shrink-0 w-20 h-20 rounded-md overflow-hidden">
                          <img :src="relatedPost.image || '/placeholder.svg?height=80&width=80'"
                            :alt="relatedPost.title"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                        </div>
                        <div class="flex-1 min-w-0">
                          <p class="text-xs text-muted-foreground mb-1 flex items-center">
                            <CalendarIcon class="h-3 w-3 mr-1" />
                            {{ formatDate(relatedPost.published_at) }}
                          </p>
                          <h4 class="font-medium text-sm mb-1 line-clamp-2 group-hover:text-primary transition-colors">
                            {{ relatedPost.title }}
                          </h4>
                          <p class="text-xs text-muted-foreground line-clamp-1">
                            {{ relatedPost.excerpt }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="p-3 text-center">
                    <Link href="/agency/blog" class="text-primary text-sm hover:underline inline-flex items-center">
                    View All Articles
                    <ArrowRightIcon class="ml-1 h-3 w-3" />
                    </Link>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>

        <!-- Related Posts Full Width with Card Hover Effects -->
        <section v-if="relatedPosts?.length > 0" class="mt-16 pt-8 border-t border-border" v-motion
          :initial="{ opacity: 0, y: 20 }" :enter="{ opacity: 1, y: 0, transition: { duration: 800 } }"
          :visibleOnce="{ opacity: 1, y: 0 }">
          <h2 class="text-2xl font-bold mb-8 flex items-center">
            <BookmarkIcon class="h-5 w-5 mr-2" />
            You might also like
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div v-for="(relatedPost, index) in relatedPosts" :key="relatedPost.id" class="group cursor-pointer"
              v-motion :initial="{ opacity: 0, y: 20 }"
              :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 200 + (index * 150) } }"
              :visibleOnce="{ opacity: 1, y: 0 }" @click="navigateToPost(relatedPost.slug)">
              <Card
                class="h-full overflow-hidden border-border/40 hover:border-primary/30 transition-all duration-300 hover:shadow-lg hover:shadow-primary/10 hover:-translate-y-1">
                <div class="relative aspect-video overflow-hidden">
                  <img :src="relatedPost.image || '/placeholder.svg?height=300&width=500'" :alt="relatedPost.title"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                  <div
                    class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  </div>
                  <div class="absolute top-2 right-2">
                    <Badge variant="outline" class="bg-black/50 text-white border-0">
                      {{ relatedPost.category?.name }}
                    </Badge>
                  </div>
                </div>
                <CardContent class="p-5">
                  <p class="text-sm text-muted-foreground mb-2 flex items-center">
                    <CalendarIcon class="h-3 w-3 mr-1" />
                    {{ formatDate(relatedPost.published_at) }}
                  </p>
                  <h3
                    class="font-bold text-lg mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-300">
                    {{ relatedPost.title }}
                  </h3>
                  <p class="text-muted-foreground text-sm mb-4 line-clamp-2">
                    {{ relatedPost.excerpt }}
                  </p>
                  <div class="flex items-center justify-between">
                    <div class="flex items-center">
                      <Avatar class="h-6 w-6 mr-2">
                        <AvatarImage
                          :src="relatedPost.user?.profile?.avatar || '/placeholder.svg?height=24&width=24'" />
                        <AvatarFallback>{{ getInitials(relatedPost.user?.name || '') }}</AvatarFallback>
                      </Avatar>
                      <span class="text-xs text-muted-foreground">{{ relatedPost.user?.name || 'Author' }}</span>
                    </div>
                    <div
                      class="text-sm text-primary font-medium flex items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                      Read more
                      <ArrowRightIcon
                        class="ml-1 h-3 w-3 transition-transform duration-300 group-hover:translate-x-1" />
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </section>

        <!-- Newsletter Subscription with Animation -->
        <Newsletter class="mt-16 mb-16" v-motion :initial="{ opacity: 0, y: 30 }"
          :enter="{ opacity: 1, y: 0, transition: { duration: 800 } }" :visibleOnce="{ opacity: 1, y: 0 }" />

        <!-- Back to Top Button with Animation -->
        <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-200 ease-in"
          leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
          <button v-show="!isAtTop" @click="scrollToTop"
            class="fixed bottom-8 right-8 bg-primary text-primary-foreground rounded-full p-3 shadow-lg hover:bg-primary/90 transition-all z-50 hover:scale-110"
            aria-label="Back to top">
            <ArrowUpIcon class="h-5 w-5" />
          </button>
        </Transition>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
// import inertia
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/vue3';
import Newsletter from '../Company/Newsletter.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue';
import { useMotion } from '@vueuse/motion';
import { usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3';

import {
  BookOpenIcon,
  ChevronRightIcon,
  ChevronUpIcon,
  ArrowRightIcon,
  TwitterIcon,
  ThumbsUpIcon,
  ReplyIcon,
  TrashIcon,
  AlertTriangleIcon,
  RefreshCwIcon,
  LoaderIcon,
  FacebookIcon,
  LinkedinIcon,
  Link2Icon,
  CalendarIcon,
  ClockIcon,
  UserIcon,
  MailIcon,
  BookmarkIcon,
  ListIcon,
  MessageSquareIcon,
  ArrowUpIcon,
  SendIcon,
  ShareIcon,
  HeartIcon,
  PrinterIcon,
  Minus,
  Plus,
  XIcon,
  ClipboardIcon
} from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { toast, Toaster } from 'vue-sonner';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Separator } from '@/components/ui/separator';
import { Switch } from '@/components/ui/switch';
import { Tooltip, TooltipContent, TooltipTrigger, TooltipProvider } from '@/components/ui/tooltip';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,

} from '@/components/ui/popover';

// Get data from Inertia props
const page = usePage();
const post = computed(() => page.props.post || {});
const relatedPosts = computed(() => page.props.relatedPosts || []);

// Table of contents state
const tableOfContents = ref([]);
const activeHeading = ref('');
const postContent = ref(null);
const tocItemRefs = ref([]);
const tocHeight = ref(0);
const tocIndicatorPosition = ref(0);
const tocIndicatorHeight = ref(0);
const tocCollapsed = ref(false);
const showMobileTOC = ref(false);

// Reading progress state
const readingProgress = ref(0);
const isAtTop = ref(true);
const scrollY = ref(0);

// Newsletter state
const newsletterEmail = ref('');

// Comment state
const commentText = ref('');

// Reading preferences
const fontSize = ref(100);
const readingMode = ref('default');
const lineHeight = ref('normal');
const bookmarked = ref(false);

// Slider dragging state
const isDragging = ref(false);

// Window object for sharing
const window = typeof globalThis !== 'undefined' ? globalThis : { location: { href: '', origin: '' } };

// comments
const props = defineProps({
  post: Object,
  comments: {
    type: Array,
    default: () => [],
  },
  auth: Object,
})

const fallbackAvatar = '/default-avatar.png'

const comments = ref([...props.comments]) // local state

const form = useForm({
  post_id: props.post.id,
  body: '',
})

const postComment = () => {
  form.post('/comments', {
    preserveScroll: true,
    onSuccess: (page) => {
      form.reset('body')

      // If server returns latest comment(s), merge or push accordingly
      if (page.props.comments?.length) {
        comments.value.push(...page.props.comments)
      }
    },
  })
}

// Modified delete comment function - replace confirm() with popover
const deleteComment = (commentId) => {
  Inertia.delete(`/comments/${commentId}`, {
    preserveScroll: true,
    onSuccess: () => {
      comments.value = comments.value.filter(c => c.id !== commentId)
    }
  })
}

// log auth user



const refreshComments = () => {
  Inertia.reload({ only: ['comments'] })
}




// Floating action buttons
const floatingActions = computed(() => [
  {
    name: 'Share',
    icon: ShareIcon,
    action: () => {
      if (navigator.share) {
        navigator.share({
          title: post.value?.title,
          text: post.value?.excerpt || 'Check out this article',
          url: window.location.href,
        });
      } else {
        // Fallback
        copyPageUrl();
      }
    }
  },
  {
    name: 'Like',
    icon: HeartIcon,
    action: () => {
      // Implement like functionality

      toast.success('Thank you for liking this article!');

    }
  },
  {
    name: 'Print',
    icon: PrinterIcon,
    action: () => {
      printArticle();
    }
  },
  {
    name: 'Scroll to Top',
    icon: ArrowUpIcon,
    action: scrollToTop
  }
]);

// Process content to add syntax highlighting and extract headings for TOC
const processedContent = computed(() => {
  if (!post.value?.body) return '';

  // Create a temporary div to manipulate the HTML
  const tempDiv = document.createElement('div');
  tempDiv.innerHTML = post.value.body;

  // Add IDs to headings for table of contents
  const headings = tempDiv.querySelectorAll('h2, h3, h4, h5, h6');
  headings.forEach((heading, index) => {
    const id = `heading-${index}`;
    heading.id = id;

    // Add anchor link
    const anchor = document.createElement('a');
    anchor.className = 'heading-anchor';
    anchor.href = `#${id}`;
    anchor.innerHTML = '<svg class="h-4 w-4" viewBox="0 0 16 16" fill="currentColor"><path fill-rule="evenodd" d="M7.775 3.275a.75.75 0 001.06 1.06l1.25-1.25a2 2 0 112.83 2.83l-2.5 2.5a2 2 0 01-2.83 0 .75.75 0 00-1.06 1.06 3.5 3.5 0 004.95 0l2.5-2.5a3.5 3.5 0 00-4.95-4.95l-1.25 1.25zm-4.69 9.64a2 2 0 010-2.83l2.5-2.5a2 2 0 012.83 0 .75.75 0 001.06-1.06 3.5 3.5 0 00-4.95 0l-2.5 2.5a3.5 3.5 0 004.95 4.95l1.25-1.25a.75.75 0 00-1.06-1.06l-1.25 1.25a2 2 0 01-2.83 0z"></path></svg>';
    heading.appendChild(anchor);
  });

  // Enhance images with lightbox capability
  const images = tempDiv.querySelectorAll('img:not([class*="avatar"])');
  images.forEach(img => {
    // Skip small icons and avatars
    if (img.width < 100 || img.height < 100) return;

    const wrapper = document.createElement('div');
    wrapper.className = 'image-wrapper';
    img.parentNode.insertBefore(wrapper, img);
    wrapper.appendChild(img);

    const caption = document.createElement('div');
    caption.className = 'image-caption';
    caption.textContent = img.alt || 'Image';
    wrapper.appendChild(caption);

    img.setAttribute('data-lightbox', 'true');
  });

  return tempDiv.innerHTML;
});

// Calculate reading time based on word count
const readingTime = computed(() => {
  if (!post.value?.body) return 0;

  // Strip HTML tags and count words
  const text = post.value.body.replace(/<[^>]*>/g, '');
  const words = text.split(/\s+/).length;

  // Average reading speed: 200 words per minute
  return Math.ceil(words / 200);
});

// Format date helper
const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  }).format(date);
};

// Get initials helper
const getInitials = (name) => {
  if (!name) return '?';
  return name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2);
};

// Social sharing options
const socials = [
  { name: 'Twitter', icon: TwitterIcon, tooltip: 'Share on Twitter' },
  { name: 'Facebook', icon: FacebookIcon, tooltip: 'Share on Facebook' },
  { name: 'LinkedIn', icon: LinkedinIcon, tooltip: 'Share on LinkedIn' },
  { name: 'WhatsApp', icon: Link2Icon, tooltip: 'Share on WhatsApp' }
];

// Share content based on platform
const shareContent = (platform) => {
  const url = window.location.href;
  const title = post.value?.title || '';
  const text = post.value?.excerpt || '';

  switch (platform) {
    case 'Twitter':
      window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`, '_blank');
      break;
    case 'Facebook':
      window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
      break;
    case 'LinkedIn':
      window.open(`https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}&summary=${encodeURIComponent(text)}`, '_blank');
      break;
    case 'WhatsApp':
      window.open(`https://wa.me/?text=${encodeURIComponent(title + ' - ' + url)}`, '_blank');
      break;
    default:
      break;
  }
};

// Copy page URL to clipboard
const copyPageUrl = () => {
  navigator.clipboard.writeText(window.location.href);
  toast.success('Page URL copied to clipboard!');
};

// Toggle TOC collapse state
const toggleTOC = () => {
  tocCollapsed.value = !tocCollapsed.value;
};

// Toggle mobile TOC
const toggleMobileTOC = () => {
  showMobileTOC.value = !showMobileTOC.value;
};

// Extract headings for table of contents
const extractTableOfContents = () => {
  if (!postContent.value) return;

  const headings = postContent.value.querySelectorAll('h2, h3, h4, h5, h6');
  const toc = [];

  headings.forEach((heading) => {
    toc.push({
      id: heading.id,
      text: heading.textContent.replace(/§$/, '').replace(/<[^>]*>/g, ''), // Remove section symbol and HTML tags
      level: parseInt(heading.tagName.substring(1))
    });
  });

  tableOfContents.value = toc;
};

// Scroll to heading when TOC item is clicked
const scrollToHeading = (id) => {
  const element = document.getElementById(id);
  if (element) {
    const yOffset = -100; // Offset to account for fixed header
    const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
    window.scrollTo({ top: y, behavior: 'smooth' });
  }
};

// Scroll to heading from mobile TOC and close the TOC
const scrollToHeadingMobile = (id) => {
  scrollToHeading(id);
  showMobileTOC.value = false;
};

// Scroll to top
const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

// Update reading progress and TOC indicator
const updateReadingProgress = () => {
  if (!postContent.value) return;

  // Update scroll position for parallax effect
  scrollY.value = window.scrollY;

  const contentHeight = postContent.value.clientHeight;
  const scrollPosition = window.scrollY;
  const windowHeight = window.innerHeight;

  // Calculate how far down the page the user has scrolled
  const scrolled = scrollPosition + windowHeight;

  // Get the offset of the content element
  const contentOffset = postContent.value.offsetTop;

  // Calculate reading progress
  const contentScrolled = scrolled - contentOffset;
  const progress = Math.min(100, Math.max(0, (contentScrolled / contentHeight) * 100));

  readingProgress.value = progress;
  isAtTop.value = scrollPosition < 100;

  // Update active heading in TOC
  updateActiveHeading();

  // Update TOC indicator position
  updateTocIndicator();
};

// Update active heading in TOC
const updateActiveHeading = () => {
  if (tableOfContents.value.length === 0) return;

  // Find all headings and their positions
  const headings = tableOfContents.value.map(item => {
    const element = document.getElementById(item.id);
    if (!element) return { id: item.id, top: 0 };

    return {
      id: item.id,
      top: element.getBoundingClientRect().top
    };
  });

  // Find the first heading that's above the middle of the viewport
  const viewportMiddle = window.innerHeight / 3;
  const currentHeading = headings
    .filter(heading => heading.top <= viewportMiddle)
    .sort((a, b) => b.top - a.top)[0];

  if (currentHeading) {
    activeHeading.value = currentHeading.id;
  } else if (headings.length > 0) {
    activeHeading.value = headings[0].id;
  }
};

// Update TOC indicator position
const updateTocIndicator = () => {
  if (tocItemRefs.value.length === 0 || tableOfContents.value.length === 0) return;

  // Calculate total height of TOC
  tocHeight.value = tocItemRefs.value.reduce((total, el) => total + (el?.offsetHeight || 0), 0);

  // Find the active item index
  const activeIndex = tableOfContents.value.findIndex(item => item.id === activeHeading.value);
  if (activeIndex === -1) return;

  // Calculate position and height for indicator
  let position = 0;
  for (let i = 0; i < activeIndex; i++) {
    position += tocItemRefs.value[i]?.offsetHeight || 0;
  }

  tocIndicatorPosition.value = position;
  tocIndicatorHeight.value = tocItemRefs.value[activeIndex]?.offsetHeight || 0;
};

// Font size controls
const increaseFontSize = () => {
  if (fontSize.value < 120) {
    fontSize.value += 5;
  }
};

const decreaseFontSize = () => {
  if (fontSize.value > 80) {
    fontSize.value -= 5;
  }
};

// Slider dragging functionality
const startDragging = (e) => {
  isDragging.value = true;
  document.addEventListener('mousemove', handleDrag);
  document.addEventListener('mouseup', stopDragging);
  handleDrag(e);
};

const handleDrag = (e) => {
  if (!isDragging.value) return;

  const slider = e.target.parentElement;
  const rect = slider.getBoundingClientRect();
  const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));

  // Map 0-1 to 80-120
  fontSize.value = Math.round(80 + x * 40);
};

const stopDragging = () => {
  isDragging.value = false;
  document.removeEventListener('mousemove', handleDrag);
  document.removeEventListener('mouseup', stopDragging);
};

// Reading mode controls
const setReadingMode = (mode) => {
  readingMode.value = mode;
};

// Line height controls
const setLineHeight = (height) => {
  lineHeight.value = height;
};

// Print article
const printArticle = () => {
  window.print();
};

// Navigation
const navigateToPost = (slug) => {
  window.location.href = `/agency/blog/${slug}`;
};

// Newsletter subscription
const subscribeToNewsletter = () => {
  // Implement your newsletter subscription logic here
  alert(`Subscribed with email: ${newsletterEmail.value}`);
  newsletterEmail.value = '';
};

// Setup lightbox for images
const setupLightbox = () => {
  if (!postContent.value) return;

  const images = postContent.value.querySelectorAll('[data-lightbox="true"]');
  images.forEach(img => {
    img.addEventListener('click', () => {
      // Create lightbox
      const lightbox = document.createElement('div');
      lightbox.className = 'fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4';

      // Create image container
      const imgContainer = document.createElement('div');
      imgContainer.className = 'relative max-w-4xl max-h-[90vh] overflow-hidden';

      // Create close button
      const closeBtn = document.createElement('button');
      closeBtn.className = 'absolute top-4 right-4 text-white bg-black/50 rounded-full p-2 hover:bg-black/70 transition-colors';
      closeBtn.innerHTML = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
      closeBtn.addEventListener('click', () => {
        document.body.removeChild(lightbox);
      });

      // Create image
      const lightboxImg = document.createElement('img');
      lightboxImg.src = img.src;
      lightboxImg.alt = img.alt;
      lightboxImg.className = 'max-w-full max-h-[80vh] object-contain';

      // Create caption
      const caption = document.createElement('div');
      caption.className = 'text-white text-center mt-4';
      caption.textContent = img.alt || 'Image';

      // Append elements
      imgContainer.appendChild(lightboxImg);
      imgContainer.appendChild(closeBtn);
      lightbox.appendChild(imgContainer);
      lightbox.appendChild(caption);

      // Add lightbox to body
      document.body.appendChild(lightbox);

      // Close on background click
      lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
          document.body.removeChild(lightbox);
        }
      });
    });

    // Add cursor pointer to indicate clickable
    img.style.cursor = 'zoom-in';
  });
};

// Lifecycle hooks
onMounted(async () => {
  // Wait for the DOM to be updated
  await nextTick();

  // Set reference to post content
  postContent.value = document.querySelector('.prose');

  // Extract table of contents
  extractTableOfContents();

  // Add scroll event listener
  window.addEventListener('scroll', updateReadingProgress);

  // Initial update
  updateReadingProgress();

  // Initialize TOC indicator
  updateTocIndicator();

  // Setup lightbox for images
  setupLightbox();
});

onUnmounted(() => {
  // Remove scroll event listener
  window.removeEventListener('scroll', updateReadingProgress);

  // Remove dragging event listeners
  document.removeEventListener('mousemove', handleDrag);
  document.removeEventListener('mouseup', stopDragging);
});
</script>

<style>
/* Enhanced Blog Content Styling */
.prose {
  max-width: none;
  color: hsl(var(--foreground));
  line-height: 1.75;
}

.prose h2 {
  font-size: 1.75rem;
  font-weight: 700;
  margin-top: 2.5rem;
  margin-bottom: 1.25rem;
  scroll-margin-top: 100px;
  position: relative;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid hsl(var(--border));
}

.prose h3 {
  font-size: 1.5rem;
  font-weight: 600;
  margin-top: 2rem;
  margin-bottom: 1rem;
  scroll-margin-top: 100px;
  position: relative;
}

.prose h4 {
  font-size: 1.25rem;
  font-weight: 600;
  margin-top: 1.75rem;
  margin-bottom: 0.75rem;
  scroll-margin-top: 100px;
  position: relative;
}

.prose p {
  margin-bottom: 1.5rem;
  line-height: 1.8;
}

.prose ul,
.prose ol {
  margin-bottom: 1.5rem;
  padding-left: 1.75rem;
}

.prose li {
  margin-bottom: 0.75rem;
  line-height: 1.7;
}

.prose blockquote {
  border-left: 4px solid hsl(var(--primary));
  padding: 1rem 1.5rem;
  font-style: italic;
  margin: 2rem 0;
  color: hsl(var(--muted-foreground));
  background-color: hsl(var(--muted) / 0.2);
  border-radius: 0.5rem;
}

.prose pre {
  background-color: hsl(var(--card));
  padding: 1.25rem;
  border-radius: 0.5rem;
  overflow-x: auto;
  margin: 1.5rem 0;
}

.prose code {
  background-color: hsl(var(--muted) / 0.5);
  padding: 0.2rem 0.4rem;
  border-radius: 0.25rem;
  font-size: 0.875rem;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}

.prose img {
  max-width: 100%;
  height: auto;
  border-radius: 0.75rem;
  margin: 2rem 0;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.prose a {
  color: hsl(var(--primary));
  text-decoration: underline;
  text-decoration-thickness: 1px;
  text-underline-offset: 2px;
  transition: all 0.2s ease;
}

.prose a:hover {
  text-decoration-thickness: 2px;
  color: hsl(var(--primary) / 0.8);
}

/* Heading anchor links */
.heading-anchor {
  opacity: 0;
  margin-left: 0.5rem;
  transition: opacity 0.2s;
  vertical-align: middle;
}

h2:hover .heading-anchor,
h3:hover .heading-anchor,
h4:hover .heading-anchor,
h5:hover .heading-anchor,
h6:hover .heading-anchor {
  opacity: 0.5;
}

/* Image wrapper styling */
.image-wrapper {
  position: relative;
  margin: 2rem 0;
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.image-wrapper:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.image-wrapper img {
  display: block;
  width: 100%;
  height: auto;
  margin: 0;
  box-shadow: none;
  border-radius: 0;
  transition: transform 0.5s ease;
}

.image-wrapper:hover img {
  transform: scale(1.03);
}

.image-caption {
  padding: 0.75rem 1rem;
  font-size: 0.875rem;
  color: hsl(var(--muted-foreground));
  background: hsl(var(--muted) / 0.3);
  text-align: center;
  border-top: 1px solid hsl(var(--border) / 0.5);
}

/* Reading modes */
.reading-mode-default {
  /* Default styles already applied */
}

.reading-mode-sepia {
  background-color: #f8f2e8;
  color: #5c4b37;
}

.reading-mode-sepia a {
  color: #8b5a2b;
}

.reading-mode-sepia blockquote {
  background-color: #f0e6d6;
  border-left-color: #c8b8a9;
  color: #6d5d4d;
}

.reading-mode-focus {
  max-width: 700px;
  margin: 0 auto;
  font-size: 1.1em;
  line-height: 1.8;
}

/* Line heights */
.line-height-normal {
  line-height: 1.75;
}

.line-height-relaxed {
  line-height: 2;
}

/* Print styles */
@media print {
  .prose {
    font-size: 12pt;
  }

  pre,
  code {
    font-size: 10pt;
    background-color: #f5f5f5 !important;
    color: #333 !important;
  }

  a {
    color: #000 !important;
    text-decoration: underline;
  }

  h2,
  h3,
  h4,
  h5,
  h6 {
    break-after: avoid;
    page-break-after: avoid;
  }

  .image-wrapper {
    break-inside: avoid;
  }
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .prose h2 {
    font-size: 1.5rem;
  }

  .prose h3 {
    font-size: 1.25rem;
  }

  .prose h4 {
    font-size: 1.125rem;
  }

  .prose blockquote {
    padding: 0.75rem 1rem;
    margin: 1.5rem 0;
  }
}

/* Hero section enhancements */
@media (max-width: 640px) {
  .hero-content {
    padding-bottom: 2rem;
  }
}

.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px -5px rgba(var(--primary-rgb), 0.1),
    0 8px 10px -6px rgba(var(--primary-rgb), 0.05);
}

/* Staggered animation for comments */
@keyframes slideInFromLeft {
  0% {
    opacity: 0;
    transform: translateX(-20px);
  }

  100% {
    opacity: 1;
    transform: translateX(0);
  }
}

/* Ripple effect for the submit button */
@keyframes ripple {
  0% {
    transform: scale(0);
    opacity: 0.5;
  }

  100% {
    transform: scale(10);
    opacity: 0;
  }
}

/* Reduce animations for users who prefer reduced motion */
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}

/* Mobile TOC animations */
@keyframes slide-up {
  from {
    transform: translateY(100%);
    opacity: 0;
  }

  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes fade-in {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

/* Enhanced lightbox styling */
.lightbox-container {
  animation: fade-in 0.3s ease-out;
}

.lightbox-image {
  animation: scale-in 0.4s ease-out;
}

@keyframes scale-in {
  from {
    transform: scale(0.9);
    opacity: 0;
  }

  to {
    transform: scale(1);
    opacity: 1;
  }
}
</style>
