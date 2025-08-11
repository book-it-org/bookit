<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    nome_usuario: '',
    nome: '',
    sobrenome: '',
    email: '',
    data_nascimento: '',
    telefone: '',
    documento: '',
    senha: '',
    confirmacao_senha: '',
});

const submit = () => {
    form.post(route('registrar'), {
        onFinish: () => form.reset('senha', 'confirmacao_senha'),
    });
};
</script>

<template>
    <AuthBase
        title="BookIt"
        description="Bem vindo! Preencha os dados abaixo com suas informações:"
    >
        <Head title="Register" />

        <form @submit.prevent="submit" class="grid gap-6">
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2 grid gap-2">
                    <Label for="nome_usuario">Nome de usuário</Label>
                    <Input
                        id="nome_usuario"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="nome_usuario"
                        v-model="form.nome_usuario"
                        placeholder="visitante2049"
                    />
                    <InputError :message="form.errors.nome_usuario" />
                </div>

                <div class="grid gap-2">
                    <Label for="nome">Nome</Label>
                    <Input
                        id="nome"
                        type="text"
                        required
                        autofocus
                        :tabindex="2"
                        autocomplete="nome"
                        v-model="form.nome"
                        placeholder="João"
                    />
                    <InputError :message="form.errors.nome" />
                </div>

                <div class="grid gap-2">
                    <Label for="sobrenome">Sobrenome</Label>
                    <Input
                        id="sobrenome"
                        type="text"
                        required
                        autofocus
                        :tabindex="3"
                        autocomplete="sobrenome"
                        v-model="form.sobrenome"
                        placeholder="da Silva"
                    />
                    <InputError :message="form.errors.sobrenome" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">E-mail</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="4"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="joaodasilva@email.com"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="data_nascimento">Data de nascimento</Label>
                    <Input
                        id="data_nascimento"
                        type="date"
                        required
                        :tabindex="5"
                        v-model="form.data_nascimento"
                    />
                    <InputError :message="form.errors.data_nascimento" />
                </div>

                <div class="grid gap-2">
                    <Label for="telefone">Telefone</Label>
                    <Input
                        id="telefone"
                        type="tel"
                        required
                        :tabindex="6"
                        autocomplete="telefone"
                        v-model="form.telefone"
                        placeholder="(00) 00000-0000"
                    />
                    <InputError :message="form.errors.telefone" />
                </div>

                <div class="grid gap-2">
                    <Label for="documento">CPF/CNPJ</Label>
                    <Input
                        id="documento"
                        type="text"
                        required
                        :tabindex="7"
                        autocomplete="documento"
                        v-model="form.documento"
                        placeholder="000.000.000-00"
                    />
                    <InputError :message="form.errors.documento" />
                </div>

                <div class="grid gap-2">
                    <Label for="senha">Senha</Label>
                    <Input
                        id="senha"
                        type="password"
                        required
                        :tabindex="8"
                        autocomplete="senha"
                        v-model="form.senha"
                        placeholder="********"
                    />
                    <InputError :message="form.errors.senha" />
                </div>

                <div class="grid gap-2">
                    <Label for="confirmacao_senha">Confirme sua senha</Label>
                    <Input
                        id="confirmacao_senha"
                        type="password"
                        required
                        :tabindex="9"
                        autocomplete="confirmacao_senha"
                        v-model="form.confirmacao_senha"
                        placeholder="********"
                    />
                    <InputError :message="form.errors.confirmacao_senha" />
                </div>

                <Button
                    type="submit"
                    class="col-span-2 mt-2 w-full"
                    tabindex="10"
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Criar conta
                </Button>
            </div>

            <div class="text-muted-foreground text-center text-sm">
                Já possui uma senha?
                <TextLink
                    :href="route('entrar')"
                    class="underline underline-offset-4"
                    :tabindex="11"
                    >Log in
                </TextLink>
            </div>
        </form>
    </AuthBase>
</template>
