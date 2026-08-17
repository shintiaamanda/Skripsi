import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { index as jadwalIndex, store as jadwalStore } from '@/routes/admin/jadwal';

const hariOptions = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

export default function JadwalCreate() {
    const { data, setData, post, processing, errors } = useForm({
        hari: '',
        tanggal_layanan: '',
        jam: '',
        guru: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(jadwalStore.url());
    };

    return (
        <>
            <Head title="Tambah Jadwal" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Tambah Jadwal Layanan BK</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="grid gap-2">
                                <Label>Hari</Label>
                                <Select value={data.hari} onValueChange={(value) => setData('hari', value)}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Pilih hari" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {hariOptions.map((hari) => (
                                            <SelectItem key={hari} value={hari}>{hari}</SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                {errors.hari && <p className="text-sm text-destructive">{errors.hari}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="tanggal_layanan">Tanggal Layanan</Label>
                                <Input
                                    id="tanggal_layanan"
                                    type="date"
                                    value={data.tanggal_layanan}
                                    onChange={(e) => setData('tanggal_layanan', e.target.value)}
                                />
                                {errors.tanggal_layanan && <p className="text-sm text-destructive">{errors.tanggal_layanan}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="jam">Jam</Label>
                                <Input
                                    id="jam"
                                    type="time"
                                    value={data.jam}
                                    onChange={(e) => setData('jam', e.target.value)}
                                    placeholder="Masukkan jam layanan"
                                />
                                {errors.jam && <p className="text-sm text-destructive">{errors.jam}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="guru">Guru</Label>
                                <Input
                                    id="guru"
                                    value={data.guru}
                                    onChange={(e) => setData('guru', e.target.value)}
                                    placeholder="Masukkan nama guru"
                                />
                                {errors.guru && <p className="text-sm text-destructive">{errors.guru}</p>}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>Simpan</Button>
                                <Button variant="outline" asChild>
                                    <Link href={jadwalIndex.url()}>Batal</Link>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

JadwalCreate.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
