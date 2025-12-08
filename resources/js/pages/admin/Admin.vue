<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData } from '@/types';
import { usePage, useForm, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

interface Oferta {
    id: number;
    titulo: string;
    titulo_livro: string;
    autor_livro: string;
    preco: number;
    capa_url: string;
    bloqueado: boolean;
    created_at: string;
    usuario?: {
        nome: string;
        email: string;
    };
    genero?: {
        nome: string;
    };
    idioma?: {
        nome: string;
    };
}

interface Props {
    limpo?: boolean;
    ofertasBloqueadas: Oferta[];
    placeholderUrl: string | null;
}

interface PageProps extends SharedData {
    ofertasBloqueadas: Oferta[];
    placeholderUrl: string | null;
}

const page = usePage<PageProps>();
const props = defineProps<Props>();

const auth = computed(() => page.props.auth);
const placeholderFile = ref<File | null>(null);
const placeholderPreview = ref<string | null>(props.placeholderUrl);
const uploadingPlaceholder = ref(false);

const handlePlaceholderChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        placeholderFile.value = file;

        // Criar preview
        const reader = new FileReader();
        reader.onload = (e) => {
            placeholderPreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const uploadPlaceholder = () => {
    if (!placeholderFile.value) return;

    uploadingPlaceholder.value = true;

    const formData = new FormData();
    formData.append('placeholder', placeholderFile.value);

    router.post(route('admin.placeholder'), formData, {
        onSuccess: () => {
            placeholderFile.value = null;
            uploadingPlaceholder.value = false;
        },
        onError: () => {
            uploadingPlaceholder.value = false;
        },
    });
};

const desbloquearOferta = (id: number) => {
    if (confirm('Deseja realmente desbloquear esta oferta?')) {
        router.post(route('admin.desbloquear', id), {}, {
            preserveScroll: true,
        });
    }
};

const formatPreco = (preco: number) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(preco);
};
</script>

<template>
    <Head title="Administração" />
    <AppLayout header-limpo>
        <div class="container mx-auto px-4 py-8 space-y-8">
            <!-- Seção de Upload do Placeholder -->
            <Card>
                <CardHeader>
                    <CardTitle>Placeholder de Oferta</CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div class="space-y-2">
                        <Label for="placeholder">Imagem Placeholder (JPG)</Label>
                        <Input
                            id="placeholder"
                            type="file"
                            accept="image/jpeg,image/jpg"
                            @change="handlePlaceholderChange"
                        />
                        <p class="text-sm text-muted-foreground">
                            A imagem será salva como placeholder.jpg na pasta ofertas
                        </p>
                    </div>

                    <div v-if="placeholderPreview" class="space-y-2">
                        <Label>Preview</Label>
                        <img
                            :src="placeholderPreview"
                            alt="Placeholder preview"
                            class="max-w-xs rounded-lg border"
                        />
                    </div>

                    <Button
                        @click="uploadPlaceholder"
                        :disabled="!placeholderFile || uploadingPlaceholder"
                    >
                        {{ uploadingPlaceholder ? 'Enviando...' : 'Upload Placeholder' }}
                    </Button>
                </CardContent>
            </Card>

            <!-- Seção de Ofertas Bloqueadas -->
            <Card>
                <CardHeader>
                    <CardTitle>Ofertas Bloqueadas</CardTitle>
                </CardHeader>
                <CardContent>
                    <div v-if="props.ofertasBloqueadas.length === 0" class="text-center py-8 text-muted-foreground">
                        Nenhuma oferta bloqueada no momento
                    </div>

                    <div v-else class="space-y-4">
                        <div
                            v-for="oferta in props.ofertasBloqueadas"
                            :key="oferta.id"
                            class="border rounded-lg p-4 space-y-3"
                        >
                            <div class="flex gap-4">
                                <img
                                    v-if="oferta.capa_url"
                                    :src="oferta.capa_url"
                                    :alt="oferta.titulo_livro"
                                    class="w-20 h-28 object-cover rounded"
                                />
                                <div class="flex-1 space-y-2">
                                    <div>
                                        <h3 class="font-semibold text-lg">{{ oferta.titulo }}</h3>
                                        <p class="text-sm text-muted-foreground">
                                            {{ oferta.titulo_livro }} - {{ oferta.autor_livro }}
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div>
                                            <span class="font-medium">Preço:</span>
                                            {{ formatPreco(oferta.preco) }}
                                        </div>
                                        <div v-if="oferta.genero">
                                            <span class="font-medium">Gênero:</span>
                                            {{ oferta.genero.nome }}
                                        </div>
                                        <div v-if="oferta.idioma">
                                            <span class="font-medium">Idioma:</span>
                                            {{ oferta.idioma.nome }}
                                        </div>
                                        <div v-if="oferta.usuario">
                                            <span class="font-medium">Vendedor:</span>
                                            {{ oferta.usuario.nome }}
                                        </div>
                                    </div>

                                    <div class="flex gap-2 pt-2">
                                        <Button
                                            size="sm"
                                            @click="desbloquearOferta(oferta.id)"
                                        >
                                            Desbloquear
                                        </Button>
                                        <Button
                                            size="sm"
                                            variant="outline"
                                            as="a"
                                            :href="route('oferta', { id: oferta.id, titulo_oferta: oferta.titulo })"
                                            target="_blank"
                                        >
                                            Visitar Oferta
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
