<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
    <AppLayout :header-limpo="true">
        <div class="flex min-h-svh flex-col items-center justify-center p-8">
            <div class="w-full max-w-3xl">
                <Heading title="Adicionar Endereço" class="mb-4" />
                <Card>
                    <CardContent>
                        <slot></slot>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
