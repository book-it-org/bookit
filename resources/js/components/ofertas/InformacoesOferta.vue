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
    editora?: string;
    estado: string;
    isbn: string;
    genero: Genero | null;
    ofertaId: number;
    pedidoIndisponivel?: boolean;
    dono?: boolean;
    vendedorNota?: number | null;
}

const props = withDefaults(defineProps<Props>(), {
    pedidoIndisponivel: false,
    dono: false,
    vendedorNota: null,
});
    const genero = props.genero ? props.genero.nome : '';
const adicionandoCarrinho = ref(false);

    const nota = computed(() => (props.vendedorNota ?? null));

    const starConfig = computed(() => {
        const full = nota.value ? Math.floor(nota.value) : 0;
        const decimal = nota.value ? nota.value - full : 0;
        let fullStars = full;
        let halfStars = 0;

        if (decimal >= 0.75) {
            fullStars += 1;
        } else if (decimal >= 0.25) {
            halfStars = 1;
        }

        const emptyStars = 5 - fullStars - halfStars;
        return { fullStars, halfStars, emptyStars };
    });

const jaNoCarrinho = computed(() => props.estaNoCarrinho);

function toggleCarrinho() {
    if (adicionandoCarrinho.value) return;

    if (props.pedidoIndisponivel || props.dono) {
        // evitar adicionar ao carrinho se indisponível ou se o usuário for o dono
        return;
    }

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

function comprarAgora() {
    if (adicionandoCarrinho.value) return;

    if (props.pedidoIndisponivel || props.dono) {
        return;
    }

    adicionandoCarrinho.value = true;

    router.post(
        route('carrinho.adicionar'),
        { oferta_id: props.ofertaId },
        {
            onFinish: () => {
                adicionandoCarrinho.value = false;
                router.visit(route('pedido.confirmar'));
            },
        },
    );
}
</script>

<template>
    <div class="flex w-full flex-col gap-4">
        <div class="flex w-full flex-col gap-4">
            <h1 class="text-3xl font-semibold">{{ titulo }}</h1>
            <div class="flex items-center gap-0.5">
                <template v-if="nota">
                    <template v-for="n in starConfig.fullStars" :key="`full-${n}`">
                        <StarIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                    </template>
                    <template v-if="starConfig.halfStars === 1">
                        <StarHalfIcon class="h-5 w-5 fill-amber-400 text-amber-400" />
                    </template>
                    <template v-for="n in starConfig.emptyStars" :key="`empty-${n}`">
                        <StarIcon class="h-5 w-5 text-gray-300" />
                    </template>
                    <span class="text-sm"> {{ props.vendedorNota ? (props.vendedorNota + '/5') : 'Sem avaliações' }} </span>
                </template>
                <template v-else>
                    <StarIcon class="h-5 w-5 text-gray-300" />
                    <StarIcon class="h-5 w-5 text-gray-300" />
                    <StarIcon class="h-5 w-5 text-gray-300" />
                    <StarIcon class="h-5 w-5 text-gray-300" />
                    <StarIcon class="h-5 w-5 text-gray-300" />
                    <span class="text-sm"> Sem avaliações </span>
                </template>
            </div>
            <div>
                <span class="text-primary text-3xl font-semibold">R$ {{ preco }}</span>
            </div>

            <div class="flex gap-4">
                <Button class="text-md flex-1" size="lg" :disabled="props.pedidoIndisponivel || props.dono" @click="comprarAgora">
                    <Package />
                    <span v-if="props.pedidoIndisponivel || props.dono">Pedido indisponível</span>
                    <span v-else>Comprar agora</span>
                </Button>
                <Button
                    size="lg"
                    @click="toggleCarrinho"
                    :disabled="adicionandoCarrinho || props.pedidoIndisponivel || props.dono"
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
