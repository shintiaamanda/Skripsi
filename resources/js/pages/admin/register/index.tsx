import { useState, useEffect } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Badge } from '@/components/ui/badge';
import { Plus, Pencil, Trash2, Search } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { index as registerIndex, create as registerCreate, edit as registerEdit, destroy as registerDestroy } from '@/routes/admin/register';

interface User {
    id_register: number;
    nama: string;
    email: string;
    username: string;
    role: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    users: {
        data: User[];
        links: PaginationLink[];
    };
    filters: {
        search?: string;
    };
}

const roleBadgeVariant = (role: string) => {
    switch (role) {
        case 'admin': return 'default';
        case 'guru_bk': return 'secondary';
        case 'siswa': return 'outline';
        case 'orang_tua': return 'outline';
        case 'kepala_sekolah': return 'secondary';
        default: return 'outline';
    }
};

export default function RegisterIndex({ users, filters }: Props) {
    const [search, setSearch] = useState(filters.search || '');
    const [deleteId, setDeleteId] = useState<number | null>(null);

    useEffect(() => {
        const timeout = setTimeout(() => {
            router.get(registerIndex.url(), { search }, { preserveState: true, replace: true });
        }, 300);
        return () => clearTimeout(timeout);
    }, [search]);

    const handleDelete = () => {
        if (deleteId) {
            router.delete(registerDestroy.url(deleteId), {
                onSuccess: () => setDeleteId(null),
            });
        }
    };

    return (
        <>
            <Head title="Data Register" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <CardTitle>Data Akun Pengguna</CardTitle>
                        <Button asChild>
                            <Link href={registerCreate.url()}>
                                <Plus className="mr-2 size-4" />
                                Tambah Akun
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <div className="mb-4">
                            <div className="relative max-w-sm">
                                <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    placeholder="Cari nama, email, atau username..."
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    className="pl-9"
                                />
                            </div>
                        </div>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nama</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead>Username</TableHead>
                                    <TableHead>Role</TableHead>
                                    <TableHead className="text-right">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {users.data.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={5} className="text-center text-muted-foreground">
                                            Tidak ada data ditemukan.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    users.data.map((user) => (
                                        <TableRow key={user.id_register}>
                                            <TableCell className="font-medium">{user.nama}</TableCell>
                                            <TableCell>{user.email}</TableCell>
                                            <TableCell>{user.username}</TableCell>
                                            <TableCell>
                                                <Badge variant={roleBadgeVariant(user.role)}>
                                                    {user.role.replace('_', ' ')}
                                                </Badge>
                                            </TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Button variant="outline" size="sm" asChild>
                                                        <Link href={registerEdit.url(user.id_register)}>
                                                            <Pencil className="size-4" />
                                                        </Link>
                                                    </Button>
                                                    <Button
                                                        variant="destructive"
                                                        size="sm"
                                                        onClick={() => setDeleteId(user.id_register)}
                                                    >
                                                        <Trash2 className="size-4" />
                                                    </Button>
                                                </div>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                )}
                            </TableBody>
                        </Table>
                        {users.links && users.links.length > 3 && (
                            <div className="mt-4 flex justify-center gap-1">
                                {users.links.map((link, i) => (
                                    link.url ? (
                                        <Button
                                            key={i}
                                            variant={link.active ? 'default' : 'outline'}
                                            size="sm"
                                            asChild
                                        >
                                            <Link href={link.url} dangerouslySetInnerHTML={{ __html: link.label }} />
                                        </Button>
                                    ) : (
                                        <Button
                                            key={i}
                                            variant="outline"
                                            size="sm"
                                            disabled
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    )
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>

            <Dialog open={deleteId !== null} onOpenChange={() => setDeleteId(null)}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Konfirmasi Hapus</DialogTitle>
                        <DialogDescription>
                            Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter>
                        <Button variant="outline" onClick={() => setDeleteId(null)}>
                            Batal
                        </Button>
                        <Button variant="destructive" onClick={handleDelete}>
                            Hapus
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </>
    );
}

RegisterIndex.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
