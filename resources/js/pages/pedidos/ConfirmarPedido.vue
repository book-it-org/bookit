<script setup lang="ts">
import PedidoCardConfirmar from '@/components/pedidos/PedidoCardConfirmar.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData } from '@/types';
import { Carrinho } from '@/types/api';
import { Head, router, usePage } from '@inertiajs/vue3';
import { capitalize, computed, ref } from 'vue';

interface PageProps extends SharedData {
    pedidos: Carrinho[];
    formasPagamento: string[];
    enderecos: any[];
}

const page = usePage<PageProps>();
const pedidos = computed(() => page.props.pedidos || []);
const formasPagamento = computed(() => page.props.formasPagamento || []);
const enderecos = computed(() => page.props.enderecos || []);

const formatarPreco = (preco: any): number => {
    return parseFloat(preco?.toString() || '0') || 0;
};

const subtotal = computed(() => {
    return pedidos.value.reduce((sum, item) => {
        return sum + formatarPreco(item.ofertas?.preco);
    }, 0);
});

const frete = 10.42;
const totalComFrete = computed(() => subtotal.value + frete);

const selectedForma = ref<number | null>(null);
const selectedEndereco = ref<number | null>(null);

function confirmPedido() {
    if (!selectedForma.value) {
        window.alert('Selecione uma forma de pagamento');
        return;
    }

    if (!selectedEndereco.value) {
        window.alert('Selecione um endereço para envio');
        return;
    }

    router.post(route('comprar'), {
        forma_pagamento: selectedForma.value,
        endereco_id: selectedEndereco.value,
    });
}
</script>

<template>
    <Head title="BookIt - Confirmar Pedido" />
    <AppLayout header-limpo>
        <div class="container mx-auto flex-1 py-6">
            <div v-if="pedidos.length > 0" class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-4">
                    <PedidoCardConfirmar v-for="p in pedidos" :key="p.id" :pedido="p" />
                </div>

                <div>
                    <Card class="p-6">
                        <div class="mb-4 text-sm">
                            <p class="font-medium">Produtos ({{ pedidos.length }}):</p>
                            <p class="text-end font-semibold">
                                R$ {{ subtotal.toFixed(2).replace('.', ',') }}
                            </p>
                            <p class="font-medium">Frete:</p>
                            <p class="text-end font-semibold">
                                R$ {{ frete.toFixed(2).replace('.', ',') }}
                            </p>
                            <div class="mt-2 border-t pt-2">
                                <div class="grid grid-cols-2 gap-4">
                                    <p class="text-lg font-bold">Total:</p>
                                    <p class="text-end text-lg font-bold text-emerald-600">
                                        R$ {{ totalComFrete.toFixed(2).replace('.', ',') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="grid gap-2">
                                <Label for="estado_livro">Estado</Label>
                                <Select v-model="selectedForma">
                                    <SelectTrigger class="w-full" name="estado_livro" :tabindex="3">
                                        <SelectValue :placeholder="'Selecione'" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Estado</SelectLabel>
                                            <SelectItem
                                                v-for="f in formasPagamento"
                                                :key="f"
                                                :value="f"
                                            >
                                                {{ capitalize(f) }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="grid gap-2">
                                <Label for="endereco">Endereço de envio</Label>
                                <Select v-model="selectedEndereco">
                                    <SelectTrigger class="w-full" name="endereco" :tabindex="4">
                                        <SelectValue :placeholder="'Selecione um endereço'" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Endereços</SelectLabel>
                                            <SelectItem v-for="e in enderecos" :key="e.id" :value="e.id">
                                                {{ e.logradouro }} {{ e.numero }} - {{ e.cidade }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <Button
                            class="w-full"
                            size="lg"
                            :disabled="!selectedForma"
                            @click="confirmPedido"
                        >
                            Confirmar pedido
                        </Button>
                    </Card>
                </div>
            </div>

            <div v-else class="flex flex-col items-center justify-center py-16">
                <h2 class="mb-2 text-2xl font-bold text-neutral-600">Seu carrinho está vazio</h2>
                <p class="text-neutral-500">Adicione alguns livros para continuar</p>
            </div>
        </div>
    </AppLayout>
</template>
