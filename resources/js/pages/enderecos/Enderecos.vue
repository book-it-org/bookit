<script setup lang="ts">
import CardEndereco from '@/components/enderecos/CardEndereco.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Endereco } from '@/types/api';
import { PageProps } from '@inertiajs/core';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import export_default from 'reka-ui/resolver';

interface Props extends PageProps {
    enderecos: Endereco[];
}

const page = usePage<Props>();
const enderecos = page.props.enderecos || [];

console.log(enderecos)
</script>

<template>
    <Head title="BookIt - Carrinho" />
    <AppLayout>
        <div class="container mx-auto flex h-full flex-1 flex-col items-center gap-4 rounded-xl">
            <div class="flex w-1/2 flex-col gap-4">
                <Button class="w-full" as-child>
                    <Link
                        class="block w-full"
                        :href="route('enderecos.adicionar')"
                        prefetch
                        as="button"
                    >
                        <Plus class="mr-2 h-4 w-4" />
                        Adicionar Endereço
                    </Link>
                </Button>
                <CardEndereco
                    v-for="endereco in enderecos"
                    :endereco="endereco"
                    :key="endereco.id"
                />
            </div>
        </div>
    </AppLayout>
</template>
