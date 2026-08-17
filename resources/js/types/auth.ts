export type User = {
    id_register: number;
    nama: string;
    name: string;
    email: string;
    username: string;
    role: string;
    avatar?: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};
