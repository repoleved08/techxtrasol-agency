<template>
  <Head title="Blog Post" />
  <meta name="description" :content="post.excerpt" />
  <meta name="author" :content="post.author.name" />
  <meta name="og:title" :content="post.title" />
  <meta name="og:description" :content="post.excerpt" />
  <meta name="og:image" :content="post.image" />
  <meta name="og:url" :content="`/blog/${post.slug}`" />
  <meta name="twitter:title" :content="post.title" />
  <meta name="twitter:description" :content="post.excerpt" />
  <meta name="twitter:image" :content="post.image" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:site" content="@techxtrasol" />
  <meta name="twitter:creator" :content="post.author.twitter" />
  <meta name="twitter:label1" content="Written by @NormanGeek" />
  <PublicLayout>
    <!-- Animated Reading Progress Bar -->
    <div
      class="fixed top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary/20 via-primary/10 to-primary/20 z-50"
      v-show="!isAtTop"
    >
      <div
        class="h-full bg-gradient-to-r from-primary via-primary/80 to-primary transition-all duration-300 ease-out"
        :style="{ width: `${readingProgress}%` }"
      ></div>
    </div>

    <div class="bg-background min-h-screen">
      <!-- Hero Section with Parallax Effect -->
      <div
        class="relative h-[50vh] md:h-[60vh] overflow-hidden bg-black"
        v-if="post.image"
      >
        <div
          class="absolute inset-0 bg-cover bg-center"
          :style="{ backgroundImage: `url(${post.image})`, transform: `translateY(${scrollY * 0.4}px)` }"
        ></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-background"></div>

        <div
          class="container relative z-10 h-full flex flex-col justify-end pb-12 px-4 mx-auto"
          v-motion
          :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { duration: 800 } }"
        >
          <Badge
            class="mb-4 bg-primary/90 hover:bg-primary text-primary-foreground border-none self-start"
            v-motion
            :initial="{ opacity: 0, scale: 0.8 }"
            :enter="{ opacity: 1, scale: 1, transition: { delay: 200, duration: 500 } }"
          >
            {{ post.category }}
          </Badge>

          <h1
            class="text-3xl md:text-5xl font-bold text-white mb-4 max-w-4xl"
            v-motion
            :initial="{ opacity: 0, y: 20 }"
            :enter="{ opacity: 1, y: 0, transition: { delay: 300, duration: 800 } }"
          >
            {{ post.title }}
          </h1>

          <div
            class="flex flex-wrap items-center gap-4 text-white/90"
            v-motion
            :initial="{ opacity: 0 }"
            :enter="{ opacity: 1, transition: { delay: 500, duration: 800 } }"
          >
            <div class="flex items-center gap-3">
              <Avatar class="h-10 w-10 border-2 border-primary/30">
                <AvatarImage :src="post.author.avatar || '/placeholder.svg?height=40&width=40'" />
                <AvatarFallback>{{ getInitials(post.author.name) }}</AvatarFallback>
              </Avatar>
              <div>
                <p class="font-medium text-white">{{ post.author.name }}</p>
                <p class="text-xs text-white/70">{{ post.author.role }}</p>
              </div>
            </div>

            <div class="flex items-center gap-4 text-sm">
              <span class="flex items-center">
                <CalendarIcon class="h-4 w-4 mr-1" />
                {{ formatDate(post.date) }}
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
        <div
          class="flex items-center text-sm text-muted-foreground my-6"
          v-motion
          :initial="{ opacity: 0 }"
          :enter="{ opacity: 1, transition: { duration: 600 } }"
        >
          <!-- Replace router-link with inertia-link or a regular anchor tag -->
          <a
            href="/agency/blog"
            class="hover:text-primary transition-colors flex items-center"
          >
            <BookOpenIcon class="h-4 w-4 mr-1" />
            Blog
          </a>
          <ChevronRightIcon class="h-4 w-4 mx-2" />
          <a
            :href="`/agency/blog?category=${post.category.toLowerCase()}`"
            class="hover:text-primary transition-colors"
          >
            {{ post.category }}
          </a>
          <ChevronRightIcon class="h-4 w-4 mx-2" />
          <span class="text-foreground truncate max-w-[200px]">{{ post.title }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pb-20">
          <!-- Floating Action Bar -->
          <div
            class="fixed left-0 top-1/2 -translate-y-1/2 z-40 hidden xl:flex flex-col items-center gap-3 ml-4"
            v-show="!isAtTop"
            v-motion
            :initial="{ opacity: 0, x: -20 }"
            :enter="{ opacity: 1, x: 0, transition: { delay: 800, duration: 500 } }"
          >
            <TooltipProvider>
              <Tooltip v-for="action in floatingActions" :key="action.name">
                <TooltipTrigger asChild>
                  <Button
                    size="icon"
                    variant="outline"
                    class="h-10 w-10 rounded-full bg-background/80 backdrop-blur-sm border-border/50 hover:bg-primary/10 hover:border-primary/50 transition-all duration-300"
                    @click="action.action"
                  >
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

          <!-- Main Content Column -->
          <div class="lg:col-span-8">
            <!-- Main Post Content -->
            <article
              class="prose prose-lg max-w-none dark:prose-invert article-content"
              v-motion
              :initial="{ opacity: 0, y: 20 }"
              :enter="{ opacity: 1, y: 0, transition: { duration: 800, delay: 200 } }"
            >
              <!-- Post Header (if no featured image) -->
              <header class="mb-12" v-if="!post.image">
                <div class="flex items-center gap-2 mb-4">
                  <Badge variant="outline" class="bg-primary/10 text-primary border-primary/20">
                    {{ post.category }}
                  </Badge>
                  <span class="text-sm text-muted-foreground flex items-center">
                    <CalendarIcon class="h-4 w-4 mr-1" />
                    {{ formatDate(post.date) }}
                  </span>
                  <span class="text-sm text-muted-foreground flex items-center ml-2">
                    <ClockIcon class="h-4 w-4 mr-1" />
                    {{ readingTime }} min read
                  </span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold mb-6">{{ post.title }}</h1>

                <!-- Author Info -->
                <div class="flex items-center gap-4 mb-8">
                  <Avatar class="h-12 w-12 border-2 border-primary/20">
                    <AvatarImage :src="post.author.avatar || '/placeholder.svg?height=48&width=48'" />
                    <AvatarFallback>{{ getInitials(post.author.name) }}</AvatarFallback>
                  </Avatar>
                  <div>
                    <p class="font-medium">{{ post.author.name }}</p>
                    <p class="text-sm text-muted-foreground" v-if="post.author.role">
                      {{ post.author.role }}
                    </p>
                  </div>
                </div>
              </header>

              <!-- Post Body with Enhanced Styling -->
              <div
                ref="postContent"
                class="prose prose-neutral dark:prose-invert"
                :class="[
                  `reading-mode-${readingMode}`,
                  `line-height-${lineHeight}`
                ]"
                :style="{ fontSize: `${fontSize}%` }"
                v-html="processedContent"
              ></div>


              <!-- Interactive Feedback Section -->
              <div class="mt-12 pt-8 border-t border-border">
                <h3 class="text-xl font-bold mb-4">Was this article helpful?</h3>
                <div class="flex flex-wrap gap-4">
                  <Button
                    variant="outline"
                    size="lg"
                    class="flex items-center gap-2 hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition-all duration-300"
                    :class="{ 'bg-green-50 text-green-600 border-green-200': feedback === 'helpful' }"
                    @click="provideFeedback('helpful')"
                  >
                    <ThumbsUpIcon class="h-5 w-5" />
                    Yes, it helped me
                  </Button>
                  <Button
                    variant="outline"
                    size="lg"
                    class="flex items-center gap-2 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-200 transition-all duration-300"
                    :class="{ 'bg-amber-50 text-amber-600 border-amber-200': feedback === 'somewhat' }"
                    @click="provideFeedback('somewhat')"
                  >
                    <ThumbsUpIcon class="h-5 w-5" />
                    Somewhat
                  </Button>
                  <Button
                    variant="outline"
                    size="lg"
                    class="flex items-center gap-2 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all duration-300"
                    :class="{ 'bg-red-50 text-red-600 border-red-200': feedback === 'not-helpful' }"
                    @click="provideFeedback('not-helpful')"
                  >
                    <ThumbsDownIcon class="h-5 w-5" />
                    Not really
                  </Button>
                </div>

                <div v-if="feedback" class="mt-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
                  <p class="text-muted-foreground mb-3">Thanks for your feedback! Would you like to share more details?</p>
                  <Textarea
                    placeholder="Your thoughts help us improve our content..."
                    class="w-full"
                    v-model="feedbackText"
                  />
                  <Button class="mt-3" @click="submitFeedback">Submit Feedback</Button>
                </div>
              </div>

              <!-- Post Footer -->
              <footer class="mt-12 pt-8 border-t border-border">
                <!-- Tags -->
                <div v-if="post.tags && post.tags.length" class="flex flex-wrap gap-2 mb-8">
                  <Badge
                    v-for="tag in post.tags"
                    :key="tag"
                    variant="secondary"
                    class="text-xs hover:bg-secondary/80 transition-colors cursor-pointer"
                    @click="navigateToTag(tag)"
                  >
                    #{{ tag }}
                  </Badge>
                </div>

                <!-- Share Buttons -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
                  <span class="text-sm text-muted-foreground">Share this post:</span>
                  <div class="flex flex-wrap gap-2">
                    <TooltipProvider>
                      <Tooltip v-for="social in socials" :key="social.name" :delayDuration="300">
                        <TooltipTrigger asChild>
                          <Button
                            size="icon"
                            variant="outline"
                            class="h-9 w-9 rounded-full hover:scale-110 transition-transform duration-300 hover:bg-primary/10 hover:border-primary/50"
                            @click="shareContent(social.name)"
                          >
                            <component :is="social.icon" class="h-4 w-4" />
                            <span class="sr-only">Share on {{ social.name }}</span>
                          </Button>
                        </TooltipTrigger>
                        <TooltipContent>
                          <p>{{ social.tooltip }}</p>
                        </TooltipContent>
                      </Tooltip>
                    </TooltipProvider>
                  </div>
                </div>

                <!-- Author Bio -->
                <div
                  v-if="post.author.bio"
                  class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-xl p-6 mb-8 border border-primary/10"
                  v-motion
                  :initial="{ opacity: 0, y: 20 }"
                  :enter="{ opacity: 1, y: 0, transition: { duration: 600 } }"
                  :visibleOnce="{ opacity: 1, y: 0 }"
                >
                  <div class="flex flex-col sm:flex-row items-start gap-6">
                    <Avatar class="h-20 w-20 border-2 border-primary/20 ring-4 ring-primary/10">
                      <AvatarImage :src="post.author.avatar || '/placeholder.svg?height=80&width=80'" />
                      <AvatarFallback>{{ getInitials(post.author.name) }}</AvatarFallback>
                    </Avatar>
                    <div>
                      <h3 class="font-bold text-xl mb-2">About {{ post.author.name }}</h3>
                      <p class="text-muted-foreground mb-4">{{ post.author.bio }}</p>
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
              </footer>
            </article>

            <!-- Comments Section with Animation -->
            <section
              class="mt-12 pt-8 border-t border-border"
              v-motion
              :initial="{ opacity: 0, y: 20 }"
              :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 200 } }"
              :visibleOnce="{ opacity: 1, y: 0 }"
            >
              <h2 class="text-2xl font-bold mb-6 flex items-center">
                <MessageSquareIcon class="h-5 w-5 mr-2" />
                Join the Discussion
              </h2>

              <div class="bg-gradient-to-br from-muted/30 to-muted/50 rounded-xl p-8 text-center border border-border/50">
                <div class="relative mb-6">
                  <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-16 h-16 rounded-full bg-primary/10 animate-ping opacity-75 duration-1000"></div>
                  </div>
                  <MessageSquareIcon class="h-12 w-12 mx-auto relative z-10 text-primary/70" />
                </div>
                <p class="text-muted-foreground mb-6">Be the first to share your thoughts on this article!</p>
                <div class="max-w-md mx-auto">
                  <Textarea
                    placeholder="Write your comment..."
                    class="mb-4 bg-background/80"
                    v-model="commentText"
                  />
                  <div class="flex gap-4 justify-center">
                    <Button variant="outline">
                      Cancel
                    </Button>
                    <Button>
                      <SendIcon class="h-4 w-4 mr-2" />
                      Post Comment
                    </Button>
                  </div>
                </div>
              </div>
            </section>
          </div>

          <!-- Sidebar Column -->
          <div class="lg:col-span-4">
            <div
              class="lg:sticky lg:top-24 space-y-8"
              v-motion
              :initial="{ opacity: 0, x: 20 }"
              :enter="{ opacity: 1, x: 0, transition: { duration: 800, delay: 400 } }"
            >
              <!-- Table of Contents with Animation -->
              <Card class="overflow-hidden border-border/40 shadow-sm hover:shadow-md transition-shadow duration-300">
                <CardHeader class="bg-gradient-to-r from-primary/5 to-primary/10 pb-3">
                  <CardTitle class="text-lg flex items-center">
                    <ListIcon class="h-5 w-5 mr-2" />
                    Table of Contents
                  </CardTitle>
                </CardHeader>
                <CardContent class="pt-4 relative">
                  <!-- Reading Position Indicator -->
                  <div
                    class="absolute left-2 w-0.5 bg-muted-foreground/20 rounded-full"
                    :style="{ height: tableOfContents.length > 0 ? `${tocHeight}px` : '0' }"
                  >
                    <div
                      class="absolute w-0.5 bg-primary rounded-full transition-all duration-300 ease-out"
                      :style="{ top: `${tocIndicatorPosition}px`, height: `${tocIndicatorHeight}px` }"
                    ></div>
                  </div>

                  <div v-if="tableOfContents.length > 0" class="space-y-1">
                    <div
                      v-for="(item, index) in tableOfContents"
                      :key="index"
                      class="transition-colors"
                      :ref="el => { if (el) tocItemRefs[index] = el }"
                    >
                      <a
                        :href="`#${item.id}`"
                        class="block py-1.5 px-2 text-sm rounded-md transition-all duration-300 hover:bg-muted"
                        :class="[
                          activeHeading === item.id ? 'bg-primary/10 text-primary font-medium translate-x-1' : 'text-muted-foreground',
                          item.level === 2 ? 'pl-4' : 'pl-6'
                        ]"
                        @click.prevent="scrollToHeading(item.id)"
                      >
                        {{ item.text }}
                      </a>
                    </div>
                  </div>
                  <div v-else class="text-sm text-muted-foreground text-center py-4">
                    No headings found in this article
                  </div>
                </CardContent>
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
                        <Button
                          variant="outline"
                          size="icon"
                          class="h-8 w-8"
                          @click="decreaseFontSize"
                        >
                          <Minus class="h-4 w-4" />
                        </Button>
                        <div class="flex-1 h-2 bg-muted rounded-full relative">
                          <div
                            class="absolute h-2 bg-primary rounded-full"
                            :style="{ width: `${(fontSize - 80) / 40 * 100}%` }"
                          ></div>
                          <div
                            class="absolute w-4 h-4 bg-primary rounded-full -mt-1 -ml-2 cursor-pointer"
                            :style="{ left: `${(fontSize - 80) / 40 * 100}%` }"
                            @mousedown="startDragging"
                          ></div>
                        </div>
                        <Button
                          variant="outline"
                          size="icon"
                          class="h-8 w-8"
                          @click="increaseFontSize"
                        >
                          <Plus class="h-4 w-4" />
                        </Button>
                      </div>
                    </div>

                    <div>
                      <label class="text-sm font-medium mb-1.5 block">Reading Mode</label>
                      <div class="grid grid-cols-3 gap-2">
                        <Button
                          variant="outline"
                          size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': readingMode === 'default' }"
                          @click="setReadingMode('default')"
                        >
                          Default
                        </Button>
                        <Button
                          variant="outline"
                          size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': readingMode === 'sepia' }"
                          @click="setReadingMode('sepia')"
                        >
                          Sepia
                        </Button>
                        <Button
                          variant="outline"
                          size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': readingMode === 'focus' }"
                          @click="setReadingMode('focus')"
                        >
                          Focus
                        </Button>
                      </div>
                    </div>

                    <div class="flex items-center justify-between">
                      <span class="text-sm font-medium">Line Spacing</span>
                      <div class="flex items-center gap-2">
                        <Button
                          variant="outline"
                          size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': lineHeight === 'normal' }"
                          @click="setLineHeight('normal')"
                        >
                          Normal
                        </Button>
                        <Button
                          variant="outline"
                          size="sm"
                          :class="{ 'bg-primary/10 border-primary/30': lineHeight === 'relaxed' }"
                          @click="setLineHeight('relaxed')"
                        >
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
                v-motion
                :initial="{ opacity: 0, scale: 0.95 }"
                :enter="{ opacity: 1, scale: 1, transition: { duration: 600, delay: 600 } }"
                :visibleOnce="{ opacity: 1, scale: 1 }"
              >
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
                    <Input
                      type="email"
                      placeholder="Enter your email"
                      v-model="newsletterEmail"
                      required
                      class="bg-background/80"
                    />
                    <Button type="submit" class="w-full bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary">
                      Subscribe
                      <SendIcon class="ml-2 h-4 w-4" />
                    </Button>
                  </form>
                </CardContent>
              </Card>

              <!-- Related Posts Sidebar with Hover Effects -->
              <Card class="overflow-hidden border-border/40 shadow-sm">
                <CardHeader class="bg-gradient-to-r from-primary/5 to-primary/10 pb-3">
                  <CardTitle class="text-lg flex items-center">
                    <BookmarkIcon class="h-5 w-5 mr-2" />
                    Related Articles
                  </CardTitle>
                </CardHeader>
                <CardContent class="pt-4 p-0">
                  <div class="divide-y divide-border">
                    <div
                      v-for="(relatedPost, index) in relatedPosts.slice(0, 3)"
                      :key="relatedPost.id"
                      class="p-4 hover:bg-muted/30 transition-all duration-300 group cursor-pointer"
                      v-motion
                      :initial="{ opacity: 0, y: 10 }"
                      :enter="{ opacity: 1, y: 0, transition: { duration: 400, delay: 200 + (index * 100) } }"
                      :visibleOnce="{ opacity: 1, y: 0 }"
                      @click="navigateToPost(relatedPost.slug)"
                    >
                      <div class="flex gap-3">
                        <div class="flex-shrink-0 w-20 h-20 rounded-md overflow-hidden">
                          <img
                            :src="relatedPost.image || '/placeholder.svg?height=80&width=80'"
                            :alt="relatedPost.title"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                          />
                        </div>
                        <div class="flex-1 min-w-0">
                          <p class="text-xs text-muted-foreground mb-1 flex items-center">
                            <CalendarIcon class="h-3 w-3 mr-1" />
                            {{ formatDate(relatedPost.date) }}
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
                    <Button variant="ghost" size="sm" class="text-primary">
                      View All Related Articles
                      <ArrowRightIcon class="ml-1 h-3 w-3" />
                    </Button>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>

        <!-- Related Posts Full Width with Card Hover Effects -->
        <section
          v-if="relatedPosts.length > 0"
          class="mt-16 pt-8 border-t border-border"
          v-motion
          :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { duration: 800 } }"
          :visibleOnce="{ opacity: 1, y: 0 }"
        >
          <h2 class="text-2xl font-bold mb-8 flex items-center">
            <BookmarkIcon class="h-5 w-5 mr-2" />
            You might also like
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
              v-for="(relatedPost, index) in relatedPosts"
              :key="relatedPost.id"
              class="group cursor-pointer"
              v-motion
              :initial="{ opacity: 0, y: 20 }"
              :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 200 + (index * 150) } }"
              :visibleOnce="{ opacity: 1, y: 0 }"
              @click="navigateToPost(relatedPost.slug)"
            >
              <Card class="h-full overflow-hidden border-border/40 hover:border-primary/30 transition-all duration-300 hover:shadow-lg hover:shadow-primary/10 hover:-translate-y-1">
                <div class="relative aspect-video overflow-hidden">
                  <img
                    :src="relatedPost.image || '/placeholder.svg?height=300&width=500'"
                    :alt="relatedPost.title"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                  />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                  <div class="absolute top-2 right-2">
                    <Badge variant="outline" class="bg-black/50 text-white border-0">
                      {{ relatedPost.category }}
                    </Badge>
                  </div>
                </div>
                <CardContent class="p-5">
                  <p class="text-sm text-muted-foreground mb-2 flex items-center">
                    <CalendarIcon class="h-3 w-3 mr-1" />
                    {{ formatDate(relatedPost.date) }}
                  </p>
                  <h3 class="font-bold text-lg mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-300">
                    {{ relatedPost.title }}
                  </h3>
                  <p class="text-muted-foreground text-sm mb-4 line-clamp-2">
                    {{ relatedPost.excerpt }}
                  </p>
                  <div class="flex items-center justify-between">
                    <div class="flex items-center">
                      <Avatar class="h-6 w-6 mr-2">
                        <AvatarImage :src="relatedPost.author.avatar || '/placeholder.svg?height=24&width=24'" />
                        <AvatarFallback>{{ getInitials(relatedPost.author.name) }}</AvatarFallback>
                      </Avatar>
                      <span class="text-xs text-muted-foreground">{{ relatedPost.author.name }}</span>
                    </div>
                    <div class="text-sm text-primary font-medium flex items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                      Read more
                      <ArrowRightIcon class="ml-1 h-3 w-3 transition-transform duration-300 group-hover:translate-x-1" />
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </section>

        <!-- Newsletter Subscription with Animation -->
        <Newsletter
          class="mt-16 mb-16"
          v-motion
          :initial="{ opacity: 0, y: 30 }"
          :enter="{ opacity: 1, y: 0, transition: { duration: 800 } }"
          :visibleOnce="{ opacity: 1, y: 0 }"
        />

        <!-- Back to Top Button with Animation -->
        <Transition
          enter-active-class="transition duration-300 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition duration-200 ease-in"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <button
            v-show="!isAtTop"
            @click="scrollToTop"
            class="fixed bottom-8 right-8 bg-primary text-primary-foreground rounded-full p-3 shadow-lg hover:bg-primary/90 transition-all z-50 hover:scale-110"
            aria-label="Back to top"
          >
            <ArrowUpIcon class="h-5 w-5" />
          </button>
        </Transition>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>

