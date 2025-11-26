<script setup lang="ts">
import { Carrinho } from '@/types/api';
import { router } from '@inertiajs/vue3';
import { Trash2Icon } from 'lucide-vue-next';
import { ref } from 'vue';
import Button from '../ui/button/Button.vue';
import Card from '../ui/card/Card.vue';
import CardDescription from '../ui/card/CardDescription.vue';
import CardTitle from '../ui/card/CardTitle.vue';

interface Props {
    item: Carrinho;
}

const props = defineProps<Props>();
const removendoItem = ref(false);

const formatarPreco = (preco: any): string => {
    const valor = parseFloat(preco?.toString() || '0') || 0;
    return valor.toFixed(2).replace('.', ',');
};

function removerDoCarrinho() {
    if (removendoItem.value) return;

    removendoItem.value = true;
    router.delete(route('carrinho.remover'), {
        data: {
            oferta_id: props.item.ofertas_id,
        },
        onFinish: () => {
            removendoItem.value = false;
        },
    });
}
</script>
<template>
    <Card class="flex flex-col gap-4 p-4">
        <div class="flex gap-4">
            <Card class="shrink-0 bg-white p-2">
                <img
                    class="h-24 w-20 rounded object-cover"
                    src="https://images-americanas.b2w.io/produtos/3518714892/imagens/usado-percy-jackson-o-mar-de-monstros-livro-dois/3518714892_1_large.jpg"
                    alt="Capa do livro"
                />
            </Card>

            <div class="flex min-w-0 flex-1 flex-col justify-between">
                <div>
                    <CardTitle class="mb-1 line-clamp-2 text-base leading-tight font-bold">
                        {{ item.ofertas?.titulo_livro || 'Título não disponível' }}
                    </CardTitle>
                    <CardDescription class="text-sm">
                        <p class="mb-1">
                            Autor: {{ item.ofertas?.autor_livro || 'Não informado' }}
                        </p>
                        <p class="text-sky-600">
                            Vendido por {{ item.ofertas?.usuario?.nome }}
                            {{ item.ofertas?.usuario?.sobrenome }}
                        </p>
                    </CardDescription>
                </div>

                <div class="mt-2 flex items-end justify-between">
                    <div>
                        <p class="mb-1 text-sm text-yellow-500">★★★☆☆ 3,5/5</p>
                        <p class="text-lg font-semibold text-emerald-600">
                            R$ {{ formatarPreco(item.ofertas?.preco) }}
                        </p>
                    </div>
                    <Button
                        size="icon"
                        variant="destructive"
                        @click="removerDoCarrinho"
                        :disabled="removendoItem"
                        class="shrink-0"
                    >
                        <Trash2Icon class="h-4 w-4" />
                    </Button>
                </div>
            </div>
        </div>
    </Card>
</template>
