import { useState, useEffect } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Plus, Pencil, Trash2, Search } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { index as siswaIndex, create as siswaCreate, edit as siswaEdit, destroy as siswaDestroy } from '@/routes/admin/siswa';

interface Siswa {
    id_siswa: number;
    nisn: string;
    nama: string;
    jenis_kelamin: string;
    kelas: string;
    alamat: string;
    no_hp: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    siswa: {
        data: Siswa[];
        links: PaginationLink[];
    };
    filters: {
        search?: string;
    };
}

export default function SiswaIndex({ siswa, filters }: Props) {
    const [search, setSearch] = useState(filters.search || '');
    const [deleteId, setDeleteId] = useState<number | null>(null);

    useEffect(() => {
        const timeout = setTimeout(() => {
            router.get(siswaIndex.url(), { search }, { preserveState: true, replace: true });
        }, 300);
        return () => clearTimeout(timeout);
    }, [search]);

    const handleDelete = () => {
        if (deleteId) {
            router.delete(siswaDestroy.url(deleteId), {
                onSuccess: () => setDeleteId(null),
            });
        }
    };

    return (
        <>
            <Head title="Data Siswa" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <CardTitle>Data Siswa</CardTitle>
                        <Button asChild>
                            <Link href={siswaCreate.url()}>
                                <Plus className="mr-2 size-4" />
                                Tambah Siswa
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <div className="mb-4">
                            <div className="relative max-w-sm">
                                <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    placeholder="Cari nama atau NISN..."
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    className="pl-9"
                                />
                            </div>
                        </div>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>NISN</TableHead>
                                    <TableHead>Nama</TableHead>
                                    <TableHead>Jenis Kelamin</TableHead>
                                    <TableHead>Kelas</TableHead>
                                    <TableHead>No HP</TableHead>
                                    <TableHead className="text-right">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {siswa.data.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={6} className="text-center text-muted-foreground">
                                            Tidak ada data ditemukan.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    siswa.data.map((item) => (
                                        <TableRow key={item.id_siswa}>
                                            <TableCell>{item.nisn}</TableCell>
                                            <TableCell className="font-medium">{item.nama}</TableCell>
                                            <TableCell>{item.jenis_kelamin}</TableCell>
                                            <TableCell>{item.kelas}</TableCell>
                                            <TableCell>{item.no_hp}</TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Button variant="outline" size="sm" asChild>
                                                        <Link href={siswaEdit.url(item.id_siswa)}>
                                                            <Pencil className="size-4" />
                                                        </Link>
                                                    </Button>
                                                    <Button
                                                        variant="destructive"
                                                        size="sm"
                                                        onClick={() => setDeleteId(item.id_siswa)}
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
                        {siswa.links && siswa.links.length > 3 && (
                            <div className="mt-4 flex justify-center gap-1">
                                {siswa.links.map((link, i) => (
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
                            Apakah Anda yakin ingin menghapus data siswa ini? Tindakan ini tidak dapat dibatalkan.
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

SiswaIndex.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
