<script setup lang="ts">
import BotoesAcaoOferta from '@/components/ofertas/BotoesAcaoOferta.vue';
import ImagensOferta from '@/components/ofertas/ImagensOferta.vue';
import InformacoesOferta from '@/components/ofertas/InformacoesOferta.vue';
import InformacoesVendedorOferta from '@/components/ofertas/InformacoesVendedorOferta.vue';
import FlashNotification from '@/components/ui/FlashNotification.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData } from '@/types';
import { Oferta } from '@/types/api';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface PageProps extends SharedData {
    oferta: Oferta;
    estaNoCarrinho: boolean;
    permissoes?: {
        podeGerenciar: boolean;
        admin: boolean;
        dono: boolean;
        podeAtivar: boolean;
    };
}

const page = usePage<PageProps>();
const oferta = computed(() => page.props.oferta);
const estaNoCarrinho = computed(() => page.props.estaNoCarrinho);
const permissoes = computed(
    () =>
        page.props.permissoes || {
            podeGerenciar: false,
            admin: false,
            dono: false,
            podeAtivar: false,
        },
);
</script>

<template>
    <Head :title="oferta.titulo" />
    <AppLayout>
        <FlashNotification />
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <BotoesAcaoOferta
                :oferta-id="oferta.id"
                :ativo="oferta.ativo"
                :bloqueado="oferta.bloqueado"
                :permissoes="permissoes"
            />

            <div class="col-span-1">
                <ImagensOferta />
            </div>

            <div class="col-span-1">
                <InformacoesOferta
                    :titulo="oferta.titulo"
                    :autor="oferta.autor_livro"
                    :titulo-livro="oferta.titulo_livro"
                    :estado="oferta.estado_livro"
                    :isbn="oferta.isbn_livro"
                    :preco="oferta.preco as number"
                    :data-publicacao="oferta.data_publicacao_livro"
                    :generos="oferta.generos"
                    :idioma="oferta.idioma.nome"
                    :oferta-id="oferta.id"
                    :esta-no-carrinho="estaNoCarrinho"
                    editora="Genérica"
                />
            </div>

            <div class="md:col-span-2">
                <InformacoesVendedorOferta
                    :descricao="oferta.descricao"
                    :vendedor-nome="oferta.usuario.nome + ' ' + oferta.usuario.sobrenome"
                    :vendedor-nome-usuario="oferta.usuario.nome_usuario"
                />
            </div>
        </div>
    </AppLayout>
</template>
