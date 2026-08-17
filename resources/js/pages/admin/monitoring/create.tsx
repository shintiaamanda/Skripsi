import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { index as monitoringIndex, store as monitoringStore } from '@/routes/admin/monitoring';

interface SiswaOption {
    id_siswa: number;
    nama: string;
}

interface Props {
    siswa: SiswaOption[];
}

export default function MonitoringCreate({ siswa }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        id_siswa: '',
        tanggal_monitoring: '',
        perkembangan: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(monitoringStore.url());
    };

    return (
        <>
            <Head title="Tambah Monitoring" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Tambah Data Monitoring</CardTitle>
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
                                <Label htmlFor="tanggal_monitoring">Tanggal Monitoring</Label>
                                <Input
                                    id="tanggal_monitoring"
                                    type="date"
                                    value={data.tanggal_monitoring}
                                    onChange={(e) => setData('tanggal_monitoring', e.target.value)}
                                />
                                {errors.tanggal_monitoring && <p className="text-sm text-destructive">{errors.tanggal_monitoring}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="perkembangan">Perkembangan</Label>
                                <Textarea
                                    id="perkembangan"
                                    value={data.perkembangan}
                                    onChange={(e) => setData('perkembangan', e.target.value)}
                                    placeholder="Deskripsikan perkembangan siswa"
                                />
                                {errors.perkembangan && <p className="text-sm text-destructive">{errors.perkembangan}</p>}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>Simpan</Button>
                                <Button variant="outline" asChild>
                                    <Link href={monitoringIndex.url()}>Batal</Link>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

MonitoringCreate.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
