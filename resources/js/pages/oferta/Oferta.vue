<script setup lang="ts">
import ImagensOferta from '@/components/ofertas/ImagensOferta.vue';
import InformacoesOferta from '@/components/ofertas/InformacoesOferta.vue';
import InformacoesVendedorOferta from '@/components/ofertas/InformacoesVendedorOferta.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData } from '@/types';
import { Oferta } from '@/types/api';
import { Head, usePage } from '@inertiajs/vue3';

interface PageProps extends SharedData {
    oferta: Oferta;
}

const page = usePage<PageProps>();
const oferta = page.props.oferta;
</script>

<template>
    <Head :title="oferta.titulo" />
    <AppLayout>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
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
                    :preco="oferta.preco"
                    :data-publicacao="oferta.data_publicacao_livro"
                    :generos="oferta.generos"
                    :idioma="oferta.idioma.nome"
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
