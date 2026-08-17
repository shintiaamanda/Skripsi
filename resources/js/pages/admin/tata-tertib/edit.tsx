import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { index as tataTertibIndex, update as tataTertibUpdate } from '@/routes/admin/tata-tertib';
import { toInputDate } from '@/utils/date';

interface TataTertibData {
    id_tertib: number;
    tata_tertib: string;
    tanggal_konseling: string;
}

interface Props {
    tataTertib: TataTertibData;
}

export default function TataTertibEdit({ tataTertib }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        tata_tertib: tataTertib.tata_tertib,
        tanggal_konseling: toInputDate(tataTertib.tanggal_konseling),
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(tataTertibUpdate.url(tataTertib.id_tertib));
    };

    return (
        <>
            <Head title="Edit Tata Tertib" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Edit Tata Tertib</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="grid gap-2">
                                <Label htmlFor="tata_tertib">Tata Tertib</Label>
                                <Textarea
                                    id="tata_tertib"
                                    value={data.tata_tertib}
                                    onChange={(e) => setData('tata_tertib', e.target.value)}
                                    placeholder="Masukkan tata tertib"
                                />
                                {errors.tata_tertib && <p className="text-sm text-destructive">{errors.tata_tertib}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="tanggal_konseling">Tanggal</Label>
                                <Input
                                    id="tanggal_konseling"
                                    type="date"
                                    value={data.tanggal_konseling}
                                    onChange={(e) => setData('tanggal_konseling', e.target.value)}
                                />
                                {errors.tanggal_konseling && <p className="text-sm text-destructive">{errors.tanggal_konseling}</p>}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>Simpan Perubahan</Button>
                                <Button variant="outline" asChild>
                                    <Link href={tataTertibIndex.url()}>Batal</Link>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

TataTertibEdit.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
