import { useState, useEffect } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Plus, Pencil, Trash2 } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { index as informasiIndex, create as informasiCreate, edit as informasiEdit, destroy as informasiDestroy } from '@/routes/admin/informasi';
import { formatDate } from '@/utils/date';

interface Informasi {
    id_info: number;
    informasi: string;
    tanggal_informasi: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    informasi: {
        data: Informasi[];
        links: PaginationLink[];
    };
}

export default function InformasiIndex({ informasi }: Props) {
    const [deleteId, setDeleteId] = useState<number | null>(null);

    const handleDelete = () => {
        if (deleteId) {
            router.delete(informasiDestroy.url(deleteId), {
                onSuccess: () => setDeleteId(null),
            });
        }
    };

    return (
        <>
            <Head title="Informasi BK" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <CardTitle>Informasi Bimbingan Konseling</CardTitle>
                        <Button asChild>
                            <Link href={informasiCreate.url()}>
                                <Plus className="mr-2 size-4" />
                                Tambah Informasi
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Informasi</TableHead>
                                    <TableHead>Tanggal</TableHead>
                                    <TableHead className="text-right">Aksi</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {informasi.data.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={3} className="text-center text-muted-foreground">
                                            Tidak ada data ditemukan.
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    informasi.data.map((item) => (
                                        <TableRow key={item.id_info}>
                                            <TableCell className="font-medium max-w-[500px] min-w-[300px] whitespace-pre-wrap break-words">{item.informasi}</TableCell>
                                            <TableCell className="whitespace-nowrap">{formatDate(item.tanggal_informasi)}</TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Button variant="outline" size="sm" asChild>
                                                        <Link href={informasiEdit.url(item.id_info)}>
                                                            <Pencil className="size-4" />
                                                        </Link>
                                                    </Button>
                                                    <Button
                                                        variant="destructive"
                                                        size="sm"
                                                        onClick={() => setDeleteId(item.id_info)}
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
                        {informasi.links && informasi.links.length > 3 && (
                            <div className="mt-4 flex justify-center gap-1">
                                {informasi.links.map((link, i) => (
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
                            Apakah Anda yakin ingin menghapus informasi ini? Tindakan ini tidak dapat dibatalkan.
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

InformasiIndex.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
