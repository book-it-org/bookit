<script setup lang="ts">
import CardOfertaCarrinho from '@/components/carrinho/CardOfertaCarrinho.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData } from '@/types';
import { Carrinho } from '@/types/api';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface PageProps extends SharedData {
    carrinho: Carrinho[];
}

const page = usePage<PageProps>();
const carrinho = computed(() => page.props.carrinho);

const formatarPreco = (preco: any): number => {
    return parseFloat(preco?.toString() || '0') || 0;
};

const total = computed(() => {
    console.log(carrinho.value);
    return carrinho.value.reduce((sum, item) => {
        return sum + formatarPreco(item.ofertas?.preco);
    }, 0);
});

const frete = 10.42;
const totalComFrete = computed(() => total.value + frete);
</script>

<template>
    <Head title="BookIt - Carrinho" />
    <AppLayout header-limpo>
        <div class="container mx-auto flex h-full flex-1 flex-col gap-4 rounded-xl">
            <div
                v-if="carrinho.length > 0"
                class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3"
            >
                <CardOfertaCarrinho v-for="item in carrinho" :key="item.id" :item="item" />
            </div>

            <div v-else class="flex flex-col items-center justify-center py-16">
                <h2 class="mb-2 text-2xl font-bold text-neutral-600">Seu carrinho está vazio</h2>
                <p class="text-neutral-500">Adicione alguns livros para continuar</p>
            </div>

            <Card v-if="carrinho.length > 0" class="items-center p-6">
                <div class="grid w-full max-w-md grid-cols-2 gap-4 text-sm">
                    <p class="font-medium">Produtos ({{ carrinho.length }}):</p>
                    <p class="text-end font-semibold">
                        R$ {{ total.toFixed(2).replace('.', ',') }}
                    </p>
                    <p class="font-medium">Frete:</p>
                    <p class="text-end font-semibold">
                        R$ {{ frete.toFixed(2).replace('.', ',') }}
                    </p>
                    <div class="col-span-2 mt-2 border-t pt-2">
                        <div class="grid grid-cols-2 gap-4">
                            <p class="text-lg font-bold">Total:</p>
                            <p class="text-end text-lg font-bold text-emerald-600">
                                R$ {{ totalComFrete.toFixed(2).replace('.', ',') }}
                            </p>
                        </div>
                    </div>
                </div>
                <Button class="mt-4 w-full md:w-auto" size="lg" as-child>
                    <Link :href="route('pedido.confirmar')">Finalizar compra</Link>
                </Button>
            </Card>
        </div>
    </AppLayout>
</template>
