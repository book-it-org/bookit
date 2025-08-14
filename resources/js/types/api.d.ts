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
