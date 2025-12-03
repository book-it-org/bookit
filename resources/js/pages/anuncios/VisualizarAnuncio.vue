<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Card from '@/components/ui/card/Card.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage<{ oferta: any, pedidos: any[] }>();
const oferta = computed(() => page.props.oferta || {});
const pedidos = computed(() => page.props.pedidos || []);

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
    <Head title="BookIt - Visualizar Anúncio (venda)" />
    <AppLayout>
        <div class="container mx-auto py-6">
            <Card class="p-4">
                <div class="flex items-start gap-4">
                    <img :src="oferta.capa_url || 'https://via.placeholder.com/140x200'" class="w-36 h-48 object-cover rounded" />
                    <div>
                        <h3 class="text-xl font-semibold">{{ oferta.titulo }}</h3>
                        <p class="text-sm text-neutral-600">{{ oferta.titulo_livro }} - {{ oferta.autor_livro }}</p>
                        <p class="mt-2 font-bold text-emerald-600">{{ formatoPreco(oferta.preco) }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h4 class="font-semibold mb-2">Pedidos relacionados</h4>
                    <div v-if="pedidos.length === 0" class="text-sm text-neutral-600">Nenhum pedido encontrado para este anúncio.</div>
                    <div v-else class="flex flex-col gap-4">
                        <div v-for="p in pedidos" :key="p.id" class="border rounded p-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-semibold">Pedido #{{ p.id }}</div>
                                    <div class="text-sm text-neutral-600">Comprador: {{ p.comprador?.nome || '-' }}</div>
                                    <div class="text-sm text-neutral-600">Estado: {{ p.estado }}</div>
                                <div v-if="p.endereco" class="text-sm text-neutral-600">Endereço de envio: {{ p.endereco.logradouro }}, {{ p.endereco.numero }}{{ p.endereco.complemento ? (' - ' + p.endereco.complemento) : '' }} - {{ p.endereco.cidade }} ({{ p.endereco.cep }})</div>
                                </div>
                                <div class="text-right">
                                    <div v-if="p.confirmacao_recebimento" class="text-sm text-green-600">Confirmado: {{ formatarData(p.confirmado_recebimento_at) }}</div>
                                    <div v-else class="text-sm text-yellow-600">Aguardando confirmação</div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div v-for="c in p.compras || []" :key="c.id" class="text-sm text-neutral-600">
                                    Compra #{{ c.id }} - {{ c.estado }} - {{ formatarData(c.data_compra) }}
                                </div>
                            </div>
                            <div class="mt-3" v-if="p.avaliacao">
                                <h5 class="font-semibold text-sm">Avaliação recebida</h5>
                                <div class="text-sm text-neutral-700">Nota: <strong>{{ p.avaliacao.nota }}/5</strong></div>
                                <div v-if="p.avaliacao.comentario" class="text-sm text-neutral-600 mt-1">"{{ p.avaliacao.comentario }}"</div>
                            </div>
                        </div>
                    </div>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>
