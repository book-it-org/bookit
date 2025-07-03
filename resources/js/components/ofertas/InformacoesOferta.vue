<script setup lang="ts">
import TopicoInformacaoOferta from '@/components/ofertas/TopicoInformacaoOferta.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { Package, ShoppingCartIcon, StarHalfIcon, StarIcon } from 'lucide-vue-next';

const titulo = 'Percy Jackson e o Mar de Monstros';
</script>

<template>
    <div class="flex w-full flex-col gap-4">
        <div class="flex w-full flex-col gap-4">
            <h1 class="text-3xl font-semibold">Percy Jackson e o Mar de Monstros</h1>
            <div class="flex items-center gap-0.5">
                <StarIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <StarIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <StarIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <StarIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <StarHalfIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <span class="text-sm"> (3 avaliações) </span>
            </div>
            <div>
                <span class="text-primary text-3xl font-semibold">R$ 57,50</span>
            </div>

            <div class="flex gap-4">
                <Button class="text-md flex-1" size="lg">
                    <Package />
                    Comprar agora
                </Button>
                <Button size="lg" class="">
                    <ShoppingCartIcon />
                </Button>
            </div>
        </div>
        <Separator />
        <div>
            <h2 class="mb-4 text-xl font-semibold">Informações do Livro</h2>
            <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                <TopicoInformacaoOferta titulo="Título" :conteudo="titulo" />
                <TopicoInformacaoOferta titulo="Autor" conteudo="Rick Riordan" />
                <TopicoInformacaoOferta titulo="Idioma" conteudo="Português" />
                <TopicoInformacaoOferta titulo="Data de publicação" conteudo="2019" />
                <TopicoInformacaoOferta titulo="Editora" conteudo="Intrínseca" />
                <TopicoInformacaoOferta titulo="Estado" conteudo="Novo" />
                <TopicoInformacaoOferta titulo="ISBN" conteudo="9788533613379" />
                <TopicoInformacaoOferta titulo="Gênero" conteudo="Ficção, Fantasia, Aventura" />
            </div>
        </div>
    </div>
</template>
