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
import usePesquisa from '@/composables/useFiltros';
import { SharedData } from '@/types';
import { Genero, Idioma } from '@/types/api';
import { useForm, usePage } from '@inertiajs/vue3';
import { Button } from '../ui/button';

interface Filtros {
    genero: string;
    idioma: string;
    estado: string;
    min: string;
    max: string;
    ordem: string;
    pesquisa: string;
}

interface Props extends SharedData {
    idiomas: Idioma[];
    generos: Genero[];
    estados: string[];
    filtros: Filtros;
}

const pesquisar = usePesquisa();
const page = usePage<Props>();
const { idiomas, generos, estados } = page.props;

const form = useForm({
    genero: page.props.filtros.genero,
    idioma: page.props.filtros.idioma,
    estado: page.props.filtros.estado,
    min: page.props.filtros.min,
    max: page.props.filtros.max,
    ordem: page.props.filtros.ordem,
});

const opcoesOrdem = [
    { id: 'preco_asc', nome: 'MENOR PREÇO' },
    { id: 'preco_desc', nome: 'MAIOR PREÇO' },
    { id: 'data_asc', nome: 'MAIS ANTIGOS' },
    { id: 'data_desc', nome: 'MAIS RECENTES' },
];

function submit() {
    pesquisar({
        genero: form.genero,
        idioma: form.idioma,
        estado: form.estado,
        min: form.min,
        max: form.max,
        ordem: form.ordem,
    });
}
</script>

<template>
    <Card class="sticky top-8">
        <CardHeader>
            <CardTitle>Filtros</CardTitle>
        </CardHeader>
        <CardContent>
            <form class="grid gap-4" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="ordem">Ordenar por</Label>
                    <Select v-model="form.ordem">
                        <SelectTrigger id="ordem" class="w-full">
                            <SelectValue placeholder="Selecione" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Ordenar por</SelectLabel>
                                <SelectItem
                                    v-for="opcao in opcoesOrdem"
                                    :key="opcao.id"
                                    :value="opcao.id"
                                >
                                    {{ opcao.nome }}
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
                                <SelectItem
                                    v-for="genero in generos"
                                    :key="genero.id"
                                    :value="String(genero.id)"
                                >
                                    {{ genero.nome }}
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
                                <SelectItem
                                    v-for="idioma in idiomas"
                                    :key="idioma.id"
                                    :value="String(idioma.id)"
                                >
                                    {{ idioma.nome }}
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
                                <SelectItem v-for="estado in estados" :key="estado" :value="estado">
                                    {{ estado.toUpperCase() }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid gap-2">
                        <Label for="preco_min">Preço mín.</Label>
                        <Input
                            id="preco_min"
                            type="number"
                            min="0"
                            v-model="form.min"
                            placeholder="Mínimo"
                        />
                    </div>
                    <div class="grid gap-2">
                        <Label for="preco_max">Preço máx.</Label>
                        <Input
                            id="preco_max"
                            type="number"
                            min="0"
                            v-model="form.max"
                            placeholder="Máximo"
                        />
                    </div>
                </div>
                <Button type="submit">Filtrar</Button>
            </form>
        </CardContent>
    </Card>
</template>
