import { useState, useEffect } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Plus, Pencil, Trash2, Search, ClipboardCheck } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { index as konselingIndex, create as konselingCreate, edit as konselingEdit, destroy as konselingDestroy } from '@/routes/admin/konseling';
import adminRoutes from '@/routes/admin';
import { formatDate } from '@/utils/date';

interface Konseling {
    id_data_konseling: number;
    siswa: { nama: string };
    tanggal: string;
    masalah: string;
    solusi: string;
    guru_bk: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    konseling: {
        data: Konseling[];
        links: PaginationLink[];
    };
    filters: {
        search?: string;
    };
}

export default function KonselingIndex({ konseling, filters }: Props) {
    const [search, setSearch] = useState(filters.search || '');
    const [deleteId, setDeleteId] = useState<number | null>(null);

    useEffect(() => {
        const timeout = setTimeout(() => {
            router.get(konselingIndex.url(), { search }, { preserveState: true, replace: true });
        }, 300);
        return () => clearTimeout(timeout);
    }, [search]);

    const handleDelete = () => {
        if (deleteId) {
            router.delete(konselingDestroy.url(deleteId), {
                onSuccess: () => setDeleteId(null),
            });
        }
    };

    return (
        <>
            <Head title="Data Konseling" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <CardTitle>Data Konseling</CardTitle>
                        <div className="flex items-center gap-2">
                            <Button variant="outline" asChild>
                                <Link href={adminRoutes.pengajuan.index.url()}>
                                    <ClipboardCheck className="mr-2 size-4 text-orange-600" />
                                    Pengajuan Konseling Siswa
                                </Link>
                            </Button>
                            <Button asChild>
                                <Link href={konselingCreate.url()}>
                                    <Plus className="mr-2 size-4" />
                                    Tambah Konseling
                                </Link>
                            </Button>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div className="mb-4">
                            <div className="relative max-w-sm">
                                <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    placeholder="Cari siswa atau masalah..."
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
                                    <TableHead>Tanggal</TableHead>
                                    <TableHead>Masalah</TableHead>
                                    <TableHead>Solusi</TableHead>
                                    <TableHead>Guru BK</TableHead>
                                    <TableHead className="text-right">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {konseling.data.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={6} className="text-center text-muted-foreground">
                                            Tidak ada data ditemukan.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    konseling.data.map((item) => (
                                        <TableRow key={item.id_data_konseling}>
                                            <TableCell className="font-medium">{item.siswa.nama}</TableCell>
                                            <TableCell>{formatDate(item.tanggal)}</TableCell>
                                            <TableCell className="max-w-[200px] truncate">{item.masalah}</TableCell>
                                            <TableCell className="max-w-[200px] truncate">{item.solusi}</TableCell>
                                            <TableCell>{item.guru_bk}</TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Button variant="outline" size="sm" asChild>
                                                        <Link href={konselingEdit.url(item.id_data_konseling)}>
                                                            <Pencil className="size-4" />
                                                        </Link>
                                                    </Button>
                                                    <Button
                                                        variant="destructive"
                                                        size="sm"
                                                        onClick={() => setDeleteId(item.id_data_konseling)}
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
                        {konseling.links && konseling.links.length > 3 && (
                            <div className="mt-4 flex justify-center gap-1">
                                {konseling.links.map((link, i) => (
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
                            Apakah Anda yakin ingin menghapus data konseling ini? Tindakan ini tidak dapat dibatalkan.
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

KonselingIndex.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
