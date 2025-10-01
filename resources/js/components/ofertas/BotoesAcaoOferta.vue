<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Heading from '../Heading.vue';
import { Button } from '../ui/button';
import { Separator } from '../ui/separator';

interface Props {
    ofertaId: number;
    ativo: boolean;
    bloqueado: boolean;
    permissoes?: {
        podeGerenciar: boolean;
        admin: boolean;
        dono: boolean;
        podeAtivar: boolean;
    };
}

const props = withDefaults(defineProps<Props>(), {
    permissoes: () => ({
        podeGerenciar: false,
        admin: false,
        dono: false,
        podeAtivar: false,
    }),
});

const loading = ref(false);

const desativarOferta = () => {
    if (loading.value) return;

    loading.value = true;
    router.post(
        route('anuncios.desativar', { id: props.ofertaId }),
        {},
        {
            onFinish: () => {
                loading.value = false;
            },
        },
    );
};

const ativarOferta = () => {
    if (loading.value) return;

    loading.value = true;
    router.post(
        route('anuncios.ativar', { id: props.ofertaId }),
        {},
        {
            onFinish: () => {
                loading.value = false;
            },
        },
    );
};

const bloquearOferta = () => {
    if (loading.value) return;

    loading.value = true;
    router.post(
        route('anuncios.bloquear', { id: props.ofertaId }),
        {},
        {
            onFinish: () => {
                loading.value = false;
            },
        },
    );
};

const desbloquearOferta = () => {
    if (loading.value) return;

    loading.value = true;
    router.post(
        route('anuncios.desbloquear', { id: props.ofertaId }),
        {},
        {
            onFinish: () => {
                loading.value = false;
            },
        },
    );
};
</script>

<template>
    <div v-if="permissoes.podeGerenciar" class="flex flex-col gap-4 md:col-span-2">
        <Heading title="Gerenciar oferta" />

        <div class="flex items-center gap-2">
            <span class="font-medium">Status da oferta:</span>
            <span
                :class="{
                    'bg-green-100 text-green-800': ativo && !bloqueado,
                    'bg-yellow-100 text-yellow-800': !ativo && !bloqueado,
                    'text-destructive bg-red-100': bloqueado,
                }"
                class="rounded-full px-2 py-1 text-center text-xs font-medium"
            >
                <span v-if="bloqueado">Bloqueada</span>
                <span v-else-if="ativo">Ativa</span>
                <span v-else>Inativa</span>
            </span>
        </div>

        <div v-if="permissoes.dono && !bloqueado">
            <Button
                v-if="ativo"
                @click="desativarOferta"
                :disabled="loading"
                class="w-full md:w-auto"
            >
                {{ loading ? 'Processando...' : 'Desativar oferta' }}
            </Button>

            <Button
                v-if="!ativo && permissoes.podeAtivar"
                @click="ativarOferta"
                :disabled="loading"
                class="w-full md:w-auto"
            >
                {{ loading ? 'Processando...' : 'Ativar oferta' }}
            </Button>
        </div>

        <div v-if="permissoes.admin">
            <Button
                v-if="!bloqueado"
                @click="bloquearOferta"
                :disabled="loading"
                class="w-full md:w-auto"
            >
                {{ loading ? 'Processando...' : 'Bloquear oferta' }}
            </Button>

            <Button
                v-if="bloqueado"
                @click="desbloquearOferta"
                :disabled="loading"
                class="w-full md:w-auto"
            >
                {{ loading ? 'Processando...' : 'Desbloquear oferta' }}
            </Button>
        </div>

        <p v-if="bloqueado" class="text-destructive">
            Esta oferta foi bloqueada por um administrador e não pode ser ativada pelo proprietário.
        </p>
    </div>

    <Separator v-if="permissoes.podeGerenciar" class="md:col-span-2" />
</template>
