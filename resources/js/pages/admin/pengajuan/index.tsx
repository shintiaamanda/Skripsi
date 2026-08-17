import { useState, useEffect } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Search, ArrowRight, Trash2 } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import adminRoutes from '@/routes/admin';
import { formatDate } from '@/utils/date';

interface Pengajuan {
    id_konseling: number;
    siswa: {
        id_siswa: number;
        nama: string;
        nisn: string;
        kelas: string;
    } | null;
    tanggal_konseling: string;
    keluhan: string;
    guru_bk?: string | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    pengajuan: {
        data: Pengajuan[];
        links: PaginationLink[];
    };
    filters: {
        search?: string;
    };
}

export default function PengajuanIndex({ pengajuan, filters }: Props) {
    const [search, setSearch] = useState(filters.search || '');
    const [deleteId, setDeleteId] = useState<number | null>(null);

    useEffect(() => {
        const timeout = setTimeout(() => {
            router.get(adminRoutes.pengajuan.index.url(), { search }, { preserveState: true, replace: true });
        }, 300);
        return () => clearTimeout(timeout);
    }, [search]);

    const handleDelete = () => {
        if (deleteId) {
            router.delete(adminRoutes.pengajuan.destroy.url(deleteId), {
                onSuccess: () => setDeleteId(null),
            });
        }
    };

    return (
        <>
            <Head title="Pengajuan Konseling" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <CardTitle>Daftar Pengajuan Konseling Siswa</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="mb-4">
                            <div className="relative max-w-sm">
                                <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    placeholder="Cari nama siswa..."
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    className="pl-9"
                                />
                            </div>
                        </div>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nama Siswa</TableHead>
                                    <TableHead>Kelas</TableHead>
                                    <TableHead>Tanggal Pengajuan</TableHead>
                                    <TableHead>Guru BK Terjadwal</TableHead>
                                    <TableHead>Keluhan / Alasan</TableHead>
                                    <TableHead className="text-right">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {pengajuan.data.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={6} className="text-center text-muted-foreground">
                                            Belum ada pengajuan konseling dari siswa.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    pengajuan.data.map((item) => (
                                        <TableRow key={item.id_konseling}>
                                            <TableCell className="font-medium">{item.siswa?.nama ?? '-'}</TableCell>
                                            <TableCell>{item.siswa?.kelas ?? '-'}</TableCell>
                                            <TableCell>{formatDate(item.tanggal_konseling)}</TableCell>
                                            <TableCell>{item.guru_bk ?? '-'}</TableCell>
                                            <TableCell className="max-w-[200px] truncate">{item.keluhan}</TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Button variant="default" size="sm" asChild>
                                                        <Link href={adminRoutes.pengajuan.show.url(item.id_konseling)}>
                                                            <ArrowRight className="mr-1 size-4" />
                                                            Proses
                                                        </Link>
                                                    </Button>
                                                    <Button
                                                        variant="destructive"
                                                        size="sm"
                                                        onClick={() => setDeleteId(item.id_konseling)}
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
                        {pengajuan.links && pengajuan.links.length > 3 && (
                            <div className="mt-4 flex justify-center gap-1">
                                {pengajuan.links.map((link, i) =>
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
                                )}
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
                            Apakah Anda yakin ingin menghapus pengajuan konseling ini?
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

PengajuanIndex.layout = (page: React.ReactNode) => (
    <AppLayout breadcrumbs={[{ title: 'Pengajuan Konseling', href: adminRoutes.pengajuan.index.url() }]}>
        {page}
    </AppLayout>
);