import PublicLayout from '@/layouts/PublicLayout.vue';
import Newsletter from './Newsletter.vue';
import { usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted, nextTick, watch } from 'vue';
import { useMotion } from '@vueuse/motion';

import { Head } from '@inertiajs/vue3';

import {
  BookOpenIcon,
  ChevronRightIcon,
  ArrowRightIcon,
  TwitterIcon,
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
  ThumbsUpIcon,
  ThumbsDownIcon,
  ShareIcon,
  PrinterIcon,
  HeartIcon,
  BookmarkPlusIcon,
  Minus,
  Plus,
  MoonIcon,
  SunIcon,
  TextIcon
} from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Separator } from '@/components/ui/separator';
import { Switch } from '@/components/ui/switch';
import { Tooltip, TooltipContent, TooltipTrigger, TooltipProvider } from '@/components/ui/tooltip';
import hljs from 'highlight.js';
import 'highlight.js/styles/atom-one-dark.css'; // You can choose different styles

const page = usePage();
const post = computed(() => page.props.post);
const relatedPosts = computed(() => page.props.relatedPosts);

// Table of contents state
const tableOfContents = ref([]);
const activeHeading = ref('');
const postContent = ref(null);
const tocItemRefs = ref([]);
const tocHeight = ref(0);
const tocIndicatorPosition = ref(0);
const tocIndicatorHeight = ref(0);

