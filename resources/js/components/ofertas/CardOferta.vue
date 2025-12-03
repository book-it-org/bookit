<script setup lang="ts">
import { Oferta } from '@/types/api';
import { router } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';
import { ref } from 'vue';
import Button from '../ui/button/Button.vue';
import Card from '../ui/card/Card.vue';
import CardContent from '../ui/card/CardContent.vue';
import CardDescription from '../ui/card/CardDescription.vue';
import CardFooter from '../ui/card/CardFooter.vue';
import CardHeader from '../ui/card/CardHeader.vue';
import CardTitle from '../ui/card/CardTitle.vue';

interface Props {
    oferta: Oferta;
}

const props = defineProps<Props>();
const adicionandoCarrinho = ref(false);

function irParaOferta() {
    router.visit(route('oferta', { id: props.oferta.id }));
}

function adicionarCarrinho() {
    if (adicionandoCarrinho.value) return;

    adicionandoCarrinho.value = true;

    router.post(
        route('carrinho.adicionar'),
        {
            oferta_id: props.oferta.id,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ['errors', 'flash'],
            onFinish: () => {
                adicionandoCarrinho.value = false;
            },
        },
    );
}
</script>

<template>
    <Card class="group relative w-auto cursor-pointer gap-2 p-3" @click="irParaOferta">
        <div class="rounded-2xl bg-white p-4">
            <img
                :src="props.oferta.capa_url || 'https://via.placeholder.com/140x200'"
                alt="Capa do livro"
                class="w-36 h-48 object-cover rounded"
            />
        </div>
        <CardHeader class="px-0.5">
            <CardTitle class="cursor-pointer leading-6 font-bold group-hover:underline">
                {{ props.oferta.titulo_livro }}
            </CardTitle>
        </CardHeader>
        <CardContent class="px-0.5">
            <CardDescription>
                <p>
                    {{ props.oferta.autor_livro }}
                </p>
                <p>{{ props.oferta.editora || '—' }}</p>
            </CardDescription>
        </CardContent>
        <CardFooter class="flex justify-between px-0.5">
            <p class="text-yellow-500">{{ props.oferta.vendedor_nota ? props.oferta.vendedor_nota + '/5' : '—' }}</p>
            <p class="text-emerald-600">R${{ props.oferta.preco }}</p>
        </CardFooter>
        <Button
            variant="secondary"
            size="icon"
            class="absolute top-4 right-4 hidden group-hover:flex"
            @click.stop="adicionarCarrinho"
            :disabled="adicionandoCarrinho"
        >
            <ShoppingCart />
        </Button>
    </Card>
</template>
