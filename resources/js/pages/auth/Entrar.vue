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
        title="Log in to your account"
        description="Enter your email and senha below to log in"
    >
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="senha">Password</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="route('senha.recuperar')"
                            class="text-sm"
                            :tabindex="5"
                        >
                            Forgot senha?
                        </TextLink>
                    </div>
                    <Input
                        id="senha"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-senha"
                        v-model="form.senha"
                        placeholder="Password"
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
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Log in
                </Button>
            </div>

            <div class="text-muted-foreground text-center text-sm">
                Don't have an account?
                <TextLink :href="route('registrar')" :tabindex="5">Sign up</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
