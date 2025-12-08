<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import {
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import type { Usuario } from '@/types/api';
import { Link, router } from '@inertiajs/vue3';
import {
    HandCoins,
    LogOut,
    MapPinHouse,
   /*  MessageSquareMore,*/
   Package,
    Settings,
    Shield,
    ShoppingCart,
} from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    user: Usuario;
}

const handleLogout = () => {
    router.flushAll();
};

const props = defineProps<Props>();
const isAdmin = computed(() => {
    return props.user && props.user.papeis_id === 0;
});
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <UserInfo :user="user" :show-email="true" />
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('carrinho')" prefetch as="button">
                <ShoppingCart class="mr-2 h-4 w-4" />
                Carrinho
            </Link>
        </DropdownMenuItem>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('pedidos')" prefetch as="button">
                <Package class="mr-2 h-4 w-4" />
                Pedidos
            </Link>
        </DropdownMenuItem>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('enderecos')" prefetch as="button">
                <MapPinHouse class="mr-2 h-4 w-4" />
                Endereços
            </Link>
        </DropdownMenuItem>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('config.conta')" prefetch as="button">
                <Settings class="mr-2 h-4 w-4" />
                Conta
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('anuncios')" as="button">
                <HandCoins class="mr-2 h-4 w-4" />
                Anúncios
            </Link>
        </DropdownMenuItem>
  <!--       <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('chat')" prefetch as="button">
                <MessageSquareMore class="mr-2 h-4 w-4" />
                Chat
            </Link>
        </DropdownMenuItem>
     --></DropdownMenuGroup>

    <template v-if="isAdmin">
        <DropdownMenuSeparator />
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" prefetch :href="route('admin')" as="button">
                <Shield class="mr-2 h-4 w-4" />
                Administrador
            </Link>
        </DropdownMenuItem>
    </template>

    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link
            class="block w-full"
            method="post"
            :href="route('sair')"
            @click="handleLogout"
            as="button"
        >
            <LogOut class="mr-2 h-4 w-4" />
            Sair
        </Link>
    </DropdownMenuItem>
</template>
