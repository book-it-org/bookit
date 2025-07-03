<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
</script>

<template>
    <div class="flex gap-4 items-center px-4 py-3 rounded-2xl cursor-pointer hover:bg-muted">
        <figure>
            <img
                src="https://plus.unsplash.com/premium_photo-1689568126014-06fea9d5d341?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cGVyZmlsfGVufDB8fDB8fHww"
                alt="Avatar"
                class="h-10 w-10 rounded-full"
            />
            <span
                class="absolute right-0 bottom-0 h-3 w-3 rounded-full border-2 border-white bg-green-500"
            ></span>
        </figure>
        <div>
            <p class="text-lg">Nome da pessoa</p>
        </div>
    </div>
</template>
