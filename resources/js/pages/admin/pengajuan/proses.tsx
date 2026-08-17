import { FormEventHandler } from 'react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { ArrowLeft, CheckCircle } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import adminRoutes from '@/routes/admin';
import { formatDate } from '@/utils/date';

interface Pengajuan {
    id_konseling: number;
    id_siswa: number;
    tanggal_konseling: string;
    keluhan: string;
    guru_bk?: string | null;
    siswa: {
        id_siswa: number;
        nama: string;
        nisn: string;
        kelas: string;
        alamat: string;
        no_hp: string;
    } | null;
}

interface Props {
    pengajuan: Pengajuan;
}

export default function PengajuanProses({ pengajuan }: Props) {
    const { auth } = usePage<{ auth: { user: { nama: string } } }>().props;

    const { data, setData, post, processing, errors } = useForm({
        masalah: pengajuan.keluhan || '',
        solusi: '',
        guru_bk: pengajuan.guru_bk || auth.user?.nama || '',
    });

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();
        post(adminRoutes.pengajuan.proses.url(pengajuan.id_konseling));
    };

    return (
        <>
            <Head title="Proses Pengajuan Konseling" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <Button variant="outline" size="sm" asChild>
                        <Link href={adminRoutes.pengajuan.index.url()}>
                            <ArrowLeft className="mr-2 size-4" />
                            Kembali
                        </Link>
                    </Button>
                    <h1 className="text-xl font-bold">Proses Pengajuan Konseling</h1>
                </div>

                <div className="grid gap-4 md:grid-cols-3">
                    {/* Ringkasan Pengajuan Siswa */}
                    <Card className="md:col-span-1">
                        <CardHeader>
                            <CardTitle className="text-base">Detail Pengajuan Siswa</CardTitle>
                            <CardDescription>Informasi dari pengajuan awal siswa</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-3 text-sm">
                            <div>
                                <span className="font-semibold text-muted-foreground">Nama Siswa:</span>
                                <p className="text-base font-medium">{pengajuan.siswa?.nama ?? '-'}</p>
                            </div>
                            <div>
                                <span className="font-semibold text-muted-foreground">NISN:</span>
                                <p>{pengajuan.siswa?.nisn ?? '-'}</p>
                            </div>
                            <div>
                                <span className="font-semibold text-muted-foreground">Kelas:</span>
                                <p>{pengajuan.siswa?.kelas ?? '-'}</p>
                            </div>
                            <div>
                                <span className="font-semibold text-muted-foreground">Tanggal Pengajuan:</span>
                                <p>{formatDate(pengajuan.tanggal_konseling)}</p>
                            </div>
                            <div>
                                <span className="font-semibold text-muted-foreground">Guru BK Terjadwal:</span>
                                <p className="font-medium text-primary">{pengajuan.guru_bk ?? auth.user?.nama ?? '-'}</p>
                            </div>
                            <div>
                                <span className="font-semibold text-muted-foreground">Keluhan Siswa:</span>
                                <p className="mt-1 rounded-md bg-muted p-2.5 text-foreground">{pengajuan.keluhan}</p>
                            </div>
                        </CardContent>
                    </Card>

                    {/* Form Input Hasil Konseling */}
                    <Card className="md:col-span-2">
                        <CardHeader>
                            <CardTitle className="text-base">Input Hasil Konseling</CardTitle>
                            <CardDescription>Lengkapi detail masalah dan solusi untuk menyimpan ke Data Konseling</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <form onSubmit={handleSubmit} className="space-y-4">
                                <div>
                                    <Label htmlFor="masalah">Masalah Siswa</Label>
                                    <Textarea
                                        id="masalah"
                                        rows={3}
                                        value={data.masalah}
                                        onChange={(e) => setData('masalah', e.target.value)}
                                        placeholder="Deskripsi masalah yang ditangani..."
                                        className="mt-1"
                                    />
                                    {errors.masalah && <p className="mt-1 text-sm text-destructive">{errors.masalah}</p>}
                                </div>

                                <div>
                                    <Label htmlFor="solusi">Solusi / Penanganan</Label>
                                    <Textarea
                                        id="solusi"
                                        rows={3}
                                        value={data.solusi}
                                        onChange={(e) => setData('solusi', e.target.value)}
                                        placeholder="Solusi atau langkah penanganan yang disepakati..."
                                        className="mt-1"
                                    />
                                    {errors.solusi && <p className="mt-1 text-sm text-destructive">{errors.solusi}</p>}
                                </div>

                                <div>
                                    <Label htmlFor="guru_bk">Guru BK Penanggung Jawab</Label>
                                    <Input
                                        id="guru_bk"
                                        type="text"
                                        value={data.guru_bk}
                                        onChange={(e) => setData('guru_bk', e.target.value)}
                                        placeholder="Nama Guru BK"
                                        className="mt-1"
                                    />
                                    {errors.guru_bk && <p className="mt-1 text-sm text-destructive">{errors.guru_bk}</p>}
                                </div>

                                <div className="flex justify-end gap-2 pt-2">
                                    <Button variant="outline" asChild>
                                        <Link href={adminRoutes.pengajuan.index.url()}>Batal</Link>
                                    </Button>
                                    <Button type="submit" disabled={processing}>
                                        <CheckCircle className="mr-2 size-4" />
                                        Simpan & Simpan ke Data Konseling
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </>
    );
}

PengajuanProses.layout = (page: React.ReactNode) => (
    <AppLayout
        breadcrumbs={[
            { title: 'Pengajuan Konseling', href: adminRoutes.pengajuan.index.url() },
            { title: 'Proses Konseling', href: '#' },
        ]}
    >
        {page}
    </AppLayout>
);
