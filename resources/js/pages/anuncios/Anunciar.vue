<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
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
import { Textarea } from '@/components/ui/textarea';
import AnunciarLayout from '@/layouts/anuncios/AnunciarLayout.vue';
import { Genero, Idioma } from '@/types/api';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    idiomas: Idioma[];
    generos: Genero[];
    estados: string[];
}

defineProps<Props>();

const passo = ref(1);

const form = useForm({
    titulo_livro: 'dsadas',
    autor_livro: 'dasdsadas',
    estado_livro: 'usado',
    generos_id: '1',
    isbn_livro: '1233161474100',
    idiomas_id: '1',
    data_publicacao_livro: '2023-01-01',
    titulo: 'dasnkdsa',
    descricao: 'dasldsaad',
    preco: '50',
    imagens: [] as File[],
});

const imagensPreview = ref<string[]>([]);

function handleImagensChange(e: Event) {
    const files = (e.target as HTMLInputElement).files;
    if (!files) return;
    form.imagens = Array.from(files);
    imagensPreview.value = Array.from(files).map((file) => URL.createObjectURL(file));
}

const submit = () => {
    if (passo.value < 3) {
        passo.value++;
        return;
    }

    form.post(route('oferta.criar'), {

       
    });
};
</script>

<template>
    <Head title="BookIt - Anunciar oferta" />
    <AnunciarLayout :passo="passo">
        <form @submit.prevent="submit" class="grid gap-6">
            <div class="grid grid-cols-2 gap-6">
                <template v-if="passo === 1">
                    <div class="col-span-2 grid gap-2">
                        <Label for="titulo">Título do Livro</Label>
                        <Input
                            id="titulo"
                            type="text"
                            required
                            autofocus
                            :tabindex="1"
                            v-model="form.titulo_livro"
                            placeholder="Percy Jackson e o Ladrão de Raios"
                        />
                        <InputError :message="form.errors.titulo_livro" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="nome">Autor</Label>
                        <Input
                            id="nome"
                            type="text"
                            required
                            :tabindex="2"
                            v-model="form.autor_livro"
                            placeholder="Rick Riordan"
                        />
                        <InputError :message="form.errors.autor_livro" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="estado_livro">Estado</Label>
                        <Select v-model="form.estado_livro">
                            <SelectTrigger class="w-full" name="estado_livro" :tabindex="3">
                                <SelectValue :placeholder="'Selecione'" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Estado</SelectLabel>
                                    <SelectItem v-for="e in estados" :key="e" :value="e">
                                        {{ e }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.estado_livro" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="idiomas_id">Idioma</Label>
                        <Select v-model="form.idiomas_id">
                            <SelectTrigger class="w-full" name="idiomas_id" :tabindex="4">
                                <SelectValue :placeholder="'Selecione'" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Idioma</SelectLabel>
                                    <SelectItem v-for="i in idiomas" :key="i.id" :value="i.id"
                                        >{{ i.nome }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.idiomas_id" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="generos_id">Gênero</Label>
                        <Select v-model="form.generos_id">
                            <SelectTrigger class="w-full" name="generos_id" :tabindex="5">
                                <SelectValue :placeholder="'Selecione'" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Gênero</SelectLabel>
                                    <SelectItem v-for="g in generos" :key="g.id" :value="g.id"
                                        >{{ g.nome }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.generos_id" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="data_publicacao_livro">Data de Publicação</Label>
                        <Input
                            id="data_publicacao_livro"
                            type="date"
                            required
                            :tabindex="6"
                            v-model="form.data_publicacao_livro"
                        />
                        <InputError :message="form.errors.data_publicacao_livro" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="isbn_livro">ISBN</Label>
                        <Input
                            id="isbn_livro"
                            type="text"
                            required
                            :tabindex="7"
                            v-model="form.isbn_livro"
                            placeholder="978-3-16-148410-0"
                        />
                        <InputError :message="form.errors.isbn_livro" />
                    </div>
                </template>

                <template v-else-if="passo === 2">
                    <div class="col-span-2 grid gap-2">
                        <Label for="titulo">Título da Oferta</Label>
                        <Input
                            id="titulo"
                            type="text"
                            required
                            :tabindex="8"
                            v-model="form.titulo"
                            placeholder="Livro Percy Jackson e o Ladrão de Raios em ótimo estado pouco usado"
                        />
                        <InputError :message="form.errors.titulo" />
                    </div>
                    <div class="col-span-2 grid gap-2">
                        <Label for="descricao">Descrição da Oferta</Label>
                        <Textarea
                            id="descricao"
                            required
                            :tabindex="9"
                            v-model="form.descricao"
                            placeholder="Livro em ótimo estado, pouco usado, perfeito para fãs de fantasia e aventura. Entrego via correios ou pessoalmente na região."
                        />
                        <InputError :message="form.errors.descricao" />
                    </div>
                    <div class="col-span-2 grid gap-2">
                        <Label for="preco">Preço</Label>
                        <Input
                            id="preco"
                            type="number"
                            required
                            :tabindex="10"
                            v-model="form.preco"
                            placeholder="R$ 50,00"
                        />
                        <InputError :message="form.errors.preco" />
                    </div>
                    <div class="col-span-2 grid gap-2">
                        <Label for="imagens">Imagens</Label>
                        <Input
                            id="imagens"
                            type="file"
                            multiple
                            accept="image/*"
                            :tabindex="11"
                            @change="handleImagensChange"
                        />
                        <div class="mt-2 flex gap-2" v-if="imagensPreview.length">
                            <img
                                v-for="(img, i) in imagensPreview"
                                :key="i"
                                :src="img"
                                class="h-20 w-20 rounded object-cover"
                            />
                        </div>
                        <InputError :message="form.errors.imagens" />
                    </div>
                </template>

                <template v-else-if="passo === 3">
                    <div class="col-span-2 grid gap-2">
                        <h2 class="mb-2 text-lg font-bold">Confirme seus dados</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-2 grid gap-2">
                                <Label for="titulo_livro">Título do Livro</Label>
                                <Input
                                    id="titulo_livro"
                                    type="text"
                                    :model-value="form.titulo_livro"
                                    disabled
                                />
                            </div>
                            <div class="col-span-2 grid gap-2">
                                <Label for="autor_livro">Autor</Label>
                                <Input
                                    id="autor_livro"
                                    type="text"
                                    :model-value="form.autor_livro"
                                    disabled
                                />
                            </div>
                            <div class="grid gap-2">
                                <Label for="estado_livro">Estado</Label>
                                <Input
                                    id="estado_livro"
                                    type="text"
                                    :model-value="
                                        estados.find((e) => e.value === form.estado_livro)?.label
                                    "
                                    disabled
                                />
                            </div>
                            <div class="grid gap-2">
                                <Label for="generos_id">Gênero</Label>
                                <Input
                                    id="generos_id"
                                    type="text"
                                    :model-value="
                                        generos.find((g) => g.value === form.generos_id)?.label
                                    "
                                    disabled
                                />
                            </div>
                            <div class="grid gap-2">
                                <Label for="data_publicacao_livro">Data de Publicação</Label>
                                <Input
                                    id="data_publicacao_livro"
                                    type="date"
                                    :model-value="form.data_publicacao_livro"
                                    disabled
                                />
                            </div>
                            <div class="grid gap-2">
                                <Label for="isbn_livro">ISBN</Label>
                                <Input
                                    id="isbn_livro"
                                    type="text"
                                    :model-value="form.isbn_livro"
                                    disabled
                                />
                            </div>
                            <div class="col-span-2 grid gap-2">
                                <Label for="titulo">Título da Oferta</Label>
                                <Input
                                    id="titulo"
                                    type="text"
                                    :model-value="form.titulo"
                                    disabled
                                />
                            </div>
                            <div class="col-span-2 grid gap-2">
                                <Label for="descricao">Descrição do Livro</Label>
                                <Input
                                    id="descricao"
                                    type="text"
                                    :model-value="form.descricao"
                                    disabled
                                />
                            </div>
                            <div class="col-span-2 grid gap-2">
                                <Label for="preco">Preço</Label>
                                <Input
                                    id="preco"
                                    type="number"
                                    :model-value="form.preco"
                                    disabled
                                />
                            </div>
                            <div class="col-span-2 grid gap-2">
                                <Label>Imagens</Label>
                                <div class="mt-2 flex gap-2" v-if="imagensPreview.length">
                                    <img
                                        v-for="(img, i) in imagensPreview"
                                        :key="i"
                                        :src="img"
                                        class="h-20 w-20 rounded object-cover"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <div class="col-span-2 grid grid-cols-2 gap-8">
                    <Button
                        @click="passo--"
                        class="mt-2 w-full"
                        :tabindex="20"
                        type="button"
                        :disabled="form.processing || passo === 1"
                    >
                        Retornar
                    </Button>
                    <Button
                        type="submit"
                        class="mt-2 w-full"
                        :tabindex="21"
                        :disabled="form.processing"
                    >
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        {{ passo === 3 ? 'Anunciar' : 'Avançar' }}
                    </Button>
                </div>
            </div>
        </form>
    </AnunciarLayout>
</template>
