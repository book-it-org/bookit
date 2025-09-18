<script setup lang="ts">
import TopicoInformacaoOferta from '@/components/ofertas/TopicoInformacaoOferta.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { Genero } from '@/types/api';
import { Package, ShoppingCartIcon, StarHalfIcon, StarIcon } from 'lucide-vue-next';

interface Props {
    titulo: string;
    preco: number;
    tituloLivro: string;
    autor: string;
    idioma: string;
    dataPublicacao: string;
    editora: string;
    estado: string;
    isbn: string;
    generos: Genero[];
}

const props = defineProps<Props>();
const genero = props.generos.map((g) => g.nome).join(', ');
</script>

<template>
    <div class="flex w-full flex-col gap-4">
        <div class="flex w-full flex-col gap-4">
            <h1 class="text-3xl font-semibold">{{ titulo }}</h1>
            <div class="flex items-center gap-0.5">
                <StarIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <StarIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <StarIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <StarIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <StarHalfIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                <span class="text-sm"> (3 avaliações) </span>
            </div>
            <div>
                <span class="text-primary text-3xl font-semibold">R$ {{ preco }}</span>
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
                <TopicoInformacaoOferta titulo="Título" :conteudo="tituloLivro" />
                <TopicoInformacaoOferta titulo="Autor" :conteudo="autor" />
                <TopicoInformacaoOferta titulo="Idioma" :conteudo="idioma" />
                <TopicoInformacaoOferta titulo="Data de publicação" :conteudo="dataPublicacao" />
                <TopicoInformacaoOferta titulo="Editora" :conteudo="editora" />
                <TopicoInformacaoOferta titulo="Estado" :conteudo="estado" />
                <TopicoInformacaoOferta titulo="ISBN" :conteudo="isbn" />
                <TopicoInformacaoOferta titulo="Gênero" :conteudo="genero" />
            </div>
        </div>
    </div>
</template>
