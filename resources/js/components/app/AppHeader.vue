<script setup lang="ts">
import AppBarraPesquisa from '@/components/app/AppBarraPesquisa.vue';
import AppLogo from '@/components/app/AppLogo.vue';
import AppLogoIcon from '@/components/app/AppLogoIcon.vue';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import { cn } from '@/lib/utils';
import { SharedData } from '@/types';
import { Genero } from '@/types/api';
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, ShoppingCart, User } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    limpo: boolean;
}

interface PageProps extends SharedData {
    generos?: Genero[];
}

const page = usePage<PageProps>();

const { generos } = page.props;
const auth = computed(() => page.props.auth);

withDefaults(defineProps<Props>(), { limpo: false });
</script>

<template>
    <div class="bg-primary w-full">
        <div class="border-sidebar-border/80 border-b">
            <div class="flex w-full items-center px-4 lg:flex-col">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button variant="ghost" size="icon" class="mr-2 h-9 w-9">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] p-6">
                            <SheetTitle class="sr-only">Menu de navegação</SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                <AppLogoIcon
                                    class="size-6 fill-current text-black dark:text-white"
                                />
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                <nav class="-mx-3 space-y-1">
                                    <div class="text-muted-foreground pl-3 text-xs">Gêneros</div>
                                    <Link
                                        v-for="genero in generos"
                                        :key="genero.id"
                                        :href="route('pesquisa', { genero: genero.id })"
                                        class="hover:bg-accent flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium"
                                    >
                                        {{ genero.nome }}
                                    </Link>
                                </nav>
                                <!-- <div class="flex flex-col space-y-4">
                                    <a
                                        v-for="item in rightNavItems"
                                        :key="item.title"
                                        :href="item.href"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="flex items-center space-x-2 text-sm font-medium"
                                    >
                                        <component
                                            v-if="item.icon"
                                            :is="item.icon"
                                            class="h-5 w-5"
                                        />
                                        <span>{{ item.title }}</span>
                                    </a>
                                </div> -->
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <div
                    class="flex h-full w-full items-center px-4 py-4 lg:grid lg:grid-cols-3 lg:justify-center"
                >
                    <Link :href="route('home')" class="flex items-center gap-x-2">
                        <AppLogo />
                    </Link>

                    <div class="hidden h-full max-w-xl lg:flex lg:flex-1 lg:items-center">
                        <AppBarraPesquisa v-if="!limpo" />
                    </div>

                    <div :class="cn('ml-auto flex items-center space-x-2', limpo && 'col-3')">
                        <!-- <Button
                            v-if="auth.user"
                            variant="ghost"
                            size="sm"
                            as-child
                            class="group hidden cursor-pointer lg:flex"
                        >
                            <Link href="/chat">
                                <MessageSquareMore
                                    class="size-5 opacity-80 group-hover:opacity-100"
                                />
                                <span>Chat</span>
                            </Link>
                        </Button> -->

                        <Button
                            variant="ghost"
                            size="sm"
                            as-child
                            class="group hidden cursor-pointer lg:flex"
                        >
                            <Link href="/carrinho" class="text-primary-foreground">
                                <ShoppingCart class="size-5 opacity-80 group-hover:opacity-100" />
                                <span>Carrinho</span>
                            </Link>
                        </Button>

                        <DropdownMenu v-if="auth.user">
                            <DropdownMenuTrigger :as-child="true">
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    class="focus-within:ring-primary relative size-10 w-auto rounded-full p-1 focus-within:ring-2"
                                >
                                    <Avatar class="size-8 overflow-hidden rounded-full">
                                        <!-- <AvatarImage
                                            v-if="auth.user.avatar"
                                            :src="auth.user.avatar"
                                            :alt="auth.user.name"
                                        /> -->
                                        <AvatarFallback
                                            class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ getInitials(auth.user?.nome) }}
                                        </AvatarFallback>
                                    </Avatar>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" class="w-56">
                                <UserMenuContent :user="auth.user" />
                            </DropdownMenuContent>
                        </DropdownMenu>

                        <template v-if="!auth.user">
                            <Button variant="ghost" size="sm" as-child class="group cursor-pointer">
                                <Link href="/entrar">
                                    <User class="size-5 opacity-80 group-hover:opacity-100" />
                                    <span>Entrar</span>
                                </Link>
                            </Button>
                        </template>
                    </div>
                </div>

                <div
                    v-if="generos && !limpo"
                    class="hidden w-full lg:flex lg:items-center lg:justify-center"
                >
                    <NavigationMenu class="flex h-full items-stretch">
                        <NavigationMenuList
                            class="divide-primary-foreground flex h-full items-stretch divide-x"
                        >
                            <NavigationMenuItem
                                v-for="genero in generos"
                                :key="genero.id"
                                class="relative flex h-full items-center"
                            >
                                <Link :href="route('pesquisa', { genero: genero.id })">
                                    <NavigationMenuLink
                                        :class="[
                                            navigationMenuTriggerStyle(),
                                            'bg-primary text-primary-foreground h-9 cursor-pointer px-3',
                                        ]"
                                    >
                                        {{ genero.nome }}
                                    </NavigationMenuLink>
                                </Link>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>
            </div>
        </div>
    </div>
</template>
