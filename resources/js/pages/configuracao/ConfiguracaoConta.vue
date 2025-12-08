<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Separator } from '@/components/ui/separator';
import { Star, StarHalf, Mail, Phone, Calendar, User } from 'lucide-vue-next';

interface Comprador {
    nome: string;
    sobrenome: string;
    nome_usuario: string;
}

interface Avaliacao {
    id: number;
    nota: number;
    comentario: string;
    data: string;
    comprador: Comprador;
}

interface Usuario {
    nome: string;
    sobrenome: string;
    nome_usuario: string;
    email: string;
    telefone: string;
    data_nascimento: string;
}

interface PageProps {
    usuario: Usuario;
    media_avaliacoes: number;
    total_avaliacoes: number;
    avaliacoes: Avaliacao[];
}

const page = usePage<PageProps>();
const usuario = computed(() => page.props.usuario);
const media = computed(() => page.props.media_avaliacoes ?? 0);
const total = computed(() => page.props.total_avaliacoes ?? 0);
const avaliacoes = computed(() => page.props.avaliacoes ?? []);

const getIniciais = (nome: string, sobrenome: string) => {
    return `${nome?.[0] || ''}${sobrenome?.[0] || ''}`.toUpperCase();
};

const renderEstrelas = (nota: number) => {
    const estrelas = [];
    const notaInteira = Math.floor(nota);
    const temMeia = nota % 1 >= 0.5;

    for (let i = 0; i < notaInteira; i++) {
        estrelas.push({ tipo: 'cheia', key: `star-${i}` });
    }

    if (temMeia && notaInteira < 5) {
        estrelas.push({ tipo: 'meia', key: `star-half` });
    }

    const vazias = 5 - estrelas.length;
    for (let i = 0; i < vazias; i++) {
        estrelas.push({ tipo: 'vazia', key: `star-empty-${i}` });
    }

    return estrelas;
};

const formatarData = (data: string) => {
    return data;
};
</script>

