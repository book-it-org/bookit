<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '../components/ui/card/Card.vue';
import CardDescription from '../components/ui/card/CardDescription.vue';
import CardTitle from '../components/ui/card/CardTitle.vue';
</script>

<template>
    <Head title="BookIt - Pedidos" />
    <AppLayout>
        <div class="container mx-auto flex h-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid grid-cols-3 gap-4">
                <Card class="inline-flex flex-row p-4" v-for="index in 5" :key="index">
                    <Card class="bg-white">
                        <img
                            class="size-25"
                            src="https://images-americanas.b2w.io/produtos/3518714892/imagens/usado-percy-jackson-o-mar-de-monstros-livro-dois/3518714892_1_large.jpg"
                            alt=""
                    /></Card>
                    <div class="grid content-center gap-4">
                        <div>
                            <CardTitle class="font-bold"
                                >Percy Jackson e o Mar de Monstros
                            </CardTitle>
                            <CardDescription
                                ><p>Autor: Rick Riordan</p>
                                <p>
                                    Vendido por
                                    <a class="text-sky-300">Livraria Ignobel</a>
                                </p></CardDescription
                            >
                        </div>
                        <div class="flex justify-between">
                            <div>
                                <p class="text-amber-200">3,5/5</p>
                                <p class="text-emerald-500">R$ 39,99</p>
                            </div>
                        </div>
                    </div>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
