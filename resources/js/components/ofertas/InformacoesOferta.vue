<script setup lang="ts">
import TopicoInformacaoOferta from '@/components/ofertas/TopicoInformacaoOferta.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { Genero } from '@/types/api';
import { router } from '@inertiajs/vue3';
import { Package, ShoppingCartIcon, StarHalfIcon, StarIcon } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    titulo: string;
    preco: number;
    tituloLivro: string;
    autor: string;
    estaNoCarrinho: boolean;
    idioma: string;
    dataPublicacao: string;
    editora: string;
    estado: string;
    isbn: string;
    generos: Genero[];
    ofertaId: number;
}

const props = defineProps<Props>();
const genero = props.generos.map((g) => g.nome).join(', ');
const adicionandoCarrinho = ref(false);

const jaNoCarrinho = computed(() => props.estaNoCarrinho);

function toggleCarrinho() {
    if (adicionandoCarrinho.value) return;

    adicionandoCarrinho.value = true;

    if (jaNoCarrinho.value) {
        router.delete(route('carrinho.remover'), {
            data: { oferta_id: props.ofertaId },
            onFinish: () => {
                adicionandoCarrinho.value = false;
            },
        });
    } else {
        router.post(
            route('carrinho.adicionar'),
            {
                oferta_id: props.ofertaId,
            },
            {
                onFinish: () => {
                    adicionandoCarrinho.value = false;
                },
            },
        );
    }
}
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
                <Button
                    size="lg"
                    @click="toggleCarrinho"
                    :disabled="adicionandoCarrinho"
                    :variant="jaNoCarrinho ? 'destructive' : 'default'"
                >
                    <ShoppingCartIcon />
                    <span v-if="adicionandoCarrinho">
                        {{ jaNoCarrinho ? 'Removendo...' : 'Adicionando...' }}
                    </span>
                    <span v-else>
                        {{ jaNoCarrinho ? 'Remover' : 'Adicionar' }}
                    </span>
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
