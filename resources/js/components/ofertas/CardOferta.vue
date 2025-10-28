<script setup lang="ts">
import { Oferta } from '@/types/api';
import { router } from '@inertiajs/vue3';
import { ShoppingCart, Check } from 'lucide-vue-next';
import { ref, computed } from 'vue';
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

const jaNoCarrinho = computed(() => {
    try {
        const cookie = document.cookie
            .split(';')
            .find(row => row.trim().startsWith('carrinho='));

        if (cookie) {
            const carrinhoData = JSON.parse(decodeURIComponent(cookie.split('=')[1]));
            return carrinhoData.some((item: any) => item.ofertas_id === props.oferta.id);
        }
    } catch (error) {
        console.error('Erro ao verificar carrinho:', error);
    }
    return false;
});

function irParaOferta() {
    router.visit(route('oferta', { id: props.oferta.id }));
}

function toggleCarrinho() {
    if (adicionandoCarrinho.value) return;

    adicionandoCarrinho.value = true;

    if (jaNoCarrinho.value) {
        const cookie = document.cookie
            .split(';')
            .find(row => row.trim().startsWith('carrinho='));

        if (cookie) {
            const carrinhoData = JSON.parse(decodeURIComponent(cookie.split('=')[1]));
            const item = carrinhoData.find((item: any) => item.ofertas_id === props.oferta.id);

            if (item) {
                router.delete(route('carrinho.remover'), {
                    data: { item_id: item.id },
                    onFinish: () => {
                        adicionandoCarrinho.value = false;
                    }
                });
            }
        }
    } else {
        router.post(route('carrinho.adicionar'), {
            oferta_id: props.oferta.id
        }, {
            onFinish: () => {
                adicionandoCarrinho.value = false;
            }
        });
    }
}
</script>

<template>
    <Card class="group relative w-auto cursor-pointer gap-2 p-3" @click="irParaOferta">
        <div class="rounded-2xl bg-white p-4">
            <img
                src="https://images-americanas.b2w.io/produtos/3518714892/imagens/usado-percy-jackson-o-mar-de-monstros-livro-dois/3518714892_1_large.jpg"
                alt=""
            />
        </div>
        <CardHeader class="px-0.5">
            <CardTitle class="cursor-pointer leading-6 font-bold group-hover:underline">
                {{ props.oferta.titulo_livro }}
            </CardTitle>
        </CardHeader>
        <CardContent class="px-0.5">
            <CardDescription>{{ props.oferta.autor_livro }}</CardDescription>
        </CardContent>
        <CardFooter class="flex justify-between px-0.5">
            <p class="text-amber-200">3,5/5</p>
            <p class="text-emerald-500">R${{ props.oferta.preco }}</p>
        </CardFooter>
        <Button
            variant="secondary"
            size="icon"
            class="absolute top-4 right-4 hidden group-hover:flex"
            @click.stop="toggleCarrinho"
            :disabled="adicionandoCarrinho"
        >
            <Check v-if="jaNoCarrinho" class="text-green-600" />
            <ShoppingCart v-else />
        </Button>
    </Card>
</template>