// Reading progress state
const readingProgress = ref(0);
const isAtTop = ref(true);
const scrollY = ref(0);

// Newsletter state
const newsletterEmail = ref('');

// Reading preferences
const fontSize = ref(100);
const readingMode = ref('default');
const lineHeight = ref('normal');
const bookmarked = ref(false);

// Feedback state
const feedback = ref('');
const feedbackText = ref('');
const commentText = ref('');

// Slider dragging state
const isDragging = ref(false);

// Floating action buttons
const floatingActions = computed(() => [
  {
    name: 'Share',
    icon: ShareIcon,
    action: () => {
      if (navigator.share) {
        navigator.share({
          title: post.value?.title,
          text: 'Check out this article',
          url: window.location.href,
        });
      } else {
        // Fallback
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied to clipboard!');
      }
    }
  },
  {
    name: 'Bookmark',
    icon: BookmarkPlusIcon,
    action: () => {
      bookmarked.value = !bookmarked.value;
    }
  },
  {
    name: 'Like',
    icon: HeartIcon,
    action: () => {
      provideFeedback('helpful');
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

// Process content to add syntax highlighting and fix numbered lists
const processedContent = computed(() => {
  if (!post.value?.body) return '';

  // Create a temporary div to manipulate the HTML
  const tempDiv = document.createElement('div');
  tempDiv.innerHTML = post.value.body;

  // Process code blocks for syntax highlighting
  const codeBlocks = tempDiv.querySelectorAll('pre code');
  codeBlocks.forEach(codeBlock => {
    // Add copy button to code blocks
    const pre = codeBlock.parentNode;
    pre.classList.add('relative', 'group');

    // Try to detect language or default to a generic highlight
    hljs.highlightElement(codeBlock);

    // Add language label if possible
    const language = codeBlock.className.match(/language-(\w+)/)?.[1];
    if (language) {
      pre.setAttribute('data-language', language);
    }

    // Add copy button HTML
    const copyButton = document.createElement('button');
    copyButton.className = 'absolute hidden group-hover:flex items-center justify-center top-2 right-2 bg-primary/90 text-primary-foreground rounded-md px-2 py-1 text-xs font-medium opacity-90 hover:opacity-100 transition-opacity';
    copyButton.innerHTML = 'Copy';
    copyButton.setAttribute('data-copy-code', 'true');
    pre.appendChild(copyButton);
  });

  // Fix numbered lists - ensure they use proper <ol> tags
  const potentialLists = tempDiv.querySelectorAll('p');
  potentialLists.forEach(p => {
    // Check if paragraph starts with a number followed by a period or x
    if (p.textContent.match(/^\d+[\.\)x]\s/)) {
      const listItems = p.textContent.split(/\n/).filter(item => item.trim());

      // If we have multiple items that look like list items
      if (listItems.length > 1 && listItems.every(item => item.match(/^\d+[\.\)x]\s/))) {
        const ol = document.createElement('ol');
        ol.className = 'list-decimal pl-5';

        listItems.forEach(item => {
          const li = document.createElement('li');
          // Remove the number prefix
          li.textContent = item.replace(/^\d+[\.\)x]\s/, '');
          ol.appendChild(li);
        });

        // Replace the paragraph with the ordered list
        p.parentNode.replaceChild(ol, p);
      }
    }
  });

  // Process checkmarks (✅)
  const paragraphs = tempDiv.querySelectorAll('p');
  paragraphs.forEach(p => {
    if (p.textContent.includes('✅')) {
      p.innerHTML = p.innerHTML.replace(/✅\s?(.*?)($|<br>)/g,
        '<div class="flex items-start gap-2 mb-2"><div class="flex-shrink-0 mt-1"><svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div><div>$1</div></div>');
    }
  });

  // Add special styling for callouts and notes
  const callouts = tempDiv.querySelectorAll('blockquote');
  callouts.forEach(callout => {
    const firstParagraph = callout.querySelector('p:first-child');
    if (firstParagraph) {
      const text = firstParagraph.textContent;
      if (text.startsWith('Note:') || text.startsWith('Tip:') || text.startsWith('Warning:') || text.startsWith('Important:')) {
        callout.classList.add('callout');

        if (text.startsWith('Note:')) {
          callout.classList.add('callout-note');
          firstParagraph.innerHTML = firstParagraph.innerHTML.replace('Note:', '<span class="callout-label">Note</span>');
        } else if (text.startsWith('Tip:')) {
          callout.classList.add('callout-tip');
          firstParagraph.innerHTML = firstParagraph.innerHTML.replace('Tip:', '<span class="callout-label">Tip</span>');
        } else if (text.startsWith('Warning:')) {
          callout.classList.add('callout-warning');
          firstParagraph.innerHTML = firstParagraph.innerHTML.replace('Warning:', '<span class="callout-label">Warning</span>');
        } else if (text.startsWith('Important:')) {
          callout.classList.add('callout-important');
          firstParagraph.innerHTML = firstParagraph.innerHTML.replace('Important:', '<span class="callout-label">Important</span>');
        }
      }
    }
  });

  // Add anchor links to headings
  const headings = tempDiv.querySelectorAll('h2, h3, h4, h5, h6');
  headings.forEach(heading => {
    if (!heading.id) {
      heading.id = heading.textContent
        .toLowerCase()
        .replace(/[^\w\s]/gi, '')
        .replace(/\s+/g, '-');
    }

    const anchor = document.createElement('a');
    anchor.className = 'heading-anchor';
    anchor.href = `#${heading.id}`;
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
  { name: 'twitter', icon: TwitterIcon, tooltip: 'Share on Twitter' },
  { name: 'facebook', icon: FacebookIcon, tooltip: 'Share on Facebook' },
  { name: 'linkedin', icon: LinkedinIcon, tooltip: 'Share on LinkedIn' },
  { name: 'copy', icon: Link2Icon, tooltip: 'Copy link to clipboard' }
];

// Share content based on platform
const shareContent = (platform) => {
  const url = window.location.href;
  const title = post.value?.title;

  switch (platform) {
    case 'twitter':
      window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`, '_blank');
      break;
    case 'facebook':
      window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
      break;
    case 'linkedin':
      window.open(`https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}`, '_blank');
      break;
    case 'copy':
      navigator.clipboard.writeText(url);
      alert('Link copied to clipboard!');
      break;
    default:
      break;
  }
};

// Extract headings for table of contents
const extractTableOfContents = () => {
  if (!postContent.value) return;

  const headings = postContent.value.querySelectorAll('h2, h3');
  const toc = [];

  headings.forEach((heading) => {
    // Create an ID if it doesn't exist
    if (!heading.id) {
      heading.id = heading.textContent
        .toLowerCase()
        .replace(/[^\w\s]/gi, '')
        .replace(/\s+/g, '-');
    }

    toc.push({
      id: heading.id,
      text: heading.textContent,
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

  // Handle copy code buttons
  setupCodeCopyButtons();
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

// Setup code copy buttons
const setupCodeCopyButtons = () => {
  if (!postContent.value) return;

  const copyButtons = postContent.value.querySelectorAll('[data-copy-code="true"]');
  copyButtons.forEach(button => {
    if (!button.hasAttribute('data-copy-initialized')) {
      button.setAttribute('data-copy-initialized', 'true');
      button.addEventListener('click', () => {
        const pre = button.closest('pre');
        const code = pre.querySelector('code');
        navigator.clipboard.writeText(code.textContent);

        // Show feedback
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.classList.add('bg-green-600');

        setTimeout(() => {
          button.textContent = originalText;
          button.classList.remove('bg-green-600');
        }, 2000);
      });
    }
  });
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

// Feedback handling
const provideFeedback = (type) => {
  feedback.value = type;
};

const submitFeedback = () => {
  // Here you would typically send the feedback to your backend
  alert(`Thank you for your feedback! Type: ${feedback.value}, Text: ${feedbackText.value}`);
  feedback.value = '';
  feedbackText.value = '';
};

// Navigation
const navigateToPost = (slug) => {
  window.location.href = `/agency/blog/${slug}`;
};

const navigateToTag = (tag) => {
  window.location.href = `/agency/blog?tag=${tag.toLowerCase()}`;
};

// Newsletter subscription
const subscribeToNewsletter = () => {
  // Implement your newsletter subscription logic here
  alert(`Subscribed with email: ${newsletterEmail.value}`);
  newsletterEmail.value = '';
};

// Lifecycle hooks
onMounted(async () => {
  // Wait for the DOM to be updated
  await nextTick();

  // Extract table of contents
  extractTableOfContents();

  // Add scroll event listener
  window.addEventListener('scroll', updateReadingProgress);

  // Initial update
  updateReadingProgress();

  // Setup code copy buttons
  setupCodeCopyButtons();

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
</script>

<style>
.prose-container {
  max-width: none;
  font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  color: hsl(var(--foreground));
  line-height: 1.75;
  position: relative;
  overflow-wrap: break-word;
  word-wrap: break-word;
  hyphens: auto;
}

/* ===== TYPOGRAPHY & SPACING ===== */
.prose-container :deep(p) {
  margin-bottom: 1.8rem;
  line-height: 1.85;
  font-size: 1.125rem;
  letter-spacing: -0.011em;
  color: hsl(var(--foreground) / 0.95);
  word-spacing: 0.05em;
}

/* First paragraph styling for visual hierarchy */
.prose-container :deep(p:first-of-type) {
  font-size: 1.25rem;
  letter-spacing: -0.014em;
  color: hsl(var(--foreground) / 0.9);
}

/* Headings with clear visual hierarchy */
.prose-container :deep(h2) {
  margin-top: 3.5rem;
  margin-bottom: 1.5rem;
  font-size: 2.25rem;
  font-weight: 800;
  line-height: 1.2;
  letter-spacing: -0.025em;
  color: hsl(var(--foreground));
  position: relative;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid hsl(var(--border) / 0.7);
}

.prose-container :deep(h2)::after {
  content: "";
  position: absolute;
  bottom: -1px;
  left: 0;
  width: 4rem;
  height: 3px;
  background: hsl(var(--primary));
  border-radius: 2px;
}

.prose-container :deep(h3) {
  margin-top: 2.75rem;
  margin-bottom: 1.25rem;
  font-size: 1.75rem;
  font-weight: 700;
  line-height: 1.3;
  letter-spacing: -0.02em;
  color: hsl(var(--foreground));
  position: relative;
}

.prose-container :deep(h4) {
  margin-top: 2.25rem;
  margin-bottom: 1rem;
  font-size: 1.35rem;
  font-weight: 600;
  line-height: 1.4;
  color: hsl(var(--foreground));
  letter-spacing: -0.015em;
}

/* Links with animated underline */
.prose-container :deep(a) {
  color: hsl(var(--primary));
  text-decoration: none;
  position: relative;
  font-weight: 500;
  transition: all 0.2s ease;
  background-image: linear-gradient(transparent calc(100% - 2px), hsl(var(--primary) / 0.3) 2px);
  background-size: 0% 100%;
  background-repeat: no-repeat;
  background-position: 0 100%;
  transition: background-size 0.3s ease;
}

.prose-container :deep(a:hover) {
  background-size: 100% 100%;
  color: hsl(var(--primary) / 0.9);
}

/* ===== CODE BLOCK STYLING ===== */
.prose-container :deep(pre) {
  margin: 2.5rem 0;
  padding: 1.5rem;
  border-radius: 0.75rem;
  background: #282c34; /* Match atom-one-dark theme */
  overflow-x: auto;
  position: relative;
  box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.15),
              0 5px 10px -5px rgba(0, 0, 0, 0.1),
              inset 0 0 0 1px rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(0, 0, 0, 0.1);
}

/* Language badge for code blocks */
.prose-container :deep(pre[data-language])::before {
  content: attr(data-language);
  position: absolute;
  top: 0.5rem;
  right: 0.75rem;
  font-size: 0.7rem;
  font-weight: 600;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.7);
  background: rgba(255, 255, 255, 0.1);
  padding: 0.2rem 0.5rem;
  border-radius: 0.25rem;
  letter-spacing: 0.05em;
}

.prose-container :deep(pre code) {
  font-family: 'JetBrains Mono', 'Fira Code', 'Menlo', monospace;
  font-size: 0.95rem;
  line-height: 1.7;
  color: #abb2bf; /* Base text color for atom-one-dark */
  tab-size: 2;
  font-feature-settings: "calt" 1, "ss01" 1, "ss02" 1;
}

/* Copy button styling */
.prose-container :deep([data-copy-code="true"]) {
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
  background: rgba(255, 255, 255, 0.1);
  color: rgba(255, 255, 255, 0.8);
  border: none;
  border-radius: 0.25rem;
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  opacity: 0;
  z-index: 10;
}

.prose-container :deep(pre:hover [data-copy-code="true"]) {
  opacity: 1;
}

.prose-container :deep([data-copy-code="true"]:hover) {
  background: rgba(255, 255, 255, 0.2);
}

.prose-container :deep([data-copy-code="true"].bg-green-600) {
  background: rgba(22, 163, 74, 0.8) !important;
  color: white;
}

/* Inline code styling */
.prose-container :deep(:not(pre) > code) {
  font-family: 'JetBrains Mono', 'Fira Code', 'Menlo', monospace;
  font-size: 0.9em;
  background-color: hsl(var(--muted) / 0.5);
  color: hsl(var(--primary) / 0.9);
  padding: 0.2em 0.4em;
  border-radius: 0.25rem;
  font-weight: 500;
  white-space: nowrap;
  border: 1px solid hsl(var(--border) / 0.5);
}

/* ===== LISTS STYLING ===== */
.prose-container :deep(ul) {
  margin: 1.75rem 0 2rem;
  padding-left: 1.25rem;
}

.prose-container :deep(ul li) {
  position: relative;
  padding-left: 1.5rem;
  margin-bottom: 0.85rem;
  list-style-type: none;
}

.prose-container :deep(ul li::before) {
  content: "";
  position: absolute;
  left: 0;
  top: 0.65em;
  width: 0.5rem;
  height: 0.5rem;
  background-color: hsl(var(--primary) / 0.7);
  border-radius: 50%;
  transform: scale(0.7);
  transition: transform 0.2s ease;
}

.prose-container :deep(ul li:hover::before) {
  transform: scale(0.9);
  background-color: hsl(var(--primary));
}

.prose-container :deep(ol) {
  margin: 1.75rem 0 2rem;
  padding-left: 1.25rem;
  counter-reset: item;
}

.prose-container :deep(ol li) {
  position: relative;
  padding-left: 2rem;
  margin-bottom: 0.85rem;
  list-style-type: none;
  counter-increment: item;
}

.prose-container :deep(ol li::before) {
  content: counter(item);
  position: absolute;
  left: 0;
  top: 0.1em;
  font-size: 0.85rem;
  font-weight: 600;
  width: 1.5rem;
  height: 1.5rem;
  background-color: hsl(var(--primary) / 0.1);
  color: hsl(var(--primary));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.prose-container :deep(ol li:hover::before) {
  background-color: hsl(var(--primary) / 0.2);
  transform: scale(1.1);
}

/* ===== BLOCKQUOTES ===== */
.prose-container :deep(blockquote) {
  margin: 2.5rem 0;
  padding: 1.75rem 2rem 1.75rem 3.5rem;
  position: relative;
  font-style: italic;
  border-radius: 0.75rem;
  background: linear-gradient(to right, hsl(var(--primary) / 0.05), hsl(var(--muted) / 0.3));
  box-shadow: inset 0 0 0 1px hsl(var(--border) / 0.5);
}

.prose-container :deep(blockquote::before) {
  content: "";
  position: absolute;
  left: 1rem;
  top: 0.75rem;
  font-size: 4rem;
  line-height: 1;
  font-family: 'Georgia', serif;
  color: hsl(var(--primary) / 0.4);
}

.prose-container :deep(blockquote p) {
  margin-bottom: 0.75rem;
  font-size: 1.125rem;
  line-height: 1.7;
  color: hsl(var(--foreground) / 0.85);
}

.prose-container :deep(blockquote p:last-child) {
  margin-bottom: 0;
}

/* ===== TABLES ===== */
.prose-container :deep(table) {
  width: 100%;
  margin: 2.5rem 0;
  border-collapse: separate;
  border-spacing: 0;
  overflow: hidden;
  border-radius: 0.75rem;
  box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.05);
  border: 1px solid hsl(var(--border));
}

.prose-container :deep(table thead) {
  background: linear-gradient(to right, hsl(var(--primary) / 0.1), hsl(var(--primary) / 0.05));
  border-bottom: 2px solid hsl(var(--border));
}

.prose-container :deep(table th) {
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.8rem;
  letter-spacing: 0.05em;
  padding: 1rem;
  text-align: left;
  color: hsl(var(--foreground) / 0.9);
}

.prose-container :deep(table td) {
  padding: 1rem;
  border-bottom: 1px solid hsl(var(--border) / 0.7);
  font-size: 0.95rem;
  vertical-align: top;
}

.prose-container :deep(table tr:last-child td) {
  border-bottom: none;
}

.prose-container :deep(table tr:nth-child(even)) {
  background-color: hsl(var(--muted) / 0.3);
}

.prose-container :deep(table tr:hover) {
  background-color: hsl(var(--primary) / 0.05);
}

/* ===== IMAGES ===== */
.prose-container :deep(img) {
  width: 100%;
  border-radius: 0.75rem;
  margin: 2rem 0;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
              0 10px 10px -5px rgba(0, 0, 0, 0.04);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.prose-container :deep(img:hover) {
  transform: translateY(-5px);
  box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.15),
              0 10px 15px -5px rgba(0, 0, 0, 0.07);
}

/* Image captions */
.prose-container :deep(.image-wrapper) {
  position: relative;
  margin: 2rem 0;
  border-radius: 0.75rem;
  overflow: hidden;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
}

.prose-container :deep(.image-caption) {
  text-align: center;
  padding: 0.75rem;
  font-size: 0.875rem;
  color: hsl(var(--muted-foreground));
  background-color: hsl(var(--muted) / 0.2);
}

/* ===== CALLOUTS ===== */
.prose-container :deep(.callout) {
  margin: 2.5rem 0;
  padding: 1.5rem 1.5rem 1.5rem 4rem;
  border-radius: 0.75rem;
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
}

.prose-container :deep(.callout::before) {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 0.5rem;
}

.prose-container :deep(.callout::after) {
  position: absolute;
  left: 1.5rem;
  top: 1.5rem;
  font-size: 1.5rem;
}

.prose-container :deep(.callout-note) {
  background-color: hsl(221, 83%, 97%);
  box-shadow: 0 0 0 1px hsl(221, 83%, 85%);
}

.prose-container :deep(.callout-note::before) {
  background-color: hsl(221, 83%, 60%);
}

.prose-container :deep(.callout-note::after) {
  content: "💡";
}

.prose-container :deep(.callout-tip) {
  background-color: hsl(142, 76%, 97%);
  box-shadow: 0 0 0 1px hsl(142, 76%, 85%);
}

.prose-container :deep(.callout-tip::before) {
  background-color: hsl(142, 76%, 50%);
}

.prose-container :deep(.callout-tip::after) {
  content: "✅";
}

.prose-container :deep(.callout-warning) {
  background-color: hsl(48, 100%, 97%);
  box-shadow: 0 0 0 1px hsl(48, 100%, 85%);
}

.prose-container :deep(.callout-warning::before) {
  background-color: hsl(48, 100%, 50%);
}

.prose-container :deep(.callout-warning::after) {
  content: "⚠️";
}

.prose-container :deep(.callout-important) {
  background-color: hsl(0, 84%, 97%);
  box-shadow: 0 0 0 1px hsl(0, 84%, 85%);
}

.prose-container :deep(.callout-important::before) {
  background-color: hsl(0, 84%, 60%);
}

.prose-container :deep(.callout-important::after) {
  content: "🔔";
}

.prose-container :deep(.callout-label) {
  display: block;
  font-weight: 700;
  margin-bottom: 0.5rem;
  color: hsl(var(--foreground));
}

/* ===== HEADING ANCHORS ===== */
.prose-container :deep(.heading-anchor) {
  opacity: 0;
  margin-left: 0.5rem;
  font-size: 0.85em;
  vertical-align: middle;
  border-bottom: none;
  color: hsl(var(--primary) / 0.6);
  transition: opacity 0.2s ease;
  background-image: none;
}

.prose-container :deep(h2:hover .heading-anchor),
.prose-container :deep(h3:hover .heading-anchor),
.prose-container :deep(h4:hover .heading-anchor) {
  opacity: 1;
}

/* ===== HORIZONTAL RULE ===== */
.prose-container :deep(hr) {
  margin: 3rem 0;
  border: 0;
  height: 1px;
  background: linear-gradient(to right, transparent, hsl(var(--border)), transparent);
  position: relative;
}

.prose-container :deep(hr::before) {
  content: "✧";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: hsl(var(--background));
  padding: 0 1rem;
  color: hsl(var(--muted-foreground));
  font-size: 1rem;
}

/* ===== READING MODES ===== */
.reading-mode-default {
  /* Default styles already applied */
}

.reading-mode-sepia {
  background-color: #f8f2e3;
  color: #5f4b32;
}

.reading-mode-sepia :deep(h2),
.reading-mode-sepia :deep(h3),
.reading-mode-sepia :deep(h4) {
  color: #704214;
}

.reading-mode-sepia :deep(a) {
  color: #9c6f2d;
}

.reading-mode-sepia :deep(blockquote) {
  background: linear-gradient(to right, rgba(156, 111, 45, 0.05), rgba(156, 111, 45, 0.1));
}

.reading-mode-focus {
  max-width: 700px;
  margin: 0 auto;
}

.reading-mode-focus :deep(p) {
  line-height: 1.9;
}

/* ===== LINE HEIGHT VARIATIONS ===== */
.line-height-normal :deep(p),
.line-height-normal :deep(li) {
  line-height: 1.75;
}

.line-height-relaxed :deep(p),
.line-height-relaxed :deep(li) {
  line-height: 2;
}

/* ===== RESPONSIVE ADJUSTMENTS ===== */
@media (max-width: 768px) {
  .prose-container :deep(h2) {
    font-size: 1.75rem;
  }

  .prose-container :deep(h3) {
    font-size: 1.5rem;
  }

  .prose-container :deep(p) {
    font-size: 1.05rem;
  }

  .prose-container :deep(blockquote) {
    padding: 1.5rem 1.5rem 1.5rem 2.5rem;
  }

  .prose-container :deep(blockquote::before) {
    font-size: 3rem;
  }

  .prose-container :deep(.callout) {
    padding: 1.25rem 1.25rem 1.25rem 3.5rem;
  }
}

/* ===== DARK MODE ADJUSTMENTS ===== */
@media (prefers-color-scheme: dark) {
  .prose-container :deep(:not(pre) > code) {
    background-color: hsl(var(--primary) / 0.15);
    color: hsl(var(--primary) / 0.9);
  }

  .prose-container :deep(table thead) {
    background: linear-gradient(to right, hsl(var(--primary) / 0.2), hsl(var(--primary) / 0.1));
  }

  .prose-container :deep(figure img) {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3),
                0 10px 10px -5px rgba(0, 0, 0, 0.2);
  }

  .prose-container :deep(.callout-note) {
    background-color: hsl(221, 83%, 10%);
    box-shadow: 0 0 0 1px hsl(221, 83%, 25%);
  }

  .prose-container :deep(.callout-tip) {
    background-color: hsl(142, 76%, 10%);
    box-shadow: 0 0 0 1px hsl(142, 76%, 25%);
  }

  .prose-container :deep(.callout-warning) {
    background-color: hsl(48, 100%, 10%);
    box-shadow: 0 0 0 1px hsl(48, 100%, 25%);
  }

  .prose-container :deep(.callout-important) {
    background-color: hsl(0, 84%, 10%);
    box-shadow: 0 0 0 1px hsl(0, 84%, 25%);
  }
}

/* ===== PRINT STYLES ===== */
@media print {
  .prose-container {
    font-size: 12pt !important;
  }

  .prose-container :deep(a) {
    color: #000 !important;
    text-decoration: underline !important;
    background-image: none !important;
  }

  .prose-container :deep(pre),
  .prose-container :deep(blockquote),
  .prose-container :deep(.callout) {
    border: 1px solid #ddd !important;
    page-break-inside: avoid;
  }

  .prose-container :deep(h2),
  .prose-container :deep(h3),
  .prose-container :deep(h4) {
    page-break-after: avoid;
  }

  .prose-container :deep(img) {
    max-width: 100% !important;
    page-break-inside: avoid;
  }

  .prose-container :deep(table) {
    border-collapse: collapse !important;
  }

  .prose-container :deep(th),
  .prose-container :deep(td) {
    border: 1px solid #ddd !important;
  }
}

/* ===== TEXT SELECTION ===== */
.prose-container ::selection {
  background-color: hsl(var(--primary) / 0.2);
  color: hsl(var(--primary));
}
</style>
