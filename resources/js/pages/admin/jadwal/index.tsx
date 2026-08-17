import { useState, useEffect } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Plus, Pencil, Trash2, Search } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { index as jadwalIndex, create as jadwalCreate, edit as jadwalEdit, destroy as jadwalDestroy } from '@/routes/admin/jadwal';
import { formatDate } from '@/utils/date';

interface Jadwal {
    id_jadwal: number;
    hari: string;
    tanggal_layanan: string;
    jam: string;
    guru: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    jadwal: {
        data: Jadwal[];
        links: PaginationLink[];
    };
    filters: {
        search?: string;
    };
}

export default function JadwalIndex({ jadwal, filters }: Props) {
    const [search, setSearch] = useState(filters.search || '');
    const [deleteId, setDeleteId] = useState<number | null>(null);

    useEffect(() => {
        const timeout = setTimeout(() => {
            router.get(jadwalIndex.url(), { search }, { preserveState: true, replace: true });
        }, 300);
        return () => clearTimeout(timeout);
    }, [search]);

    const handleDelete = () => {
        if (deleteId) {
            router.delete(jadwalDestroy.url(deleteId), {
                onSuccess: () => setDeleteId(null),
            });
        }
    };

    return (
        <>
            <Head title="Jadwal Layanan BK" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <CardTitle>Jadwal Layanan BK</CardTitle>
                        <Button asChild>
                            <Link href={jadwalCreate.url()}>
                                <Plus className="mr-2 size-4" />
                                Tambah Jadwal
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <div className="mb-4">
                            <div className="relative max-w-sm">
                                <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    placeholder="Cari guru atau hari..."
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    className="pl-9"
                                />
                            </div>
                        </div>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Hari</TableHead>
                                    <TableHead>Tanggal Layanan</TableHead>
                                    <TableHead>Jam</TableHead>
                                    <TableHead>Guru</TableHead>
                                    <TableHead className="text-right">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {jadwal.data.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={5} className="text-center text-muted-foreground">
                                            Tidak ada data ditemukan.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    jadwal.data.map((item) => (
                                        <TableRow key={item.id_jadwal}>
                                            <TableCell className="font-medium">{item.hari}</TableCell>
                                            <TableCell>{formatDate(item.tanggal_layanan)}</TableCell>
                                            <TableCell>{item.jam}</TableCell>
                                            <TableCell>{item.guru}</TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Button variant="outline" size="sm" asChild>
                                                        <Link href={jadwalEdit.url(item.id_jadwal)}>
                                                            <Pencil className="size-4" />
                                                        </Link>
                                                    </Button>
                                                    <Button
                                                        variant="destructive"
                                                        size="sm"
                                                        onClick={() => setDeleteId(item.id_jadwal)}
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
                        {jadwal.links && jadwal.links.length > 3 && (
                            <div className="mt-4 flex justify-center gap-1">
                                {jadwal.links.map((link, i) => (
                                    link.url ? (
                                        <Button key={i} variant={link.active ? 'default' : 'outline'} size="sm" asChild>
                                            <Link href={link.url} dangerouslySetInnerHTML={{ __html: link.label }} />
                                        </Button>
                                    ) : (
                                        <Button key={i} variant="outline" size="sm" disabled dangerouslySetInnerHTML={{ __html: link.label }} />
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
                            Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.
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

JadwalIndex.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
