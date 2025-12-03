<script setup lang="ts">
import { Oferta } from '@/types/api';
import { router } from '@inertiajs/vue3';
import { Edit, Eye, Pause, Play, ShoppingCart } from 'lucide-vue-next';
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
const loading = ref(false);

function irParaOferta() {
    router.visit(route('oferta', { id: props.oferta.id }));
}

function editarOferta() {
    router.visit(route('anuncios.formulario', { editando: props.oferta.id }));
}

function alternarStatus() {
    if (loading.value) return;

    loading.value = true;
    const rota = props.oferta.ativo ? 'anuncios.desativar' : 'anuncios.ativar';

    router.post(
        route(rota, { id: props.oferta.id }),
        {},
        {
            onFinish: () => {
                loading.value = false;
            },
        },
    );
}

function getStatusClass() {
    if (props.oferta.bloqueado) {
        return 'bg-red-100 text-red-800';
    }
    return props.oferta.ativo ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
}

function getStatusText() {
    if (props.oferta.bloqueado) {
        return 'Bloqueada';
    }
    return props.oferta.ativo ? 'Ativa' : 'Inativa';
}
</script>

<template>
    <Card class="group relative w-auto gap-2 p-3">
        <div class="absolute top-3 right-3 z-10 space-y-1">
            <div>
                <span :class="getStatusClass()" class="rounded-full px-2 py-1 text-xs font-medium">
                    {{ getStatusText() }}
                </span>
            </div>
            <div v-if="props.oferta.compra_concluida" class="mt-1">
                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-800">Concluída (paga)</span>
            </div>
            <div v-else-if="props.oferta.em_compra" class="mt-1">
                <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs font-medium text-indigo-800">Em compra</span>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-4">
            <img
                :src="props.oferta.capa_url || 'https://via.placeholder.com/140x200'"
                alt="Capa do livro"
                class="w-36 h-48 object-cover rounded"
            />
        </div>

        <CardHeader class="px-0.5">
            <CardTitle class="text-sm leading-6 font-bold">
                {{ props.oferta.titulo }}
            </CardTitle>
            <CardDescription class="text-xs">
                {{ props.oferta.titulo_livro }} - {{ props.oferta.autor_livro }}
            </CardDescription>
        </CardHeader>

        <CardContent class="px-0.5">
            <p class="text-muted-foreground text-xs">Estado: {{ props.oferta.estado_livro }}</p>
            <p class="text-muted-foreground text-xs">
                Criado em: {{ new Date(props.oferta.created_at).toLocaleDateString('pt-BR') }}
            </p>
        </CardContent>

        <CardFooter class="flex justify-between px-0.5">
            <div class="flex w-full flex-col gap-2">
                <div class="flex w-full items-center justify-between">
                    <p class="font-bold text-emerald-500">R$ {{ props.oferta.preco }}</p>
                </div>
                <div class="flex w-full justify-end gap-2">
                    <Button variant="outline" size="sm" @click="irParaOferta" title="Ver oferta">
                        <Eye class="h-4 w-4" />
                    </Button>

                    <Button
                        v-if="props.oferta.em_compra"
                        variant="outline"
                        size="sm"
                        @click.prevent="
                            router.visit(route('anuncio.visualizar', { id: props.oferta.id }))
                        "
                        title="Ver compra deste anúncio"
                    >
                        <ShoppingCart class="h-4 w-4" />
                    </Button>

                    <Button
                        v-if="!props.oferta.bloqueado"
                        variant="outline"
                        size="sm"
                        @click="editarOferta"
                        title="Editar oferta"
                    >
                        <Edit class="h-4 w-4" />
                    </Button>

                    <Button
                        v-if="!props.oferta.bloqueado && !props.oferta.em_compra"
                        :variant="props.oferta.ativo ? 'destructive' : 'default'"
                        size="sm"
                        @click="alternarStatus"
                        :disabled="loading"
                        :title="props.oferta.ativo ? 'Desativar oferta' : 'Ativar oferta'"
                    >
                        <Pause v-if="props.oferta.ativo" class="h-4 w-4" />
                        <Play v-else class="h-4 w-4" />
                    </Button>
                </div>
            </div>
        </CardFooter>
    </Card>
</template>
