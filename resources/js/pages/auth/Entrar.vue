<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    senha: '',
    lembrar_usuario: false,
});

const submit = () => {
    form.post(route('entrar'), {});
};
</script>

<template>
    <AuthBase
        title="Entrar na sua conta"
        description="Insira seu email e senha para acessar sua conta."
    >
        <Head title="Entrar" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@exemplo.com"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="senha">Senha</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="route('senha.recuperar')"
                            class="text-sm"
                            :tabindex="5"
                        >
                            Esqueceu sua senha?
                        </TextLink>
                    </div>
                    <Input
                        id="senha"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.senha"
                        placeholder="Senha"
                    />
                    <InputError :message="form.errors.senha" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="lembrar_usuario" class="flex items-center space-x-3">
                        <Checkbox
                            id="lembrar_usuario"
                            v-model="form.lembrar_usuario"
                            :tabindex="3"
                        />
                        <span>Lembrar usuário</span>
                    </Label>
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Entrar
                </Button>
            </div>

            <div class="text-muted-foreground text-center text-sm">
                Não tem uma conta?
                <TextLink :href="route('registrar')" :tabindex="5">Criar conta</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
