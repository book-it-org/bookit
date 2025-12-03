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
import { SharedData } from '@/types';
import { Genero, Idioma, Oferta } from '@/types/api';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

interface PageProps extends SharedData {
    idiomas: Idioma[];
    generos: Genero[];
    estados: string[];
    oferta?: Oferta;
    editando: boolean;
}

const page = usePage<PageProps>();
const props = computed(() => page.props);
const idiomas = computed(() => props.value.idiomas || []);
const generos = computed(() => props.value.generos || []);
const estados = computed(() => props.value.estados || []);

const passo = ref(1);
const editando = computed(() => props.value.editando);
const ofertaParaEditar = computed(() => props.value.oferta);

const form = useForm({
    titulo_livro: editando.value ? (ofertaParaEditar.value?.titulo_livro || '') : '',
    autor_livro: editando.value ? (ofertaParaEditar.value?.autor_livro || '') : '',
    estado_livro: editando.value ? (ofertaParaEditar.value?.estado_livro || '') : '',
    generos_id: editando.value ? (ofertaParaEditar.value?.generos?.[0]?.id || 1) : 1,
    isbn_livro: editando.value ? (ofertaParaEditar.value?.isbn_livro || '') : '',
    idiomas_id: editando.value ? (ofertaParaEditar.value?.idiomas_id || 1) : 1,
    data_publicacao_livro: editando.value ? (ofertaParaEditar.value?.data_publicacao_livro || '') : '',
    titulo: editando.value ? (ofertaParaEditar.value?.titulo || '') : '',
    editora: editando.value ? (ofertaParaEditar.value?.editora || '') : '',
    descricao: editando.value ? (ofertaParaEditar.value?.descricao || '') : '',
    preco: editando.value ? String(ofertaParaEditar.value?.preco || '') : '',
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
    if (passo.value < 3 && !editando.value) {
        passo.value++;
        return;
    }

    if (editando.value && ofertaParaEditar.value) {
        // editar oferta
        form.put(route('oferta.editar', { id: ofertaParaEditar.value.id }), {
            onError: (errors: Record<string, any>) => {
                determineStepFromErrors(errors);
            },
        });
    } else {
        // criar oferta
        form.post(route('oferta.criar'), {
            onError: (errors: Record<string, any>) => {
                determineStepFromErrors(errors);
            },
        });
    }
};

function determineStepFromErrors(errors: Record<string, any> | null) {
    if (!errors) return;
    const step1Fields = [
        'titulo_livro',
        'autor_livro',
        'estado_livro',
        'idiomas_id',
        'generos_id',
        'data_publicacao_livro',
        'isbn_livro',
        'editora',
    ];

    const step2Fields = [
        'titulo',
        'descricao',
        'preco',
        'imagens',
    ];

    const keys = Object.keys(errors || {});
    for (const k of keys) {
        if (step1Fields.includes(k)) {
            passo.value = 1;
            return;
        }
    }
    for (const k of keys) {
        if (step2Fields.includes(k)) {
            passo.value = 2;
            return;
        }
    }
}

// se estiver editando, pula direto para o passo 2 (informações da oferta)
watch(editando, (novoValor) => {
    if (novoValor) {
        passo.value = 2;
    }
}, { immediate: true });
</script>

<template>
    <Head :title="editando ? 'BookIt - Editar oferta' : 'BookIt - Anunciar oferta'" />
    <AnunciarLayout :passo="passo">
        <form @submit.prevent="submit" class="grid gap-6">
            <div class="grid gap-6 sm:grid-cols-2">
                <template v-if="passo === 1 && !editando">
                    <div class="grid grid-cols-2 gap-4 sm:col-span-2">
                        <div class="grid gap-2">
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
                            <Label for="editora">Editora</Label>
                            <Input
                                id="editora"
                                type="text"
                                :tabindex="2"
                                v-model="form.editora"
                                placeholder="Companhia das Letras"
                            />
                            <InputError :message="form.errors.editora" />
                        </div>
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
                                        {{ e.toUpperCase() }}
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
                            maxlength="13"
                            inputmode="numeric"
                            pattern="[0-9-]+"
                            :tabindex="7"
                            v-model="form.isbn_livro"
                            placeholder="9783161484100"
                        />
                        <InputError :message="form.errors.isbn_livro" />
                    </div>
                </template>

                <!-- campos não editáveis quando está editando -->
                <template v-else-if="passo === 2">
                    <template v-if="editando">
                        <div class="col-span-2 mb-4">
                            <h3 class="text-lg font-semibold mb-2">Informações do Livro (não editáveis)</h3>
                            <div class="grid grid-cols-2 gap-4 p-4 bg-neutral-50 rounded-lg">
                                <div>
                                    <Label>Título do Livro</Label>
                                    <p class="font-medium">{{ form.titulo_livro }}</p>
                                </div>
                                <div>
                                    <Label>Autor</Label>
                                    <p class="font-medium">{{ form.autor_livro }}</p>
                                </div>
                                <div>
                                    <Label>Estado</Label>
                                    <p class="font-medium">{{ form.estado_livro.toUpperCase() }}</p>
                                </div>
                                <div>
                                    <Label>Gênero</Label>
                                    <p class="font-medium">
                                        {{ generos.find(g => g.id === form.generos_id)?.nome || 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- campos editáveis -->
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
                            step="0.01"
                            placeholder="50"
                        />
                        <InputError :message="form.errors.preco" />
                    </div>
                    <div v-if="!editando" class="col-span-2 grid gap-2">
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

                <template v-else-if="passo === 3 && !editando">
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
                            <div class="col-span-2 grid gap-2">
                                <Label for="editora">Editora</Label>
                                <Input
                                    id="editora"
                                    type="text"
                                    :model-value="form.editora"
                                    disabled
                                />
                            </div>
                            <div class="grid gap-2">
                                <Label for="estado_livro">Estado</Label>
                                <Input
                                    id="estado_livro"
                                    type="text"
                                    :model-value="form.estado_livro"
                                    disabled
                                />
                            </div>
                            <div class="grid gap-2">
                                <Label for="generos_id">Gênero</Label>
                                <Input
                                    id="generos_id"
                                    type="text"
                                    :model-value="generos.find(g => g.id === form.generos_id)?.nome || 'N/A'"
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
                                <p v-else class="text-muted-foreground">Nenhuma imagem selecionada</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex justify-between">
                <Button
                    type="button"
                    variant="outline"
                    @click="passo > 1 ? passo-- : null"
                    :disabled="passo === 1 || (editando && passo === 2)"
                >
                    Voltar
                </Button>
                <Button type="submit" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                    <span v-if="editando">
                        Salvar alterações
                    </span>
                    <span v-else-if="passo < 3">
                        Continuar
                    </span>
                    <span v-else>
                        Anunciar livro
                    </span>
                </Button>
            </div>
        </form>
    </AnunciarLayout>
</template>
