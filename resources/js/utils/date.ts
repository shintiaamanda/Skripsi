export function formatDate(dateString: string | null | undefined): string {
    if (!dateString) return '-';

    const cleanDate = dateString.split('T')[0].split(' ')[0];
    const parts = cleanDate.split('-');
    if (parts.length === 3) {
        const year = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1;
        const day = parseInt(parts[2], 10);
        const date = new Date(year, month, day);
        if (!isNaN(date.getTime())) {
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
            });
        }
    }

    const date = new Date(dateString);
    if (isNaN(date.getTime())) return dateString;
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
}

export function toInputDate(dateString: string | null | undefined): string {
    if (!dateString) return '';
    return dateString.split('T')[0].slice(0, 10);
}
