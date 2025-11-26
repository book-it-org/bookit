<script setup lang="ts">
import { Oferta } from '@/types/api';
import { router } from '@inertiajs/vue3';
import { Edit, Eye, Pause, Play } from 'lucide-vue-next';
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
        <div class="absolute top-3 right-3 z-10">
            <span :class="getStatusClass()" class="rounded-full px-2 py-1 text-xs font-medium">
                {{ getStatusText() }}
            </span>
        </div>

        <div class="rounded-2xl bg-white p-4">
            <img
                src="https://images-americanas.b2w.io/produtos/3518714892/imagens/usado-percy-jackson-o-mar-de-monstros-livro-dois/3518714892_1_large.jpg"
                alt=""
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
            <p class="font-bold text-yellow-500">3,5/5</p>
            <p class="font-bold text-emerald-500">R$ {{ props.oferta.preco }}</p>
            <div class="flex gap-2">
                <Button variant="outline" size="sm" @click="irParaOferta" title="Ver oferta">
                    <Eye class="h-4 w-4" />
                </Button>

                <Button
                    v-if="!oferta.bloqueado"
                    variant="outline"
                    size="sm"
                    @click="editarOferta"
                    title="Editar oferta"
                >
                    <Edit class="h-4 w-4" />
                </Button>

                <Button
                    v-if="!oferta.bloqueado"
                    :variant="oferta.ativo ? 'destructive' : 'default'"
                    size="sm"
                    @click="alternarStatus"
                    :disabled="loading"
                    :title="oferta.ativo ? 'Desativar oferta' : 'Ativar oferta'"
                >
                    <Pause v-if="oferta.ativo" class="h-4 w-4" />
                    <Play v-else class="h-4 w-4" />
                </Button>
            </div>
        </CardFooter>
    </Card>
</template>
