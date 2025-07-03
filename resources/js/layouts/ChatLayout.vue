<script setup lang="ts">
import ContatosChat from '@/components/chat/ContatosChat.vue';
import ConversaChat from '@/components/chat/ConversaChat.vue';
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
    <AppLayout :header-limpo="true">
        <div class="grid max-h-svh grid-cols-7 gap-8">
            <div class="col-span-1 md:col-span-2">
                <ContatosChat />
            </div>
            <div class="col-span-1 md:col-span-5">
                <ConversaChat />
            </div>
        </div>
    </AppLayout>
</template>
