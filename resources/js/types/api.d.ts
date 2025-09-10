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
