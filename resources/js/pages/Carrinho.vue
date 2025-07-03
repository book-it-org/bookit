<script setup lang="ts">
import CardOfertaCarrinho from '@/components/carrinho/CardOfertaCarrinho.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="BookIt - Carrinho" />
    <AppLayout>
        <div class="container mx-auto flex h-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid grid-cols-3 gap-4">
                <CardOfertaCarrinho v-for="index in 5" :key="index"></CardOfertaCarrinho>
            </div>

            <Card class="items-center">
                <div class="grid w-full max-w-sm grid-cols-2 gap-4">
                    <p>Produtos (1):</p>
                    <p class="text-end">R$ 39,99</p>
                    <p>Frete:</p>
                    <p class="text-end">R$ 10,42</p>
                    <p class="font-bold">Total:</p>
                    <p class="text-end font-bold">R$ 50,41</p>
                </div>
                <Button class="col-start-2 w-fit">Finalizar compra</Button>
            </Card>
        </div>
    </AppLayout>
</template>
