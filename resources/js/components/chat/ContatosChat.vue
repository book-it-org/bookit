<script setup lang="ts">
import ContatoChat from '@/components/chat/ContatoChat.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
</script>

<template>
    <Card class="max-h-svh h-full">
        <CardHeader>
            <CardTitle>Conversas</CardTitle>
        </CardHeader>
        <CardContent class="flex flex-col overflow-y-auto">
            <template v-for="item in 15" :key="item">
                <ContatoChat />
                <Separator v-if="item < 15" />
            </template>
        </CardContent>
    </Card>
</template>
