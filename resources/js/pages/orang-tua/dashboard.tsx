import { Head } from '@inertiajs/react';
import { Users, Activity, AlertTriangle } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { formatDate } from '@/utils/date';

type Monitoring = {
    tanggal_monitoring: string;
    perkembangan: string;
};

type Pelanggaran = {
    tanggal_pelanggaran: string;
    poin: number;
    tindakan: string;
};

type Siswa = {
    id_siswa: number;
    nisn: string;
    nama: string;
    kelas: string;
    monitoring: Monitoring[];
    pelanggaran: Pelanggaran[];
};

type DashboardProps = {
    siswa: Siswa[];
};

export default function Dashboard({ siswa }: DashboardProps) {
    return (
        <>
            <Head title="Dashboard Orang Tua" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <div className="absolute inset-0 flex items-center justify-center bg-blue-50 dark:bg-blue-950/30">
                            <div className="text-center">
                                <Users className="mx-auto size-8 text-blue-600" />
                                <p className="mt-1 text-2xl font-bold">{siswa.length}</p>
                                <p className="text-sm text-muted-foreground">Anak Terdaftar</p>
                            </div>
                        </div>
                    </div>
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <div className="absolute inset-0 flex items-center justify-center bg-green-50 dark:bg-green-950/30">
                            <div className="text-center">
                                <Activity className="mx-auto size-8 text-green-600" />
                                <p className="mt-1 text-2xl font-bold">
                                    {siswa.reduce((acc, s) => acc + s.monitoring.length, 0)}
                                </p>
                                <p className="text-sm text-muted-foreground">Total Monitoring</p>
                            </div>
                        </div>
                    </div>
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <div className="absolute inset-0 flex items-center justify-center bg-red-50 dark:bg-red-950/30">
                            <div className="text-center">
                                <AlertTriangle className="mx-auto size-8 text-red-600" />
                                <p className="mt-1 text-2xl font-bold">
                                    {siswa.reduce((acc, s) => acc + s.pelanggaran.length, 0)}
                                </p>
                                <p className="text-sm text-muted-foreground">Total Pelanggaran</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="relative min-h-[100vh] flex-1 space-y-4 overflow-hidden rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border">
                    <h2 className="text-lg font-semibold">Data Anak</h2>
                    {siswa.length === 0 ? (
                        <p className="py-8 text-center text-sm text-muted-foreground">
                            Tidak ada data siswa yang terkait dengan akun Anda.
                        </p>
                    ) : (
                        <div className="space-y-4">
                            {siswa.map((child) => (
                                <div key={child.id_siswa} className="rounded-lg border p-4">
                                    <div className="mb-3 flex items-center gap-2">
                                        <h3 className="font-semibold">{child.nama}</h3>
                                        <span className="rounded-full bg-secondary px-2 py-0.5 text-xs">{child.kelas}</span>
                                        <span className="text-xs text-muted-foreground">NISN: {child.nisn}</span>
                                    </div>

                                    <div className="grid gap-4 lg:grid-cols-2">
                                        <div>
                                            <h4 className="mb-2 flex items-center gap-1 text-sm font-medium">
                                                <Activity className="size-4 text-green-600" /> Monitoring
                                            </h4>
                                            {child.monitoring.length === 0 ? (
                                                <p className="text-xs text-muted-foreground">Belum ada data.</p>
                                            ) : (
                                                <div className="space-y-1">
                                                    {child.monitoring.map((m, idx) => (
                                                        <div key={idx} className="rounded border px-2 py-1 text-sm">
                                                            <span className="text-xs text-muted-foreground">{formatDate(m.tanggal_monitoring)}</span>
                                                            <p>{m.perkembangan}</p>
                                                        </div>
                                                    ))}
                                                </div>
                                            )}
                                        </div>
                                        <div>
                                            <h4 className="mb-2 flex items-center gap-1 text-sm font-medium">
                                                <AlertTriangle className="size-4 text-red-600" /> Pelanggaran
                                            </h4>
                                            {child.pelanggaran.length === 0 ? (
                                                <p className="text-xs text-muted-foreground">Tidak ada pelanggaran.</p>
                                            ) : (
                                                <div className="space-y-1">
                                                    {child.pelanggaran.map((p, idx) => (
                                                        <div key={idx} className="flex items-center justify-between rounded border px-2 py-1 text-sm">
                                                            <div>
                                                                <span className="text-xs text-muted-foreground">{formatDate(p.tanggal_pelanggaran)}</span>
                                                                <p>{p.tindakan}</p>
                                                            </div>
                                                            <span className="shrink-0 rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                                                {p.poin} poin
                                                            </span>
                                                        </div>
                                                    ))}
                                                </div>
                                            )}
                                        </div>
                                    </div>
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
