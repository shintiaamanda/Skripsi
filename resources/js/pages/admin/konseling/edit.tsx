import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { index as konselingIndex, update as konselingUpdate } from '@/routes/admin/konseling';
import { toInputDate } from '@/utils/date';

interface KonselingData {
    id_data_konseling: number;
    id_siswa: number;
    tanggal: string;
    masalah: string;
    solusi: string;
    guru_bk: string;
}

interface SiswaOption {
    id_siswa: number;
    nama: string;
}

interface Props {
    konseling: KonselingData;
    siswa: SiswaOption[];
}

export default function KonselingEdit({ konseling, siswa }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        id_siswa: String(konseling.id_siswa),
        tanggal: toInputDate(konseling.tanggal),
        masalah: konseling.masalah,
        solusi: konseling.solusi,
        guru_bk: konseling.guru_bk,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(konselingUpdate.url(konseling.id_data_konseling));
    };

    return (
        <>
            <Head title="Edit Konseling" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Edit Data Konseling</CardTitle>
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
                                <Label htmlFor="tanggal">Tanggal</Label>
                                <Input
                                    id="tanggal"
                                    type="date"
                                    value={data.tanggal}
                                    onChange={(e) => setData('tanggal', e.target.value)}
                                />
                                {errors.tanggal && <p className="text-sm text-destructive">{errors.tanggal}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="masalah">Masalah</Label>
                                <Textarea
                                    id="masalah"
                                    value={data.masalah}
                                    onChange={(e) => setData('masalah', e.target.value)}
                                    placeholder="Deskripsikan masalah"
                                />
                                {errors.masalah && <p className="text-sm text-destructive">{errors.masalah}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="solusi">Solusi</Label>
                                <Textarea
                                    id="solusi"
                                    value={data.solusi}
                                    onChange={(e) => setData('solusi', e.target.value)}
                                    placeholder="Deskripsikan solusi"
                                />
                                {errors.solusi && <p className="text-sm text-destructive">{errors.solusi}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="guru_bk">Guru BK</Label>
                                <Input
                                    id="guru_bk"
                                    value={data.guru_bk}
                                    onChange={(e) => setData('guru_bk', e.target.value)}
                                    placeholder="Masukkan nama Guru BK"
                                />
                                {errors.guru_bk && <p className="text-sm text-destructive">{errors.guru_bk}</p>}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>
                                    Simpan Perubahan
                                </Button>
                                <Button variant="outline" asChild>
                                    <Link href={konselingIndex.url()}>Batal</Link>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

KonselingEdit.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
