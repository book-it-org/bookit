<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';

interface Props {
    pedido: any;
}

defineProps<Props>();

const formatarPreco = (preco: any): string => {
    const valor = parseFloat(preco?.toString() || '0') || 0;
    return valor.toFixed(2).replace('.', ',');
};
</script>

<template>
    <Card class="flex gap-4 p-4">
        <div class="shrink-0">
            <div class="h-24 w-20 overflow-hidden rounded bg-slate-100">
                <img
                    class="h-full w-full object-cover"
                    :src="pedido.ofertas?.capa_url || 'https://via.placeholder.com/120x160'"
                    alt="Capa do livro"
                />
            </div>
        </div>

        <div class="flex min-w-0 flex-1 flex-col justify-between">
            <div>
                <CardTitle class="mb-1 line-clamp-2 text-base leading-tight font-bold">
                    {{ pedido.ofertas?.titulo_livro || 'Título não disponível' }}
                </CardTitle>
                <CardDescription class="text-sm">
                    <p class="mb-1">Autor: {{ pedido.ofertas?.autor_livro || 'Não informado' }}</p>
                    <p class="text-sky-600">Vendedor: {{ pedido.ofertas?.usuario?.nome }}</p>
                </CardDescription>
            </div>

            <div class="mt-2 flex items-end justify-between">
                <div>
                    <p class="text-lg font-semibold text-emerald-600">
                        R$ {{ formatarPreco(pedido.ofertas?.preco) }}
                    </p>
                </div>
            </div>
        </div>
    </Card>
</template>
