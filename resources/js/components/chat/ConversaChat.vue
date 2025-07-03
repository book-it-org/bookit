<script setup lang="ts">
import MensagemChat from '@/components/chat/MensagemChat.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import {SendIcon} from 'lucide-vue-next';
</script>

<template>
    <Card class="h-full max-h-svh">
        <CardHeader>
            <CardTitle>Fulano de Tal</CardTitle>
        </CardHeader>
        <CardContent class="flex max-h-svh flex-col relative overflow-y-auto">
            <div class="flex flex-1 flex-col gap-4 ">
                <MensagemChat
                    v-for="index in 20"
                    :key="index"
                    :class="[index % 2 === 0 && 'text-start']"
                />
            </div>
            <div class="flex gap-2 sticky bottom-0 pt-4 bg-background">
                <Input class="flex-1" placeholder="Mensagem"/>
                <Button size="icon">
                    <SendIcon />
                </Button>
            </div>
        </CardContent>
    </Card>
</template>
