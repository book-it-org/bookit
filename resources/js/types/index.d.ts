import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';
import { Usuario } from './api';

export interface Auth {
    user: Usuario | null;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    auth: Auth;
    ziggy: Config & { location: string };
}

export type BreadcrumbItemType = BreadcrumbItem;
