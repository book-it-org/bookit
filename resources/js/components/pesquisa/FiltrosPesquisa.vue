<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
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
import { Genero, Idioma } from '@/types/api';
import { PageProps } from '@inertiajs/core';
import { useForm, usePage } from '@inertiajs/vue3';

interface Props extends PageProps {
    idiomas: Idioma[];
    generos: Genero[];
    estados: string[];
}

const page = usePage<Props>();
const params = new URLSearchParams(window.location.search);

const { idiomas, generos, estados } = page.props;

const form = useForm({
    ordem: params.get('ordem') || 'mais_relevante',
    genero: params.get('genero') || '*',
    idioma: params.get('idioma') || '*',
    estado: params.get('estado') || '*',
    data_lancamento: params.get('data_lancamento') || '',
    preco_min: params.get('preco_min') || '',
    preco_max: params.get('preco_max') || '',
});

const opcoesOrdem = [
    { id: 'mais_relevante', nome: 'MAIS RELEVANTE' },
    { id: 'menos_relevante', nome: 'MENOS RELEVANTE' },
    { id: 'recentes', nome: 'MAIS RECENTES' },
    { id: 'antigos', nome: 'MAIS ANTIGOS' },
];
</script>

<template>
    <Card class="sticky top-8">
        <CardHeader>
            <CardTitle>Filtros</CardTitle>
        </CardHeader>
        <CardContent>
            <div class="grid gap-4">
                <div class="grid gap-2">
                    <Label for="ordem">Ordenar por</Label>
                    <Select v-model="form.ordem">
                        <SelectTrigger id="ordem" class="w-full">
                            <SelectValue placeholder="Selecione" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Ordenar por</SelectLabel>
                                <SelectItem v-for="op in opcoesOrdem" :key="op.id" :value="op.id">
                                    {{ op.nome }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid gap-2">
                    <Label for="genero">Gênero</Label>
                    <Select v-model="form.genero">
                        <SelectTrigger id="genero" class="w-full">
                            <SelectValue placeholder="Selecione" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Gênero</SelectLabel>
                                <SelectItem value="*">Todos</SelectItem>
                                <SelectItem v-for="g in generos" :key="g.id" :value="g.id">
                                    {{ g.nome }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid gap-2">
                    <Label for="idioma">Idioma</Label>
                    <Select v-model="form.idioma">
                        <SelectTrigger id="idioma" class="w-full">
                            <SelectValue placeholder="Selecione" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Idioma</SelectLabel>
                                <SelectItem value="*">Todos</SelectItem>
                                <SelectItem v-for="i in idiomas" :key="i.id" :value="i.id">
                                    {{ i.nome }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid gap-2">
                    <Label for="estado">Estado</Label>
                    <Select v-model="form.estado">
                        <SelectTrigger id="estado" class="w-full">
                            <SelectValue placeholder="Selecione" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Estado</SelectLabel>
                                <SelectItem value="*">Todos</SelectItem>
                                <SelectItem v-for="e in estados" :key="e" :value="e">
                                    {{ e }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid gap-2">
                    <Label for="data_lancamento">Data de Lançamento</Label>
                    <Input
                        id="data_lancamento"
                        type="date"
                        v-model="form.data_lancamento"
                        placeholder="Data de lançamento"
                    />
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid gap-2">
                        <Label for="preco_min">Preço mín.</Label>
                        <Input
                            id="preco_min"
                            type="number"
                            min="0"
                            v-model="form.preco_min"
                            placeholder="Mínimo"
                        />
                    </div>
                    <div class="grid gap-2">
                        <Label for="preco_max">Preço máx.</Label>
                        <Input
                            id="preco_max"
                            type="number"
                            min="0"
                            v-model="form.preco_max"
                            placeholder="Máximo"
                        />
                    </div>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
