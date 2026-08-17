import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { index as siswaIndex, store as siswaStore } from '@/routes/admin/siswa';

export default function SiswaCreate() {
    const { data, setData, post, processing, errors } = useForm({
        nisn: '',
        nama: '',
        jenis_kelamin: '',
        kelas: '',
        alamat: '',
        no_hp: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(siswaStore.url());
    };

    return (
        <>
            <Head title="Tambah Siswa" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Tambah Data Siswa</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="grid gap-2">
                                <Label htmlFor="nisn">NISN</Label>
                                <Input
                                    id="nisn"
                                    value={data.nisn}
                                    onChange={(e) => setData('nisn', e.target.value)}
                                    placeholder="Masukkan NISN"
                                />
                                {errors.nisn && <p className="text-sm text-destructive">{errors.nisn}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="nama">Nama</Label>
                                <Input
                                    id="nama"
                                    value={data.nama}
                                    onChange={(e) => setData('nama', e.target.value)}
                                    placeholder="Masukkan nama siswa"
                                />
                                {errors.nama && <p className="text-sm text-destructive">{errors.nama}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label>Jenis Kelamin</Label>
                                <Select value={data.jenis_kelamin} onValueChange={(value) => setData('jenis_kelamin', value)}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Pilih jenis kelamin" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="Laki-laki">Laki-laki</SelectItem>
                                        <SelectItem value="Perempuan">Perempuan</SelectItem>
                                    </SelectContent>
                                </Select>
                                {errors.jenis_kelamin && <p className="text-sm text-destructive">{errors.jenis_kelamin}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="kelas">Kelas</Label>
                                <Input
                                    id="kelas"
                                    value={data.kelas}
                                    onChange={(e) => setData('kelas', e.target.value)}
                                    placeholder="Masukkan kelas"
                                />
                                {errors.kelas && <p className="text-sm text-destructive">{errors.kelas}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="alamat">Alamat</Label>
                                <Textarea
                                    id="alamat"
                                    value={data.alamat}
                                    onChange={(e) => setData('alamat', e.target.value)}
                                    placeholder="Masukkan alamat"
                                />
                                {errors.alamat && <p className="text-sm text-destructive">{errors.alamat}</p>}
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="no_hp">No HP</Label>
                                <Input
                                    id="no_hp"
                                    value={data.no_hp}
                                    onChange={(e) => setData('no_hp', e.target.value)}
                                    placeholder="Masukkan nomor HP"
                                />
                                {errors.no_hp && <p className="text-sm text-destructive">{errors.no_hp}</p>}
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit" disabled={processing}>
                                    Simpan
                                </Button>
                                <Button variant="outline" asChild>
                                    <Link href={siswaIndex.url()}>Batal</Link>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

SiswaCreate.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
