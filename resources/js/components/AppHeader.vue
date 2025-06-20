<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import { useGenerosEmDestaque } from '@/composables/useGenerosEmDestaque';
import { getInitials } from '@/composables/useInitials';
import { NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, Menu, MessageSquareMore, ShoppingCart, User } from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogoIcon from './AppLogoIcon.vue';
import { Avatar, AvatarFallback, AvatarImage } from './ui/avatar';
import { Button } from './ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from './ui/dropdown-menu';
import { Input } from './ui/input';
import { NavigationMenu, NavigationMenuItem, NavigationMenuLink, NavigationMenuList, navigationMenuTriggerStyle } from './ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from './ui/sheet';
import UserMenuContent from './UserMenuContent.vue';

const page = usePage();
const auth = computed(() => page.props.auth);

const isCurrentRoute = computed(() => (url: string) => page.url === url);

const activeItemStyles = computed(
    () => (url: string) => (isCurrentRoute.value(url) ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100' : ''),
);

const generosEmDestaque = useGenerosEmDestaque();
const generos = computed(() =>
    generosEmDestaque.value.map((item) => ({
        ...item,
        href: `/pesquisa?genero=${item.id}`,
    })),
);

const rightNavItems: NavItem[] = [
    {
        title: 'Chat',
        href: '/chat',
        icon: Folder,
    },
    {
        title: 'Carrinho',
        href: '/carrinho',
        icon: BookOpen,
    },
];
</script>

<template>
    <div>
        <div class="border-sidebar-border/80 border-b">
            <div class="mx-auto flex w-full items-center px-4 md:max-w-7xl lg:flex-col">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button variant="ghost" size="icon" class="mr-2 h-9 w-9">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] p-6">
                            <SheetTitle class="sr-only">Navigation Menu</SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                <AppLogoIcon class="size-6 fill-current text-black dark:text-white" />
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                <!-- <nav class="-mx-3 space-y-1">
                                    <Link
                                        v-for="item in mainNavItems"
                                        :key="item.title"
                                        :href="item.href"
                                        class="hover:bg-accent flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium"
                                        :class="activeItemStyles(item.href)"
                                    >
                                        <component v-if="item.icon" :is="item.icon" class="h-5 w-5" />
                                        {{ item.title }}
                                    </Link>
                                </nav>
                                <div class="flex flex-col space-y-4">
                                    <a
                                        v-for="item in rightNavItems"
                                        :key="item.title"
                                        :href="item.href"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="flex items-center space-x-2 text-sm font-medium"
                                    >
                                        <component v-if="item.icon" :is="item.icon" class="h-5 w-5" />
                                        <span>{{ item.title }}</span>
                                    </a>
                                </div> -->
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <div class="flex h-full w-full items-center px-4 py-4 md:max-w-7xl lg:grid lg:grid-cols-3 lg:justify-center">
                    <Link :href="route('home')" class="flex items-center gap-x-2">
                        <AppLogo />
                    </Link>

                    <div class="hidden h-full max-w-xl lg:flex lg:flex-1 lg:items-center">
                        <Input placeholder="Percy Jackson e o Mar de Monstros..." />
                    </div>

                    <div class="ml-auto flex items-center space-x-2">
                        <template v-if="auth.user">
                            <Button variant="ghost" size="sm" as-child class="group cursor-pointer">
                                <Link href="/chat">
                                    <MessageSquareMore class="size-5 opacity-80 group-hover:opacity-100" />
                                    <span>Chat</span>
                                </Link>
                            </Button>

                            <Button variant="ghost" size="sm" as-child class="group cursor-pointer">
                                <Link href="/carrinho">
                                    <ShoppingCart class="size-5 opacity-80 group-hover:opacity-100" />
                                    <span>Carrinho</span>
                                </Link>
                            </Button>

                            <DropdownMenu>
                                <DropdownMenuTrigger :as-child="true">
                                    <Button
                                        variant="ghost"
                                        size="icon"
                                        class="focus-within:ring-primary relative size-10 w-auto rounded-full p-1 focus-within:ring-2"
                                    >
                                        <Avatar class="size-8 overflow-hidden rounded-full">
                                            <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" />
                                            <AvatarFallback
                                                class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white"
                                            >
                                                {{ getInitials(auth.user?.name) }}
                                            </AvatarFallback>
                                        </Avatar>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end" class="w-56">
                                    <UserMenuContent :user="auth.user" />
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </template>
                        <template v-else>
                            <Button variant="ghost" size="sm" as-child class="group cursor-pointer">
                                <Link href="/entrar">
                                    <User class="size-5 opacity-80 group-hover:opacity-100" />
                                    <span>Entrar</span>
                                </Link>
                            </Button>
                        </template>
                    </div>
                </div>

                <div class="hidden w-full lg:flex lg:items-center lg:justify-center">
                    <NavigationMenu class="flex h-full items-stretch">
                        <NavigationMenuList class="flex h-full items-stretch divide-x-1">
                            <NavigationMenuItem v-for="(item, index) in generos" :key="index" class="relative flex h-full items-center">
                                <Link :href="item.href">
                                    <NavigationMenuLink
                                        :class="[navigationMenuTriggerStyle(), activeItemStyles(item.href), 'h-9 cursor-pointer px-3']"
                                    >
                                        {{ item.nome }}
                                    </NavigationMenuLink>
                                </Link>
                                <div
                                    v-if="isCurrentRoute(item.href)"
                                    class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                                ></div>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>
            </div>
        </div>
    </div>
</template>
