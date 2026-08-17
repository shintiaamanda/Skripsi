import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { index as informasiIndex, update as informasiUpdate } from '@/routes/admin/informasi';
import { toInputDate } from '@/utils/date';

interface InformasiData {
    id_info: number;
    informasi: string;
    tanggal_informasi: string;
}

interface Props {
    informasi: InformasiData;
}

export default function InformasiEdit({ informasi }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        informasi: informasi.informasi,
        tanggal_informasi: toInputDate(informasi.tanggal_informasi),
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(informasiUpdate.url(informasi.id_info));
    };

    return (
        <>
            <Head title="Edit Informasi" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Edit Informasi BK</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="grid gap-2">
                                <Label htmlFor="informasi">Informasi</Label>
                                <Textarea
                                    id="informasi"
                                    value={data.informasi}
                                    onChange={(e) => setData('informasi', e.target.value)}
                                    placeholder="Masukkan informasi"
                                />
                                {errors.informasi && <p className="text-sm text-destructive">{errors.informasi}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="tanggal_informasi">Tanggal Informasi</Label>
                                <Input
                                    id="tanggal_informasi"
                                    type="date"
                                    value={data.tanggal_informasi}
                                    onChange={(e) => setData('tanggal_informasi', e.target.value)}
                                />
                                {errors.tanggal_informasi && <p className="text-sm text-destructive">{errors.tanggal_informasi}</p>}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>Simpan Perubahan</Button>
                                <Button variant="outline" asChild>
                                    <Link href={informasiIndex.url()}>Batal</Link>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

InformasiEdit.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
