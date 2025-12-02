<script setup lang="ts">
import PedidoCardConfirmar from '@/components/pedidos/PedidoCardConfirmar.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface PageProps extends SharedData {
    compra: any;
    transacao: any;
}

const page = usePage<PageProps>();
const compra = computed(() => page.props.compra || {});
const transacao = computed(() => page.props.transacao || null);
const authUser = computed(() => (page.props as any).auth?.user || null);

const itens = computed(() => compra.value.pedidos || []);

const subtotal = computed(() => {
    return Number(transacao.value.valor);
});

const frete = 10.42;
const totalComFrete = computed(() => subtotal.value + frete);

function efetuarPagamento() {
    router.post(route('pedido.pagar', { id: compra.value.id }));
}
</script>

<template>
    <Head title="BookIt - Pagar Pedido" />
    <AppLayout header-limpo>
        <div class="container mx-auto flex-1 py-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-4">
                    <PedidoCardConfirmar v-for="p in itens" :key="p.id" :pedido="p" />
                </div>

                <div>
                    <Card class="p-6">
                        <div class="mb-4 text-sm">
                            <p class="font-medium">Produtos ({{ itens.length }}):</p>
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
                            <p class="mb-2 text-sm text-neutral-600">Transação</p>
                            <div class="text-sm">
                                <p>
                                    Valor: R$
                                    {{ totalComFrete.toFixed(2).replace('.', ',') }}
                                </p>
                                <p>
                                    Status:
                                    <span class="font-semibold">{{
                                        transacao?.pago ? 'Pago' : 'Pendente'
                                    }}</span>
                                </p>
                                <p v-if="transacao?.tipo">Tipo: {{ transacao.tipo }}</p>
                            </div>
                        </div>

                        <div
                            v-if="
                                authUser &&
                                authUser.id === compra.usuario_id &&
                                compra.estado === 'pendente'
                            "
                        >
                            <Button class="w-full" size="lg" @click="efetuarPagamento">
                                Efetuar pagamento (simulado)
                            </Button>
                        </div>
                        <div v-else class="text-sm text-gray-500">Pagamento indisponível.</div>

                        <Dialog>
                            <DialogTrigger as-child>
                                <Button variant="destructive" class="w-full"
                                    >Cancelar compra</Button
                                >
                            </DialogTrigger>
                            <DialogContent>
                                <DialogHeader>
                                    <DialogTitle>Confirmar cancelamento</DialogTitle>
                                    <DialogDescription
                                        >Tem certeza que deseja cancelar esta
                                        compra?</DialogDescription
                                    >
                                </DialogHeader>
                                <DialogFooter class="gap-2">
                                    <DialogClose as-child>
                                        <Button variant="secondary">Não</Button>
                                    </DialogClose>
                                    <Button
                                        variant="destructive"
                                        @click.prevent="
                                            router.post(route('pedido.cancelar', { id: compra.id }))
                                        "
                                        >Sim, cancelar</Button
                                    >
                                </DialogFooter>
                            </DialogContent>
                        </Dialog>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