<template>
    <Head title="BookIt - Minha Conta" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4 md:p-8">
            <!-- Título da página -->
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Minha Conta</h1>
                <p class="text-muted-foreground mt-1">Gerencie suas informações pessoais e veja suas avaliações</p>
            </div>

            <!-- Grid de Cards -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Card de Informações Pessoais -->
                <Card class="col-span-1">
                    <CardHeader>
                        <div class="flex items-start gap-4">
                            <Avatar class="size-16">
                                <AvatarImage :src="`https://api.dicebear.com/7.x/initials/svg?seed=${usuario?.nome} ${usuario?.sobrenome}`" />
                                <AvatarFallback class="text-lg">
                                    {{ getIniciais(usuario?.nome || '', usuario?.sobrenome || '') }}
                                </AvatarFallback>
                            </Avatar>
                            <div class="flex-1">
                                <CardTitle class="text-2xl">
                                    {{ usuario?.nome }} {{ usuario?.sobrenome }}
                                </CardTitle>
                                <CardDescription class="mt-1">
                                    @{{ usuario?.nome_usuario }}
                                </CardDescription>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="flex items-center gap-3 text-sm">
                            <Mail class="size-4 text-muted-foreground" />
                            <span>{{ usuario?.email }}</span>
                        </div>
                        <div v-if="usuario?.telefone" class="flex items-center gap-3 text-sm">
                            <Phone class="size-4 text-muted-foreground" />
                            <span>{{ usuario?.telefone }}</span>
                        </div>
                        <div v-if="usuario?.data_nascimento" class="flex items-center gap-3 text-sm">
                            <Calendar class="size-4 text-muted-foreground" />
                            <span>{{ new Date(usuario.data_nascimento).toLocaleDateString('pt-BR') }}</span>
                        </div>
                    </CardContent>
                </Card>

                <!-- Card de Estatísticas de Avaliações -->
                <Card class="col-span-1">
                    <CardHeader>
                        <CardTitle>Estatísticas de Avaliações</CardTitle>
                        <CardDescription>Como vendedor</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-6">
                            <!-- Média de Avaliações -->
                            <div>
                                <div class="flex items-end gap-2">
                                    <span class="text-5xl font-bold">{{ media.toFixed(1) }}</span>
                                    <span class="text-muted-foreground mb-2 text-2xl">/5</span>
                                </div>
                                <div class="mt-2 flex items-center gap-1">
                                    <template v-for="estrela in renderEstrelas(media)" :key="estrela.key">
                                        <Star v-if="estrela.tipo === 'cheia'" class="size-5 fill-yellow-400 text-yellow-400" />
                                        <StarHalf v-else-if="estrela.tipo === 'meia'" class="size-5 fill-yellow-400 text-yellow-400" />
                                        <Star v-else class="size-5 text-gray-300" />
                                    </template>
                                </div>
                            </div>

                            <Separator />

                            <!-- Total de Avaliações -->
                            <div>
                                <p class="text-muted-foreground text-sm">Total de avaliações recebidas</p>
                                <p class="mt-1 text-3xl font-semibold">{{ total }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Lista de Avaliações -->
            <Card v-if="avaliacoes.length > 0">
                <CardHeader>
                    <CardTitle>Avaliações Recentes</CardTitle>
                    <CardDescription>Últimas {{ avaliacoes.length }} avaliações recebidas</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="space-y-6">
                        <div v-for="(avaliacao, index) in avaliacoes" :key="avaliacao.id">
                            <div class="flex gap-4">
                                <!-- Avatar do Comprador -->
                                <Avatar class="size-10">
                                    <AvatarImage :src="`https://api.dicebear.com/7.x/initials/svg?seed=${avaliacao.comprador.nome} ${avaliacao.comprador.sobrenome}`" />
                                    <AvatarFallback>
                                        {{ getIniciais(avaliacao.comprador.nome, avaliacao.comprador.sobrenome) }}
                                    </AvatarFallback>
                                </Avatar>

                                <!-- Conteúdo da Avaliação -->
                                <div class="flex-1 space-y-2">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-medium">
                                                {{ avaliacao.comprador.nome }} {{ avaliacao.comprador.sobrenome }}
                                            </p>
                                            <p class="text-muted-foreground text-xs">
                                                @{{ avaliacao.comprador.nome_usuario }}
                                            </p>
                                        </div>
                                        <span class="text-muted-foreground text-sm">{{ avaliacao.data }}</span>
                                    </div>

                                    <!-- Estrelas da Avaliação -->
                                    <div class="flex items-center gap-1">
                                        <template v-for="estrela in renderEstrelas(avaliacao.nota)" :key="estrela.key">
                                            <Star v-if="estrela.tipo === 'cheia'" class="size-4 fill-yellow-400 text-yellow-400" />
                                            <StarHalf v-else-if="estrela.tipo === 'meia'" class="size-4 fill-yellow-400 text-yellow-400" />
                                            <Star v-else class="size-4 text-gray-300" />
                                        </template>
                                        <span class="ml-2 text-sm font-medium">{{ avaliacao.nota.toFixed(1) }}</span>
                                    </div>

                                    <!-- Comentário -->
                                    <p v-if="avaliacao.comentario" class="text-muted-foreground text-sm">
                                        {{ avaliacao.comentario }}
                                    </p>
                                </div>
                            </div>

                            <!-- Separador entre avaliações -->
                            <Separator v-if="index < avaliacoes.length - 1" class="mt-6" />
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Mensagem quando não há avaliações -->
            <Card v-else>
                <CardContent class="flex flex-col items-center justify-center py-12">
                    <User class="text-muted-foreground size-12 mb-4" />
                    <p class="text-muted-foreground text-center">
                        Você ainda não recebeu nenhuma avaliação como vendedor.
                    </p>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
