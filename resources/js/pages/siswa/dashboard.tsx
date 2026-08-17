import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle, Send, ClipboardList, Calendar } from 'lucide-react';
import { FormEventHandler } from 'react';
import AppLayout from '@/layouts/app-layout';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { dashboard } from '@/routes';
import { ajukanKonseling } from '@/routes/siswa';
import { formatDate } from '@/utils/date';

type Pengajuan = {
    id_konseling: number;
    tanggal_konseling: string;
    keluhan: string;
};

type Riwayat = {
    id_data_konseling: number;
    tanggal: string;
    masalah: string;
    solusi: string;
};

type Jadwal = {
    id_jadwal: number;
    hari: string;
    tanggal_layanan: string;
    jam: string;
    guru: string;
};

type DashboardProps = {
    pengajuan: Pengajuan[];
    riwayat: Riwayat[];
    jadwal: Jadwal[];
};

export default function Dashboard({ pengajuan = [], riwayat = [], jadwal = [] }: DashboardProps) {
    const { data, setData, post, processing, errors, reset } = useForm<{
        id_jadwal: number | null;
        tanggal_konseling: string;
        keluhan: string;
    }>({
        id_jadwal: null,
        tanggal_konseling: '',
        keluhan: '',
    });

    const handleJadwalSelect = (jadwalId: number, dateStr: string, timeStr: string) => {
        const cleanDate = dateStr.split('T')[0].split(' ')[0];
        const match = timeStr.match(/(\d{1,2})[:.](\d{2})/);
        const tanggal = match
            ? `${cleanDate} ${match[1].padStart(2, '0')}:${match[2]}:00`
            : `${cleanDate} 00:00:00`;
        setData((prev) => ({ ...prev, id_jadwal: jadwalId, tanggal_konseling: tanggal }));
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(ajukanKonseling.url(), {
            onSuccess: () => reset(),
        });
    };

    return (
        <>
            <Head title="Dashboard Siswa" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                {/* Information Card: Jadwal Layanan BK */}
                <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div className="mb-3 flex items-center gap-2">
                        <Calendar className="size-5 text-primary" />
                        <h2 className="text-lg font-semibold">Jadwal Layanan BK Tersedia</h2>
                    </div>
                    {jadwal.length === 0 ? (
                        <p className="py-4 text-center text-sm text-muted-foreground">
                            Belum ada jadwal layanan BK yang diinputkan oleh Guru BK.
                        </p>
                    ) : (
                        <div className="overflow-x-auto">
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Hari</TableHead>
                                        <TableHead>Tanggal Layanan</TableHead>
                                        <TableHead>Jam</TableHead>
                                        <TableHead>Guru BK</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {jadwal.map((item) => (
                                        <TableRow key={item.id_jadwal}>
                                            <TableCell className="font-medium">{item.hari}</TableCell>
                                            <TableCell>{formatDate(item.tanggal_layanan)}</TableCell>
                                            <TableCell>{item.jam}</TableCell>
                                            <TableCell>{item.guru}</TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </div>
                    )}
                </div>

                <div className="grid auto-rows-min gap-4 lg:grid-cols-2">
                    {/* Form Ajukan Konseling */}
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <div className="mb-4 flex items-center gap-2">
                            <Send className="size-5 text-primary" />
                            <h2 className="text-lg font-semibold">Ajukan Konseling</h2>
                        </div>
                        <form onSubmit={submit} className="space-y-4">
                            <div className="grid gap-2">
                                <Label htmlFor="tanggal_konseling">Tanggal & Jam Konseling</Label>
                                {jadwal.length > 0 ? (
                                    <Select
                                        value={data.id_jadwal ? String(data.id_jadwal) : ''}
                                        onValueChange={(value) => {
                                            const selected = jadwal.find((j) => String(j.id_jadwal) === value);
                                            if (selected) {
                                                handleJadwalSelect(selected.id_jadwal, selected.tanggal_layanan, selected.jam);
                                            }
                                        }}
                                    >
                                        <SelectTrigger id="tanggal_konseling">
                                            <SelectValue placeholder="Pilih tanggal & jadwal layanan BK..." />
                                        </SelectTrigger>
                                        <SelectContent>
                                            {jadwal.map((j) => (
                                                <SelectItem key={j.id_jadwal} value={String(j.id_jadwal)}>
                                                    {j.hari}, {formatDate(j.tanggal_layanan)} (Jam: {j.jam} - {j.guru})
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                ) : (
                                    <Input
                                        id="tanggal_konseling"
                                        type="date"
                                        value={data.tanggal_konseling}
                                        onChange={(e) => setData('tanggal_konseling', e.target.value)}
                                        required
                                    />
                                )}
                                <InputError message={errors.tanggal_konseling} />
                            </div>
                            <div className="grid gap-2">
                                <Label htmlFor="keluhan">Keluhan</Label>
                                <textarea
                                    id="keluhan"
                                    className="border-input placeholder:text-muted-foreground flex min-h-[100px] w-full rounded-md border bg-transparent px-3 py-2 text-base shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                    placeholder="Ceritakan keluhan Anda..."
                                    value={data.keluhan}
                                    onChange={(e) => setData('keluhan', e.target.value)}
                                    required
                                />
                                <InputError message={errors.keluhan} />
                            </div>
                            <Button type="submit" disabled={processing} className="w-full">
                                {processing && <LoaderCircle className="animate-spin" />}
                                Ajukan Konseling
                            </Button>
                        </form>
                    </div>

                    {/* Riwayat Pengajuan */}
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <div className="mb-4 flex items-center gap-2">
                            <ClipboardList className="size-5 text-primary" />
                            <h2 className="text-lg font-semibold">Riwayat Pengajuan</h2>
                        </div>
                        {pengajuan.length === 0 ? (
                            <p className="py-8 text-center text-sm text-muted-foreground">Belum ada riwayat pengajuan.</p>
                        ) : (
                            <div className="space-y-2">
                                {pengajuan.map((item) => (
                                    <div key={item.id_konseling} className="rounded-lg border p-3">
                                        <p className="text-sm text-muted-foreground">{formatDate(item.tanggal_konseling)}</p>
                                        <p className="mt-1">{item.keluhan}</p>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>

                {/* Riwayat Konseling */}
                <div className="relative min-h-[30vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border">
                    <h2 className="mb-3 text-lg font-semibold">Riwayat Konseling</h2>
                    {riwayat.length === 0 ? (
                        <p className="py-8 text-center text-sm text-muted-foreground">Belum ada riwayat konseling.</p>
                    ) : (
                        <div className="space-y-2">
                            {riwayat.map((item) => (
                                <div key={item.id_data_konseling} className="rounded-lg border p-3">
                                    <div className="flex items-center justify-between">
                                        <p className="font-medium">{item.masalah}</p>
                                        <span className="text-xs text-muted-foreground">{formatDate(item.tanggal)}</span>
                                    </div>
                                    {item.solusi && (
                                        <p className="mt-1 text-sm text-muted-foreground">Solusi: {item.solusi}</p>
                                    )}
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}

Dashboard.layout = (page: React.ReactNode) => (
    <AppLayout breadcrumbs={[{ title: 'Dashboard', href: dashboard() }]}>
        {page}
    </AppLayout>
);
