import { router } from '@inertiajs/vue3';

interface FiltrosPesquisa {
    pesquisa?: string;
    genero?: string;
    idioma?: string;
    estado?: string;
    min?: string;
    max?: string;
    ordem?: string;
}

const filtros = ['pesquisa', 'genero', 'idioma', 'estado', 'min', 'max', 'ordem'] as const;

function usePesquisa() {
    const pesquisar = (novosFiltros: FiltrosPesquisa) => {
        const query = new URLSearchParams(window.location.search);
        const parametros: Record<string, string> = {};

        for (const filtro of filtros) {
            const valor = query.get(filtro);
            if (valor && valor !== '*' && valor !== '') {
                parametros[filtro] = valor;
            }
        }

        for (const [filtro, valor] of Object.entries(novosFiltros)) {
            if (valor && valor !== '*' && valor !== '') {
                parametros[filtro] = valor;
            } else {
                delete parametros[filtro];
            }
        }

        router.get(route('pesquisa'), parametros, {
            preserveState: true,
            replace: true,
        });
    };

    return pesquisar;
}

export default usePesquisa;
