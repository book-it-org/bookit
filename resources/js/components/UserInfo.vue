<script setup lang="ts">
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import type { Usuario } from '@/types/api';

interface Props {
    user: Usuario;
    showEmail?: boolean;
}

withDefaults(defineProps<Props>(), {
    showEmail: false,
});

const { getInitials } = useInitials();

// Compute whether we should show the avatar image
// const showAvatar = computed(() => props.user.avatar && props.user.avatar !== '');
</script>

<template>
    <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
        <!-- <AvatarImage v-if="showAvatar" :src="user.avatar" :alt="user.name" /> -->
        <AvatarFallback class="rounded-lg text-black dark:text-white">
            {{ getInitials(user.nome) }}
        </AvatarFallback>
    </Avatar>

    <div class="grid flex-1 text-left text-sm leading-tight">
        <span class="truncate font-medium">{{ user.nome }}</span>
        <span v-if="showEmail" class="text-muted-foreground truncate text-xs">
            {{ user.email }}
        </span>
    </div>
</template>
