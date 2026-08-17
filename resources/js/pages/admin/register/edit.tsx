import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { index as registerIndex, update as registerUpdate } from '@/routes/admin/register';

interface User {
    id_register: number;
    nama: string;
    email: string;
    username: string;
    role: string;
}

interface Props {
    user: User;
}

export default function RegisterEdit({ user }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        nama: user.nama,
        email: user.email,
        username: user.username,
        password: '',
        password_confirmation: '',
        role: user.role,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(registerUpdate.url(user.id_register));
    };

    return (
        <>
            <Head title="Edit Akun" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Edit Akun Pengguna</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="grid gap-2">
                                <Label htmlFor="nama">Nama</Label>
                                <Input
                                    id="nama"
                                    value={data.nama}
                                    onChange={(e) => setData('nama', e.target.value)}
                                    placeholder="Masukkan nama lengkap"
                                />
                                {errors.nama && <p className="text-sm text-destructive">{errors.nama}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="email">Email</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    placeholder="Masukkan email"
                                />
                                {errors.email && <p className="text-sm text-destructive">{errors.email}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="username">Username</Label>
                                <Input
                                    id="username"
                                    value={data.username}
                                    onChange={(e) => setData('username', e.target.value)}
                                    placeholder="Masukkan username"
                                />
                                {errors.username && <p className="text-sm text-destructive">{errors.username}</p>}
                            </div>
                            <div className="grid gap-2">
                                <Label htmlFor="password">Password (kosongkan jika tidak diubah)</Label>
                                <Input
                                    id="password"
                                    type="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    placeholder="Masukkan password baru"
                                />
                                {errors.password && <p className="text-sm text-destructive">{errors.password}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="password_confirmation">Konfirmasi Password</Label>
                                <Input
                                    id="password_confirmation"
                                    type="password"
                                    value={data.password_confirmation}
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                    placeholder="Masukkan ulang password baru"
                                />
                            </div>

                            <div className="grid gap-2">
                                <Label>Role</Label>
                                <Select value={data.role} onValueChange={(value) => setData('role', value)}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Pilih role" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="siswa">Siswa</SelectItem>
                                        <SelectItem value="guru_bk">Guru BK</SelectItem>
                                        <SelectItem value="orang_tua">Orang Tua</SelectItem>
                                        <SelectItem value="kepala_sekolah">Kepala Sekolah</SelectItem>
                                    </SelectContent>
                                </Select>
                                {errors.role && <p className="text-sm text-destructive">{errors.role}</p>}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>
                                    Simpan Perubahan
                                </Button>
                                <Button variant="outline" asChild>
                                    <Link href={registerIndex.url()}>Batal</Link>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

RegisterEdit.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
