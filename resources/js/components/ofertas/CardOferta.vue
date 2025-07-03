<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';
import Button from '../ui/button/Button.vue';
import Card from '../ui/card/Card.vue';
import CardContent from '../ui/card/CardContent.vue';
import CardDescription from '../ui/card/CardDescription.vue';
import CardFooter from '../ui/card/CardFooter.vue';
import CardHeader from '../ui/card/CardHeader.vue';
import CardTitle from '../ui/card/CardTitle.vue';

function irParaOferta() {
    router.visit(route('oferta', { id: '1' }));
}

function irParaCarrinho() {
    router.visit(route('carrinho'));
}
</script>

<template>
    <Card class="group relative w-auto gap-2 p-3 cursor-pointer" @click="irParaOferta">
        <div class="bg-white p-4 rounded-2xl">
            <img
                src="https://images-americanas.b2w.io/produtos/3518714892/imagens/usado-percy-jackson-o-mar-de-monstros-livro-dois/3518714892_1_large.jpg"
                alt=""
        /></div>
        <CardHeader class="px-0.5">
            <CardTitle class="cursor-pointer font-bold group-hover:underline leading-6">
                Percy Jackson e o Mar de Monstros
            </CardTitle>
        </CardHeader>
        <CardContent class="px-0.5">
            <CardDescription>Rick Riordan</CardDescription>
        </CardContent>
        <CardFooter class="flex justify-between px-0.5">
            <p class="text-amber-200">3,5/5</p>
            <p class="text-emerald-500">R$39,99</p>
        </CardFooter>
        <Button
            variant="secondary"
            size="icon"
            class="absolute top-4 right-4 hidden group-hover:flex"
            @click.stop="irParaCarrinho"
        >
            <ShoppingCart />
        </Button>
    </Card>
</template>
