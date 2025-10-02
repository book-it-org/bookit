<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Endereco } from '@/types/api';
import { router } from '@inertiajs/vue3';
import { MapPinHouse, Trash2Icon } from 'lucide-vue-next';
import Button from '../ui/button/Button.vue';

interface Props {
    endereco: Endereco;
}

const props = defineProps<Props>();

const excluir = () => {
    router.delete(route('endereco.excluir', { id: props.endereco.id }));
};
</script>

<template>
    <Card>
        <CardHeader class="flex items-center justify-between">
            <div class="flex items-center">
                <MapPinHouse class="mr-2 h-4 w-4" />
                <CardTitle>{{ endereco.logradouro }} - {{ endereco.numero }}</CardTitle>
            </div>
            <Button size="icon" variant="destructive" @click="excluir">
                <Trash2Icon />
            </Button>
        </CardHeader>
        <CardContent>
            <CardDescription>
                <span>
                    {{ endereco.cidade }}, {{ endereco.estado.nome }}, CEP {{ endereco.cep }}
                </span>
            </CardDescription>
            <CardDescription>
                <span>{{ endereco.complemento }}</span>
            </CardDescription>
        </CardContent>
    </Card>
</template>
