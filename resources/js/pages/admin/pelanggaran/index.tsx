import { useState, useEffect } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Plus, Pencil, Trash2, Search } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { index as pelanggaranIndex, create as pelanggaranCreate, edit as pelanggaranEdit, destroy as pelanggaranDestroy } from '@/routes/admin/pelanggaran';
import { formatDate } from '@/utils/date';

interface Pelanggaran {
    id_pelanggaran: number;
    siswa: { nama: string };
    tanggal_pelanggaran: string;
    poin: number;
    tindakan: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    pelanggaran: {
        data: Pelanggaran[];
        links: PaginationLink[];
    };
    filters: {
        search?: string;
    };
}

export default function PelanggaranIndex({ pelanggaran, filters }: Props) {
    const [search, setSearch] = useState(filters.search || '');
    const [deleteId, setDeleteId] = useState<number | null>(null);

    useEffect(() => {
        const timeout = setTimeout(() => {
            router.get(pelanggaranIndex.url(), { search }, { preserveState: true, replace: true });
        }, 300);
        return () => clearTimeout(timeout);
    }, [search]);

    const handleDelete = () => {
        if (deleteId) {
            router.delete(pelanggaranDestroy.url(deleteId), {
                onSuccess: () => setDeleteId(null),
            });
        }
    };

    return (
        <>
            <Head title="Data Pelanggaran" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <CardTitle>Data Pelanggaran</CardTitle>
                        <Button asChild>
                            <Link href={pelanggaranCreate.url()}>
                                <Plus className="mr-2 size-4" />
                                Tambah Pelanggaran
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <div className="mb-4">
                            <div className="relative max-w-sm">
                                <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    placeholder="Cari siswa..."
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    className="pl-9"
                                />
                            </div>
                        </div>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Siswa</TableHead>
                                    <TableHead>Tanggal Pelanggaran</TableHead>
                                    <TableHead>Poin</TableHead>
                                    <TableHead>Tindakan</TableHead>
                                    <TableHead className="text-right">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {pelanggaran.data.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={5} className="text-center text-muted-foreground">
                                            Tidak ada data ditemukan.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    pelanggaran.data.map((item) => (
                                        <TableRow key={item.id_pelanggaran}>
                                            <TableCell className="font-medium">{item.siswa.nama}</TableCell>
                                            <TableCell>{formatDate(item.tanggal_pelanggaran)}</TableCell>
                                            <TableCell>{item.poin}</TableCell>
                                            <TableCell className="max-w-[250px] truncate">{item.tindakan}</TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Button variant="outline" size="sm" asChild>
                                                        <Link href={pelanggaranEdit.url(item.id_pelanggaran)}>
                                                            <Pencil className="size-4" />
                                                        </Link>
                                                    </Button>
                                                    <Button
                                                        variant="destructive"
                                                        size="sm"
                                                        onClick={() => setDeleteId(item.id_pelanggaran)}
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
                        {pelanggaran.links && pelanggaran.links.length > 3 && (
                            <div className="mt-4 flex justify-center gap-1">
                                {pelanggaran.links.map((link, i) => (
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
                            Apakah Anda yakin ingin menghapus data pelanggaran ini? Tindakan ini tidak dapat dibatalkan.
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter>
                        <Button variant="outline" onClick={() => setDeleteId(null)}>Batal</Button>
                        <Button variant="destructive" onClick={handleDelete}>Hapus</Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </>
    );
}

PelanggaranIndex.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
