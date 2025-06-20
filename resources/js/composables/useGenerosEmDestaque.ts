import { GeneroEmDestaque } from '@/types/api';
import { ref } from 'vue';

export function useGenerosEmDestaque() {
    const generos = ref<GeneroEmDestaque[]>([
        { nome: 'ROMANCE', id: 'romance' },
        { nome: 'BIOGRAFIA', id: 'biografia' },
        { nome: 'FICCAO CIENTIFICA', id: 'ficcao-cientifica' },
        { nome: 'INFANTIL', id: 'infantil' },
        { nome: 'AVENTURA', id: 'aventura' },
        { nome: 'FANTASIA', id: 'fantasia' },
        { nome: 'AUTOAJUDA', id: 'autoajuda' },
        { nome: 'LITERATURA TECNICA', id: 'literatura-tecnica' },
        { nome: 'RELIGIAO', id: 'religiao' },
        { nome: 'TERROR', id: 'terror' },
        { nome: 'OUTROS', id: 'outros' },
    ]);

    return generos;
}
