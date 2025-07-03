<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg
        version="1.0"
        xmlns="http://www.w3.org/2000/svg"
        width="96.000000pt"
        height="96.000000pt"
        viewBox="0 0 96.000000 96.000000"
        preserveAspectRatio="xMidYMid meet"
        :class="className"
        v-bind="$attrs"
    >
        <g
            transform="translate(0.000000,96.000000) scale(0.100000,-0.100000)"
            fill="currentColor"
            stroke="none"
        >
            <path
                d="M612 815 c-58 -25 -92 -55 -122 -108 l-30 -52 0 -322 c0 -312 1 -323
19 -323 13 0 23 11 31 36 37 111 161 169 274 129 22 -8 43 -12 48 -9 4 3 8
147 8 320 l0 315 -35 15 c-44 18 -150 18 -193 -1z"
            />
            <path
                d="M200 739 c-59 -9 -92 -23 -146 -60 l-44 -30 0 -320 0 -319 188 2
c158 3 187 5 187 18 0 13 -26 15 -167 18 l-168 2 0 285 0 284 35 26 c72 55
179 69 275 35 70 -25 72 -24 68 2 -6 41 -132 72 -228 57z"
            />
            <path
                d="M910 350 l0 -300 -167 -2 c-142 -3 -168 -5 -168 -18 0 -13 29 -15
188 -18 l187 -2 0 320 c0 313 0 320 -20 320 -20 0 -20 -7 -20 -300z"
            />
        </g>
    </svg>
</template>
