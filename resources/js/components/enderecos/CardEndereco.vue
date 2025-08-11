<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { MapPinHouse, Trash2Icon } from 'lucide-vue-next';
import Button from '../ui/button/Button.vue';
</script>

<template>
    <Card>
        <CardHeader class="flex items-center justify-between">
            <div class="flex items-center">
                <MapPinHouse class="mr-2 h-4 w-4" />
                <CardTitle>Avenida Jonas Marcos 212</CardTitle>
            </div>
            <Button size="icon" variant="destructive">
                <Trash2Icon />
            </Button>
        </CardHeader>
        <CardContent>
            <CardDescription>
                <span>Cidade, Estado, CEP 12123123</span>
            </CardDescription>
            <CardDescription>
                <span>Complemento do endereço</span>
            </CardDescription>
        </CardContent>
    </Card>
</template>
