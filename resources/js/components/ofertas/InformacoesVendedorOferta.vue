<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { getInitials } from '@/composables/useInitials';
import { Avatar, AvatarFallback } from '../ui/avatar';

interface Props {
    descricao: string;
    vendedorNome: string;
    vendedorNomeUsuario: string;
}

defineProps<Props>();
</script>
<template>
    <div>
        <Heading title="Descrição da Oferta" class="mb-2" />
        <div class="space-y-4">
            <p>
                {{ descricao }}
            </p>

            <div class="flex items-center gap-4">
                <Avatar class="size-15 overflow-hidden rounded-full">
                    <!-- <AvatarImage v-if="showAvatar" :src="user.avatar" :alt="user.name" /> -->
                    <AvatarFallback class="rounded-lg text-black dark:text-white">
                        {{ getInitials(vendedorNome) }}
                    </AvatarFallback>
                </Avatar>
                <div class="grid flex-1 text-left text-md leading-tight">
                    <span class="truncate font-medium">{{ vendedorNome }}</span>
                    <span class="text-muted-foreground truncate text-sm">
                        {{ vendedorNomeUsuario }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
