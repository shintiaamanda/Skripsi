import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { index as informasiIndex, store as informasiStore } from '@/routes/admin/informasi';

export default function InformasiCreate() {
    const { data, setData, post, processing, errors } = useForm({
        informasi: '',
        tanggal_informasi: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(informasiStore.url());
    };

    return (
        <>
            <Head title="Tambah Informasi" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Tambah Informasi BK</CardTitle>
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
                                <Button type="submit" disabled={processing}>Simpan</Button>
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

InformasiCreate.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
