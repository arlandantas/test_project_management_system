import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function formatDate(date: string) {
    return new Date(date).toLocaleDateString();
}

export function formatTime(datetime: string) {
    return new Date(datetime).toLocaleTimeString();
}

export function formatDateTime(datetime: string) {
    return new Date(datetime).toLocaleString();
}

const currencyFormatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2,
});

export function formatCurrency(value: number) {
    return currencyFormatter.format(value);
}
