import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { index as pelanggaranIndex, store as pelanggaranStore } from '@/routes/admin/pelanggaran';

interface SiswaOption {
    id_siswa: number;
    nama: string;
}

interface Props {
    siswa: SiswaOption[];
}

export default function PelanggaranCreate({ siswa }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        id_siswa: '',
        tanggal_pelanggaran: '',
        poin: '',
        tindakan: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(pelanggaranStore.url());
    };

    return (
        <>
            <Head title="Tambah Pelanggaran" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Tambah Data Pelanggaran</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="grid gap-2">
                                <Label>Siswa</Label>
                                <Select value={data.id_siswa} onValueChange={(value) => setData('id_siswa', value)}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Pilih siswa" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {siswa.map((item) => (
                                            <SelectItem key={item.id_siswa} value={String(item.id_siswa)}>
                                                {item.nama}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                {errors.id_siswa && <p className="text-sm text-destructive">{errors.id_siswa}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="tanggal_pelanggaran">Tanggal Pelanggaran</Label>
                                <Input
                                    id="tanggal_pelanggaran"
                                    type="date"
                                    value={data.tanggal_pelanggaran}
                                    onChange={(e) => setData('tanggal_pelanggaran', e.target.value)}
                                />
                                {errors.tanggal_pelanggaran && <p className="text-sm text-destructive">{errors.tanggal_pelanggaran}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="poin">Poin</Label>
                                <Input
                                    id="poin"
                                    type="number"
                                    value={data.poin}
                                    onChange={(e) => setData('poin', e.target.value)}
                                    placeholder="Masukkan poin pelanggaran"
                                />
                                {errors.poin && <p className="text-sm text-destructive">{errors.poin}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="tindakan">Tindakan</Label>
                                <Textarea
                                    id="tindakan"
                                    value={data.tindakan}
                                    onChange={(e) => setData('tindakan', e.target.value)}
                                    placeholder="Deskripsikan tindakan yang diambil"
                                />
                                {errors.tindakan && <p className="text-sm text-destructive">{errors.tindakan}</p>}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>Simpan</Button>
                                <Button variant="outline" asChild>
                                    <Link href={pelanggaranIndex.url()}>Batal</Link>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

PelanggaranCreate.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
