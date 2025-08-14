<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { MapPinHouse, Trash2Icon } from 'lucide-vue-next';
import Button from '../ui/button/Button.vue';
import { Endereco } from '@/types/api';

interface Props {
    endereco: Endereco;
}

defineProps<Props>();
</script>

<template>
    <Card>
        <CardHeader class="flex items-center justify-between">
            <div class="flex items-center">
                <MapPinHouse class="mr-2 h-4 w-4" />
                <CardTitle>{{ endereco.logradouro}} - {{ endereco.numero}}</CardTitle>
            </div>
            <Button size="icon" variant="destructive">
                <Trash2Icon />
            </Button>
        </CardHeader>
        <CardContent>
            <CardDescription>
                <span>{{endereco.cidade}}, {{ endereco.estado.nome }}, CEP {{endereco.cep}}</span>
            </CardDescription>
            <CardDescription>
                <span>{{ endereco.complemento}}</span>
            </CardDescription>
        </CardContent>
    </Card>
</template>
