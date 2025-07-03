<script setup lang="ts">
import { Trash2Icon } from 'lucide-vue-next';
import Button from '../ui/button/Button.vue';
import Card from '../ui/card/Card.vue';
import CardDescription from '../ui/card/CardDescription.vue';
import CardTitle from '../ui/card/CardTitle.vue';
</script>
<template>
    <Card class="inline-flex flex-row p-4">
        <Card class="bg-white">
            <img
                class="size-25"
                src="https://images-americanas.b2w.io/produtos/3518714892/imagens/usado-percy-jackson-o-mar-de-monstros-livro-dois/3518714892_1_large.jpg"
                alt=""
        /></Card>
        <div class="grid content-center gap-4">
            <div>
                <CardTitle class="font-bold">Percy Jackson e o Mar de Monstros</CardTitle
                ><CardDescription
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
                <Button size="icon" class="bg-red-500"><Trash2Icon /></Button>
            </div>
        </div>
    </Card>
</template>
