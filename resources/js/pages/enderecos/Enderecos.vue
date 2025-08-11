<script setup lang="ts">
import CardEndereco from '@/components/enderecos/CardEndereco.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
</script>

<template>
    <Head title="BookIt - Carrinho" />
    <AppLayout>
        <div class="container mx-auto flex h-full flex-1 flex-col items-center gap-4 rounded-xl">
            <div class="flex w-1/2 flex-col gap-4">
                <Button class="w-full" as-child>
                    <Link
                        class="block w-full"
                        :href="route('enderecos.adicionar')"
                        prefetch
                        as="button"
                    >
                        <Plus class="mr-2 h-4 w-4" />
                        Adicionar Endereço
                    </Link>
                </Button>
                <CardEndereco v-for="index in 5" :key="index"></CardEndereco>
            </div>
        </div>
    </AppLayout>
</template>
