export interface Papel {
    id: number;
    nome: string;
    descricao: string;
}

export interface Usuario {
    id: number;
    nome: string;
    sobrenome: string;
    nome_usuario: string;
    data_nascimento: string;
    email: string;
    telefone: string;
    documento: string;
    email_verified_at: string | null;
    papeis_id: number;
    papel: Papel;
    created_at: string;
    updated_at: string;
}

export interface GeneroEmDestaque {
    nome: string;
    id: number;
}

export interface Idioma {
    nome: string;
    id: number;
}

export interface Genero {
    nome: string;
    id: number;
}

export interface Estado {
    id: number;
    sigla: string;
    nome: string;
}

export interface Endereco {
    id: number;
    cep: string;
    logradouro: string;
    numero: string;
    complemento?: string;
    bairro: string;
    cidade: string;
    estado: Estado;
}

export interface Oferta {
    id: number;
    usuarios_id: number;
    idiomas_id: number;
    titulo: string;
    descricao: string;
    preco: number | string;
    ativo: boolean;
    bloqueado: boolean;
    titulo_livro: string;
    autor_livro: string;
    estado_livro: string;
    isbn_livro: string;
    data_publicacao_livro: string;
    editora?: string;
    capa_url?: string | null;
    created_at: string;
    updated_at: string;

    usuario: Usuario;
    idioma: Idioma;
    generos: Genero[];
    em_compra?: boolean;
    pedido_id?: number | null;
    compra_concluida?: boolean;
    compra_concluida_id?: number | null;
    vendedor_nota?: number | null;
}

interface Carrinho {
    id: number | string;
    ofertas_id: number;
    ofertas?: Oferta;
}
