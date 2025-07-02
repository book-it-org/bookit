<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader } from '@/components/ui/card';
import { Stepper, StepperItem, StepperSeparator, StepperTitle } from '@/components/ui/stepper';
import AppLayout from '@/layouts/AppLayout.vue';
import { CheckIcon, InfoIcon, PackageIcon } from 'lucide-vue-next';

interface Props {
    passo: number;
}

defineProps<Props>();

const passos = [
    {
        passo: 1,
        titulo: 'Informações Básicas',
        icon: InfoIcon,
    },
    {
        passo: 2,
        titulo: 'Detalhes da Oferta',
        icon: PackageIcon,
    },
    {
        passo: 3,
        titulo: 'Revisão e Publicação',
        icon: CheckIcon,
    },
];
</script>

<template>
    <AppLayout :header-limpo="true">
        <div class="flex min-h-svh flex-col items-center justify-center p-8">
            <div class="w-full max-w-3xl">
                <Card>
                    <CardHeader class="mt-10 mb-4 w-full">
                        <Stepper class="w-full">
                            <div class="flex w-full gap-2">
                                <StepperItem
                                    v-for="_passo in passos"
                                    :key="_passo.passo"
                                    class="relative w-full flex-col items-center justify-center"
                                    :step="_passo.passo"
                                >
                                    <StepperSeparator
                                        v-if="_passo.passo !== passos[passos.length - 1].passo"
                                        class="bg-primary absolute top-5 right-[calc(-50%+10px)] left-[calc(50%+20px)] block h-0.5 shrink-0 rounded-full"
                                        :class="passo > _passo.passo ? 'bg-primary' : 'bg-muted'"
                                    />

                                    <Button
                                        :variant="_passo.passo <= passo ? 'default' : 'outline'"
                                        size="icon"
                                        role="step"
                                        class="ring-ring ring-offset-background z-10 shrink-0 rounded-full ring-2 ring-offset-2"
                                    >
                                        <component :is="_passo.icon" />
                                    </Button>

                                    <StepperTitle
                                        class="text-sm font-normal transition lg:text-base"
                                        :class="{
                                            'text-primary': passo >= _passo.passo,
                                            'text-muted-foreground': passo < _passo.passo,
                                        }"
                                    >
                                        {{ _passo.titulo }}
                                    </StepperTitle>
                                </StepperItem>
                            </div>
                        </Stepper>
                    </CardHeader>
                    <CardContent>
                        <slot></slot>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
