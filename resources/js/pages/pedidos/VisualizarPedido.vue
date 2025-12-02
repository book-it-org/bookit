<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Card from '@/components/ui/card/Card.vue';
import Button from '@/components/ui/button/Button.vue';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    Dialog,
    DialogTrigger,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
    DialogClose,
} from '@/components/ui/dialog';

interface CompraProps {
    id: number;
    usuario_id?: number;
    data_compra?: string | null;
    preco_total?: number | null;
    estado?: string;
    pedidos?: any[];
}

const page = usePage<{ compra: CompraProps }>();
const compra = computed(() => page.props.compra || {} as CompraProps);
const authUser = computed(() => (page.props as any).auth?.user || null);

function formatoPreco(v: number | null | undefined) {
    if (v === null || v === undefined) return '-';
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v);
}

function formatarData(d: string | undefined | null) {
    if (!d) return '-';
    return new Date(d).toLocaleString('pt-BR');
}
</script>

<template>
    <Head title="BookIt - Visualizar Pedido" />
    <AppLayout>
        <div class="container mx-auto py-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <Card class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold">Compra #{{ compra.id }}</h3>
                                    <span v-if="compra.estado === 'cancelado'" class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded">CANCELADA</span>
                                    <span v-else-if="compra.estado === 'pago'" class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-emerald-100 text-emerald-800 rounded">PAGA</span>
                                    <span v-else class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">{{ compra.estado }}</span>
                                </div>
                                <p class="text-sm text-gray-500">Data: {{ formatarData(compra.data_compra) }}</p>
                                <p class="text-sm text-gray-500">Estado: <span class="font-medium">{{ compra.estado }}</span></p>
                            </div>
                                <div class="text-right">
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="text-xl font-bold text-emerald-600">{{ formatoPreco(compra.preco_total) }}</p>
                                <div class="flex justify-end gap-2 mt-2">
                                    <div v-if="authUser && authUser.id === compra.usuario_id && compra.estado === 'pendente'">
                                        <Link :href="route('pedido.pagar', { id: compra.id })">
                                            <Button>Ir para pagamento</Button>
                                        </Link>
                                    </div>
                                    <div v-if="authUser && authUser.id === compra.usuario_id && compra.estado === 'pendente'">
                                        <Dialog>
                                            <DialogTrigger as-child>
                                                <Button variant="destructive">Cancelar compra</Button>
                                            </DialogTrigger>
                                            <DialogContent>
                                                <DialogHeader>
                                                    <DialogTitle>Confirmar cancelamento</DialogTitle>
                                                    <DialogDescription>Tem certeza que deseja cancelar esta compra?</DialogDescription>
                                                </DialogHeader>
                                                <DialogFooter class="gap-2">
                                                    <DialogClose as-child>
                                                        <Button variant="secondary">Não</Button>
                                                    </DialogClose>
                                                    <Button variant="destructive" @click.prevent="router.post(route('pedido.cancelar', { id: compra.id }))">Sim, cancelar</Button>
                                                </DialogFooter>
                                            </DialogContent>
                                        </Dialog>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 border-t pt-4">
                            <h4 class="font-semibold mb-2">Itens</h4>
                            <div class="flex flex-col gap-4">
                                <div v-for="pedido in compra.pedidos || []" :key="pedido.id" class="flex gap-4 items-start">
                                    <img :src="pedido.oferta?.capa_url || 'https://via.placeholder.com/100x140'" class="w-24 h-32 object-cover rounded" />
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <div class="font-semibold">{{ pedido.oferta?.titulo || pedido.oferta?.titulo_livro }}</div>
                                                <div class="text-sm text-gray-600">{{ pedido.oferta?.autor_livro }}</div>
                                                <div class="text-sm text-gray-500">Vendedor: {{ pedido.vendedor?.nome || '-' }}</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm text-emerald-600">{{ formatoPreco(pedido.oferta?.preco ?? null) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </Card>
                </div>

                <div>
                    <Card class="p-4">
                        <h4 class="font-semibold mb-2">Resumo</h4>
                        <div class="text-sm text-gray-600">
                            <p>ID: {{ compra.id }}</p>
                            <p>Data: {{ formatarData(compra.data_compra) }}</p>
                            <p>Estado: {{ compra.estado }}</p>
                            <p class="mt-2 font-semibold">Total: {{ formatoPreco(compra.preco_total) }}</p>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
