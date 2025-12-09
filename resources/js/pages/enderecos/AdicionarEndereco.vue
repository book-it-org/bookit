<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue
} from '@/components/ui/select';
import AdicionarEnderecoLayout from '@/layouts/enderecos/AdicionarEnderecoLayout.vue';
import { Estado } from '@/types/api';
import { PageProps } from '@inertiajs/core';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

interface Props extends PageProps {
    estados: Estado[];
}

const page = usePage<Props>();

const form = useForm({
    cep: '',
    logradouro: '',
    numero: '',
    complemento: '',
    cidade: '',
    bairro: '',
    estados_id: null
});

const submit = () => {
    console.log(form);
    form.post(route('endereco.criar'), {
        onSuccess: () => {
            console.log('Endereço adicionado com sucesso!');
        },
        onError: (err) => {
            console.error('Erro ao adicionar endereço:', err);
        }
    });
};
</script>

<template>
    <Head title="BookIt - Carrinho" />
    <AdicionarEnderecoLayout>
        <form @submit.prevent="submit" class="grid gap-6">
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2 grid grid-cols-3 gap-6">
                    <div class="col-span-2 grid gap-2">
                        <Label for="logradouro">Logradouro</Label>
                        <Input
                            id="logradouro"
                            type="text"
                            required
                            :tabindex="1"
                            v-model="form.logradouro"
                            placeholder="Rua Doze de Junho"
                        />
                        <InputError :message="form.errors.logradouro" />
                    </div>
                    <div class="col-span-1 grid gap-2">
                        <Label for="numero">Número</Label>
                        <Input
                            id="numero"
                            type="text"
                            required
                            :tabindex="2"
                            v-model="form.numero"
                            placeholder="212"
                        />
                        <InputError :message="form.errors.numero" />
                    </div>
                </div>
                <div class="col-span-2 grid grid-cols-3 gap-6">
                    <div class="col-span-2 grid gap-2">
                        <Label for="complemento">Complemento</Label>
                        <Input
                            id="complemento"
                            type="text"
                            :tabindex="3"
                            v-model="form.complemento"
                            placeholder="Casa amarela com portão verde..."
                        />
                        <InputError :message="form.errors.complemento" />
                    </div>
                    <div class="col-span-1 grid gap-2">
                        <Label for="cep">CEP</Label>
                        <Input
                            id="cep"
                            type="text"
                            required
                            :tabindex="4"
                            v-model="form.cep"
                            placeholder="20202-020"
                        />
                        <InputError :message="form.errors.cep" />
                    </div>
                </div>
                <div class="grid col-span-2 gap-6 sm:grid-cols-3">
                    <div class="grid gap-2">
                        <Label for="estados_id">Estado</Label>
                        <Select v-model="form.estados_id">
                            <SelectTrigger class="w-full" name="estados_id" :tabindex="6">
                                <SelectValue :placeholder="'Selecione'" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Estado</SelectLabel>
                                    <SelectItem
                                        v-for="estado in page.props.estados"
                                        :key="estado.id"
                                        :value="estado.id"
                                    >{{ estado.nome }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.estados_id" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="cidade">Cidade</Label>
                        <Input
                            id="cidade"
                            type="text"
                            required
                            :tabindex="5"
                            v-model="form.cidade"
                            placeholder="Colatina"
                        />
                        <InputError :message="form.errors.cidade" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="bairro">Bairro</Label>
                        <Input
                            id="bairro"
                            type="text"
                            required
                            :tabindex="5"
                            v-model="form.bairro"
                            placeholder="São Silvano"
                        />
                        <InputError :message="form.errors.bairro" />
                    </div>
                </div>
                <Button
                    as-child
                    class="mt-2 w-full"
                    :tabindex="20"
                    type="button"
                    variant="outline"
                    :disabled="form.processing"
                >
                    <Link :href="route('enderecos')" prefetch as="button"> Cancelar</Link>
                </Button>
                <Button
                    type="submit"
                    class="mt-2 w-full"
                    :tabindex="21"
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Adicionar Endereço
                </Button>
            </div>
        </form>
    </AdicionarEnderecoLayout>
</template>
